<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Metode Pembayaran</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root { --blue-900: #0c2461; --blue-500: #2563EB; --muted: #475569; }
    body {
      background: #b8cfe8; display: flex; justify-content: center; align-items: center;
      height: 100vh; overflow: hidden; padding: 24px 16px; font-family: 'DM Sans', sans-serif;
    }
    .phone {
      width: 375px; height: 812px; border-radius: 44px; border: 9px solid #18181b;
      position: relative; overflow: hidden; display: flex; flex-direction: column;
      background: linear-gradient(165deg, #1e57b8 0%, #2563EB 18%, #4A90D9 36%, #82B8F0 54%, #C5DEFF 72%, #EBF4FF 88%, #F5F9FF 100%);
      box-shadow: 0 40px 80px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.12);
    }
    .notch { position: absolute; top: 8px; left: 50%; transform: translateX(-50%); width: 100px; height: 26px; background: #18181b; border-radius: 14px; z-index: 500; }
    .scroll { flex: 1; overflow-y: auto; scrollbar-width: none; padding-bottom: 40px; }
    .scroll::-webkit-scrollbar { display: none; }

    .page-header { display: flex; align-items: center; gap: 12px; padding: 52px 20px 20px; }
    .back-btn {
      width: 36px; height: 36px; border-radius: 12px;
      background: rgba(255,255,255,.55); border: 1px solid rgba(255,255,255,.8);
      display: flex; align-items: center; justify-content: center; cursor: pointer;
      box-shadow: 0 2px 8px rgba(12,36,97,.08);
    }
    .back-btn svg { width: 18px; height: 18px; stroke: var(--blue-900); fill: none; stroke-width: 2; stroke-linecap: round; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: var(--blue-900); }

    .section { padding: 0 20px 16px; }
    .sec-label { font-size: 12px; font-weight: 700; color: var(--blue-900); margin-bottom: 10px; letter-spacing: .2px; }

    .method-card {
      background: rgba(255,255,255,.75); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,.9); border-radius: 18px; padding: 14px 16px;
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 10px; cursor: pointer; transition: all .2s;
      box-shadow: 0 4px 16px rgba(12,36,97,.06), inset 0 1px 0 rgba(255,255,255,1);
    }
    .method-card.active { border-color: var(--blue-500); background: rgba(37,99,235,.08); }
    .method-left { display: flex; align-items: center; gap: 12px; }
    .method-icon {
      width: 44px; height: 44px; border-radius: 14px;
      background: rgba(37,99,235,.1); display: flex; align-items: center; justify-content: center;
    }
    .method-icon svg { width: 20px; height: 20px; stroke: var(--blue-500); fill: none; stroke-width: 1.8; stroke-linecap: round; }
    .method-name { font-size: 13px; font-weight: 700; color: var(--blue-900); }
    .method-sub { font-size: 10px; color: var(--muted); margin-top: 2px; }
    .method-badge {
      font-size: 9px; font-weight: 700; padding: 3px 8px; border-radius: 999px;
      background: #EFF6FF; color: var(--blue-500);
    }
    .method-badge.saved { background: #F0FDF4; color: #16a34a; }

    .add-btn {
      width: 100%; padding: 14px; border: 1.5px dashed rgba(37,99,235,.3);
      border-radius: 18px; background: rgba(255,255,255,.4); backdrop-filter: blur(12px);
      color: var(--blue-500); font-size: 13px; font-weight: 600;
      font-family: 'DM Sans', sans-serif; cursor: pointer; display: flex;
      align-items: center; justify-content: center; gap: 8px;
    }
    .add-btn svg { width: 16px; height: 16px; stroke: var(--blue-500); fill: none; stroke-width: 2; }

    html.dark-mode body { background: #020617; }
    html.dark-mode .phone { border-color: #0f172a !important; background: linear-gradient(165deg, #0f172a 0%, #111827 30%, #1f2937 60%, #0f172a 100%) !important; }
  </style>
</head>
<body>
<div class="phone">
  <div class="notch"></div>
  <div class="scroll">

    <div class="page-header">
      <button class="back-btn" onclick="history.back()">
        <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
      </button>
      <div class="page-title">Metode Pembayaran</div>
    </div>

    <div class="section">
      <div class="sec-label">Kartu Tersimpan</div>

      <div class="method-card active">
        <div class="method-left">
          <div class="method-icon">
            <svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/></svg>
          </div>
          <div>
            <div class="method-name">Visa •••• 4242</div>
            <div class="method-sub">Exp 08/27</div>
          </div>
        </div>
        <span class="method-badge saved">Utama</span>
      </div>

      <div class="method-card">
        <div class="method-left">
          <div class="method-icon">
            <svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/></svg>
          </div>
          <div>
            <div class="method-name">Mastercard •••• 8810</div>
            <div class="method-sub">Exp 03/26</div>
          </div>
        </div>
        <span class="method-badge">Kartu</span>
      </div>

      <button class="add-btn">
        <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        Tambah Kartu Baru
      </button>
    </div>

    <div class="section">
      <div class="sec-label">E-Wallet</div>

      <div class="method-card">
        <div class="method-left">
          <div class="method-icon">
            <svg viewBox="0 0 24 24"><path d="M8 2h8a2 2 0 012 2v16a2 2 0 01-2 2H8a2 2 0 01-2-2V4a2 2 0 012-2z"/><path d="M10 19h4"/></svg>
          </div>
          <div>
            <div class="method-name">GoPay</div>
            <div class="method-sub">Saldo: Rp 250.000</div>
          </div>
        </div>
        <span class="method-badge saved">Terhubung</span>
      </div>

      <div class="method-card">
        <div class="method-left">
          <div class="method-icon">
            <svg viewBox="0 0 24 24"><path d="M8 2h8a2 2 0 012 2v16a2 2 0 01-2 2H8a2 2 0 01-2-2V4a2 2 0 012-2z"/><path d="M10 19h4"/></svg>
          </div>
          <div>
            <div class="method-name">OVO</div>
            <div class="method-sub">Belum terhubung</div>
          </div>
        </div>
        <span class="method-badge">Hubungkan</span>
      </div>

      <div class="method-card">
        <div class="method-left">
          <div class="method-icon">
            <svg viewBox="0 0 24 24"><path d="M8 2h8a2 2 0 012 2v16a2 2 0 01-2 2H8a2 2 0 01-2-2V4a2 2 0 012-2z"/><path d="M10 19h4"/></svg>
          </div>
          <div>
            <div class="method-name">DANA</div>
            <div class="method-sub">Belum terhubung</div>
          </div>
        </div>
        <span class="method-badge">Hubungkan</span>
      </div>
    </div>

    <div class="section">
      <div class="sec-label">Transfer Bank</div>
      <div class="method-card">
        <div class="method-left">
          <div class="method-icon">
            <svg viewBox="0 0 24 24"><path d="M3 10L12 4l9 6"/><path d="M6 10v10h12V10"/></svg>
          </div>
          <div>
            <div class="method-name">Virtual Account</div>
            <div class="method-sub">BCA, Mandiri, BNI, BRI</div>
          </div>
        </div>
        <span class="method-badge">Tersedia</span>
      </div>
    </div>

  </div>
</div>
<script src="theme.js"></script>
</body>
</html>
