<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Masuk - <?= $parkir['id_parkir'] ?></title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .no-print,
            .btn-print,
            button {
                display: none !important;
                visibility: hidden !important;
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
            padding: 16px;
            max-width: 300px;
            margin: 0 auto;
        }

        .struk {
            border: 2px dashed #333;
            padding: 16px;
            background: white;
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }

        .header h1 {
            font-size: 22px;
            letter-spacing: 2px;
            margin-bottom: 3px;
        }

        .header .subtitle {
            font-size: 11px;
            color: #555;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 7px 0;
            border-bottom: 1px dotted #ccc;
            font-size: 13px;
        }

        .row:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: 700;
            color: #333;
        }

        .value {
            text-align: right;
            color: #111;
        }

        .qr-section {
            text-align: center;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 2px dashed #333;
        }

        .qr-section p {
            font-size: 11px;
            color: #555;
            margin-bottom: 8px;
        }

        .qr-section img {
            width: 160px;
            height: 160px;
            display: block;
            margin: 0 auto;
        }

        .footer {
            text-align: center;
            margin-top: 14px;
            padding-top: 12px;
            border-top: 2px dashed #333;
            font-size: 11px;
            color: #555;
            line-height: 1.6;
        }

        .btn-print {
            display: block;
            width: 100%;
            padding: 12px;
            background: #4caf50;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            margin-top: 16px;
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
            <div class="subtitle">Tiket Masuk Kendaraan</div>
        </div>

        <div class="row">
            <span class="label">ID Parkir</span>
            <span class="value"><?= $parkir['id_parkir'] ?></span>
        </div>
        <div class="row">
            <span class="label">Tanggal</span>
            <span class="value"><?= date('d/m/Y', strtotime($parkir['waktu_masuk'])) ?></span>
        </div>
        <div class="row">
            <span class="label">Masuk</span>
            <span class="value"><?= date('H:i', strtotime($parkir['waktu_masuk'])) ?></span>
        </div>

        <div class="qr-section">
            <p>Scan saat keluar</p>
            <img src="<?= $qr_base64 ?>" alt="QR Code <?= $parkir['id_parkir'] ?>">
        </div>

        <div class="footer">
            <p><strong>Simpan struk ini</strong></p>
            <p>Tunjukkan saat keluar parkir</p>
        </div>
    </div>

    <button class="btn-print no-print" onclick="window.print()">
        Cetak Struk
    </button>
</body>

</html> 