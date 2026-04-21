<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Parkir - <?= ucfirst($periode === 'daily' ? 'Harian' : ($periode === 'weekly' ? 'Mingguan' : 'Bulanan')) ?></title>
    <style>
        @media print {
            body { margin: 0; padding: 20px; }
            .no-print { display: none; }
            @page { margin: 20mm; }
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif;
            padding: 30px;
            background: white;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #667eea;
        }
        .header h1 {
            font-size: 28px;
            color: #667eea;
            margin-bottom: 5px;
        }
        .header .subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }
        .header .period {
            font-size: 14px;
            color: #999;
        }
        .info-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9ff;
            border-radius: 8px;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
        }
        .info-label {
            font-weight: 600;
            color: #333;
        }
        .info-value {
            color: #667eea;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table thead {
            background: #667eea;
            color: white;
        }
        table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border: 1px solid #667eea;
        }
        table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
        }
        table tbody tr:nth-child(even) {
            background: #f8f9ff;
        }
        table tbody tr:hover {
            background: #e8ebff;
        }
        .summary-row {
            background: #667eea !important;
            color: white;
            font-weight: 700;
        }
        .summary-row td {
            border-color: #667eea !important;
        }
        .statistics {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        .stat-box {
            padding: 20px;
            background: #f8f9ff;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .stat-box .label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        .stat-box .value {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .btn-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 15px 30px;
            background: #4caf50;
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(76, 175, 80, 0.4);
            transition: all 0.3s;
        }
        .btn-print:hover {
            background: #45a049;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.5);
        }
        .action-buttons {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: flex;
            gap: 15px;
            z-index: 1000;
        }
        .btn-action {
            padding: 15px 30px;
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-download {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-download:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }
        .btn-print-btn {
            background: #4caf50;
            box-shadow: 0 5px 20px rgba(76, 175, 80, 0.4);
        }
        .btn-print-btn:hover {
            background: #45a049;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.5);
        }
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>E-PARKIR</h1>
        <div class="subtitle">Laporan <?= ucfirst($periode === 'daily' ? 'Harian' : ($periode === 'weekly' ? 'Mingguan' : 'Bulanan')) ?></div>
        <div class="period">
            Periode: <?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?>
        </div>
    </div>

    <?php if (!empty($laporan)): 
        $totalTransaksi = 0;
        $totalPendapatan = 0;
        foreach ($laporan as $row) {
            $totalTransaksi += $row['total_transaksi'];
            $totalPendapatan += $row['total_pendapatan'];
        }
        $rataRata = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;
    ?>

    <div class="info-section">
        <div class="info-item">
            <span class="info-label">Total Transaksi:</span>
            <span class="info-value"><?= $totalTransaksi ?> transaksi</span>
        </div>
        <div class="info-item">
            <span class="info-label">Total Pendapatan:</span>
            <span class="info-value">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Rata-rata per Transaksi:</span>
            <span class="info-value">Rp <?= number_format($rataRata, 0, ',', '.') ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Dicetak pada:</span>
            <span class="info-value"><?= date('d/m/Y H:i:s') ?></span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Periode</th>
                <th style="width: 20%;">Total Transaksi</th>
                <th style="width: 25%;">Total Pendapatan</th>
                <th style="width: 20%;">Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($laporan as $row): 
                $avg = $row['total_transaksi'] > 0 ? $row['total_pendapatan'] / $row['total_transaksi'] : 0;
            ?>
            <tr>
                <td style="text-align: center;"><?= $no++ ?></td>
                <td>
                    <?php if ($periode === 'weekly'): ?>
                        Minggu ke-<?= $row['minggu'] ?? '-' ?>, <?= $row['tahun'] ?? '-' ?>
                    <?php elseif ($periode === 'monthly'): ?>
                        <?php 
                        $bulanNama = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        echo $bulanNama[$row['bulan']] . ' ' . $row['tahun'];
                        ?>
                    <?php else: ?>
                        <?= date('d F Y', strtotime($row['tanggal'])) ?>
                    <?php endif; ?>
                </td>
                <td style="text-align: center;"><strong><?= $row['total_transaksi'] ?></strong></td>
                <td style="text-align: right;"><strong>Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?></strong></td>
                <td style="text-align: right;">Rp <?= number_format($avg, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="summary-row">
                <td colspan="2" style="text-align: center;"><strong>TOTAL KESELURUHAN</strong></td>
                <td style="text-align: center;"><strong><?= $totalTransaksi ?></strong></td>
                <td style="text-align: right;"><strong>Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></strong></td>
                <td style="text-align: right;"><strong>Rp <?= number_format($rataRata, 0, ',', '.') ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div class="statistics">
        <div class="stat-box">
            <div class="label">📊 Total Transaksi</div>
            <div class="value"><?= $totalTransaksi ?></div>
        </div>
        <div class="stat-box">
            <div class="label">💰 Total Pendapatan</div>
            <div class="value">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></div>
        </div>
        <div class="stat-box">
            <div class="label">📈 Rata-rata per Transaksi</div>
            <div class="value">Rp <?= number_format($rataRata, 0, ',', '.') ?></div>
        </div>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <div style="font-size: 60px; margin-bottom: 20px;">📊</div>
        <p style="font-size: 18px;">Tidak ada data laporan untuk periode ini</p>
    </div>
    <?php endif; ?>

    <div class="footer">
        <p><strong>E-PARKIR</strong></p>
        <p>Sistem Parkir Otomatis dengan QR Code</p>
        <p style="margin-top: 10px;">Dokumen ini dicetak pada: <?= date('d F Y, H:i:s') ?> WIB</p>
        <p style="margin-top: 5px; font-size: 10px;">
            © <?= date('Y') ?> E-PARKIR. All rights reserved.
        </p>
    </div>

    <div class="action-buttons no-print">
        <button class="btn-action btn-download" onclick="downloadPDF()">
            Download PDF
        </button>
        <button class="btn-action btn-print-btn" onclick="window.print()">
            Cetak Laporan
        </button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPDF() {
            const element = document.body;
            const buttons = document.querySelector('.action-buttons');
            
            // Sembunyikan tombol sementara
            buttons.style.display = 'none';
            
            const opt = {
                margin: [10, 10, 10, 10],
                filename: 'Laporan_Parkir_<?= $periode ?>_<?= date('dmY', strtotime($start_date)) ?>-<?= date('dmY', strtotime($end_date)) ?>.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            html2pdf().set(opt).from(element).save().then(() => {
                // Tampilkan tombol lagi setelah download
                buttons.style.display = 'flex';
            });
        }
    </script>
</body>
</html>