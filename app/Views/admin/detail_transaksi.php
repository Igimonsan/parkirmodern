<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - <?= date('d/m/Y', strtotime($tanggal)) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar h1 {
            font-size: 24px;
        }
        .navbar-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .navbar a:hover {
            background: rgba(255,255,255,0.2);
        }
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-card .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .stat-card .label {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: #667eea;
        }
        .content-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .content-card h2 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #667eea;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            background: #f8f9ff;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        table tr:hover {
            background: #f8f9ff;
        }
        .badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-selesai {
            background: #4caf50;
            color: white;
        }
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #999;
        }
        .btn-detail {
            background: #2196f3;
            color: white;
            padding: 6px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-detail:hover {
            background: #1976d2;
        }
        .total-row {
            background: #667eea !important;
            color: white;
            font-weight: 700;
        }
        .total-row td {
            border: none;
        }
        .btn-export {
            padding: 10px 20px;
            background: #4caf50;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-block;
        }
        .btn-export:hover {
            background: #45a049;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📊 Detail Transaksi - <?= date('d F Y', strtotime($tanggal)) ?></h1>
        <div class="navbar-right">
            <span>👤 <?= session()->get('nama') ?></span>
            <a href="<?= base_url('admin/dashboard') ?>">🏠 Dashboard</a>
            <a href="<?= base_url('logout') ?>">🚪 Logout</a>
        </div>
    </div>

    <div class="container">
        <a href="<?= base_url('admin/laporan') ?>" class="back-button">
            ← Kembali ke Laporan
        </a>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">🚗</div>
                <div class="label">Total Transaksi</div>
                <div class="value"><?= $stats['total_transaksi'] ?></div>
            </div>
            <div class="stat-card">
                <div class="icon">💰</div>
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp <?= number_format($stats['total_pendapatan'], 0, ',', '.') ?></div>
            </div>
            <div class="stat-card">
                <div class="icon">⏱️</div>
                <div class="label">Rata-rata Durasi</div>
                <div class="value"><?= format_durasi(round($stats['rata_durasi'])) ?></div>
            </div>
            <div class="stat-card">
                <div class="icon">📈</div>
                <div class="label">Rata-rata Pendapatan</div>
                <div class="value">Rp <?= number_format($stats['total_transaksi'] > 0 ? $stats['total_pendapatan'] / $stats['total_transaksi'] : 0, 0, ',', '.') ?></div>
            </div>
        </div>

        <div class="content-card">
            <h2>
                <span>📋 Daftar Transaksi</span>
                <a href="javascript:window.print()" class="btn-export">Cetak</a>
            </h2>

            <?php if (empty($transaksi)): ?>
                <div class="empty-state">
                    <div style="font-size: 60px; margin-bottom: 20px;">📊</div>
                    <p>Tidak ada transaksi pada tanggal ini</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 15%;">ID Parkir</th>
                            <th style="width: 15%;">Waktu Masuk</th>
                            <th style="width: 15%;">Waktu Keluar</th>
                            <th style="width: 12%;">Durasi</th>
                            <th style="width: 13%;">Biaya</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($transaksi as $t): 
                            $info = parse_id_parkir($t['id_parkir']);
                        ?>
                        <tr>
                            <td style="text-align: center;"><?= $no++ ?></td>
                            <td>
                                <strong><?= $t['id_parkir'] ?></strong>
                                <br>
                                <small style="color: #999;">Transaksi #<?= $info['nomor_transaksi'] ?></small>
                            </td>
                            <td><?= date('H:i:s', strtotime($t['waktu_masuk'])) ?></td>
                            <td><?= date('H:i:s', strtotime($t['waktu_keluar'])) ?></td>
                            <td><strong><?= format_durasi($t['durasi_menit']) ?></strong></td>
                            <td><strong>Rp <?= number_format($t['biaya'], 0, ',', '.') ?></strong></td>
                            <td><span class="badge badge-selesai">SELESAI</span></td>
                            <td>
                                <a href="<?= base_url('parkir/scan/' . $t['id_parkir']) ?>" 
                                   class="btn-detail" target="_blank">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="total-row">
                            <td colspan="4" style="text-align: right; padding-right: 15px;">
                                <strong>TOTAL</strong>
                            </td>
                            <td><strong><?= format_durasi(round($stats['rata_durasi'] * $stats['total_transaksi'])) ?></strong></td>
                            <td><strong>Rp <?= number_format($stats['total_pendapatan'], 0, ',', '.') ?></strong></td>
                            <td colspan="2"><strong><?= $stats['total_transaksi'] ?> Transaksi</strong></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <style>
        @media print {
            .navbar, .back-button, .btn-detail, .btn-export { display: none; }
            body { background: white; }
            .container { margin: 0; padding: 20px; }
        }
    </style>
</body>
</html>