<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staycation App</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --blue-900: #0c2461;
    --blue-700: #1e5799;
    --blue-500: #2563EB;
    --blue-400: #3B82F6;
    --blue-300: #60A5FA;
    --blue-100: #DBEAFE;
    --blue-50:  #EFF6FF;
    
    /* Konfigurasi Kaca Super Transparan & Tipis ala Mockup Kanan */
    --glass-bg: rgba(255, 255, 255, 0.40);
    --glass-border: rgba(255, 255, 255, 0.45);
    --glass-blur: blur(25px);
    --glass-bg-dark: rgba(255,255,255,0.10);
    --muted: #475569;
  }

  body {
    background: #b8cfe8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden; /* Mengunci scroll browser desktop */
    padding: 24px 16px;
    font-family: 'DM Sans', sans-serif;
  }

  /* ── PHONE FRAME ── */
  .phone {
    width: 375px;
    height: 812px;
    border-radius: 44px;
    border: 9px solid #18181b;
    position: relative;
    background: linear-gradient(165deg,
      #1e57b8 0%,
      #2563EB 18%,
      #4A90D9 36%,
      #82B8F0 54%,
      #C5DEFF 72%,
      #EBF4FF 88%,
      #F5F9FF 100%
    );
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow:
      0 40px 80px rgba(0,0,0,.35),
      inset 0 0 0 1px rgba(255,255,255,.12);
  }

  /* cloud blobs */
  .blob {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
  }
  .blob-1 {
    width: 320px; height: 320px;
    background: radial-gradient(circle, rgba(255,255,255,.22) 0%, transparent 70%);
    top: -80px; right: -80px;
    animation: drift 12s ease-in-out infinite;
  }
  .blob-2 {
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(255,255,255,.14) 0%, transparent 70%);
    top: 60px; left: -60px;
    animation: drift 16s ease-in-out infinite reverse;
  }
  @keyframes drift {
    0%,100% { transform: translate(0,0) scale(1); }
    50% { transform: translate(12px,-16px) scale(1.06); }
  }

  .notch {
    position: absolute;
    top: 8px; left: 50%;
    transform: translateX(-50%);
    width: 100px; height: 26px;
    background: #18181b;
    border-radius: 14px;
    z-index: 500; /* Selalu berada di atas konten & modal */
  }

  /* ── SCROLL AREA ── */
  .scroll {
    flex: 1;
    overflow-y: auto;
    scrollbar-width: none;
    padding-bottom: 110px; /* Ditambah jaraknya agar tidak terpotong navbar fixed */
    position: relative;
    z-index: 10;
  }
  .scroll::-webkit-scrollbar { display: none; }

  /* ── STATUS BAR ── */
  .statusbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 42px 24px 0;
    font-size: 11px;
    font-weight: 600;
    color: rgba(255,255,255,.9);
    letter-spacing: .3px;
  }
  .statusbar .icons { display: flex; gap: 5px; align-items: center; }
  .statusbar .icons svg { width: 14px; height: 14px; fill: rgba(255,255,255,.9); }

  /* ── TOP BAR ── */
  .topbar {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 10px 20px 0;
  }
  .topbar .greeting { color: rgba(255,255,255,.8); font-size: 12px; font-weight: 400; }
  .topbar .name {
    color: white;
    font-size: 18px;
    font-weight: 700;
    font-family: 'Playfair Display', serif;
    letter-spacing: -.2px;
  }
  .avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ffd89b, #19547b);
    border: 2px solid rgba(255,255,255,.5);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 14px; font-weight: 700;
  }

  /* ── HERO BANNER ── */
  .hero {
    margin: 16px 16px 0;
    background: linear-gradient(135deg, rgba(13,40,120,.85), rgba(30,87,185,.75));
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 22px;
    padding: 18px 20px;
    border: 1px solid rgba(255,255,255,.2);
    box-shadow: 0 8px 32px rgba(13,40,120,.3), inset 0 1px 0 rgba(255,255,255,.15);
    position: relative;
    overflow: hidden;
  }
  .hero::after {
    content: '';
    position: absolute;
    top: -30px; right: -20px;
    width: 120px; height: 120px;
    background: radial-gradient(circle, rgba(255,255,255,.12) 0%, transparent 65%);
    pointer-events: none;
  }
  .hero-eyebrow {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: rgba(255,255,255,.6);
    margin-bottom: 5px;
  }
  .hero h2 {
    font-family: 'Playfair Display', serif;
    font-size: 17px;
    font-weight: 700;
    color: white;
    line-height: 1.3;
    margin-bottom: 5px;
  }
  .hero p {
    font-size: 10px;
    color: rgba(255,255,255,.7);
    line-height: 1.6;
    margin-bottom: 14px;
  }
  .hero-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: white;
    color: #1D4ED8;
    font-size: 11px;
    font-weight: 700;
    padding: 8px 16px;
    border-radius: 10px;
    cursor: pointer;
    transition: transform .15s, box-shadow .15s;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
  }
  .hero-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(0,0,0,.2); }
  .hero-btn svg { width: 12px; height: 12px; fill: #1D4ED8; }

  /* ── SEARCH BAR ── */
  .search-wrap { padding: 14px 16px 0; }
  .searchbar {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,.75);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border-radius: 16px;
    padding: 0 14px;
    height: 48px;
    border: 1px solid rgba(255,255,255,.9);
    box-shadow: 0 4px 18px rgba(37,99,235,.1);
  }
  .searchbar svg { width: 16px; height: 16px; flex-shrink: 0; }
  .searchbar input {
    flex: 1;
    border: none;
    background: transparent;
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    color: #1e3a5f;
    outline: none;
  }
  .searchbar input::placeholder { color: rgba(30,58,95,.4); }
  .filter-pill {
    width: 32px; height: 32px;
    background: #2563EB;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    cursor: pointer;
  }
  .filter-pill svg { width: 15px; height: 15px; fill: white; }

  /* ── FILTER CHIPS ── */
  .chips {
    display: flex;
    gap: 8px;
    padding: 12px 16px 0;
    overflow-x: auto;
    scrollbar-width: none;
  }
  .chips::-webkit-scrollbar { display: none; }
  .chip {
    white-space: nowrap;
    padding: 7px 16px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    flex-shrink: 0;
  }
  .chip.active {
    background: #1D4ED8;
    color: white;
    box-shadow: 0 4px 14px rgba(29,78,216,.4);
  }
  .chip.idle {
    background: rgba(255,255,255,.65);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    color: #1e3a5f;
    border: 1px solid rgba(255,255,255,.85);
  }
  .chip.idle:hover { background: rgba(255,255,255,.85); }

  /* ── SECTION HEADER ── */
  .sec-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 16px 10px;
  }
  .sec-head .title {
    font-size: 14px;
    font-weight: 700;
    color: #0c2461;
    font-family: 'Playfair Display', serif;
  }
  .sec-head .see-all {
    font-size: 10px;
    font-weight: 600;
    color: #2563EB;
    cursor: pointer;
  }

  /* ── STACKED CATEGORY CARDS ── */
  .stack-row {
    display: flex;
    gap: 12px;
    padding: 0 16px;
    overflow-x: auto;
    scrollbar-width: none;
  }
  .stack-row::-webkit-scrollbar { display: none; }

  .stack-group {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0;
    cursor: pointer;
  }

  .stack-cluster {
    position: relative;
    width: 88px;
    height: 80px;
    margin-bottom: 8px;
  }
  .stack-cluster .sc {
    position: absolute;
    width: 78px;
    height: 68px;
    border-radius: 14px;
    overflow: hidden;
    border: 2px solid white;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
  }
  .stack-cluster .sc img { width: 100%; height: 100%; object-fit: cover; display: block; }
  .stack-cluster .sc:nth-child(1) { top: 0; left: 10px; transform: rotate(6deg); opacity: .6; filter: brightness(.85); z-index: 1; }
  .stack-cluster .sc:nth-child(2) { top: 4px; left: 5px; transform: rotate(3deg); opacity: .8; z-index: 2; }
  .stack-cluster .sc:nth-child(3) { top: 8px; left: 0; transform: rotate(0deg); z-index: 3; }
  .stack-cluster .sc:nth-child(3)::after {
    content: attr(data-count);
    position: absolute;
    bottom: 5px; right: 5px;
    background: rgba(0,0,0,.55);
    backdrop-filter: blur(6px);
    color: white;
    font-size: 8px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 6px;
  }
  .stack-label { font-size: 11px; font-weight: 600; color: #1e3a5f; text-align: center; }
  .stack-sub { font-size: 9px; color: rgba(30,58,95,.5); margin-top: 1px; }
  .stack-group:hover .sc:nth-child(3) { transform: rotate(-2deg) translateY(-4px); transition: transform .2s; }
  .stack-group:hover .sc:nth-child(2) { transform: rotate(1deg) translateY(-2px); transition: transform .2s .04s; }

  /* ── FEATURED / BIG CARD ── */
  .featured-scroll {
    display: flex;
    gap: 14px;
    padding: 0 16px 4px;
    overflow-x: auto;
    scrollbar-width: none;
  }
  .featured-scroll::-webkit-scrollbar { display: none; }
  .feat-card {
    min-width: 200px;
    border-radius: 22px;
    overflow: hidden;
    background: white;
    box-shadow: 0 10px 28px rgba(0,0,0,.1);
    flex-shrink: 0;
    transition: transform .2s, box-shadow .2s;
    cursor: pointer;
  }
  .feat-card:hover { transform: translateY(-4px); box-shadow: 0 16px 36px rgba(0,0,0,.15); }
  .feat-card img { width: 100%; height: 120px; object-fit: cover; display: block; }
  .feat-info { padding: 12px; }
  .feat-tag {
    display: inline-block;
    padding: 3px 9px;
    border-radius: 999px;
    background: #EFF6FF;
    color: #2563EB;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: .4px;
    margin-bottom: 6px;
  }
  .feat-info h5 { font-size: 13px; font-weight: 700; color: #0c2461; margin-bottom: 3px; font-family: 'Playfair Display', serif; }
  .feat-info .loc { font-size: 10px; color: rgba(12,36,97,.55); margin-bottom: 8px; display: flex; align-items: center; gap: 3px; }
  .feat-info .loc svg { width: 9px; height: 9px; fill: #2563EB; }
  .feat-bottom { display: flex; justify-content: space-between; align-items: center; }
  .feat-price { font-size: 14px; font-weight: 700; color: #1D4ED8; }
  .feat-price span { font-size: 9px; font-weight: 400; color: rgba(12,36,97,.45); }
  .feat-stars { display: flex; align-items: center; gap: 2px; font-size: 10px; font-weight: 600; color: #0c2461; }
  .feat-stars svg { width: 11px; height: 11px; fill: #F59E0B; }

  /* ── GLASS NAVBAR (FIXED STICKY BOTTOM POSITION) ── */
  .navbar {
    position: absolute; /* Tetap absolute menempel dasar kontainer .phone */
    bottom: 16px;
    left: 14px;
    right: 14px;
    height: 68px;
    border-radius: 26px;
    background: rgba(255, 255, 255, 0.22);
    backdrop-filter: blur(28px) saturate(160%);
    -webkit-backdrop-filter: blur(28px) saturate(160%);
    border: 1px solid rgba(255,255,255,0.45);
    box-shadow: 0 8px 32px rgba(30,87,185,.18), 0 2px 8px rgba(0,0,0,.08), inset 0 1px 0 rgba(255,255,255,.6);
    display: flex;
    justify-content: space-around;
    align-items: center;
    z-index: 200; /* Berada di atas scroll area, di bawah modal detail */
  }
  
  .nav-item { display: flex; flex-direction: column; align-items: center; gap: 3px; padding: 10px 12px; border-radius: 16px; cursor: pointer; flex: 1; }
  .nav-item svg { width: 20px; height: 20px; fill: none; stroke: rgba(12,36,97,.4); stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
  .nav-item span { font-size: 9px; font-weight: 600; color: rgba(12,36,97,.4); }
  .nav-item.active { background: rgba(255,255,255,.55); box-shadow: 0 2px 12px rgba(37,99,235,.15); }
  .nav-item.active svg { stroke: #1D4ED8; }
  .nav-item.active span { color: #1D4ED8; }


  /* =========================================================
     ── 🛠️ NEW LAYOUT REMODEL: DETAIL POPUP MODAL (GLASS) ──
     ========================================================= */

  .detail-modal {
    display: none;
    position: absolute; /* Dikunci presisi dalam frame HP */
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(12, 36, 97, 0.35);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 400; /* Menutupi navbar bawan saat aktif */
  }
  .detail-modal.active { display: flex; align-items: flex-end; }

  .detail-content {
    width: 100%;
    height: 94%; 
    background: #F5F9FF;
    border-radius: 36px 36px 0 0;
    overflow-y: auto;
    position: relative;
    scrollbar-width: none;
    animation: slideUp 0.38s cubic-bezier(0.16, 1, 0.3, 1) both;
  }
  .detail-content::-webkit-scrollbar { display: none; }

  @keyframes slideUp {
    from { transform: translateY(100%); }
    to { transform: translateY(0); }
  }

  .detail-header { position: relative; width: 100%; height: 340px; }
  .detail-header img { width: 100%; height: 100%; object-fit: cover; }
  
  .detail-close {
    position: absolute;
    top: 44px; left: 20px;
    width: 36px; height: 36px;
    background: rgba(255, 255, 255, 0.3);
    border: 1px solid rgba(255,255,255,0.4);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; z-index: 220; color: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  .detail-close svg { width: 18px; height: 18px; stroke: white; }

  .detail-glass-panel {
    position: relative;
    margin-top: -55px; 
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur) saturate(170%);
    -webkit-backdrop-filter: var(--glass-blur) saturate(170%);
    border-top: 1px solid var(--glass-border);
    border-radius: 32px 32px 0 0;
    padding: 24px 20px 100px; 
    z-index: 10;
    box-shadow: 0 -10px 32px rgba(0, 0, 0, 0.06);
    min-height: 450px;
  }

  .panel-handle {
    width: 36px; height: 4px;
    background: rgba(12, 36, 97, 0.15);
    border-radius: 999px;
    margin: -12px auto 20px;
  }

  .detail-title {
    font-family: 'Playfair Display', serif;
    font-size: 22px; font-weight: 700;
    color: var(--blue-900);
    line-height: 1.3; margin-bottom: 6px;
  }
  .detail-location { display: flex; align-items: center; gap: 4px; font-size: 11px; color: var(--muted); margin-bottom: 18px; }
  .detail-location svg { width: 12px; height: 12px; fill: #2563EB; }

  .detail-rating { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
  .detail-stars { display: flex; align-items: center; gap: 2px; }
  .detail-stars svg { width: 13px; height: 13px; fill: #F59E0B; }
  .detail-rating-text { font-size: 12px; font-weight: 700; color: var(--blue-900); }
  .detail-rating-count { font-size: 11px; color: rgba(12, 36, 97, 0.5); }

  .detail-spec-grid { display: flex; gap: 10px; margin-bottom: 22px; }
  .spec-card {
    background: rgba(255, 255, 255, 0.55);
    border: 1px solid rgba(255, 255, 255, 0.45);
    padding: 10px; border-radius: 14px; flex: 1; text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.01);
  }
  .spec-card .val { font-size: 13px; font-weight: 700; color: var(--blue-900); }
  .spec-card .lbl { font-size: 10px; color: var(--muted); margin-top: 2px; }

  .detail-section-title { font-size: 13px; font-weight: 700; color: var(--blue-900); margin-bottom: 8px; letter-spacing: 0.1px; }
  .detail-description { font-size: 12px; color: #334155; line-height: 1.7; margin-bottom: 22px; }

  .detail-amenities { display: flex; gap: 8px; flex-wrap: wrap; }
  .detail-amenity {
    background: rgba(255, 255, 255, 0.45);
    border: 1px solid rgba(255, 255, 255, 0.35);
    border-radius: 10px; padding: 6px 12px;
    font-size: 11px; font-weight: 600; color: #334155;
    display: flex; align-items: center; gap: 6px;
  }
  .detail-amenity svg { width: 14px; height: 14px; fill: none; stroke: #2563EB; stroke-width: 2; }

  .modal-fixed-footer {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 85px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-top: 1px solid rgba(255,255,255,0.5);
    display: flex; justify-content: space-between; align-items: center;
    padding: 0 24px 10px;
    z-index: 100;
    box-shadow: 0 -6px 20px rgba(0,0,0,0.03);
  }
  .modal-price-wrap { display: flex; flex-direction: column; }
  .detail-price { font-size: 18px; font-weight: 700; color: #1D4ED8; }
  .detail-price span { font-size: 10px; font-weight: 400; color: var(--muted); }
  
  .detail-button {
    padding: 12px 28px; background: #1D4ED8; color: white;
    border: none; border-radius: 14px; font-size: 13px; font-weight: 700;
    cursor: pointer; box-shadow: 0 6px 16px rgba(29,78,216,0.25);
  }
</style>
</head>
<body>

<div class="phone">
  <div class="notch"></div>
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  <div class="scroll">

    <div class="statusbar">
      <span>9:41</span>
      <div class="icons">
        <svg viewBox="0 0 24 24"><rect x="2" y="14" width="3" height="6" rx="1"/><rect x="7" y="10" width="3" height="10" rx="1"/><rect x="12" y="6" width="3" height="14" rx="1"/><rect x="17" y="2" width="3" height="18" rx="1" opacity=".35"/></svg>
        <svg viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0M8.53 16.11a6 6 0 016.95 0M12 20h.01" stroke="rgba(255,255,255,.9)" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="18" height="10" rx="2" stroke="rgba(255,255,255,.9)" stroke-width="1.5" fill="none"/><rect x="3" y="8" width="13" height="8" rx="1" fill="rgba(255,255,255,.9)"/><path d="M20 10v4" stroke="rgba(255,255,255,.9)" stroke-width="1.5" stroke-linecap="round"/></svg>
      </div>
    </div>

    <div class="topbar">
      <div>
        <div class="greeting">Selamat datang kembali 👋</div>
        <div class="name">Jessica Putri</div>
      </div>
      <div class="avatar">JP</div>
    </div>

    <div class="hero">
      <div class="hero-eyebrow">Destinasi Terbaik</div>
      <h2>Explore Beautiful<br>Staycation in Indonesia</h2>
      <p>Temukan hotel aesthetic, villa cozy,<br>dan pengalaman liburan terbaik.</p>
      <div class="hero-btn">
        <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
        Explore Now
      </div>
    </div>

    <div class="search-wrap">
      <div class="searchbar">
        <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2" stroke-linecap="round">
          <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" placeholder="Cari hotel, villa, destinasi...">
        <div class="filter-pill">
          <svg viewBox="0 0 24 24"><path d="M3 6h18M6 12h12M9 18h6"/></svg>
        </div>
      </div>
    </div>

    <div class="chips">
      <div class="chip active">Semua</div>
      <div class="chip idle">🏨 Hotel</div>
      <div class="chip idle">🏡 Villa</div>
      <div class="chip idle">🏢 Apartemen</div>
      <div class="chip idle">🎒 Hostel</div>
      <div class="chip idle">🌊 Resort</div>
    </div>

    <div class="sec-head">
      <div class="title">Jelajah Kategori</div>
      <div class="see-all">Lihat semua →</div>
    </div>

    <div class="stack-row">
      <div class="stack-group">
        <div class="stack-cluster">
          <div class="sc"><img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=200&q=60" alt=""></div>
          <div class="sc"><img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=200&q=60" alt=""></div>
          <div class="sc" data-count="24+"><img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=200&q=60" alt=""></div>
        </div>
        <div class="stack-label">Hotel</div>
        <div class="stack-sub">24 properti</div>
      </div>

      <div class="stack-group">
        <div class="stack-cluster">
          <div class="sc"><img src="https://images.unsplash.com/photo-1601628828688-632f38a5a7d0?w=200&q=60" alt=""></div>
          <div class="sc"><img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=200&q=60" alt=""></div>
          <div class="sc" data-count="18+"><img src="https://images.unsplash.com/photo-1523217582562-09d0def993a6?w=200&q=60" alt=""></div>
        </div>
        <div class="stack-label">Villa</div>
        <div class="stack-sub">18 properti</div>
      </div>

      <div class="stack-group">
        <div class="stack-cluster">
          <div class="sc"><img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=200&q=60" alt=""></div>
          <div class="sc"><img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=200&q=60" alt=""></div>
          <div class="sc" data-count="11+"><img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=200&q=60" alt=""></div>
        </div>
        <div class="stack-label">Apartemen</div>
        <div class="stack-sub">11 properti</div>
      </div>

      <div class="stack-group">
        <div class="stack-cluster">
          <div class="sc"><img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=200&q=60" alt=""></div>
          <div class="sc"><img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=200&q=60" alt=""></div>
          <div class="sc" data-count="9+"><img src="https://images.unsplash.com/photo-1537640538966-79f369143f8f?w=200&q=60" alt=""></div>
        </div>
        <div class="stack-label">Resort</div>
        <div class="stack-sub">9 properti</div>
      </div>
    </div>

    <div class="sec-head">
      <div class="title">Rekomendasi Untukmu</div>
      <div class="see-all">Lihat semua →</div>
    </div>

    <div class="featured-scroll">
      <div class="feat-card" data-id="1" data-name="Wisma Wisata Wiratama" data-location="Batu, Jawa Timur" data-price="272" data-rating="4.8" data-img="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500&q=80" data-description="Hotel terbaik dengan nilai luar biasa. Menikmati kenyamanan sejuk maksimal khas Kota Wisata Batu dengan harga terjangkau. Properti ini menawarkan akses mudah ke berbagai destinasi utama.">
        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=400&q=70" alt="Wisma Wisata">
        <div class="feat-info">
          <div class="feat-tag">BEST VALUE</div>
          <h5>Wisma Wisata Wiratama</h5>
          <div class="loc">
            <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
            Batu, Jawa Timur
          </div>
          <div class="feat-bottom">
            <div class="feat-price">Rp 272rb <span>/ malam</span></div>
            <div class="feat-stars">
              <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              4.8
            </div>
          </div>
        </div>
      </div>

      <div class="feat-card" data-id="2" data-name="Rose Garden Hotel" data-location="Surabaya, Jawa Timur" data-price="620" data-rating="4.7" data-img="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500&q=80" data-description="Hotel megah dengan perpaduan arsitektur modern klasik di jantung kota Surabaya. Menawarkan pelayanan premium serta hidangan sarapan gratis berkualitas tinggi setiap pagi.">
        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&q=70" alt="Rose Garden">
        <div class="feat-info">
          <div class="feat-tag">FREE BREAKFAST</div>
          <h5>Rose Garden Hotel</h5>
          <div class="loc">
            <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
            Surabaya, Jawa Timur
          </div>
          <div class="feat-bottom">
            <div class="feat-price">Rp 620rb <span>/ malam</span></div>
            <div class="feat-stars">
              <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              4.7
            </div>
          </div>
        </div>
      </div>

      <div class="feat-card" data-id="3" data-name="Skyline Suites Bali" data-location="Kuta, Bali" data-price="950" data-rating="4.9" data-img="https://images.unsplash.com/photo-1549294413-26f195200c16?w=500&q=80" data-description="Suite mewah dengan pemandangan langsung menghadap birunya Samudra Hindia. Menyajikan panorama sunset terbaik dari balkon kamar Anda. Kolam renang infinity dan fasilitas bintang lima.">
        <img src="https://images.unsplash.com/photo-1549294413-26f195200c16?w=400&q=70" alt="Skyline">
        <div class="feat-info">
          <div class="feat-tag">OCEAN VIEW</div>
          <h5>Skyline Suites Bali</h5>
          <div class="loc">
            <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
            Kuta, Bali
          </div>
          <div class="feat-bottom">
            <div class="feat-price">Rp 950rb <span>/ malam</span></div>
            <div class="feat-stars">
              <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              4.9
            </div>
          </div>
        </div>
      </div>
    </div>

    <div style="height:8px"></div>
  </div><nav class="navbar">
    <div class="nav-item active">
      <a href="home.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
        <svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1V9.5z"/><path d="M9 21V12h6v9"/></svg>
        <span>Home</span>
      </a>
    </div>
    <div class="nav-item">
      <a href="explore.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <span>Explore</span>
      </a>
    </div>
    <div class="nav-item">
      <a href="pesanan.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        <span>Pesanan</span>
      </a>
    </div>
    <div class="nav-item">
      <a href="profile.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <span>Profil</span>
      </a>
    </div>
  </nav>

  <div class="detail-modal" id="detailModal">
    <div class="detail-content">
      
      <div class="detail-header">
        <img id="detailImg" src="" alt="Property Image">
        <button class="detail-close" onclick="closeDetail()" aria-label="Close">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>

      <div class="detail-glass-panel">
        <div class="panel-handle"></div>
        
        <h2 class="detail-title" id="detailName">Nama Properti</h2>
        
        <div class="detail-location">
          <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
          <span id="detailLocation">Lokasi</span>
        </div>

        <div class="detail-rating">
          <div class="detail-stars">
            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          </div>
          <div>
            <span class="detail-rating-text" id="detailRating">0.0</span>
            <span class="detail-rating-count">(324 ulasan)</span>
          </div>
        </div>

        <div class="detail-spec-grid">
          <div class="spec-card">
            <div class="val">Wi-Fi</div>
            <div class="lbl">Koneksi</div>
          </div>
          <div class="spec-card">
            <div class="val">2-4 Pax</div>
            <div class="lbl">Kapasitas</div>
          </div>
          <div class="spec-card">
            <div class="val">Disinfeksi</div>
            <div class="lbl">Prokes</div>
          </div>
        </div>

        <div class="detail-title-section" style="font-size: 13px; font-weight: 700; color: var(--blue-900); margin-bottom: 8px;">Tentang Properti</div>
        <p class="detail-description" id="detailDescription">Deskripsi properti...</p>

        <div class="detail-title-section" style="font-size: 13px; font-weight: 700; color: var(--blue-900); margin-bottom: 8px;">Fasilitas Utama</div>
        <div class="detail-amenities">
          <div class="detail-amenity">
            <svg viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0114.08 0"/></svg> WiFi
          </div>
          <div class="detail-amenity">
            <svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 014 4v14"/></svg> Pool
          </div>
          <div class="detail-amenity">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg> AC
          </div>
          <div class="detail-amenity">
            <svg viewBox="0 0 24 24"><path d="M12 2v20M17 5H9"/></svg> Resto
          </div>
        </div>
      </div><div class="modal-fixed-footer">
        <div class="modal-price-wrap">
          <div class="detail-price">Rp <span id="detailPrice">000</span>rb <span>/ malam</span></div>
        </div>
        <button class="detail-button" onclick="bookDetail()">Pesan Sekarang</button>
      </div>

    </div>
  </div>

</div><script>
  // Chip click handler
  document.querySelectorAll('.chip').forEach(c => {
    c.addEventListener('click', () => {
      document.querySelectorAll('.chip').forEach(x => {
        x.classList.remove('active');
        x.classList.add('idle');
      });
      c.classList.remove('idle');
      c.classList.add('active');
    });
  });

  // Navbar click handler
  document.querySelectorAll('.nav-item').forEach(n => {
    n.addEventListener('click', () => {
      document.querySelectorAll('.nav-item').forEach(x => x.classList.remove('active'));
      n.classList.add('active');
    });
  });

  // Featured card click handler
  document.querySelectorAll('.feat-card').forEach(card => {
    card.addEventListener('click', () => {
      const id = card.getAttribute('data-id');
      const name = card.getAttribute('data-name');
      const location = card.getAttribute('data-location');
      const price = card.getAttribute('data-price');
      const rating = card.getAttribute('data-rating');
      const img = card.getAttribute('data-img');
      const description = card.getAttribute('data-description');

      // Set detail content
      document.getElementById('detailImg').src = img;
      document.getElementById('detailName').textContent = name;
      document.getElementById('detailLocation').textContent = location;
      document.getElementById('detailRating').textContent = rating;
      document.getElementById('detailPrice').textContent = price;
      document.getElementById('detailDescription').textContent = description;

      // Show modal
      document.getElementById('detailModal').classList.add('active');
    });
  });

  // Close detail modal
  function closeDetail() {
    document.getElementById('detailModal').classList.remove('active');
  }

  // Book detail
  function bookDetail() {
    alert('Terima kasih telah memilih! Lanjutkan ke halaman pemesanan.');
    closeDetail();
  }

  // Close modal when clicking outside the panel content area
  document.getElementById('detailModal').addEventListener('click', (e) => {
    if (e.target.id === 'detailModal') {
      closeDetail();
    }
  });
</script>
</body>
</html>