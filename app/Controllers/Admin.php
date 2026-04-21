<?php

namespace App\Controllers;

use App\Models\ParkirModel;

class Admin extends BaseController
{
    protected $parkirModel;

    public function __construct()
    {
        $this->parkirModel = new ParkirModel();
        helper(['parkir', 'form']);
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'stats' => $this->parkirModel->getDashboardStats(),
            'parkir_aktif' => $this->parkirModel->getAktifParkir()
        ];

        return view('admin/dashboard', $data);
    }

    public function checkout($id)
    {
        $parkir = $this->parkirModel->find($id);

        if (!$parkir || $parkir['status'] !== 'aktif') {
            return redirect()->back()->with('error', 'Data parkir tidak valid!');
        }

        $waktuKeluar = date('Y-m-d H:i:s');
        $hitungan = hitung_biaya_parkir($parkir['waktu_masuk'], $waktuKeluar);

        $data = [
            'waktu_keluar' => $waktuKeluar,
            'durasi_menit' => $hitungan['durasi_menit'],
            'biaya' => $hitungan['biaya'],
            'status' => 'selesai'
        ];

        if ($this->parkirModel->checkoutParkir($id, $data)) {
            return redirect()->back()->with('success', 'Checkout berhasil! Biaya: Rp ' . number_format($hitungan['biaya'], 0, ',', '.'));
        }

        return redirect()->back()->with('error', 'Checkout gagal!');
    }

    public function laporan()
    {
        $periode = $this->request->getGet('periode') ?? 'daily';
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

        // Tentukan groupBy berdasarkan periode
        $groupBy = 'daily';
        if ($periode === 'weekly') {
            $groupBy = 'weekly';
        } elseif ($periode === 'monthly') {
            $groupBy = 'monthly';
        }

        $data = [
            'title' => 'Laporan Parkir',
            'periode' => $periode,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'laporan' => $this->parkirModel->getLaporan($startDate . ' 00:00:00', $endDate . ' 23:59:59', $groupBy)
        ];

        return view('admin/laporan', $data);
    }

    public function exportPDF()
    {
        $periode = $this->request->getGet('periode') ?? 'daily';
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

        $groupBy = 'daily';
        if ($periode === 'weekly') {
            $groupBy = 'weekly';
        } elseif ($periode === 'monthly') {
            $groupBy = 'monthly';
        }

        $data = [
            'periode' => $periode,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'laporan' => $this->parkirModel->getLaporan($startDate . ' 00:00:00', $endDate . ' 23:59:59', $groupBy)
        ];

        $html = view('admin/laporan_pdf', $data);

        return $this->response
            ->setHeader('Content-Type', 'text/html')
            ->setBody($html);
    }

    public function detailTransaksi($tanggal = null)
    {
        if (!$tanggal) {
            return redirect()->back()->with('error', 'Tanggal tidak valid!');
        }

        // Ambil semua transaksi pada tanggal tersebut
        $transaksi = $this->parkirModel->getTransaksiByDate($tanggal);

        // Hitung statistik
        $totalTransaksi = count($transaksi);
        $totalPendapatan = 0;
        $totalDurasi = 0;

        foreach ($transaksi as $t) {
            $totalPendapatan += $t['biaya'];
            $totalDurasi += $t['durasi_menit'];
        }

        $rataDurasi = $totalTransaksi > 0 ? $totalDurasi / $totalTransaksi : 0;

        $data = [
            'title' => 'Detail Transaksi',
            'tanggal' => $tanggal,
            'transaksi' => $transaksi,
            'stats' => [
                'total_transaksi' => $totalTransaksi,
                'total_pendapatan' => $totalPendapatan,
                'rata_durasi' => $rataDurasi
            ]
        ];

        return view('admin/detail_transaksi', $data);
    }
}