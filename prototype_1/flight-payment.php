<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pembayaran Flight</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root { --blue-900: #0c2461; --blue-500: #2563EB; --muted: #475569; }
  body {
    background: #b8cfe8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden;
    padding: 24px 16px;
    font-family: 'DM Sans', sans-serif;
  }
  .phone {
    width: 375px;
    height: 812px;
    border-radius: 44px;
    border: 9px solid #18181b;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    background: linear-gradient(165deg, #1e57b8 0%, #2563EB 18%, #4A90D9 36%, #82B8F0 54%, #C5DEFF 72%, #EBF4FF 88%, #F5F9FF 100%);
    box-shadow: 0 40px 80px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.12);
  }
  .notch {
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 26px;
    border-radius: 14px;
    background: #18181b;
    z-index: 500;
  }
  .scroll {
    flex: 1;
    overflow-y: auto;
    scrollbar-width: none;
    padding-bottom: 120px;
  }
  .scroll::-webkit-scrollbar { display: none; }
  .hero-header { position: relative; width: 100%; height: 180px; overflow: hidden; }
  .hero-header img { width: 100%; height: 100%; object-fit: cover; display: block; }
  .hero-header-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(12,36,97,.55) 0%, rgba(12,36,97,.25) 100%);
    display: flex;
    align-items: flex-end;
    padding: 16px 20px 20px;
    gap: 12px;
  }
  .back-btn {
    width: 36px;
    height: 36px;
    border-radius: 12px;
    flex-shrink: 0;
    background: rgba(255,255,255,.25);
    border: 1px solid rgba(255,255,255,.4);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }
  .back-btn svg { width: 18px; height: 18px; stroke: white; fill: none; stroke-width: 2; stroke-linecap: round; }
  .page-title { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: white; }
  .prop-info { padding: 16px 20px 0; }
  .prop-tag {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 999px;
    background: #EFF6FF;
    color: var(--blue-500);
    font-size: 9px;
    font-weight: 700;
    letter-spacing: .4px;
    margin-bottom: 6px;
  }
  .prop-name { font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 700; color: var(--blue-900); margin-bottom: 4px; }
  .prop-loc { font-size: 11px; color: var(--muted); display: flex; align-items: center; gap: 4px; margin-bottom: 4px; }
  .prop-loc svg { width: 11px; height: 11px; fill: var(--blue-500); }
  .section { padding: 14px 20px 0; }
  .sec-label { font-size: 13px; font-weight: 700; color: var(--blue-900); margin-bottom: 10px; }
  .glass-card {
    background: rgba(255,255,255,.75);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 16px;
    border: 1px solid rgba(255,255,255,.9);
    box-shadow: 0 4px 24px rgba(12,36,97,.07), inset 0 1px 0 rgba(255,255,255,1);
  }
  .summary-row { display: flex; justify-content: space-between; font-size: 12px; color: var(--muted); margin-bottom: 10px; }
  .summary-row:last-child { margin-bottom: 0; }
  .summary-row strong { color: var(--blue-900); font-weight: 600; }
  .method-card {
    background: rgba(255,255,255,.75);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1.5px solid rgba(255,255,255,.9);
    border-radius: 16px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: all .2s;
    margin-bottom: 10px;
    box-shadow: 0 4px 16px rgba(12,36,97,.06), inset 0 1px 0 rgba(255,255,255,1);
  }
  .method-card:last-child { margin-bottom: 0; }
  .method-card.active { border-color: var(--blue-500); background: rgba(37,99,235,.1); }
  .method-left { display: flex; align-items: center; gap: 12px; }
  .method-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: rgba(37,99,235,.1);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .method-icon svg { width: 20px; height: 20px; stroke: var(--blue-500); fill: none; stroke-width: 1.8; }
  .method-name { font-size: 13px; font-weight: 700; color: var(--blue-900); }
  .method-desc { font-size: 10px; color: var(--muted); margin-top: 2px; }
  .radio {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid rgba(12,36,97,.2);
    flex-shrink: 0;
    transition: all .2s;
  }
  .method-card.active .radio { border: 5px solid var(--blue-500); }
  #promoList {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .promo-item {
    background: rgba(255,255,255,.85);
    border: 1px solid rgba(37,99,235,.16);
    border-radius: 18px;
    padding: 12px;
    display: flex;
    gap: 12px;
    align-items: center;
    cursor: pointer;
    transition: transform .2s, border-color .2s, background .2s;
  }
  .promo-item:hover { transform: translateY(-1px); }
  .promo-item.active {
    border-color: var(--blue-500);
    background: rgba(37,99,235,.12);
  }
  .promo-thumb { width: 52px; height: 52px; border-radius: 14px; object-fit: cover; flex-shrink: 0; }
  .promo-body { flex: 1; }
  .promo-badge { display: inline-block; font-size: 10px; font-weight: 700; color: var(--blue-500); background: rgba(37,99,235,.12); padding: 4px 8px; border-radius: 999px; margin-bottom: 4px; }
  .promo-title { font-size: 13px; font-weight: 700; color: var(--blue-900); margin-bottom: 2px; }
  .promo-code { font-size: 10px; color: var(--muted); }
  .promo-check {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    border: 2px solid rgba(12,36,97,.2);
    display: grid;
    place-items: center;
    flex-shrink: 0;
  }
  .promo-item.active .promo-check { border-color: var(--blue-500); background: var(--blue-500); }
  .promo-item.active .promo-check::after {
    content: '✓';
    color: white;
    font-size: 12px;
  }
  .total-row {
    display: flex;
    justify-content: space-between;
    font-size: 15px;
    font-weight: 700;
    color: var(--blue-900);
    border-top: 1px dashed rgba(12,36,97,.15);
    padding-top: 12px;
    margin-top: 4px;
  }
  .total-row span:last-child { color: var(--blue-500); }
  .footer-btn {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    padding: 15px;
    border: none;
    border-radius: 18px;
    background: #1D4ED8;
    color: white;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    box-shadow: 0 8px 20px rgba(29,78,216,.35);
  }
</style>
</head>

<body>

<div class="phone">
  <div class="notch"></div>
  <div class="scroll">

    <div class="hero-header">
      <img id="heroImg" src="" alt="Flight image">
      <div class="hero-header-overlay">
        <button class="back-btn" onclick="history.back()">
          <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        </button>
        <div class="page-title">Pembayaran Flight</div>
      </div>
    </div>

    <div class="prop-info">
      <div class="prop-tag" id="flightTag"></div>
      <div class="prop-name" id="airlineName"></div>
      <div class="prop-loc">
        <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
        <span id="routeText"></span>
      </div>
    </div>

    <div class="section">
      <div class="sec-label">Detail Pesanan</div>
      <div class="glass-card">
        <div class="summary-row"><span>Tanggal Keberangkatan</span><strong id="sumDate"></strong></div>
        <div class="summary-row"><span>Penumpang</span><strong id="sumPassenger"></strong></div>
        <div class="summary-row"><span>Rute</span><strong id="sumRoute"></strong></div>
      </div>
    </div>

    <div class="section">
      <div class="sec-label">Gunakan Promo</div>
      <div id="promoList"></div>
    </div>

    <div class="section">
      <div class="sec-label">Metode Pembayaran</div>
      <div id="methodList">
        <div class="method-card active" data-method="Credit Card">
          <div class="method-left">
            <div class="method-icon"><svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/></svg></div>
            <div><div class="method-name">Credit Card</div><div class="method-desc">Visa, Mastercard, JCB</div></div>
          </div>
          <div class="radio"></div>
        </div>
        <div class="method-card" data-method="Bank Transfer">
          <div class="method-left">
            <div class="method-icon"><svg viewBox="0 0 24 24"><path d="M3 10L12 4l9 6"/><path d="M6 10v10h12V10"/></svg></div>
            <div><div class="method-name">Bank Transfer</div><div class="method-desc">BCA, Mandiri, BNI</div></div>
          </div>
          <div class="radio"></div>
        </div>
        <div class="method-card" data-method="E-Wallet">
          <div class="method-left">
            <div class="method-icon"><svg viewBox="0 0 24 24"><path d="M8 2h8a2 2 0 012 2v16a2 2 0 01-2 2H8a2 2 0 01-2-2V4a2 2 0 012-2z"/><path d="M10 19h4"/></svg></div>
            <div><div class="method-name">E-Wallet</div><div class="method-desc">GoPay, OVO, DANA</div></div>
          </div>
          <div class="radio"></div>
        </div>
      </div>
    </div>

    <div class="section" style="padding-bottom:8px;">
      <div class="sec-label">Ringkasan Pembayaran</div>
      <div class="glass-card">
        <div class="summary-row"><span>Total Harga</span><strong id="sumTotal"></strong></div>
        <div class="summary-row"><span>Promo Diskon</span><strong id="sumDiscount"></strong></div>
        <div class="total-row"><span>Total Payment</span><span id="sumFinal"></span></div>
      </div>
    </div>

  </div>

  <button class="footer-btn" id="payBtn">Bayar Sekarang</button>
</div>

<script src="db.js"></script>
<script>
  const booking = JSON.parse(localStorage.getItem('pendingFlightBooking'));

  if (!booking) {
    window.location.href = 'flight.php';
  }

  const fmt = n => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(n);
  const promoData = [
    { badge: 'FLASH SALE 15%', title: 'Diskon 15% Tiket Domestik', code: 'FLY15', discount: 15, imageUrl: 'https://images.unsplash.com/photo-1500534623283-312aade485b7?w=200&auto=format&fit=crop' },
    { badge: 'TRAVEL DEAL 10%', title: 'Potongan 10% untuk penerbangan', code: 'TRAVEL10', discount: 10, imageUrl: 'https://images.unsplash.com/photo-1526772662000-3f88f10405ff?w=200&auto=format&fit=crop' },
    { badge: 'EARLY BIRD 20%', title: 'Diskon 20% untuk booking awal', code: 'EARLY20', discount: 20, imageUrl: 'https://images.unsplash.com/photo-1495344517868-8ebaf0a2044a?w=200&auto=format&fit=crop' }
  ];

  let selectedPromoIndex = null;
  let selectedPaymentMethod = 'Credit Card';

  function updateSummary() {
    const total = Number(booking.totalPrice || 0);
    const discountPercent = selectedPromoIndex !== null ? promoData[selectedPromoIndex].discount : 0;
    const discountAmount = Math.round(total * discountPercent / 100);
    const finalTotal = total - discountAmount;

    document.getElementById('sumTotal').innerText = fmt(total);
    document.getElementById('sumDiscount').innerText = discountPercent > 0 ? `- ${fmt(discountAmount)} (${discountPercent}%)` : '-';
    document.getElementById('sumFinal').innerText = fmt(finalTotal);
    return { discountAmount, finalTotal };
  }

  function renderPromos() {
    const promoList = document.getElementById('promoList');
    promoList.innerHTML = promoData.map((promo, index) => {
      const activeClass = index === selectedPromoIndex ? 'active' : '';
      return `
        <div class="promo-item ${activeClass}" data-index="${index}">
          <img class="promo-thumb" src="${promo.imageUrl}" alt="${promo.title}">
          <div class="promo-body">
            <div class="promo-badge">${promo.badge}</div>
            <div class="promo-title">${promo.title}</div>
            <div class="promo-code">Kode: ${promo.code}</div>
          </div>
          <div class="promo-check"></div>
        </div>
      `;
    }).join('');
  }

  function selectPromo(index) {
    selectedPromoIndex = selectedPromoIndex === index ? null : index;
    renderPromos();
    updateSummary();
  }

  function initPaymentMethods() {
    document.querySelectorAll('.method-card').forEach(card => {
      card.addEventListener('click', () => {
        document.querySelectorAll('.method-card').forEach(x => x.classList.remove('active'));
        card.classList.add('active');
        selectedPaymentMethod = card.dataset.method;
      });
    });
  }

  document.getElementById('flightTag').innerText = booking.type === 'flight' ? 'Flight' : 'Travel';
  document.getElementById('airlineName').innerText = booking.airline || 'Flight Booking';
  document.getElementById('routeText').innerText = `${booking.from} → ${booking.to}`;
  document.getElementById('sumDate').innerText = booking.departureDate || '-';
  document.getElementById('sumPassenger').innerText = `${booking.passenger || 0} Penumpang`;
  document.getElementById('sumRoute').innerText = `${booking.from} → ${booking.to}`;
  document.getElementById('heroImg').src = booking.imageUrl || 'https://images.unsplash.com/photo-1517832207067-4db24a2ae47c?w=800';

  renderPromos();
  initPaymentMethods();
  updateSummary();

  document.getElementById('promoList').addEventListener('click', event => {
    const target = event.target.closest('.promo-item');
    if (!target) return;
    selectPromo(Number(target.dataset.index));
  });

  document.getElementById('payBtn').addEventListener('click', async () => {
    const { discountAmount, finalTotal } = updateSummary();

    if (!selectedPaymentMethod) {
      alert('Pilih metode pembayaran terlebih dahulu');
      return;
    }

    const payload = {
      ...booking,
      paymentMethod: selectedPaymentMethod,
      promoCode: selectedPromoIndex !== null ? promoData[selectedPromoIndex].code : null,
      promoTitle: selectedPromoIndex !== null ? promoData[selectedPromoIndex].title : null,
      promoDiscount: selectedPromoIndex !== null ? promoData[selectedPromoIndex].discount : 0,
      discountAmount,
      grandTotal: finalTotal,
      bookedAt: new Date().toISOString()
    };

    const res = await fetch('save-flight-booking.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });

    const result = await res.json();

    if (result.success) {
      localStorage.removeItem('pendingFlightBooking');
      alert('Pembayaran Berhasil ✈️');
      // Redirect with timestamp to avoid cached JS/data
      window.location.href = 'pesanan.php?ts=' + Date.now();
    } else {
      alert(result.message || 'Gagal menyimpan pembayaran');
    }
  });
</script>

</body>
</html>
