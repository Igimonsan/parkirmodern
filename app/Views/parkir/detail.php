<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Parkir -
        <?= $parkir['id_parkir'] ?>
    </title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #667eea;
        }

        .header h1 {
            color: #667eea;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .status-aktif {
            background: #4caf50;
            color: white;
        }

        .status-selesai {
            background: #999;
            color: white;
        }

        .info-section {
            margin: 20px 0;
        }

        .info-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-grid {
            display: grid;
            gap: 15px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            background: #f8f9ff;
            border-radius: 8px;
        }

        .info-label {
            font-weight: 600;
            color: #666;
        }

        .info-value {
            color: #667eea;
            font-weight: 600;
            text-align: right;
        }

        .biaya-highlight {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin: 25px 0;
        }

        .biaya-highlight .label {
            font-size: 14px;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .biaya-highlight .value {
            font-size: 36px;
            font-weight: 700;
        }

        .btn-pdf {
            display: block;
            width: 100%;
            padding: 15px;
            background: #4caf50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            transition: background 0.3s;
            margin-top: 20px;
        }

        .btn-pdf:hover {
            background: #45a049;
        }

        .note {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1> Detail Parkir</h1>
            <span class="status-badge status-<?= $parkir['status'] ?>">
                <?= strtoupper($parkir['status']) ?>
            </span>
        </div>

        <div class="info-section">
            <div class="info-title"> Informasi Parkir</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">ID Parkir:</span>
                    <span class="info-value">
                        <?= $parkir['id_parkir'] ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Transaksi Ke:</span>
                    <span class="info-value">#
                        <?= $parkir['info']['nomor_transaksi'] ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal:</span>
                    <span class="info-value">
                        <?= $parkir['info']['tanggal'] ?>/
                        <?= $parkir['info']['bulan'] ?>/
                        <?= $parkir['info']['tahun'] ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="info-section">
            <div class="info-title">Waktu</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Waktu Masuk:</span>
                    <span class="info-value">
                        <?= date('d/m/Y H:i', strtotime($parkir['waktu_masuk'])) ?>
                    </span>
                </div>
                <?php if ($parkir['status'] === 'selesai'): ?>
                    <div class="info-item">
                        <span class="info-label">Waktu Keluar:</span>
                        <span class="info-value">
                            <?= date('d/m/Y H:i', strtotime($parkir['waktu_keluar'])) ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Lama Parkir:</span>
                        <span class="info-value">
                            <?= format_durasi($parkir['durasi_menit']) ?>
                        </span>
                    </div>
                <?php else: ?>
                    <div class="info-item">
                        <span class="info-label">Lama Parkir:</span>
                        <span class="info-value">
                            <?= format_durasi($parkir['durasi_real']) ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="biaya-highlight">
            <div class="label">Total Biaya Parkir</div>
            <div class="value">
                Rp
                <?= number_format($parkir['status'] === 'selesai' ? $parkir['biaya'] : $parkir['biaya_real'], 0, ',', '.') ?>
            </div>
        </div>

        <?php if ($parkir['status'] === 'aktif'): ?>
            <div class="note">
                ℹ️ <strong>Catatan:</strong> Biaya ini adalah estimasi real-time.
                Biaya final akan dihitung saat checkout.
                <br><br>
                📌 Tarif: Rp 5.000 (pertama) + Rp 2.000/jam setelah 1 jam pertama
            </div>
        <?php endif; ?>

        <a href="<?= base_url('parkir/pdf/' . $parkir['id_parkir']) ?>" class="btn-pdf" target="_blank">
            Cetak / Download PDF
        </a>
    </div>
</body>

</html>