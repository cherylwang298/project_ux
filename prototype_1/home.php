<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staycation App</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --blue-900: #0c2461;
      --blue-700: #1e5799;
      --blue-500: #2563EB;
      --blue-400: #3B82F6;
      --blue-300: #60A5FA;
      --blue-100: #DBEAFE;
      --blue-50: #EFF6FF;

      /* Konfigurasi Kaca Super Transparan & Tipis ala Mockup Kanan */
      --glass-bg: rgba(255, 255, 255, 0.40);
      --glass-border: rgba(255, 255, 255, 0.45);
      --glass-blur: blur(25px);
      --glass-bg-dark: rgba(255, 255, 255, 0.10);
      --muted: #475569;
    }

    body {
      background: #b8cfe8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
      /* Mengunci scroll browser desktop */
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
          #F5F9FF 100%);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      box-shadow:
        0 40px 80px rgba(0, 0, 0, .35),
        inset 0 0 0 1px rgba(255, 255, 255, .12);
    }

    /* cloud blobs */
    .blob {
      position: absolute;
      border-radius: 50%;
      pointer-events: none;
    }

    .blob-1 {
      width: 320px;
      height: 320px;
      background: radial-gradient(circle, rgba(255, 255, 255, .22) 0%, transparent 70%);
      top: -80px;
      right: -80px;
      animation: drift 12s ease-in-out infinite;
    }

    .blob-2 {
      width: 220px;
      height: 220px;
      background: radial-gradient(circle, rgba(255, 255, 255, .14) 0%, transparent 70%);
      top: 60px;
      left: -60px;
      animation: drift 16s ease-in-out infinite reverse;
    }

    @keyframes drift {

      0%,
      100% {
        transform: translate(0, 0) scale(1);
      }

      50% {
        transform: translate(12px, -16px) scale(1.06);
      }
    }

    .notch {
      position: absolute;
      top: 8px;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 26px;
      background: #18181b;
      border-radius: 14px;
      z-index: 500;
      /* Selalu berada di atas konten & modal */
    }

    /* ── SCROLL AREA ── */
    .scroll {
      flex: 1;
      overflow-y: auto;
      scrollbar-width: none;
      padding-bottom: 110px;
      /* Ditambah jaraknya agar tidak terpotong navbar fixed */
      position: relative;
      z-index: 10;
    }

    .scroll::-webkit-scrollbar {
      display: none;
    }

    /* ── STATUS BAR ── */
    .statusbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 42px 24px 0;
      font-size: 11px;
      font-weight: 600;
      color: rgba(255, 255, 255, .9);
      letter-spacing: .3px;
    }

    .statusbar .icons {
      display: flex;
      gap: 5px;
      align-items: center;
    }

    .statusbar .icons svg {
      width: 14px;
      height: 14px;
      fill: rgba(255, 255, 255, .9);
    }

    /* ── TOP BAR ── */
    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 10px 20px 0;
    }

    .topbar .greeting {
      color: rgba(255, 255, 255, .8);
      font-size: 12px;
      font-weight: 400;
    }

    .topbar .name {
      color: white;
      font-size: 18px;
      font-weight: 700;
      font-family: 'Playfair Display', serif;
      letter-spacing: -.2px;
    }

    .avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: linear-gradient(135deg, #ffd89b, #19547b);
      border: 2px solid rgba(255, 255, 255, .5);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 14px;
      font-weight: 700;
    }

    /* ── HERO SLIDER ── */
    .hero-slide {
      min-width: 100%;
      height: 148px;
      position: relative;
      flex-shrink: 0;
      border-radius: 22px;
      overflow: hidden;
    }
    .hero-slide img {
      width: 100%; height: 100%; object-fit: cover; display: block;
    }
    .hero-slide-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(13,40,120,.55), rgba(30,87,185,.25));
      padding: 18px 20px;
      display: flex; flex-direction: column; justify-content: flex-end;
    }
    .hero-dot {
      width: 6px; height: 6px; border-radius: 999px;
      background: rgba(12,36,97,0.2); transition: all 0.3s; cursor: pointer;
    }
    .hero-dot.active { width: 18px; background: #1D4ED8; }

    /* ── HERO BANNER ── */
    .hero {
      margin: 16px 16px 0;
      background: linear-gradient(135deg, rgba(13, 40, 120, .85), rgba(30, 87, 185, .75));
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 22px;
      padding: 18px 20px;
      border: 1px solid rgba(255, 255, 255, .2);
      box-shadow: 0 8px 32px rgba(13, 40, 120, .3), inset 0 1px 0 rgba(255, 255, 255, .15);
      position: relative;
      overflow: hidden;
    }

    .hero::after {
      content: '';
      position: absolute;
      top: -30px;
      right: -20px;
      width: 120px;
      height: 120px;
      background: radial-gradient(circle, rgba(255, 255, 255, .12) 0%, transparent 65%);
      pointer-events: none;
    }

    .hero-eyebrow {
      font-size: 9px;
      font-weight: 700;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      color: rgba(255, 255, 255, .6);
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
      color: rgba(255, 255, 255, .7);
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
      box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
    }

    .hero-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, .2);
    }

    .hero-btn svg {
      width: 12px;
      height: 12px;
      fill: #1D4ED8;
    }

    /* ── SEARCH BAR ── */
    .search-wrap {
      padding: 14px 16px 0;
    }

    .searchbar {
      display: flex;
      align-items: center;
      gap: 10px;
      background: rgba(255, 255, 255, .75);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border-radius: 16px;
      padding: 0 14px;
      height: 48px;
      border: 1px solid rgba(255, 255, 255, .9);
      box-shadow: 0 4px 18px rgba(37, 99, 235, .1);
    }

    .searchbar svg {
      width: 16px;
      height: 16px;
      flex-shrink: 0;
    }

    .searchbar input {
      flex: 1;
      border: none;
      background: transparent;
      font-family: 'DM Sans', sans-serif;
      font-size: 12px;
      color: #1e3a5f;
      outline: none;
    }

    .searchbar input::placeholder {
      color: rgba(30, 58, 95, .4);
    }

    .filter-pill {
      width: 32px;
      height: 32px;
      background: #2563EB;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      cursor: pointer;
    }

    .filter-pill svg {
      width: 15px;
      height: 15px;
      fill: white;
    }

    /* ── FILTER CHIPS ── */
    .chips {
      display: flex;
      gap: 8px;
      padding: 12px 16px 0;
      overflow-x: auto;
      scrollbar-width: none;
    }

    .chips::-webkit-scrollbar {
      display: none;
    }

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
      box-shadow: 0 4px 14px rgba(29, 78, 216, .4);
    }

    .chip.idle {
      background: rgba(255, 255, 255, .65);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      color: #1e3a5f;
      border: 1px solid rgba(255, 255, 255, .85);
    }

    .chip.idle:hover {
      background: rgba(255, 255, 255, .85);
    }

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

    .stack-row::-webkit-scrollbar {
      display: none;
    }

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
      box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
    }

    .stack-cluster .sc img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .stack-cluster .sc:nth-child(1) {
      top: 0;
      left: 10px;
      transform: rotate(6deg);
      opacity: .6;
      filter: brightness(.85);
      z-index: 1;
    }

    .stack-cluster .sc:nth-child(2) {
      top: 4px;
      left: 5px;
      transform: rotate(3deg);
      opacity: .8;
      z-index: 2;
    }

    .stack-cluster .sc:nth-child(3) {
      top: 8px;
      left: 0;
      transform: rotate(0deg);
      z-index: 3;
    }

    .stack-cluster .sc:nth-child(3)::after {
      content: attr(data-count);
      position: absolute;
      bottom: 5px;
      right: 5px;
      background: rgba(0, 0, 0, .55);
      backdrop-filter: blur(6px);
      color: white;
      font-size: 8px;
      font-weight: 700;
      padding: 2px 6px;
      border-radius: 6px;
    }

    .stack-label {
      font-size: 11px;
      font-weight: 600;
      color: #1e3a5f;
      text-align: center;
    }

    .stack-sub {
      font-size: 9px;
      color: rgba(30, 58, 95, .5);
      margin-top: 1px;
    }

    .stack-group:hover .sc:nth-child(3) {
      transform: rotate(-2deg) translateY(-4px);
      transition: transform .2s;
    }

    .stack-group:hover .sc:nth-child(2) {
      transform: rotate(1deg) translateY(-2px);
      transition: transform .2s .04s;
    }

    /* ── PROMO SLIDER ── */
    .promo-slider-wrap {
      margin: 0 16px;
      position: relative;
      border-radius: 20px;
      overflow: hidden;
      cursor: pointer;
    }

    .promo-track {
      display: flex;
      transition: transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .promo-slide {
      min-width: 100%;
      height: 130px;
      position: relative;
      border-radius: 20px;
      overflow: hidden;
      flex-shrink: 0;
    }

    .promo-slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .promo-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(90deg, rgba(12,36,97,0.78) 0%, rgba(12,36,97,0.25) 70%, transparent 100%);
      padding: 16px 18px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .promo-badge {
      display: inline-block;
      background: #F59E0B;
      color: #0c2461;
      font-size: 9px;
      font-weight: 800;
      padding: 3px 9px;
      border-radius: 999px;
      letter-spacing: 0.5px;
      margin-bottom: 6px;
      width: fit-content;
    }

    .promo-title {
      font-family: 'Playfair Display', serif;
      font-size: 15px;
      font-weight: 700;
      color: white;
      line-height: 1.3;
      margin-bottom: 4px;
    }

    .promo-sub {
      font-size: 10px;
      color: rgba(255,255,255,0.75);
    }

    .promo-dots {
      display: flex;
      justify-content: center;
      gap: 5px;
      margin-top: 8px;
    }

    .promo-dot {
      width: 6px;
      height: 6px;
      border-radius: 999px;
      background: rgba(12,36,97,0.2);
      transition: all 0.3s;
    }

    .promo-dot.active {
      width: 18px;
      background: #1D4ED8;
    }

    /* ── PROMO DETAIL MODAL ── */
    .promo-modal {
      display: none;
      position: absolute;
      inset: 0;
      background: rgba(12,36,97,0.4);
      backdrop-filter: blur(4px);
      z-index: 450;
      align-items: flex-end;
    }

    .promo-modal.active { display: flex; }

    .promo-sheet {
      width: 100%;
      background: #F5F9FF;
      border-radius: 32px 32px 0 0;
      padding: 0 0 32px;
      animation: slideUp 0.35s cubic-bezier(0.16,1,0.3,1);
    }

    .promo-sheet-img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      border-radius: 32px 32px 0 0;
    }

    .promo-sheet-body {
      padding: 20px 20px 0;
    }

    .promo-sheet-badge {
      display: inline-block;
      background: #FEF3C7;
      color: #92400E;
      font-size: 10px;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 999px;
      margin-bottom: 10px;
    }

    .promo-sheet-title {
      font-family: 'Playfair Display', serif;
      font-size: 18px;
      font-weight: 700;
      color: #0c2461;
      margin-bottom: 8px;
    }

    .promo-sheet-desc {
      font-size: 12px;
      color: #475569;
      line-height: 1.7;
      margin-bottom: 16px;
    }

    .promo-code-box {
      background: #EFF6FF;
      border: 1.5px dashed #2563EB;
      border-radius: 12px;
      padding: 12px 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
    }

    .promo-code-label { font-size: 10px; color: #475569; }
    .promo-code-val { font-size: 15px; font-weight: 800; color: #1D4ED8; letter-spacing: 1px; }
    .promo-copy-btn {
      background: #1D4ED8;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 10px;
      font-weight: 700;
      padding: 6px 12px;
      cursor: pointer;
    }

    .promo-close-btn {
      width: 100%;
      padding: 13px;
      background: #0c2461;
      color: white;
      border: none;
      border-radius: 14px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      margin: 0 20px;
      width: calc(100% - 40px);
    }

    /* ── FEATURED / BIG CARD ── */
    .featured-scroll {
      display: flex;
      gap: 14px;
      padding: 0 16px 4px;
      overflow-x: auto;
      scrollbar-width: none;
    }

    .featured-scroll::-webkit-scrollbar {
      display: none;
    }

    .feat-card {
      min-width: 200px;
      border-radius: 22px;
      overflow: hidden;
      background: white;
      box-shadow: 0 10px 28px rgba(0, 0, 0, .1);
      flex-shrink: 0;
      transition: transform .2s, box-shadow .2s;
      cursor: pointer;
    }

    .feat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 36px rgba(0, 0, 0, .15);
    }

    .feat-card img {
      width: 100%;
      height: 120px;
      object-fit: cover;
      display: block;
    }

    .feat-info {
      padding: 12px;
    }

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

    .feat-info h5 {
      font-size: 13px;
      font-weight: 700;
      color: #0c2461;
      margin-bottom: 3px;
      font-family: 'Playfair Display', serif;
    }

    .feat-info .loc {
      font-size: 10px;
      color: rgba(12, 36, 97, .55);
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 3px;
    }

    .feat-info .loc svg {
      width: 9px;
      height: 9px;
      fill: #2563EB;
    }

    .feat-bottom {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .feat-price {
      font-size: 14px;
      font-weight: 700;
      color: #1D4ED8;
    }

    .feat-price span {
      font-size: 9px;
      font-weight: 400;
      color: rgba(12, 36, 97, .45);
    }

    .feat-stars {
      display: flex;
      align-items: center;
      gap: 2px;
      font-size: 10px;
      font-weight: 600;
      color: #0c2461;
    }

    .feat-stars svg {
      width: 11px;
      height: 11px;
      fill: #F59E0B;
    }

    /* ── CATEGORY LIST MODAL ── */
    .cat-modal-overlay {
      display: none;
      position: absolute;
      inset: 0;
      background: rgba(12, 36, 97, .35);
      backdrop-filter: blur(4px);
      z-index: 350;
      align-items: flex-end;
    }

    .cat-modal-overlay.active {
      display: flex;
    }

    .cat-sheet {
      width: 100%;
      background: #F5F9FF;
      border-radius: 32px 32px 0 0;
      max-height: 75%;
      overflow-y: auto;
      scrollbar-width: none;
      padding: 0 0 24px;
      animation: slideUp .3s cubic-bezier(.16, 1, .3, 1);
    }

    .cat-sheet::-webkit-scrollbar {
      display: none;
    }

    .cat-sheet-handle {
      width: 36px;
      height: 4px;
      background: rgba(12, 36, 97, .15);
      border-radius: 999px;
      margin: 14px auto 0;
    }

    .cat-sheet-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 20px 10px;
    }

    .cat-sheet-title {
      font-family: 'Playfair Display', serif;
      font-size: 16px;
      font-weight: 700;
      color: #0c2461;
    }

    .cat-close-btn {
      width: 30px;
      height: 30px;
      background: rgba(12, 36, 97, .08);
      border: none;
      border-radius: 10px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .cat-close-btn svg {
      width: 16px;
      height: 16px;
    }

    .cat-list-item {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 12px 20px;
      border-bottom: 1px solid rgba(12, 36, 97, .06);
      cursor: pointer;
      transition: background .15s;
      text-decoration: none;
    }

    .cat-list-item:last-child {
      border-bottom: none;
    }

    .cat-list-item:hover {
      background: rgba(37, 99, 235, .05);
    }

    .cat-list-thumb {
      width: 52px;
      height: 52px;
      border-radius: 14px;
      object-fit: cover;
      flex-shrink: 0;
    }

    .cat-list-info {
      flex: 1;
    }

    .cat-list-name {
      font-size: 13px;
      font-weight: 700;
      color: #0c2461;
      margin-bottom: 2px;
    }

    .cat-list-loc {
      font-size: 10px;
      color: rgba(12, 36, 97, .55);
    }

    .cat-list-price {
      font-size: 13px;
      font-weight: 700;
      color: #1D4ED8;
      white-space: nowrap;
    }

    /* ── CATEGORY LIST MODAL ── */
    .cat-modal-overlay {
      display: none;
      position: absolute;
      inset: 0;
      background: rgba(12, 36, 97, .35);
      backdrop-filter: blur(4px);
      z-index: 350;
      align-items: flex-end;
    }

    .cat-modal-overlay.active {
      display: flex;
    }

    .cat-sheet {
      width: 100%;
      background: #F5F9FF;
      border-radius: 32px 32px 0 0;
      max-height: 75%;
      overflow-y: auto;
      scrollbar-width: none;
      padding: 0 0 24px;
      animation: slideUp .3s cubic-bezier(.16, 1, .3, 1);
    }

    .cat-sheet::-webkit-scrollbar {
      display: none;
    }

    .cat-sheet-handle {
      width: 36px;
      height: 4px;
      background: rgba(12, 36, 97, .15);
      border-radius: 999px;
      margin: 14px auto 0;
    }

    .cat-sheet-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 20px 10px;
    }

    .cat-sheet-title {
      font-family: 'Playfair Display', serif;
      font-size: 16px;
      font-weight: 700;
      color: #0c2461;
    }

    .cat-close-btn {
      width: 30px;
      height: 30px;
      background: rgba(12, 36, 97, .08);
      border: none;
      border-radius: 10px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .cat-close-btn svg {
      width: 16px;
      height: 16px;
    }

    .cat-list-item {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 12px 20px;
      border-bottom: 1px solid rgba(12, 36, 97, .06);
      cursor: pointer;
      transition: background .15s;
      text-decoration: none;
    }

    .cat-list-item:last-child {
      border-bottom: none;
    }

    .cat-list-item:hover {
      background: rgba(37, 99, 235, .05);
    }

    .cat-list-thumb {
      width: 52px;
      height: 52px;
      border-radius: 14px;
      object-fit: cover;
      flex-shrink: 0;
    }

    .cat-list-info {
      flex: 1;
    }

    .cat-list-name {
      font-size: 13px;
      font-weight: 700;
      color: #0c2461;
      margin-bottom: 2px;
    }

    .cat-list-loc {
      font-size: 10px;
      color: rgba(12, 36, 97, .55);
    }

    .cat-list-price {
      font-size: 13px;
      font-weight: 700;
      color: #1D4ED8;
      white-space: nowrap;
    }

    /* ── GLASS NAVBAR (FIXED STICKY BOTTOM POSITION) ── */
    .navbar {
      position: absolute;
      /* Tetap absolute menempel dasar kontainer .phone */
      bottom: 16px;
      left: 14px;
      right: 14px;
      height: 68px;
      border-radius: 26px;
      background: rgba(255, 255, 255, 0.22);
      backdrop-filter: blur(28px) saturate(160%);
      -webkit-backdrop-filter: blur(28px) saturate(160%);
      border: 1px solid rgba(255, 255, 255, 0.45);
      box-shadow: 0 8px 32px rgba(30, 87, 185, .18), 0 2px 8px rgba(0, 0, 0, .08), inset 0 1px 0 rgba(255, 255, 255, .6);
      display: flex;
      justify-content: space-around;
      align-items: center;
      z-index: 200;
      /* Berada di atas scroll area, di bawah modal detail */
    }

    .nav-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 3px;
      padding: 10px 12px;
      border-radius: 16px;
      cursor: pointer;
      flex: 1;
    }

    .nav-item svg {
      width: 20px;
      height: 20px;
      fill: none;
      stroke: rgba(12, 36, 97, .4);
      stroke-width: 1.8;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .nav-item span {
      font-size: 9px;
      font-weight: 600;
      color: rgba(12, 36, 97, .4);
    }

    .nav-item.active {
      background: rgba(255, 255, 255, .55);
      box-shadow: 0 2px 12px rgba(37, 99, 235, .15);
    }

    .nav-item.active svg {
      stroke: #1D4ED8;
    }

    .nav-item.active span {
      color: #1D4ED8;
    }


    /* =========================================================
     ── 🛠️ NEW LAYOUT REMODEL: DETAIL POPUP MODAL (GLASS) ──
     ========================================================= */

    .detail-modal {
      display: none;
      position: absolute;
      /* Dikunci presisi dalam frame HP */
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(12, 36, 97, 0.35);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      z-index: 400;
      /* Menutupi navbar bawan saat aktif */
    }

    .detail-modal.active {
      display: flex;
      align-items: flex-end;
    }

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

    .detail-content::-webkit-scrollbar {
      display: none;
    }

    @keyframes slideUp {
      from {
        transform: translateY(100%);
      }

      to {
        transform: translateY(0);
      }
    }

    .detail-header {
      position: relative;
      width: 100%;
    }

    .detail-header img {
      width: 100%;
      height: auto;
      display: block;
      object-fit: unset;
    }

    .detail-close {
      position: absolute;
      top: 44px;
      left: 20px;
      width: 36px;
      height: 36px;
      background: rgba(255, 255, 255, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 220;
      color: white;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .detail-close svg {
      width: 18px;
      height: 18px;
      stroke: white;
    }

    .detail-glass-panel {
      position: relative;
      background: rgba(255,255,255,0.92);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-top: 1px solid rgba(255,255,255,0.6);
      border-radius: 32px 32px 0 0;
      padding: 24px 20px 100px;
      z-index: 10;
      box-shadow: 0 -10px 32px rgba(0,0,0,0.06);
    }

    .panel-handle {
      width: 36px;
      height: 4px;
      background: rgba(12, 36, 97, 0.15);
      border-radius: 999px;
      margin: -12px auto 20px;
    }

    .detail-title {
      font-family: 'Playfair Display', serif;
      font-size: 22px;
      font-weight: 700;
      color: var(--blue-900);
      line-height: 1.3;
      margin-bottom: 6px;
    }

    .detail-location {
      display: flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      color: var(--muted);
      margin-bottom: 18px;
    }

    .detail-location svg {
      width: 12px;
      height: 12px;
      fill: #2563EB;
    }

    .detail-rating {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
    }

    .detail-stars {
      display: flex;
      align-items: center;
      gap: 2px;
    }

    .detail-stars svg {
      width: 13px;
      height: 13px;
      fill: #F59E0B;
    }

    .detail-rating-text {
      font-size: 12px;
      font-weight: 700;
      color: var(--blue-900);
    }

    .detail-rating-count {
      font-size: 11px;
      color: rgba(12, 36, 97, 0.5);
    }

    .detail-spec-grid {
      display: flex;
      gap: 10px;
      margin-bottom: 22px;
    }

    .spec-card {
      background: rgba(255, 255, 255, 0.55);
      border: 1px solid rgba(255, 255, 255, 0.45);
      padding: 10px;
      border-radius: 14px;
      flex: 1;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
    }

    .spec-card .val {
      font-size: 13px;
      font-weight: 700;
      color: var(--blue-900);
    }

    .spec-card .lbl {
      font-size: 10px;
      color: var(--muted);
      margin-top: 2px;
    }

    .detail-section-title {
      font-size: 13px;
      font-weight: 700;
      color: var(--blue-900);
      margin-bottom: 8px;
      letter-spacing: 0.1px;
    }

    .detail-description {
      font-size: 12px;
      color: #334155;
      line-height: 1.7;
      margin-bottom: 22px;
    }

    .detail-amenities {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .detail-amenity {
      background: rgba(255, 255, 255, 0.45);
      border: 1px solid rgba(255, 255, 255, 0.35);
      border-radius: 10px;
      padding: 6px 12px;
      font-size: 11px;
      font-weight: 600;
      color: #334155;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .detail-amenity svg {
      width: 14px;
      height: 14px;
      fill: none;
      stroke: #2563EB;
      stroke-width: 2;
    }

    .modal-fixed-footer {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 85px;
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border-top: 1px solid rgba(255, 255, 255, 0.5);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 24px 10px;
      z-index: 100;
      box-shadow: 0 -6px 20px rgba(0, 0, 0, 0.03);
    }

    .modal-price-wrap {
      display: flex;
      flex-direction: column;
    }

    .detail-price {
      font-size: 18px;
      font-weight: 700;
      color: #1D4ED8;
    }

    .detail-price span {
      font-size: 10px;
      font-weight: 400;
      color: var(--muted);
    }

    .detail-button {
      padding: 12px 28px;
      background: #1D4ED8;
      color: white;
      border: none;
      border-radius: 14px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 6px 16px rgba(29, 78, 216, 0.25);
    }

    html.dark-mode body {
      background: #020617;
      color: #e2e8f0;
    }

    html.dark-mode .phone,
    html.dark-mode .phone-frame {
      border-color: #0f172a !important;
      background: linear-gradient(165deg, #0f172a 0%, #111827 30%, #1f2937 60%, #0f172a 100%) !important;
      box-shadow: 0 40px 90px rgba(0, 0, 0, .8) !important;
    }

    html.dark-mode .scroll,
    html.dark-mode .statusbar,
    html.dark-mode .topbar,
    html.dark-mode .hero,
    html.dark-mode .searchbar,
    html.dark-mode .quick-chips-row,
    html.dark-mode .q-chip,
    html.dark-mode .discover-card,
    html.dark-mode .explore-card,
    html.dark-mode .card-info,
    html.dark-mode .nav-bar {
      background: rgba(15, 23, 42, .92) !important;
      border-color: rgba(148, 163, 184, .2) !important;
      color: #e2e8f0 !important;
    }

    html.dark-mode .hero-btn,
    html.dark-mode .filter-pill,
    html.dark-mode .q-chip.active,
    html.dark-mode .nav-item.active {
      background: rgba(37, 99, 235, .95) !important;
      color: white !important;
    }

    html.dark-mode .searchbar input,
    html.dark-mode .booking-search,
    html.dark-mode input,
    html.dark-mode select,
    html.dark-mode textarea {
      background: rgba(15, 23, 42, .96) !important;
      color: #e2e8f0 !important;
      border-color: rgba(148, 163, 184, .3) !important;
    }

    html.dark-mode .card-title,
    html.dark-mode .card-loc,
    html.dark-mode .card-price,
    html.dark-mode .discover-title,
    html.dark-mode .statusbar,
    html.dark-mode .topbar .greeting,
    html.dark-mode .topbar .name {
      color: #e2e8f0 !important;
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
          <svg viewBox="0 0 24 24">
            <rect x="2" y="14" width="3" height="6" rx="1" />
            <rect x="7" y="10" width="3" height="10" rx="1" />
            <rect x="12" y="6" width="3" height="14" rx="1" />
            <rect x="17" y="2" width="3" height="18" rx="1" opacity=".35" />
          </svg>
          <svg viewBox="0 0 24 24">
            <path d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0M8.53 16.11a6 6 0 016.95 0M12 20h.01" stroke="rgba(255,255,255,.9)" stroke-width="2" fill="none" stroke-linecap="round" />
          </svg>
          <svg viewBox="0 0 24 24">
            <rect x="2" y="7" width="18" height="10" rx="2" stroke="rgba(255,255,255,.9)" stroke-width="1.5" fill="none" />
            <rect x="3" y="8" width="13" height="8" rx="1" fill="rgba(255,255,255,.9)" />
            <path d="M20 10v4" stroke="rgba(255,255,255,.9)" stroke-width="1.5" stroke-linecap="round" />
          </svg>
        </div>
      </div>

      <div class="topbar">
        <div>
          <div class="greeting">Selamat datang kembali 👋</div>
          <div class="name">Jessica Putri</div>
        </div>
        <div class="avatar">JP</div>
      </div>

      <div class="hero" id="heroSlider" style="padding:0; overflow:hidden; min-height:148px;">
        <div id="heroTrack" style="display:flex; transition: transform 0.6s cubic-bezier(0.4,0,0.2,1);"></div>
      </div>
      <div style="display:flex; justify-content:center; gap:5px; margin-top:8px;" id="heroDots"></div>

      <div class="search-wrap">
        <div class="searchbar">
          <svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.2" stroke-linecap="round">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
          </svg>
          <input type="text" placeholder="Cari hotel, villa, destinasi...">
          <div class="filter-pill">
            <svg viewBox="0 0 24 24">
              <path d="M3 6h18M6 12h12M9 18h6" />
            </svg>
          </div>
        </div>
      </div>

      <div class="chips">
        <div class="chip active" data-filter="semua">Semua</div>
        <div class="chip idle" data-filter="flight">Flight</div>
        <div class="chip idle" data-filter="hotel">Hotel</div>
        <div class="chip idle" data-filter="villa">Villa</div>
        <div class="chip idle" data-filter="apartemen">Apartemen</div>
      </div>

      <div class="sec-head">
        <div class="title">Jelajah Kategori</div>
        <div class="see-all">Lihat semua →</div>
      </div>

      <div class="stack-row" id="stackRow"></div>

      <div class="sec-head">
        <div class="title">Promo & Diskon</div>
      </div>

      <div class="promo-slider-wrap" id="promoSliderWrap">
        <div class="promo-track" id="promoTrack"></div>
      </div>
      <div class="promo-dots" id="promoDots"></div>


      <div class="sec-head">
    <div class="title">Rekomendasi Populer</div>
    <div class="see-all">Lihat semua →</div>
</div>

<div class="featured-scroll" id="featuredScroll"></div>


      

      <div style="height:8px"></div>
    </div>
    <nav class="navbar">
      <div class="nav-item active">
        <a href="home.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
          <svg viewBox="0 0 24 24">
            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1V9.5z" />
            <path d="M9 21V12h6v9" />
          </svg>
          <span>Home</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="explore.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
          <svg viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
          </svg>
          <span>Explore</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="pesanan.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
          <svg viewBox="0 0 24 24">
            <rect x="3" y="4" width="18" height="18" rx="2" />
            <path d="M16 2v4M8 2v4M3 10h18" />
          </svg>
          <span>Pesanan</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="profile.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
          <svg viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
            <circle cx="12" cy="7" r="4" />
          </svg>
          <span>Profil</span>
        </a>
      </div>
    </nav>

    <div class="detail-modal" id="detailModal">
      <div class="detail-content">

        <div class="detail-header">
          <img id="detailImg" src="" alt="Property Image">
          <button class="detail-close" onclick="closeDetail()" aria-label="Close">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
              <line x1="18" y1="6" x2="6" y2="18" />
              <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
          </button>
        </div>

        <div class="detail-glass-panel">
          <div class="panel-handle"></div>

          <h2 class="detail-title" id="detailName">Nama Properti</h2>

          <div class="detail-location">
            <svg viewBox="0 0 24 24">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
            </svg>
            <span id="detailLocation">Lokasi</span>
          </div>

          <div class="detail-rating">
            <div class="detail-stars">
              <svg viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
              </svg>
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
              <svg viewBox="0 0 24 24">
                <path d="M5 12.55a11 11 0 0114.08 0" />
              </svg> WiFi
            </div>
            <div class="detail-amenity">
              <svg viewBox="0 0 24 24">
                <path d="M2 3h6a4 4 0 014 4v14" />
              </svg> Pool
            </div>
            <div class="detail-amenity">
              <svg viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" />
              </svg> AC
            </div>
            <div class="detail-amenity">
              <svg viewBox="0 0 24 24">
                <path d="M12 2v20M17 5H9" />
              </svg> Resto
            </div>
          </div>
        </div>
        <div class="modal-fixed-footer">
          <div class="modal-price-wrap">
            <div class="detail-price">Rp <span id="detailPrice">000</span>rb <span>/ malam</span></div>
          </div>
          <button class="detail-button" onclick="bookDetail(currentProp)">Pesan Sekarang</button>
        </div>

      </div>
    </div>


    <!-- PROMO DETAIL MODAL -->
    <div class="promo-modal" id="promoModal">
      <div class="promo-sheet">
        <img class="promo-sheet-img" id="promoModalImg" src="" alt="Promo">
        <div class="promo-sheet-body">
          <div class="promo-sheet-badge" id="promoModalBadge"></div>
          <div class="promo-sheet-title" id="promoModalTitle"></div>
          <div class="promo-sheet-desc" id="promoModalDesc"></div>
          <div class="promo-code-box">
            <div>
              <div class="promo-code-label">Kode Promo</div>
              <div class="promo-code-val" id="promoModalCode"></div>
            </div>
            <button class="promo-copy-btn" onclick="copyPromoCode()">Salin</button>
          </div>
        </div>
        <button class="promo-close-btn" onclick="closePromoModal()">Tutup</button>
      </div>
    </div>

    <!-- CATEGORY LIST MODAL -->
    <div class="cat-modal-overlay" id="catModal">
      <div class="cat-sheet">
        <div class="cat-sheet-handle"></div>
        <div class="cat-sheet-head">
          <div class="cat-sheet-title" id="catModalTitle">Kategori</div>
          <button class="cat-close-btn" id="catCloseBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="#0c2461" stroke-width="2.5" stroke-linecap="round">
              <path d="M18 6L6 18M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div id="catListBody"></div>
      </div>
    </div>
    <!-- ==========================================
       ── LOGIKA JAVASCRIPT & INTEGRASI DATABASE ──
       ========================================== -->
    <script>
      // 1. DATA MASTER (Diambil dari database yang kamu berikan)
      const villaDatabase = [{
          id: "v-001",
          name: "Sky View Private Villa",
          type: "Villa & Balcony",
          city: "Batu",
          locationDetail: "Oro-Oro Ombo, Batu (500m dari Jatim Park 2)",
          pricePerNight: 850000,
          rating: 4.8,
          facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "📶 Wifi"],
          imageUrl: "https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=500"
        },
        {
          id: "v-002",
          name: "Green Pine Family Homestay",
          type: "Villa Rumah",
          city: "Batu",
          locationDetail: "Songgokerto, Batu",
          pricePerNight: 620000,
          rating: 4.6,
          facilities: ["👪 Fam Room", "🌳 Garden", "📶 Wifi"],
          imageUrl: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=500"
        },
        {
          id: "v-003",
          name: "Canggu Bliss Luxury Villa",
          type: "Private Pool Villa",
          city: "Bali",
          locationDetail: "Canggu, Bali",
          pricePerNight: 1850000,
          rating: 4.9,
          facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "📶 Wifi"],
          imageUrl: "https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500"
        },
        {
          id: "v-004",
          name: "Ubud Rainforest Retreat",
          type: "Resort Villa",
          city: "Bali",
          locationDetail: "Sayan, Ubud, Bali",
          pricePerNight: 2100000,
          rating: 4.9,
          facilities: ["🏊‍♂️ Pool", "🌳 Garden", "📶 Wifi"],
          imageUrl: "https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=500"
        },
        {
          id: "v-005",
          name: "Seminyak Sun & Surf Villa",
          type: "Private Pool Villa",
          city: "Bali",
          locationDetail: "Seminyak, Kuta, Bali",
          pricePerNight: 1650000,
          rating: 4.7,
          facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "📶 Wifi"],
          imageUrl: "https://images.unsplash.com/photo-1512915922686-57c11dde9b6b?w=500"
        },
        {
          id: "v-006",
          name: "Alpine Wooden Chalet",
          type: "Cabin Villa",
          city: "Batu",
          locationDetail: "Bumiaji, Batu",
          pricePerNight: 950000,
          rating: 4.5,
          facilities: ["🔥 Fireplace", "🌳 Garden", "📶 Wifi"],
          imageUrl: "https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=500"
        },
        {
          id: "v-007",
          name: "Nusa Dua Cliffside Mansion",
          type: "Luxury Ocean Villa",
          city: "Bali",
          locationDetail: "Nusa Dua, Bali",
          pricePerNight: 3500000,
          rating: 5.0,
          facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "🚗 Parking"],
          imageUrl: "https://images.unsplash.com/photo-1583037189850-1921ae7c6c22?w=500"
        },
        {
          id: "v-008",
          name: "Hilltop Vista Homestay",
          type: "Family Villa",
          city: "Batu",
          locationDetail: "Sisir, Batu",
          pricePerNight: 750000,
          rating: 4.4,
          facilities: ["👪 Fam Room", "🌅 Balcony", "📶 Wifi"],
          imageUrl: "https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=500"
        }
      ];

      const hotelDatabase = [{
          id: "h-001",
          name: "The Grand Palace Hotel",
          type: "Luxury Hotel",
          city: "Surabaya",
          locationDetail: "Genteng, Surabaya Pusat",
          pricePerNight: 1200000,
          rating: 4.8,
          facilities: ["🏊‍♂️ Pool", "🏋️‍♂️ Gym", "🍳 Breakfast"],
          imageUrl: "https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500"
        },
        {
          id: "h-002",
          name: "Neo Horizon Business Hotel",
          type: "Business Hotel",
          city: "Surabaya",
          locationDetail: "Gubeng, Surabaya",
          pricePerNight: 650000,
          rating: 4.5,
          facilities: ["💻 Meeting Rm", "🍳 Breakfast", "📶 Wifi"],
          imageUrl: "https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=500"
        },
        {
          id: "h-003",
          name: "Batu Heritage Resort & Hotel",
          type: "Boutique Hotel",
          city: "Batu",
          locationDetail: "Sisir, Kota Batu",
          pricePerNight: 890000,
          rating: 4.6,
          facilities: ["🏊‍♂️ Pool", "🌳 Garden", "🍳 Breakfast"],
          imageUrl: "https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500"
        },
        {
          id: "h-004",
          name: "Kuta Beachfront Inn",
          type: "Budget Hotel",
          city: "Bali",
          locationDetail: "Kuta, Bali",
          pricePerNight: 450000,
          rating: 4.2,
          facilities: ["🏖️ Beach Access", "📶 Wifi", "🚗 Parking"],
          imageUrl: "https://images.unsplash.com/photo-1543968996-ee822b8176ba?w=500"
        },
        {
          id: "h-005",
          name: "The Urban Stay",
          type: "Minimalist Hotel",
          city: "Surabaya",
          locationDetail: "Wonokromo, Surabaya",
          pricePerNight: 380000,
          rating: 4.3,
          facilities: ["📶 Wifi", "☕ Cafe", "🚗 Parking"],
          imageUrl: "https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=500"
        },
        {
          id: "h-006",
          name: "Golden Tulip Skyline",
          type: "Luxury Hotel",
          city: "Batu",
          locationDetail: "Oro-Oro Ombo, Batu",
          pricePerNight: 1350000,
          rating: 4.7,
          facilities: ["🏊‍♂️ Pool", "🏋️‍♂️ Gym", "🌅 Balcony"],
          imageUrl: "https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=500"
        },
        {
          id: "h-007",
          name: "Sanur Serenity Resort",
          type: "Wellness Hotel",
          city: "Bali",
          locationDetail: "Sanur, Bali",
          pricePerNight: 1500000,
          rating: 4.8,
          facilities: ["🏊‍♂️ Pool", "🧘‍♂️ Yoga Deck", "🍳 Breakfast"],
          imageUrl: "https://images.unsplash.com/photo-1564507592333-c60657eea523?w=500"
        },
        {
          id: "h-008",
          name: "Spark Smart Hotel",
          type: "Transit Hotel",
          city: "Surabaya",
          locationDetail: "Juanda, Sidoarjo (Dekat Bandara)",
          pricePerNight: 320000,
          rating: 4.1,
          facilities: ["📶 Wifi", "🚌 Shuttle", "🚗 Parking"],
          imageUrl: "https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=500"
        },
        {
          id: "h-009",
          name: "The Ritz Signature",
          type: "5-Star Premium Hotel",
          city: "Bali",
          locationDetail: "Jimbaran, Bali",
          pricePerNight: 4200000,
          rating: 4.9,
          facilities: ["🏊‍♂️ Pool", "🏋️‍♂️ Gym", "🏖️ Beach Access"],
          imageUrl: "https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500"
        },
        {
          id: "h-010",
          name: "Eco Green Boutique Hotel",
          type: "Eco Hotel",
          city: "Batu",
          locationDetail: "Songgokerto, Batu",
          pricePerNight: 580000,
          rating: 4.4,
          facilities: ["🌳 Garden", "📶 Wifi", "☕ Cafe"],
          imageUrl: "https://images.unsplash.com/photo-1582719508461-905c673771fd?w=500"
        }
      ];

      const apartmentDatabase = [{
          id: "a-001",
          name: "Grand Pakuwon Residence",
          type: "Studio Apartment",
          city: "Surabaya",
          locationDetail: "Pakuwon Indah, Surabaya Barat",
          pricePerNight: 550000,
          rating: 4.6,
          facilities: ["🏊‍♂️ Pool", "📶 Wifi", "🍳 Kitchenette"],
          imageUrl: "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=500"
        },
        {
          id: "a-002",
          name: "Tunjungan Plaza Heights",
          type: "2BR Premium Apartment",
          city: "Surabaya",
          locationDetail: "Tegalsari, Surabaya Pusat",
          pricePerNight: 980000,
          rating: 4.8,
          facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "🏋️‍♂️ Gym"],
          imageUrl: "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=500"
        },
        {
          id: "a-003",
          name: "Batu Panorama Studio",
          type: "Mountain View Condo",
          city: "Batu",
          locationDetail: "Sisir, Kota Batu",
          pricePerNight: 480000,
          rating: 4.4,
          facilities: ["🌅 Balcony", "📶 Wifi", "🍳 Kitchenette"],
          imageUrl: "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=500"
        },
        {
          id: "a-004",
          name: "Canggu Loft & Studio",
          type: "Loft Apartment",
          city: "Bali",
          locationDetail: "Canggu, Bali",
          pricePerNight: 850000,
          rating: 4.7,
          facilities: ["🏊‍♂️ Pool", "📶 Wifi", "🍳 Kitchenette"],
          imageUrl: "https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=500"
        },
        {
          id: "a-005",
          name: "Ciputra World Orbit",
          type: "1BR Modern Apartment",
          city: "Surabaya",
          locationDetail: "Mayjen Sungkono, Surabaya",
          pricePerNight: 700000,
          rating: 4.5,
          facilities: ["🏊‍♂️ Pool", "🏋️‍♂️ Gym", "📶 Wifi"],
          imageUrl: "https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=500"
        },
        {
          id: "a-006",
          name: "Gunawangsa Merr Co-Living",
          type: "Budget Studio",
          city: "Surabaya",
          locationDetail: "Rungkut, Surabaya Timur",
          pricePerNight: 300000,
          rating: 4.2,
          facilities: ["🏊‍♂️ Pool", "📶 Wifi", "🚗 Parking"],
          imageUrl: "https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=500"
        },
        {
          id: "a-007",
          name: "De溫暖 Batu Apartment",
          type: "Family Suite Condo",
          city: "Batu",
          locationDetail: "Oro-Oro Ombo, Batu",
          pricePerNight: 650000,
          rating: 4.5,
          facilities: ["👪 Fam Room", "🌅 Balcony", "📶 Wifi"],
          imageUrl: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=500"
        },
        {
          id: "a-008",
          name: "Seminyak Urban Lofts",
          type: "Studio Apartment",
          city: "Bali",
          locationDetail: "Seminyak, Bali",
          pricePerNight: 900000,
          rating: 4.6,
          facilities: ["🏊‍♂️ Pool", "📶 Wifi", "🍳 Kitchenette"],
          imageUrl: "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=500"
        },
        {
          id: "a-009",
          name: "Educity Stanford Suite",
          type: "Student Studio",
          city: "Surabaya",
          locationDetail: "Mulyorejo, Surabaya Timur",
          pricePerNight: 320000,
          rating: 4.3,
          facilities: ["🏊‍♂️ Pool", "📶 Wifi", "Laundry"],
          imageUrl: "https://images.unsplash.com/photo-1554995207-c18c203602cb?w=500"
        },
        {
          id: "a-010",
          name: "The Peak Penthouse",
          type: "Luxury Penthouse",
          city: "Surabaya",
          locationDetail: "Embong Malang, Surabaya Pusat",
          pricePerNight: 2500000,
          rating: 4.9,
          facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "🏋️‍♂️ Gym"],
          imageUrl: "https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=500"
        }
      ];

      
const flightDatabase = [
{
    id:"f-001",
    airline:"Garuda Indonesia",
    origin:"Surabaya",
    destination:"Bali",
    departure:"08:00",
    arrival:"09:05",
    price:850000,
    imageUrl:"https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=500"
},
{
    id:"f-002",
    airline:"Citilink",
    origin:"Surabaya",
    destination:"Jakarta",
    departure:"10:20",
    arrival:"11:45",
    price:650000,
    imageUrl:"https://images.unsplash.com/photo-1540339832862-474599807836?w=500"
},
{
    id:"f-003",
    airline:"AirAsia",
    origin:"Surabaya",
    destination:"Yogyakarta",
    departure:"13:00",
    arrival:"14:05",
    price:500000,
    imageUrl:"https://images.unsplash.com/photo-1517479149777-5f3b1511d5ad?w=500"
}
];

      // Gabungkan semua menjadi satu data terpusat
      const allProperties = [
         ...flightDatabase.map(f => ({
            ...f,
            category: 'flight'
        })),
        ...villaDatabase.map(v => ({
          ...v,
          category: 'villa'
        })),
        ...hotelDatabase.map(h => ({
          ...h,
          category: 'hotel'
        })),
        ...apartmentDatabase.map(a => ({
          ...a,
          category: 'apartemen'
        }))
      ];

      const allAccommodations = [
  ...villaDatabase.map(v=>({...v,category:'villa'})),
  ...hotelDatabase.map(h=>({...h,category:'hotel'})),
  ...apartmentDatabase.map(a=>({...a,category:'apartemen'}))
];

      // DATA WISATA HERO SLIDER
      // const heroData = [
      //   { city: 'Bali', name: 'Tanah Lot', desc: 'Pura ikonik di atas batu karang tepi laut', imageUrl: 'https://images.unsplash.com/photo-1604999333679-b86d54738315?w=700' },
      //   { city: 'Bali', name: 'Tegalalang Rice Terrace', desc: 'Sawah terasering hijau memukau di Ubud', imageUrl: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=700' },
      //   { city: 'Bali', name: 'Pantai Kuta', desc: 'Pantai legendaris dengan sunset terbaik', imageUrl: 'https://images.unsplash.com/photo-1573790387438-4da905039392?w=700' },
      //   { city: 'Batu', name: 'Coban Rondo', desc: 'Air terjun indah di tengah hutan pinus', imageUrl: 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=700' },
      //   { city: 'Batu', name: 'Gunung Bromo', desc: 'Pemandangan gunung berapi paling ikonik di Jawa', imageUrl: 'https://images.unsplash.com/photo-1589308078059-be1415eab4c3?w=700' },
      //   { city: 'Batu', name: 'Selecta', desc: 'Taman bunga & kolam renang sejuk pegunungan', imageUrl: 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=700' },
      //   { city: 'Surabaya', name: 'Taman Bungkul', desc: 'Taman kota terbaik & ruang publik favorit', imageUrl: 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=700' },
      //   { city: 'Surabaya', name: 'Monumen Kapal Selam', desc: 'Ikon kebanggaan kota pahlawan Surabaya', imageUrl: 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=700' },
      // ];

      const heroData = [

{
city:'Flight',
name:'Jakarta → Bali',
desc:'Mulai Rp 499rb',
imageUrl:'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=700'
},

{
city:'Villa Bali',
name:'Luxury Private Pool',
desc:'Diskon hingga 40%',
imageUrl:'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=700'
},

{
city:'Hotel Surabaya',
name:'Staycation Premium',
desc:'Mulai Rp 380rb',
imageUrl:'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=700'
}

];

      let heroIndex = 0, heroTimer = null;

      function initHeroSlider() {
        const track = document.getElementById('heroTrack');
        const dots = document.getElementById('heroDots');
        if (!track || !dots) return;

        track.innerHTML = heroData.map(d => `
          <div class="hero-slide">
            <img src="${d.imageUrl}" alt="${d.name}">
            <div class="hero-slide-overlay">
              <div class="hero-eyebrow">${d.city} &bull; Destinasi Terbaik</div>
              <h2 style="font-family:'Playfair Display',serif;font-size:17px;font-weight:700;color:white;line-height:1.3;margin-bottom:4px;">${d.name}</h2>
              <p style="font-size:10px;color:rgba(255,255,255,.85);margin:0;">${d.desc}</p>
            </div>
          </div>
        `).join('');

        dots.innerHTML = heroData.map((_, i) =>
          `<div class="hero-dot${i === 0 ? ' active' : ''}" onclick="goToHero(${i})"></div>`
        ).join('');

        heroTimer = setInterval(() => { heroIndex = (heroIndex + 1) % heroData.length; goToHero(heroIndex); }, 5000);
      }

      function goToHero(idx) {
        heroIndex = idx;
        document.getElementById('heroTrack').style.transform = `translateX(-${idx * 100}%)`;
        document.querySelectorAll('.hero-dot').forEach((d, i) => d.classList.toggle('active', i === idx));
      }

      // DATA PROMO
      const promoData = [
        {
          badge: 'FLASH SALE 40%',
          title: 'Diskon 40% Villa Bali',
          sub: 'Berlaku s/d 31 Juli 2025',
          code: 'BALI40',
          desc: 'Dapatkan diskon 40% untuk semua villa di Bali. Berlaku untuk pemesanan minimal 2 malam. Tidak dapat digabung dengan promo lain.',
          imageUrl: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600'
        },
        {
          badge: 'WEEKEND DEAL 25%',
          title: 'Hotel Surabaya Hemat 25%',
          sub: 'Khusus Sabtu & Minggu',
          code: 'WKND25',
          desc: 'Nikmati menginap di hotel bintang 4 & 5 Surabaya dengan harga spesial 25% off setiap akhir pekan. Check-in Jumat–Minggu.',
          imageUrl: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600'
        },
        {
          badge: 'EARLY BIRD 30%',
          title: 'Pesan Lebih Awal, Hemat 30%',
          sub: 'Pesan 14 hari sebelumnya',
          code: 'EARLY30',
          desc: 'Rencanakan liburanmu lebih awal dan hemat hingga 30%! Berlaku untuk semua tipe properti jika dipesan minimal 14 hari sebelum check-in.',
          imageUrl: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=600'
        },
        {
          badge: 'BATU SPECIAL 20%',
          title: 'Staycation Batu Diskon 20%',
          sub: 'Berlaku sepanjang bulan ini',
          code: 'BATU20',
          desc: 'Rasakan kesejukan Kota Batu dengan harga lebih terjangkau. Diskon 20% untuk semua properti di Batu, berlaku untuk semua hari.',
          imageUrl: 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=600'
        }
      ];

      // 2. KETIKA WINDOW / HALAMAN SELESAI DIMUAT
      document.addEventListener("DOMContentLoaded", () => {
        initHeroSlider();
        initCategories();
        applyFilterAndSearch();
        initFilters();
        initSearch();
        initCategoryModal();
        initPromoSlider();
        // renderFlights();
      });

      // 3. LOGIKA RENDER KATEGORI TIPE PROPERTI (STACKED CARDS)
      const categoryConfig = [
        { key:'flight', label:'Flight' },
        { key: 'villa',     label: 'Villa' },
        { key: 'hotel',     label: 'Hotel' },
        { key: 'apartemen', label: 'Apartemen' },
      ];

      function initCategories() {
        const stackRow = document.getElementById("stackRow");
        if (!stackRow) return;
        stackRow.innerHTML = "";

        categoryConfig.forEach(cat => {
          
          // --- KONDISI 1: JIKA KATEGORINYA ADALAH FLIGHT ---
          if (cat.key === 'flight') {
            stackRow.insertAdjacentHTML("beforeend", `
              <div class="stack-group" onclick="window.location.href='flight.php'">
                <div class="stack-cluster">
                  <div class="sc"><img src="https://images.unsplash.com/photo-1521727857535-28d2047314ac?w=500"></div>
                  <div class="sc"><img src="https://images.unsplash.com/photo-1502920917128-1aa500764ce7?w=500"></div>
                  <div class="sc"><img src="https://images.unsplash.com/photo-1517479149777-5f3b1511d5ad?w=500"></div>
                </div>
                <div class="stack-label">Flight</div>
          
              </div>
            `);
            return; // Lompat ke perulangan berikutnya, jangan eksekusi kode properti di bawah
          }

          // --- KONDISI 2: UNTUK VILLA, HOTEL, APARTEMEN ---
          const catProps = allProperties.filter(p => p.category === cat.key);
          const imgs = catProps.slice(0, 3).map(p => p.imageUrl);
          while (imgs.length < 3) imgs.push(imgs[0]);

          const groupHtml = `
            <div class="stack-group" onclick="window.location.href='accom.php?type=${cat.key}'">
              <div class="stack-cluster">
                <div class="sc"><img src="${imgs[2]}" alt="${cat.label}"></div>
                <div class="sc"><img src="${imgs[1]}" alt="${cat.label}"></div>
                <div class="sc" data-count="+${catProps.length}"><img src="${imgs[0]}" alt="${cat.label}"></div>
              </div>
              <div class="stack-label">${cat.label}</div>
             
            </div>
          `;
          stackRow.insertAdjacentHTML("beforeend", groupHtml);
        }); // Penutup forEach yang aman
      } // Penutup fungsi initCategories() yang aman

      // 4. LOGIKA RENDER KARTU UTAMA REKOMENDASI
      function renderFeatured(propertiesList) {
        const featuredScroll = document.getElementById("featuredScroll");
        if (!featuredScroll) return;

        if (propertiesList.length === 0) {
          featuredScroll.innerHTML = `<div style="padding: 20px; color: var(--muted); font-size: 12px; text-align: center; width: 100%;">Properti tidak ditemukan...</div>`;
          return;
        }

        featuredScroll.innerHTML = "";
        propertiesList.forEach(prop => {
          if(prop.category === 'flight'){

        featuredScroll.innerHTML += `
        <div class="feat-card">
            <img src="${prop.imageUrl}">
            <div class="feat-info">

                <span class="feat-tag">
                    ${prop.airline}
                </span>

                <h5>
                    ${prop.origin} → ${prop.destination}
                </h5>

                <div class="loc">
                    🕒 ${prop.departure} - ${prop.arrival}
                </div>

                <div class="feat-bottom">
                    <div class="feat-price">
                        Rp ${Math.round(prop.price/1000)}rb
                    </div>

                    <div class="feat-stars">
                        ✈️ Flight
                    </div>
                </div>

            </div>
        </div>
        `;

        return;
    }

          const priceInRb = Math.round(prop.pricePerNight / 1000);
          // Atasi masalah single quote agar parsing objek di inline onclick aman
          const safePropJson = JSON.stringify(prop).replace(/'/g, "\\'").replace(/"/g, '&quot;');

          const cardHtml = `
      <div class="feat-card" onclick="openDetail(${safePropJson})">
        <img src="${prop.imageUrl}" alt="${prop.name}">
        <div class="feat-info">
          <span class="feat-tag">${prop.type}</span>
          <h5>${prop.name}</h5>
          <div class="loc">
            <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
            ${prop.locationDetail}
          </div>
          <div class="feat-bottom">
            <div class="feat-price">Rp ${priceInRb}rb<span>/malam</span></div>
            <div class="feat-stars">
              <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              ${prop.rating.toFixed(1)}
            </div>
          </div>
        </div>
      </div>
    `;
          featuredScroll.insertAdjacentHTML("beforeend", cardHtml);
        });
      }

      // 5. FITUR CHIPS FILTER
      let currentCategoryFilter = "semua";

      function initFilters() {
        const chips = document.querySelectorAll(".chips .chip");
        chips.forEach(chip => {
          chip.addEventListener("click", () => {
            chips.forEach(c => {
              c.classList.remove("active");
              c.classList.add("idle");
            });
            chip.classList.remove("idle");
            chip.classList.add("active");

            currentCategoryFilter = chip.getAttribute("data-filter");
            applyFilterAndSearch();
          });
        });
      }

      // 6. FITUR SEARCH BAR 
      let searchQuery = "";

      function initSearch() {
        const searchInput = document.querySelector(".searchbar input");
        if (!searchInput) return;

        searchInput.addEventListener("input", (e) => {
          searchQuery = e.target.value.toLowerCase().trim();
          applyFilterAndSearch();
        });
      }

      function applyFilterAndSearch() {
        let filtered = allProperties;

        if (currentCategoryFilter !== "semua") {
          filtered = filtered.filter(p => p.category === currentCategoryFilter);
        }

        if (searchQuery !== "") {
          // filtered = filtered.filter(p =>
          //   p.name.toLowerCase().includes(searchQuery) ||
          //   p.city.toLowerCase().includes(searchQuery) ||
          //   p.locationDetail.toLowerCase().includes(searchQuery)
          // );
          filtered = filtered.filter(p => {

    if(p.category === 'flight'){
        return (
            p.origin.toLowerCase().includes(searchQuery) ||
            p.destination.toLowerCase().includes(searchQuery) ||
            p.airline.toLowerCase().includes(searchQuery)
        );
    }

    return (
        p.name.toLowerCase().includes(searchQuery) ||
        p.city.toLowerCase().includes(searchQuery) ||
        p.locationDetail.toLowerCase().includes(searchQuery)
    );

});
        }

        // Urutkan default berdasarkan rating terbaik
        filtered.sort((a, b) => b.rating - a.rating);
        renderFeatured(filtered);
      }

      // 7. POPUP MODAL DETAIL INTERAKTIF
      let currentProp = null;
      window.openDetail = function(prop) {
        currentProp = prop;
        const modal = document.getElementById("detailModal");
        if (!modal) return;

        document.getElementById("detailImg").src = prop.imageUrl;
        document.getElementById("detailName").innerText = prop.name;
        document.getElementById("detailLocation").innerText = prop.locationDetail;
        document.getElementById("detailRating").innerText = prop.rating.toFixed(1);
        document.getElementById("detailPrice").innerText = Math.round(prop.pricePerNight / 1000);

        document.getElementById("detailDescription").innerText =
          `Nikmati staycation premium di ${prop.name} yang berlokasi di ${prop.city}. Akomodasi berjenis ${prop.type} ini menawarkan kenyamanan terbaik lengkap dengan fasilitas utama meliputi ${prop.facilities.join(', ')}. Sangat cocok untuk agenda liburan akhir pekan maupun staycation santai Anda.`;

        modal.classList.add("active");
      };

      window.closeDetail = function() {
        const modal = document.getElementById("detailModal");
        if (modal) modal.classList.remove("active");
      };

      window.bookDetail = function(prop) {
        window.location.href = 'booking.php?id=' + prop.id;
      };

      // 8. POPUP BOTTOM SHEET KATEGORI (LIHAT SEMUA KOTA)
      function initCategoryModal() {
        const closeBtn = document.getElementById("catCloseBtn");
        const overlay = document.getElementById("catModal");

        if (closeBtn && overlay) {
          closeBtn.addEventListener("click", () => overlay.classList.remove("active"));
          overlay.addEventListener("click", (e) => {
            if (e.target === overlay) overlay.classList.remove("active");
          });
        }

        const seeAllButtons = document.querySelectorAll(".sec-head .see-all");
        seeAllButtons.forEach(btn => {
          btn.addEventListener("click", () => openCategoryModal("Semua Kota"));
        });
      }

      window.openCategoryModal = function(cityName) {
        const overlay = document.getElementById("catModal");
        const title = document.getElementById("catModalTitle");
        const body = document.getElementById("catListBody");

        if (!overlay || !title || !body) return;

        title.innerText = cityName === "Semua Kota" ? "Semua Properti" : `Destinasi di ${cityName}`;

        const listData = cityName === "Semua Kota" ?
          allProperties :
          allProperties.filter(p => p.city.toLowerCase() === cityName.toLowerCase());

        body.innerHTML = "";

        if (listData.length === 0) {
          body.innerHTML = `<div style="padding: 30px; text-align:center; color: var(--muted); font-size: 13px;">Belum ada properti terdaftar.</div>`;
        } else {
          listData.forEach(prop => {
            const safePropJson = JSON.stringify(prop).replace(/'/g, "\\'").replace(/"/g, '&quot;');
            const itemHtml = `
        <div class="cat-list-item" onclick="closeCategoryModalAndOpenDetail(${safePropJson})">
          <img class="cat-list-thumb" src="${prop.imageUrl}" alt="${prop.name}">
          <div class="cat-list-info">
            <div class="cat-list-name">${prop.name}</div>
            <div class="cat-list-loc">${prop.locationDetail}</div>
          </div>
          <div class="cat-list-price">Rp ${Math.round(prop.pricePerNight/1000)}rb<span style="font-size:9px; font-weight:400; color:var(--muted)">/m</span></div>
        </div>
      `;
            body.insertAdjacentHTML("beforeend", itemHtml);
          });
        }

        overlay.classList.add("active");
      };

      // PROMO SLIDER LOGIC
      let promoIndex = 0;
      let promoTimer = null;

      function initPromoSlider() {
        const track = document.getElementById('promoTrack');
        const dotsWrap = document.getElementById('promoDots');
        const wrap = document.getElementById('promoSliderWrap');
        if (!track || !dotsWrap) return;

        track.innerHTML = promoData.map((p, i) => `
          <div class="promo-slide">
            <img src="${p.imageUrl}" alt="${p.title}">
            <div class="promo-overlay">
              <div class="promo-badge">${p.badge}</div>
              <div class="promo-title">${p.title}</div>
              <div class="promo-sub">${p.sub}</div>
            </div>
          </div>
        `).join('');

        dotsWrap.innerHTML = promoData.map((_, i) =>
          `<div class="promo-dot${i === 0 ? ' active' : ''}" onclick="goToPromo(${i})"></div>`
        ).join('');

        wrap.addEventListener('click', () => openPromoModal(promoIndex));
        startPromoTimer();
      }

      function goToPromo(idx) {
        promoIndex = idx;
        document.getElementById('promoTrack').style.transform = `translateX(-${idx * 100}%)`;
        document.querySelectorAll('.promo-dot').forEach((d, i) => {
          d.classList.toggle('active', i === idx);
        });
      }

      function startPromoTimer() {
        clearInterval(promoTimer);
        promoTimer = setInterval(() => {
          promoIndex = (promoIndex + 1) % promoData.length;
          goToPromo(promoIndex);
        }, 5000);
      }

      window.openPromoModal = function(idx) {
        const p = promoData[idx];
        document.getElementById('promoModalImg').src = p.imageUrl;
        document.getElementById('promoModalBadge').innerText = p.badge;
        document.getElementById('promoModalTitle').innerText = p.title;
        document.getElementById('promoModalDesc').innerText = p.desc;
        document.getElementById('promoModalCode').innerText = p.code;
        document.getElementById('promoModal').classList.add('active');
        clearInterval(promoTimer);
      };

      window.closePromoModal = function() {
        document.getElementById('promoModal').classList.remove('active');
        startPromoTimer();
      };

      window.copyPromoCode = function() {
        const code = document.getElementById('promoModalCode').innerText;
        navigator.clipboard.writeText(code).then(() => {
          const btn = document.querySelector('.promo-copy-btn');
          btn.innerText = 'Tersalin!';
          setTimeout(() => btn.innerText = 'Salin', 1500);
        });
      };

      window.closeCategoryModalAndOpenDetail = function(prop) {
        document.getElementById("catModal").classList.remove("active");
        setTimeout(() => {
          openDetail(prop);
        }, 250);
      };

      function renderFlights(){

const flightScroll =
document.getElementById('flightScroll');

flightScroll.innerHTML='';

flightDatabase.forEach(f=>{

flightScroll.innerHTML += `

<div class="feat-card">

<img src="${f.imageUrl}">

<div class="feat-info">

<span class="feat-tag">
${f.airline}
</span>

<h5>
${f.origin} → ${f.destination}
</h5>

<div class="loc">
🕒 ${f.departure} - ${f.arrival}
</div>

<div class="feat-bottom">

<div class="feat-price">
Rp ${Math.round(f.price/1000)}rb
</div>

<div class="feat-stars">
✈️ Flight
</div>

</div>

</div>

</div>

`;

});

}
    </script>
</body>