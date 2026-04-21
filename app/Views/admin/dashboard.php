<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-PARKIR</title>
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .content-card h2 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #667eea;
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

        .badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-aktif {
            background: #4caf50;
            color: white;
        }

        .btn-checkout {
            background: #ff9800;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn-checkout:hover {
            background: #f57c00;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .empty-state {
            text-align: center;
            padding: 50px;
            color: #999;
        }

        /* === PANEL PERANGKAT === */
        .device-panel {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }

        .device-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #667eea;
        }

        .device-panel-header h2 {
            color: #333;
            font-size: 18px;
        }

        .btn-reload {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: opacity 0.2s;
        }

        .btn-reload:hover { opacity: 0.85; }
        .btn-reload:disabled { opacity: 0.5; cursor: not-allowed; }

        .device-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .device-grid { grid-template-columns: 1fr; }
        }

        .device-section h3 {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .device-list {
            list-style: none;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            min-height: 60px;
        }

        .device-list li {
            padding: 10px 14px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .device-list li:last-child { border-bottom: none; }

        .device-list li.empty {
            color: #aaa;
            font-style: italic;
            justify-content: center;
        }

        .device-status {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4caf50;
            flex-shrink: 0;
        }

        /* === SEARCH === */
        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-bar input {
            flex: 1;
            padding: 10px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        .search-bar input:focus { border-color: #667eea; }

        .btn-search {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: opacity 0.2s;
        }

        .btn-search:hover { opacity: 0.85; }

        .search-result-badge {
            font-size: 12px;
            background: #667eea;
            color: white;
            padding: 2px 10px;
            border-radius: 10px;
            margin-left: 8px;
            vertical-align: middle;
        }

        .row-highlight {
            background: #fffde7 !important;
            outline: 2px solid #f9a825;
        }

        /* === WEBCAM MODAL === */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active { display: flex; }

        .modal-box {
            background: white;
            border-radius: 16px;
            padding: 24px;
            width: 90%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .modal-box h3 {
            color: #333;
            margin-bottom: 4px;
        }

        .modal-box .modal-sub {
            color: #888;
            font-size: 13px;
            margin-bottom: 14px;
        }

        /* Area video dengan overlay scan */
        .scan-viewport {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            background: #000;
            border-radius: 12px;
            overflow: hidden;
        }

        #webcamVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Overlay gelap di luar area scan */
        .scan-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        /* Area scan tengah 60% */
        .scan-area {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 65%;
            aspect-ratio: 1 / 1;
            border: 3px solid rgba(255,255,255,0.9);
            border-radius: 8px;
            box-shadow:
                0 0 0 9999px rgba(0,0,0,0.45),
                inset 0 0 0 2px rgba(102,126,234,0.6);
        }

        /* Sudut scan (corner brackets) */
        .scan-area::before,
        .scan-area::after {
            content: '';
            position: absolute;
            width: 22px;
            height: 22px;
            border-color: #667eea;
            border-style: solid;
        }

        .scan-area::before {
            top: -3px; left: -3px;
            border-width: 4px 0 0 4px;
            border-radius: 4px 0 0 0;
        }

        .scan-area::after {
            bottom: -3px; right: -3px;
            border-width: 0 4px 4px 0;
            border-radius: 0 0 4px 0;
        }

        /* Garis scan animasi */
        .scan-line {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 65%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #667eea, transparent);
            animation: scanMove 2s ease-in-out infinite;
        }

        @keyframes scanMove {
            0%   { margin-top: -32.5%; }
            50%  { margin-top:  32.5%; }
            100% { margin-top: -32.5%; }
        }

        .scan-status {
            margin-top: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            background: #f5f5f5;
            color: #666;
        }

        .scan-status.scanning { background: #e3f2fd; color: #1565c0; }
        .scan-status.success  { background: #e8f5e9; color: #2e7d32; }
        .scan-status.error    { background: #fce4ec; color: #c62828; }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 14px;
        }

        .btn-close-modal {
            flex: 1;
            padding: 10px;
            border: 2px solid #ddd;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.2s;
        }

        .btn-close-modal:hover { background: #f5f5f5; }
    </style>
</head>

<body>
    <div class="navbar">
        <h1> E-PARKIR - Admin</h1>
        <div class="navbar-right">
            <span>👤
                <?= session()->get('nama') ?>
            </span>
            <a href="<?= base_url('admin/laporan') ?>">📊 Laporan</a>
            <a href="<?= base_url('parkir') ?>">🅿️ Parkir</a>
            <a href="<?= base_url('logout') ?>">🚪 Logout</a>
        </div>
    </div>

    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                ✅
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                ❌
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- PANEL PERANGKAT -->
        <div class="device-panel">
            <div class="device-panel-header">
                <h2>🔧 Perangkat</h2>
                <button class="btn-reload" id="btnReloadDevices" onclick="loadDevices()">
                    🔄 Reload
                </button>
            </div>
            <div class="device-grid">
                <div class="device-section">
                    <h3>📷 Webcam</h3>
                    <ul class="device-list" id="webcamList">
                        <li class="empty">Klik Reload untuk memuat...</li>
                    </ul>
                </div>
                <div class="device-section">
                    <h3>🖨️ Printer</h3>
                    <ul class="device-list" id="printerList">
                        <li class="empty">Klik Reload untuk memuat...</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- MODAL WEBCAM SCAN -->
        <div class="modal-overlay" id="webcamModal">
            <div class="modal-box">
                <h3>📷 Scan QR Kendaraan</h3>
                <p class="modal-sub">Posisikan QR Code di dalam kotak</p>

                <div class="scan-viewport">
                    <video id="webcamVideo" autoplay playsinline muted></video>
                    <div class="scan-overlay">
                        <div class="scan-area"></div>
                        <div class="scan-line"></div>
                    </div>
                </div>

                <canvas id="webcamCanvas" style="display:none;"></canvas>
                <div class="scan-status scanning" id="scanStatus">🔍 Menginisialisasi kamera...</div>
                <div class="modal-actions">
                    <button class="btn-close-modal" onclick="closeWebcamModal()">✖ Tutup</button>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">🚗</div>
                <div class="label">Kendaraan Parkir Saat Ini</div>
                <div class="value">
                    <?= $stats['aktif'] ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon">📅</div>
                <div class="label">Transaksi Hari Ini</div>
                <div class="value">
                    <?= $stats['today'] ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon">💰</div>
                <div class="label">Pendapatan Hari Ini</div>
                <div class="value">Rp
                    <?= number_format($stats['today_revenue'], 0, ',', '.') ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon">📊</div>
                <div class="label">Pendapatan Minggu Ini</div>
                <div class="value">Rp
                    <?= number_format($stats['week_revenue'], 0, ',', '.') ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon">📈</div>
                <div class="label">Pendapatan Bulan Ini</div>
                <div class="value">Rp
                    <?= number_format($stats['month_revenue'], 0, ',', '.') ?>
                </div>
            </div>
        </div>

        <div class="content-card">
            <h2>🅿️ Kendaraan Sedang Parkir</h2>

            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="🔍 Cari ID Parkir..." oninput="searchTable()" onkeydown="if(event.key==='Escape'){clearSearch()}">
                <button class="btn-search" onclick="openWebcamModal()">📷 Scan QR</button>
            </div>

            <?php if (empty($parkir_aktif)): ?>
                <div class="empty-state">
                    <div style="font-size: 60px; margin-bottom: 20px;">🚫</div>
                    <p>Tidak ada kendaraan yang sedang parkir</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID Parkir</th>
                            <th>Waktu Masuk</th>
                            <th>Durasi</th>
                            <th>Estimasi Biaya</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parkir_aktif as $p):
                            $hitungan = hitung_biaya_parkir($p['waktu_masuk']);
                            ?>
                            <tr data-id="<?= strtolower($p['id_parkir']) ?>">
                                <td><strong>
                                        <?= $p['id_parkir'] ?>
                                    </strong></td>
                                <td>
                                    <?= date('d/m/Y H:i', strtotime($p['waktu_masuk'])) ?>
                                </td>
                                <td>
                                    <?= format_durasi($hitungan['durasi_menit']) ?>
                                </td>
                                <td><strong>Rp
                                        <?= number_format($hitungan['biaya'], 0, ',', '.') ?>
                                    </strong></td>
                                <td><span class="badge badge-aktif">AKTIF</span></td>
                                <td>
                                    <form action="<?= base_url('admin/checkout/' . $p['id']) ?>" method="POST"
                                        onsubmit="return confirm('Checkout kendaraan dengan ID <?= $p['id_parkir'] ?>?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn-checkout">Checkout</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>

<script>
// =============================================
// DEVICE LIST (Webcam & Printer)
// =============================================
async function loadDevices() {
    const btn = document.getElementById('btnReloadDevices');
    btn.disabled = true;
    btn.textContent = '⏳ Memuat...';

    const webcamList  = document.getElementById('webcamList');
    const printerList = document.getElementById('printerList');

    webcamList.innerHTML  = '<li class="empty">Memuat...</li>';
    printerList.innerHTML = '<li class="empty">Memuat...</li>';

    // --- Webcam via MediaDevices API ---
    try {
        const devices = await navigator.mediaDevices.enumerateDevices();
        const cameras = devices.filter(d => d.kind === 'videoinput');
        if (cameras.length === 0) {
            webcamList.innerHTML = '<li class="empty">Tidak ada webcam ditemukan</li>';
        } else {
            webcamList.innerHTML = cameras.map((c, i) =>
                `<li><span class="device-status"></span>${c.label || 'Kamera ' + (i + 1)}</li>`
            ).join('');
        }
    } catch (e) {
        webcamList.innerHTML = '<li class="empty">Akses kamera ditolak</li>';
    }

    // --- Printer via window.print detection (browser limitation) ---
    // Browser tidak bisa enumerate printer secara langsung.
    // Kita deteksi apakah browser mendukung printing dan tampilkan status.
    try {
        const mediaMatch = window.matchMedia('print');
        printerList.innerHTML = `
            <li><span class="device-status"></span>Printer Sistem Default</li>
            <li style="color:#888;font-size:12px;padding:8px 14px;border-bottom:none;">
                ℹ️ Browser hanya mengakses printer default. Pilih printer saat dialog print muncul.
            </li>`;
    } catch (e) {
        printerList.innerHTML = '<li class="empty">Tidak dapat mendeteksi printer</li>';
    }

    btn.disabled = false;
    btn.innerHTML = '🔄 Reload';
}

// =============================================
// SEARCH BY ID PARKIR
// =============================================
function searchTable() {
    const query = document.getElementById('searchInput').value.trim().toLowerCase();
    const rows  = document.querySelectorAll('tbody tr[data-id]');
    let found   = 0;

    rows.forEach(row => {
        const id = row.getAttribute('data-id');
        if (!query || id.includes(query)) {
            row.style.display = '';
            row.classList.toggle('row-highlight', query.length > 0 && id.includes(query));
            if (query && id.includes(query)) found++;
        } else {
            row.style.display = 'none';
            row.classList.remove('row-highlight');
        }
    });

    // Update heading count badge
    const h2 = document.querySelector('.content-card h2');
    const badge = document.getElementById('searchBadge');
    if (query) {
        if (!badge) {
            const b = document.createElement('span');
            b.id = 'searchBadge';
            b.className = 'search-result-badge';
            b.textContent = found + ' hasil';
            h2.appendChild(b);
        } else {
            badge.textContent = found + ' hasil';
        }
    } else {
        if (badge) badge.remove();
    }
}

function clearSearch() {
    document.getElementById('searchInput').value = '';
    searchTable();
}

// =============================================
// WEBCAM SCAN QR → AUTO CHECKOUT
// =============================================
let webcamStream = null;
let zxingReader  = null;
let lastScanned  = '';
let scanCooldown = false;
let scanCount    = 0;
let scanInterval = null; // dummy
let _decodeActive = false;

async function openWebcamModal() {
    document.getElementById('webcamModal').classList.add('active');
    setScanStatus('scanning', '\ud83d\udd0d Menginisialisasi kamera...');
    lastScanned   = '';
    scanCooldown  = false;
    scanCount     = 0;
    _decodeActive = true;

    try {
        const video = document.getElementById('webcamVideo');
        webcamStream = await navigator.mediaDevices.getUserMedia({
            video: { width: { ideal: 1280 }, height: { ideal: 720 } }
        });
        video.srcObject = webcamStream;
        await video.play();
        setScanStatus('scanning', '\ud83d\udcf7 Kamera aktif \u2014 arahkan QR Code ke kotak...');
        decodeLoop();
    } catch (e) {
        setScanStatus('error', '\u274c Gagal mengakses kamera: ' + e.message);
    }
}

function closeWebcamModal() {
    _decodeActive = false;
    if (webcamStream) {
        webcamStream.getTracks().forEach(t => t.stop());
        webcamStream = null;
    }
    const video = document.getElementById('webcamVideo');
    if (video) video.srcObject = null;
    document.getElementById('webcamModal').classList.remove('active');
    setScanStatus('scanning', '\ud83d\udd0d Menginisialisasi kamera...');
    lastScanned  = '';
    scanCooldown = false;
}

async function decodeLoop() {
    const video  = document.getElementById('webcamVideo');
    const canvas = document.getElementById('webcamCanvas');
    const ctx    = canvas.getContext('2d', { willReadFrequently: true });

    while (_decodeActive) {
        await new Promise(r => setTimeout(r, 150));
        if (!_decodeActive || scanCooldown) continue;
        if (video.readyState < video.HAVE_ENOUGH_DATA || !video.videoWidth) continue;

        canvas.width  = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0);

        try {
            // Gunakan BarcodeDetector API (tersedia di Chromium/Electron)
            if (window._barcodeDetector) {
                const codes = await window._barcodeDetector.detect(canvas);
                if (codes.length > 0) {
                    const val = codes[0].rawValue;
                    if (val && val !== lastScanned) {
                        lastScanned = val;
                        handleQRResult(val);
                    }
                } else {
                    scanCount++;
                    if (scanCount % 15 === 0) setScanStatus('scanning', '\ud83d\udcf7 Scanning frame ' + scanCount + '...');
                }
            }
        } catch(e) {
            // skip frame
        }
    }
}

function stopQRScan() { _decodeActive = false; }

// Init BarcodeDetector saat halaman load
(async function initDetector() {
    if ('BarcodeDetector' in window) {
        window._barcodeDetector = new BarcodeDetector({ formats: ['qr_code'] });
        console.log('BarcodeDetector ready');
    } else {
        console.warn('BarcodeDetector tidak tersedia, scan mungkin tidak berfungsi');
    }
})();

async function handleQRResult(qrData) {
    scanCooldown = true;

    // Extract ID Parkir dari URL
    let idParkir = qrData.trim();
    const match = qrData.match(/parkir\/scan\/([^/?#\s]+)/);
    if (match) idParkir = match[1].trim();

    setScanStatus('scanning', '✅ QR: ' + idParkir + ' — mencari...');

    // Cari row di tabel — case insensitive
    const rows = document.querySelectorAll('tbody tr[data-id]');
    let matchRow = null;
    rows.forEach(row => {
        const rowId = row.getAttribute('data-id').trim().toLowerCase();
        if (rowId === idParkir.toLowerCase()) matchRow = row;
    });

    if (!matchRow) {
        // Tampilkan semua ID yang ada di tabel untuk debug
        const allIds = Array.from(rows).map(r => r.getAttribute('data-id')).join(', ');
        setScanStatus('error', '⚠️ "' + idParkir + '" tidak ditemukan. Aktif: [' + (allIds || 'kosong') + ']');
        setTimeout(() => {
            setScanStatus('scanning', '📷 Arahkan QR Code ke dalam kotak...');
            scanCooldown = false;
            lastScanned  = '';
        }, 5000);
        return;
    }

    const form = matchRow.querySelector('form[action*="checkout"]');
    if (!form) {
        setScanStatus('error', '⚠️ Form checkout tidak ditemukan');
        setTimeout(() => { scanCooldown = false; lastScanned = ''; }, 2000);
        return;
    }

    setScanStatus('success', '🚗 Checkout otomatis: ' + idParkir + '...');

    document.querySelectorAll('tbody tr').forEach(r => r.classList.remove('row-highlight'));
    matchRow.classList.add('row-highlight');
    matchRow.scrollIntoView({ behavior: 'smooth', block: 'center' });

    setTimeout(() => {
        closeWebcamModal();
        form.submit();
    }, 1500);
}

function setScanStatus(type, text) {
    const el = document.getElementById('scanStatus');
    el.className = 'scan-status ' + type;
    el.textContent = text;
}

// Tutup modal jika klik di luar
document.getElementById('webcamModal').addEventListener('click', function(e) {
    if (e.target === this) closeWebcamModal();
});
</script>