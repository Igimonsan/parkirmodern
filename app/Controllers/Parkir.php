<?php

namespace App\Controllers;

use App\Models\ParkirModel;

class Parkir extends BaseController
{
    protected $parkirModel;

    public function __construct()
    {
        $this->parkirModel = new ParkirModel();
        helper(['parkir', 'url']);
    }

    public function index()
    {
        return view('parkir/index');
    }

    public function create()
    {
        try {
            // Hitung nomor transaksi hari ini
            $nomorTransaksi = $this->parkirModel->countTodayTransactions() + 1;

            // Generate ID Parkir
            $idParkir = generate_id_parkir($nomorTransaksi);

            // URL untuk scan QR Code
            $scanUrl = base_url('parkir/scan/' . $idParkir);

            // Generate QR Code via API
            $qrApiUrl = env('QR_API_URL');
            $qrApiKey = env('QR_API_KEY');
            // Send request url
            $requestUrl = $qrApiUrl . '?text=' . urlencode($scanUrl) . '&apikey=' . $qrApiKey;

            // Ambil gambar QR Code
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $requestUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // simpan qr ke variable qerImage
            $qrImage = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200 || empty($qrImage)) {
                throw new \Exception('Gagal menghasilkan QR Code');
            }

            // Simpan QR Code ke folder
            $qrFolder = WRITEPATH . 'uploads/qr/';
            if (!is_dir($qrFolder)) {
                mkdir($qrFolder, 0777, true);
            }

            $qrFileName = $idParkir . '.png';
            $qrPath = $qrFolder . $qrFileName;
            file_put_contents($qrPath, $qrImage);

            // Simpan data parkir ke database
            $data = [
                'id_parkir' => $idParkir,
                'qr_code'   => $qrFileName,
                'qr_base64' => 'data:image/png;base64,' . base64_encode($qrImage),
                'waktu_masuk' => date('Y-m-d H:i:s'),
                'biaya' => (int) env('PARKIR_BIAYA_AWAL', 5000),
                'status' => 'aktif'
            ];

            $this->parkirModel->insert($data);

            // Response dengan QR Code dalam base64
            $qrBase64 = base64_encode($qrImage);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Parkir berhasil dibuat',
                'data' => [
                    'id_parkir' => $idParkir,
                    'waktu_masuk' => $data['waktu_masuk'],
                    'biaya_awal' => $data['biaya'],
                    'qr_code' => 'data:image/png;base64,' . $qrBase64,
                    'scan_url' => $scanUrl
                ]
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal membuat parkir: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function scan($idParkir)
    {
        $parkir = $this->parkirModel->getByIdParkir($idParkir);

        if (!$parkir) {
            return view('errors/html/error_404');
        }

        // Hitung biaya parkir real-time
        $hitungan = hitung_biaya_parkir($parkir['waktu_masuk']);
        $parkir['durasi_real'] = $hitungan['durasi_menit'];
        $parkir['biaya_real'] = $hitungan['biaya'];

        // Parse ID Parkir
        $parkir['info'] = parse_id_parkir($idParkir);

        return view('parkir/detail', ['parkir' => $parkir]);
    }

    public function struk($idParkir)
    {
        $parkir = $this->parkirModel->getByIdParkir($idParkir);

        if (!$parkir) {
            return view('errors/html/error_404');
        }

        // Ambil QR base64 dari database (tidak bergantung file sistem)
        $qrBase64 = $parkir['qr_base64'] ?? '';

        // Fallback: baca dari file kalau kolom kosong (data lama)
        if (empty($qrBase64)) {
            $qrPath = WRITEPATH . 'uploads/qr/' . $parkir['qr_code'];
            if (file_exists($qrPath)) {
                $qrBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($qrPath));
            }
        }

        $html = view('parkir/struk', [
            'parkir'    => $parkir,
            'qr_base64' => $qrBase64,
        ]);

        return $this->response
            ->setHeader('Content-Type', 'text/html')
            ->setBody($html);
    }

    public function generatePDF($idParkir)
    {
        $parkir = $this->parkirModel->getByIdParkir($idParkir);

        if (!$parkir) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data parkir tidak ditemukan'
            ])->setStatusCode(404);
        }

        // Hitung biaya real-time
        $hitungan = hitung_biaya_parkir($parkir['waktu_masuk']);
        $parkir['durasi_real'] = $hitungan['durasi_menit'];
        $parkir['biaya_real'] = $hitungan['biaya'];
        $parkir['info'] = parse_id_parkir($idParkir);

        // Load library PDF (Anda bisa menggunakan TCPDF atau Dompdf)
        // Untuk contoh ini, kita return HTML yang bisa di-print

        $html = view('parkir/pdf', ['parkir' => $parkir]);

        return $this->response
            ->setHeader('Content-Type', 'text/html')
            ->setBody($html);
    }
}