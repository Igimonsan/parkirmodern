<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Parkir -
        <?= $parkir['id_parkir'] ?>
    </title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 20px;
            }

            .no-print {
                display: none;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: white;
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
        }

        .struk {
            border: 2px dashed #333;
            padding: 20px;
            background: white;
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header .subtitle {
            font-size: 12px;
            color: #666;
        }

        .row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dotted #ccc;
        }

        .row:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: 600;
        }

        .value {
            text-align: right;
        }

        .section {
            margin: 15px 0;
        }

        .section-title {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .total {
            background: #333;
            color: white;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px dashed #333;
            font-size: 12px;
        }

        .btn-print {
            display: block;
            width: 100%;
            padding: 15px;
            background: #4caf50;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn-print:hover {
            background: #45a049;
        }
    </style>
</head>

<body>
    <div class="struk">
        <div class="header">
            <h1>E-PARKIR</h1>
            <div class="subtitle">Sistem Parkir Otomatis</div>
        </div>

        <div class="section">
            <div class="section-title">Informasi Parkir</div>
            <div class="row">
                <span class="label">ID Parkir:</span>
                <span class="value">
                    <?= $parkir['id_parkir'] ?>
                </span>
            </div>
            <div class="row">
                <span class="label">Transaksi:</span>
                <span class="value">#
                    <?= $parkir['info']['nomor_transaksi'] ?>
                </span>
            </div>
            <div class="row">
                <span class="label">Tanggal:</span>
                <span class="value">
                    <?= $parkir['info']['tanggal'] ?>/
                    <?= $parkir['info']['bulan'] ?>/
                    <?= $parkir['info']['tahun'] ?>
                </span>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Detail Waktu</div>
            <div class="row">
                <span class="label">Masuk:</span>
                <span class="value">
                    <?= date('d/m/Y H:i', strtotime($parkir['waktu_masuk'])) ?>
                </span>
            </div>
            <?php if ($parkir['status'] === 'selesai'): ?>
                <div class="row">
                    <span class="label">Keluar:</span>
                    <span class="value">
                        <?= date('d/m/Y H:i', strtotime($parkir['waktu_keluar'])) ?>
                    </span>
                </div>
                <div class="row">
                    <span class="label">Durasi:</span>
                    <span class="value">
                        <?= format_durasi($parkir['durasi_menit']) ?>
                    </span>
                </div>
            <?php else: ?>
                <div class="row">
                    <span class="label">Durasi:</span>
                    <span class="value">
                        <?= format_durasi($parkir['durasi_real']) ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <div class="section">
            <div class="section-title">Rincian Biaya</div>
            <div class="row">
                <span class="label">Biaya Awal:</span>
                <span class="value">Rp 5.000</span>
            </div>
            <?php
            $biaya = $parkir['status'] === 'selesai' ? $parkir['biaya'] : $parkir['biaya_real'];
            $durasi = $parkir['status'] === 'selesai' ? $parkir['durasi_menit'] : $parkir['durasi_real'];
            if ($durasi > 60):
                $jamTambahan = ceil(($durasi - 60) / 60);
                $biayaTambahan = $jamTambahan * 2000;
                ?>
                <div class="row">
                    <span class="label">Tambahan (
                        <?= $jamTambahan ?> jam):
                    </span>
                    <span class="value">Rp
                        <?= number_format($biayaTambahan, 0, ',', '.') ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <div class="total">
            TOTAL: Rp
            <?= number_format($biaya, 0, ',', '.') ?>
        </div>

        <div class="footer">
            <p><strong>Terima Kasih</strong></p>
            <p>Simpan struk ini sebagai bukti parkir</p>
            <p style="margin-top: 10px; font-size: 10px;">
                Dicetak:
                <?= date('d/m/Y H:i:s') ?>
            </p>
        </div>
    </div>

    <button class="btn-print no-print" onclick="window.print()">
        Cetak Struk
    </button>
</body>

</html>