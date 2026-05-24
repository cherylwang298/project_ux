<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --blue-900: #0c2461; --blue-500: #2563EB; --muted: #475569;
      --glass-bg: rgba(255,255,255,0.40); --glass-border: rgba(255,255,255,0.45);
      --glass-blur: blur(25px);
    }
    body {
      background: #b8cfe8; display: flex; justify-content: center; align-items: center;
      height: 100vh; overflow: hidden; padding: 24px 16px; font-family: 'DM Sans', sans-serif;
    }
    .phone {
      width: 375px; height: 812px; border-radius: 44px; border: 9px solid #18181b;
      position: relative; overflow: hidden; display: flex; flex-direction: column;
      background: #F5F9FF;
      box-shadow: 0 40px 80px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.12);
    }
    .notch {
      position: absolute; top: 8px; left: 50%; transform: translateX(-50%);
      width: 100px; height: 26px; background: #18181b; border-radius: 14px; z-index: 500;
    }
    .scroll {
      flex: 1; overflow-y: auto; scrollbar-width: none; padding-bottom: 100px;
    }
    .scroll::-webkit-scrollbar { display: none; }

    /* HERO HEADER */
    .hero-header {
      position: relative; width: 100%; height: 180px; overflow: hidden;
    }
    .hero-header img {
      width: 100%; height: 100%; object-fit: cover; display: block;
    }
    .hero-header-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(180deg, rgba(12,36,97,.55) 0%, rgba(12,36,97,.25) 100%);
      display: flex; align-items: flex-end; padding: 16px 20px 20px;
      gap: 12px;
    }
    .back-btn {
      width: 36px; height: 36px; border-radius: 12px; flex-shrink: 0;
      background: rgba(255,255,255,.25); border: 1px solid rgba(255,255,255,.4);
      backdrop-filter: blur(10px); display: flex; align-items: center;
      justify-content: center; cursor: pointer;
    }
    .back-btn svg { width: 18px; height: 18px; stroke: white; fill: none; stroke-width: 2; stroke-linecap: round; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: white; }

    /* PROPERTY INFO */
    .prop-info { padding: 16px 20px 0; }
    .prop-tag {
      display: inline-block; padding: 3px 10px; border-radius: 999px;
      background: rgba(255,255,255,.3); color: white; font-size: 9px; font-weight: 700;
      letter-spacing: .4px; margin-bottom: 6px; backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,.4);
    }
    .prop-name { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: #0c2461; margin-bottom: 4px; }
    .prop-loc { font-size: 11px; color: #475569; display: flex; align-items: center; gap: 4px; margin-bottom: 6px; }
    .prop-loc svg { width: 11px; height: 11px; fill: var(--blue-500); }
    .prop-price { font-size: 18px; font-weight: 700; color: var(--blue-500); margin-bottom: 0; }
    .prop-price span { font-size: 11px; font-weight: 400; color: var(--muted); }

    /* SECTION */
    .section { padding: 14px 20px 0; }
    .sec-label { font-size: 12px; font-weight: 700; color: #0c2461; margin-bottom: 8px; letter-spacing: .2px; }

    /* DATE PILLS */
    .date-pills { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 4px; }
    .date-pill {
      padding: 6px 14px; border-radius: 999px;
      background: white; border: 1px solid rgba(12,36,97,.08);
      box-shadow: 0 2px 8px rgba(12,36,97,.06), inset 0 1px 0 rgba(255,255,255,1);
      color: var(--blue-500); font-size: 11px; font-weight: 600;
    }

    /* FORM CARD */
    .form-card {
      background: white; border-radius: 20px; padding: 16px;
      border: 1px solid rgba(255,255,255,.9);
      box-shadow: 0 4px 24px rgba(12,36,97,.07), inset 0 1px 0 rgba(255,255,255,1);
    }
    .form-group { margin-bottom: 14px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-group label { display: block; font-size: 11px; font-weight: 600; color: #475569; margin-bottom: 6px; }
    .form-input {
      width: 100%; padding: 12px 14px; border-radius: 12px;
      border: 1px solid rgba(12,36,97,.08);
      background: #F8FBFF;
      font-size: 13px; color: var(--blue-900); font-family: 'DM Sans', sans-serif; outline: none;
    }
    .form-input:focus { border-color: var(--blue-500); background: rgba(255,255,255,.85); }

    /* PROMO LIST */
    .promo-list { display: flex; flex-direction: column; gap: 10px; }
    .promo-item {
      background: white;
      border: 1px solid rgba(255,255,255,.9);
      border-radius: 16px; padding: 12px; display: flex; align-items: center;
      gap: 12px; cursor: pointer; transition: all .2s;
      box-shadow: 0 4px 16px rgba(12,36,97,.06), inset 0 1px 0 rgba(255,255,255,1);
    }
    .promo-item.selected { border-color: var(--blue-500); background: rgba(37,99,235,.12); }
    .promo-item-img { width: 48px; height: 48px; border-radius: 12px; object-fit: cover; flex-shrink: 0; }
    .promo-item-info { flex: 1; }
    .promo-item-badge {
      font-size: 9px; font-weight: 800; color: #92400E;
      background: #FEF3C7; padding: 2px 8px; border-radius: 999px;
      display: inline-block; margin-bottom: 3px;
    }
    .promo-item-title { font-size: 12px; font-weight: 700; color: var(--blue-900); margin-bottom: 1px; }
    .promo-item-code { font-size: 10px; color: var(--muted); }
    .promo-check {
      width: 22px; height: 22px; border-radius: 50%;
      border: 2px solid rgba(255,255,255,.7); flex-shrink: 0; transition: all .2s;
      display: flex; align-items: center; justify-content: center;
      background: rgba(255,255,255,.3);
    }
    .promo-item.selected .promo-check { background: var(--blue-500); border-color: var(--blue-500); }
    .promo-item.selected .promo-check::after {
      content: ''; width: 5px; height: 9px;
      border: 2px solid white; border-top: none; border-left: none;
      transform: rotate(45deg) translateY(-1px); display: block;
    }

    /* SUMMARY */
    .summary-card {
      background: white; border-radius: 20px; padding: 16px;
      border: 1px solid rgba(255,255,255,.9);
      box-shadow: 0 4px 24px rgba(12,36,97,.07), inset 0 1px 0 rgba(255,255,255,1);
    }
    .summary-row { display: flex; justify-content: space-between; font-size: 12px; color: var(--muted); margin-bottom: 10px; }
    .summary-discount { display: flex; justify-content: space-between; font-size: 12px; color: #16a34a; font-weight: 600; margin-bottom: 10px; }
    .summary-total {
      display: flex; justify-content: space-between;
      font-size: 15px; font-weight: 700; color: var(--blue-900);
      border-top: 1px dashed rgba(12,36,97,.15); padding-top: 12px; margin-top: 4px;
    }

    /* FOOTER BTN */
    .footer-btn {
      position: absolute; bottom: 20px; left: 20px; right: 20px;
      padding: 15px; border: none; border-radius: 18px;
      background: #1D4ED8; color: white; font-size: 14px; font-weight: 700;
      cursor: pointer; font-family: 'DM Sans', sans-serif;
      box-shadow: 0 8px 20px rgba(29,78,216,.35);
    }
  </style>
</head>
<body>
<div class="phone">
  <div class="notch"></div>
  <div class="scroll">

    <div class="hero-header">
      <img id="heroImg" src="" alt="">
      <div class="hero-header-overlay">
        <button class="back-btn" onclick="history.back()">
          <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        </button>
        <div class="page-title">Detail Booking</div>
      </div>
    </div>

    <div class="prop-info">
      <div class="prop-tag" id="propTag"></div>
      <div class="prop-name" id="propName"></div>
      <div class="prop-loc">
        <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
        <span id="propLoc"></span>
      </div>
      <div class="prop-price" id="propPrice"></div>
    </div>

    <div class="section">
      <div class="sec-label">Tanggal Tersedia</div>
      <div class="date-pills">
        <div class="date-pill">20 Jul</div>
        <div class="date-pill">21 Jul</div>
        <div class="date-pill">22 Jul</div>
        <div class="date-pill">24 Jul</div>
        <div class="date-pill">25 Jul</div>
      </div>
    </div>

    <div class="section">
      <div class="sec-label">Booking Detail</div>
      <div class="form-card">
        <div class="form-group">
          <label>Check-in</label>
          <input type="date" id="checkin" class="form-input">
        </div>
        <div class="form-group">
          <label>Check-out</label>
          <input type="date" id="checkout" class="form-input">
        </div>
        <div class="form-group">
          <label>Jumlah Guest</label>
          <select id="guestCount" class="form-input">
            <option>1 Guest</option>
            <option>2 Guests</option>
            <option>3 Guests</option>
            <option>4 Guests</option>
            <option>5 Guests</option>
            <option>6 Guests</option>
          </select>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="sec-label">Gunakan Promo</div>
      <div class="promo-list" id="promoList"></div>
    </div>

    <div class="section" style="padding-bottom: 8px;">
      <div class="sec-label">Ringkasan Pembayaran</div>
      <div class="summary-card">
        <div class="summary-row"><span>Harga per malam</span><span id="sumPrice">-</span></div>
        <div class="summary-row"><span>Jumlah malam</span><span id="sumNights">0 malam</span></div>
        <div class="summary-row"><span>Service Fee</span><span>Rp 75.000</span></div>
        <div class="summary-discount" id="discountRow" style="display:none">
          <span id="discountLabel">Diskon</span>
          <span id="discountAmt"></span>
        </div>
        <div class="summary-total"><span>Total</span><span id="sumTotal">Rp 0</span></div>
      </div>
    </div>

  </div>

  <button class="footer-btn" onclick="goToPayment()">Lanjut ke Pembayaran</button>
</div>

<script src="db.js"></script>
<script>
  const params = new URLSearchParams(window.location.search);
  const villaId = params.get('id');

  const allDB = typeof allDatabase !== 'undefined' ? allDatabase : [...(typeof villaDatabase !== 'undefined' ? villaDatabase : []), ...(typeof hotelDatabase !== 'undefined' ? hotelDatabase : []), ...(typeof apartmentDatabase !== 'undefined' ? apartmentDatabase : [])];

  const villa = allDB.find(v => v.id === villaId) || {
    id: villaId, name: 'Properti', type: '-', locationDetail: '-',
    pricePerNight: 0, imageUrl: '', rating: 0, facilities: []
  };

  const fmt = n => new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', maximumFractionDigits:0 }).format(n);

  document.getElementById('heroImg').src = villa.imageUrl;
  document.getElementById('propTag').innerText = villa.type;
  document.getElementById('propName').innerText = villa.name;
  document.getElementById('propLoc').innerText = villa.locationDetail;
  document.getElementById('propPrice').innerHTML = fmt(villa.pricePerNight) + ' <span>/ malam</span>';
  document.getElementById('sumPrice').innerText = fmt(villa.pricePerNight);

  const promoData = [
    { badge: 'FLASH SALE 40%', title: 'Diskon 40% Villa Bali', code: 'BALI40', discount: 40, imageUrl: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=200' },
    { badge: 'WEEKEND DEAL 25%', title: 'Hotel Surabaya Hemat 25%', code: 'WKND25', discount: 25, imageUrl: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=200' },
    { badge: 'EARLY BIRD 30%', title: 'Pesan Lebih Awal, Hemat 30%', code: 'EARLY30', discount: 30, imageUrl: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=200' },
    { badge: 'BATU SPECIAL 20%', title: 'Staycation Batu Diskon 20%', code: 'BATU20', discount: 20, imageUrl: 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=200' }
  ];

  let selectedPromo = null;

  document.getElementById('promoList').innerHTML = promoData.map((p, i) => `
    <div class="promo-item" id="pi-${i}" onclick="selectPromo(${i})">
      <img class="promo-item-img" src="${p.imageUrl}" alt="${p.title}">
      <div class="promo-item-info">
        <div class="promo-item-badge">${p.badge}</div>
        <div class="promo-item-title">${p.title}</div>
        <div class="promo-item-code">Kode: ${p.code}</div>
      </div>
      <div class="promo-check" id="pc-${i}"></div>
    </div>
  `).join('');

  function selectPromo(idx) {
    selectedPromo = selectedPromo === idx ? null : idx;
    promoData.forEach((_, i) => document.getElementById(`pi-${i}`).classList.toggle('selected', i === selectedPromo));
    calcTotal();
  }

  function calcTotal() {
    const ci = new Date(document.getElementById('checkin').value);
    const co = new Date(document.getElementById('checkout').value);
    const nights = Math.round((co - ci) / 86400000);
    if (nights <= 0) return;

    const subtotal = villa.pricePerNight * nights;
    const service = 75000;
    let disc = 0;

    document.getElementById('sumNights').innerText = nights + ' malam';

    if (selectedPromo !== null) {
      const p = promoData[selectedPromo];
      disc = Math.round(subtotal * p.discount / 100);
      document.getElementById('discountLabel').innerText = `Diskon ${p.discount}% (${p.code})`;
      document.getElementById('discountAmt').innerText = '- ' + fmt(disc);
      document.getElementById('discountRow').style.display = 'flex';
    } else {
      document.getElementById('discountRow').style.display = 'none';
    }

    document.getElementById('sumTotal').innerText = fmt(subtotal + service - disc);
  }

  document.getElementById('checkin').addEventListener('change', calcTotal);
  document.getElementById('checkout').addEventListener('change', calcTotal);

  function goToPayment() {
    const checkin = document.getElementById('checkin').value;
    const checkout = document.getElementById('checkout').value;
    const guest = document.getElementById('guestCount').value;
    const total = document.getElementById('sumTotal').innerText.replace(/[^\d]/g, '');

    if (!checkin || !checkout) { alert('Pilih tanggal terlebih dahulu'); return; }

    const promoCode = selectedPromo !== null ? promoData[selectedPromo].code : '';
    const promoDiscount = selectedPromo !== null ? promoData[selectedPromo].discount : 0;

    window.location.href = `payment.php?id=${villa.id}&checkin=${checkin}&checkout=${checkout}&guest=${encodeURIComponent(guest)}&total=${total}&promoCode=${promoCode}&promoDiscount=${promoDiscount}`;
  }
</script>
</body>
</html>
