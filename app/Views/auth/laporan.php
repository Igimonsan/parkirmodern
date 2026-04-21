<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Parkir Modern</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
            background: rgba(255, 255, 255, 0.2);
        }

        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .filter-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: #4caf50;
            color: white;
        }

        .btn-success:hover {
            background: #45a049;
        }

        .content-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        table tr:hover {
            background: #f8f9ff;
        }

        .summary-row {
            background: #667eea !important;
            color: white;
            font-weight: 700;
        }

        .summary-row td {
            border: none;
        }

        .empty-state {
            text-align: center;
            padding: 50px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <h1>📊 Laporan Parkir</h1>
        <div class="navbar-right">
            <span>👤
                <?= session()->get('nama') ?>
            </span>
            <a href="<?= base_url('admin/dashboard') ?>">🏠 Dashboard</a>
            <a href="<?= base_url('logout') ?>">🚪 Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="filter-card">
            <form action="<?= base_url('admin/laporan') ?>" method="GET" class="filter-form">
                <div class="form-group">
                    <label for="periode">Periode</label>
                    <select name="periode" id="periode">
                        <option value="daily" <?= $periode === 'daily' ? 'selected' : '' ?>>Harian</option>
                        <option value="weekly" <?= $periode === 'weekly' ? 'selected' : '' ?>>Mingguan</option>
                        <option value="monthly" <?= $periode === 'monthly' ? 'selected' : '' ?>>Bulanan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="<?= $start_date ?>" required>
                </div>

                <div class="form-group">
                    <label for="end_date">Tanggal Akhir</label>
                    <input type="date" name="end_date" id="end_date" value="<?= $end_date ?>" required>
                </div>

                <div class="form-group" style="flex-direction: row; gap: 10px;">
                    <button type="submit" class="btn btn-primary">🔍 Tampilkan</button>
                    <a href="<?= base_url('admin/export-pdf?periode=' . $periode . '&start_date=' . $start_date . '&end_date=' . $end_date) ?>"
                        class="btn btn-success" target="_blank">📄 Export PDF</a>
                </div>
            </form>
        </div>

        <div class="content-card">
            <h2>
                <span>📈 Laporan
                    <?= ucfirst($periode === 'daily' ? 'Harian' : ($periode === 'weekly' ? 'Mingguan' : 'Bulanan')) ?>
                </span>
                <span style="font-size: 14px; font-weight: 400; color: #666;">
                    <?= date('d/m/Y', strtotime($start_date)) ?> -
                    <?= date('d/m/Y', strtotime($end_date)) ?>
                </span>
            </h2>

            <?php if (empty($laporan)): ?>
                <div class="empty-state">
                    <div style="font-size: 60px; margin-bottom: 20px;">📊</div>
                    <p>Tidak ada data laporan untuk periode ini</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Total Transaksi</th>
                            <th>Total Pendapatan</th>
                            <th>Rata-rata per Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalTransaksi = 0;
                        $totalPendapatan = 0;
                        foreach ($laporan as $row):
                            $totalTransaksi += $row['total_transaksi'];
                            $totalPendapatan += $row['total_pendapatan'];
                            $ratarata = $row['total_transaksi'] > 0 ? $row['total_pendapatan'] / $row['total_transaksi'] : 0;
                            ?>
                            <tr>
                                <td>
                                    <?php if ($periode === 'weekly'): ?>
                                        Minggu ke-
                                        <?= $row['minggu'] ?? '-' ?>,
                                        <?= $row['tahun'] ?? '-' ?>
                                    <?php elseif ($periode === 'monthly'): ?>
                                        <?php
                                        $bulanNama = [
                                            1 => 'Januari',
                                            2 => 'Februari',
                                            3 => 'Maret',
                                            4 => 'April',
                                            5 => 'Mei',
                                            6 => 'Juni',
                                            7 => 'Juli',
                                            8 => 'Agustus',
                                            9 => 'September',
                                            10 => 'Oktober',
                                            11 => 'November',
                                            12 => 'Desember'
                                        ];
                                        echo $bulanNama[$row['bulan']] . ' ' . $row['tahun'];
                                        ?>
                                    <?php else: ?>
                                        <?= date('d/m/Y', strtotime($row['tanggal'])) ?>
                                    <?php endif; ?>
                                </td>
                                <td><strong>
                                        <?= $row['total_transaksi'] ?>
                                    </strong> transaksi</td>
                                <td><strong>Rp
                                        <?= number_format($row['total_pendapatan'], 0, ',', '.') ?>
                                    </strong></td>
                                <td>Rp
                                    <?= number_format($ratarata, 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="summary-row">
                            <td><strong>TOTAL</strong></td>
                            <td><strong>
                                    <?= $totalTransaksi ?> transaksi
                                </strong></td>
                            <td><strong>Rp
                                    <?= number_format($totalPendapatan, 0, ',', '.') ?>
                                </strong></td>
                            <td><strong>Rp
                                    <?= number_format($totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0, 0, ',', '.') ?>
                                </strong></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>