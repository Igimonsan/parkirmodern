<?php

if (!function_exists('generate_id_parkir')) {

    function generate_id_parkir($nomorTransaksi)
    {
        $tanggal = date('dmY');
        $nomor = str_pad($nomorTransaksi, 2, '0', STR_PAD_LEFT);
        return $nomor . '-' . $tanggal;
    }
}

if (!function_exists('parse_id_parkir')) {

    function parse_id_parkir($idParkir)
    {
        $parts = explode('-', $idParkir);
        if (count($parts) !== 2) {
            return null;
        }

        $nomorTransaksi = $parts[0];
        $tanggalString = $parts[1];

        return [
            'nomor_transaksi' => (int) $nomorTransaksi,
            'tanggal' => substr($tanggalString, 0, 2),
            'bulan' => substr($tanggalString, 2, 2),
            'tahun' => substr($tanggalString, 4, 4),
            'full_date' => substr($tanggalString, 4, 4) . '-' . substr($tanggalString, 2, 2) . '-' . substr($tanggalString, 0, 2)
        ];
    }
}

if (!function_exists('hitung_biaya_parkir')) {

    function hitung_biaya_parkir($waktuMasuk, $waktuKeluar = null)
    {
        $biayaAwal = (int) env('PARKIR_BIAYA_AWAL', 5000);
        $biayaPerJam = (int) env('PARKIR_BIAYA_PER_JAM', 2000);

        if ($waktuKeluar === null) {
            $waktuKeluar = date('Y-m-d H:i:s');
        }

        $masuk = strtotime($waktuMasuk);
        $keluar = strtotime($waktuKeluar);
        $durasiDetik = $keluar - $masuk;
        $durasiMenit = floor($durasiDetik / 60);

        // Jika belum sampai 1 jam, biaya tetap 5000
        if ($durasiMenit < 60) {
            return [
                'durasi_menit' => $durasiMenit,
                'biaya' => $biayaAwal
            ];
        }

        // Setelah 1 jam, tambahkan 2000 per jam
        $jamTambahan = ceil(($durasiMenit - 60) / 60);
        $biayaTotal = $biayaAwal + ($jamTambahan * $biayaPerJam);

        return [
            'durasi_menit' => $durasiMenit,
            'biaya' => $biayaTotal
        ];
    }
}

if (!function_exists('format_durasi')) {

    function format_durasi($menit)
    {
        if ($menit < 60) {
            return $menit . ' menit';
        }

        $jam = floor($menit / 60);
        $sisaMenit = $menit % 60;

        if ($sisaMenit == 0) {
            return $jam . ' jam';
        }

        return $jam . ' jam ' . $sisaMenit . ' menit';
    }
}