<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PARKIR</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        h1 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
        }
        .btn-parkir {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 20px 50px;
            font-size: 20px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        .btn-parkir:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        }
        .btn-parkir:active {
            transform: translateY(-2px);
        }
        .btn-parkir:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .qr-container {
            margin-top: 30px;
            display: none;
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .qr-code {
            max-width: 300px;
            margin: 20px auto;
            border: 5px solid #667eea;
            border-radius: 15px;
            padding: 10px;
            background: white;
        }
        .info-parkir {
            background: #f8f9ff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            text-align: left;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #333;
        }
        .info-value {
            color: #667eea;
            font-weight: 600;
        }
        .loading {
            display: none;
            margin-top: 20px;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .admin-link {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        .admin-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>E-PARKIR</h1>
        <p class="subtitle">Inovasi teknologi di bidang parkir</p>

        <button class="btn-parkir" id="btnParkir" onclick="createParkir()">
            PARKIR SEKARANG
        </button>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p style="margin-top: 15px; color: #666;">Membuat tiket parkir...</p>
        </div>

        <div class="qr-container" id="qrContainer">
            <h3 style="color: #667eea; margin-bottom: 15px;">Tiket Parkir Anda</h3>
            <img class="qr-code" id="qrCode" src="" alt="QR Code Parkir">
            
            <div class="info-parkir">
                <div class="info-item">
                    <span class="info-label">ID Parkir:</span>
                    <span class="info-value" id="idParkir">-</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Waktu Masuk:</span>
                    <span class="info-value" id="waktuMasuk">-</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Biaya Awal:</span>
                    <span class="info-value" id="biayaAwal">-</span>
                </div>
            </div>

            <p style="margin-top: 20px; color: #666; font-size: 14px;">
                 Scan QR Code ini saat keluar untuk mengetahui biaya parkir
            </p>

            <button class="btn-parkir" style="margin-top: 20px; font-size: 16px; padding: 12px 30px;" onclick="resetForm()">
                Buat Tiket Baru
            </button>
        </div>

        <div class="admin-link">
            <a href="<?= base_url('login') ?>">Login Admin</a>
        </div>
    </div>

    <script>
        async function createParkir() {
            const btnParkir = document.getElementById('btnParkir');
            const loading = document.getElementById('loading');
            const qrContainer = document.getElementById('qrContainer');

            btnParkir.disabled = true;
            loading.style.display = 'block';
            qrContainer.style.display = 'none';

            try {
                const response = await fetch('<?= base_url('parkir/create') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });

                const result = await response.json();

                if (result.success) {
                    document.getElementById('qrCode').src = result.data.qr_code;
                    document.getElementById('idParkir').textContent = result.data.id_parkir;
                    document.getElementById('waktuMasuk').textContent = formatDateTime(result.data.waktu_masuk);
                    document.getElementById('biayaAwal').textContent = formatRupiah(result.data.biaya_awal);

                    qrContainer.style.display = 'block';

                    // Auto-print struk setelah tiket dibuat
                    autoPrintStruk(result.data.id_parkir);
                } else {
                    alert('Gagal membuat tiket parkir: ' + result.message);
                    btnParkir.disabled = false;
                }
            } catch (error) {
                alert('Terjadi kesalahan: ' + error.message);
                btnParkir.disabled = false;
            } finally {
                loading.style.display = 'none';
            }
        }

        function resetForm() {
            location.reload();
        }

        function formatDateTime(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function autoPrintStruk(idParkir) {
            const struktUrl = '<?= base_url('parkir/struk/') ?>' + idParkir;
            const printWin = window.open(struktUrl, '_blank', 'width=400,height=600');
            if (printWin) {
                printWin.onload = function () {
                    printWin.focus();
                    printWin.print();
                };
            }
        }
    </script>
</body>
</html>