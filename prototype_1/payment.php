<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
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
    .notch {
      position: absolute; top: 8px; left: 50%; transform: translateX(-50%);
      width: 100px; height: 26px; background: #18181b; border-radius: 14px; z-index: 500;
    }
    .scroll { flex: 1; overflow-y: auto; scrollbar-width: none; padding-bottom: 100px; }
    .scroll::-webkit-scrollbar { display: none; }

    /* HERO HEADER */
    .hero-header { position: relative; width: 100%; height: 180px; overflow: hidden; }
    .hero-header img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .hero-header-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(180deg, rgba(12,36,97,.55) 0%, rgba(12,36,97,.25) 100%);
      display: flex; align-items: flex-end; padding: 16px 20px 20px; gap: 12px;
    }
    .back-btn {
      width: 36px; height: 36px; border-radius: 12px; flex-shrink: 0;
      background: rgba(255,255,255,.25); border: 1px solid rgba(255,255,255,.4);
      backdrop-filter: blur(10px); display: flex; align-items: center;
      justify-content: center; cursor: pointer;
    }
    .back-btn svg { width: 18px; height: 18px; stroke: white; fill: none; stroke-width: 2; stroke-linecap: round; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: white; }

    /* PROP INFO */
    .prop-info { padding: 16px 20px 0; }
    .prop-tag {
      display: inline-block; padding: 3px 10px; border-radius: 999px;
      background: #EFF6FF; color: var(--blue-500); font-size: 9px; font-weight: 700;
      letter-spacing: .4px; margin-bottom: 6px;
    }
    .prop-name { font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 700; color: var(--blue-900); margin-bottom: 4px; }
    .prop-loc { font-size: 11px; color: var(--muted); display: flex; align-items: center; gap: 4px; margin-bottom: 4px; }
    .prop-loc svg { width: 11px; height: 11px; fill: var(--blue-500); }

    /* SECTION */
    .section { padding: 14px 20px 0; }
    .sec-label { font-size: 13px; font-weight: 700; color: var(--blue-900); margin-bottom: 10px; }

    /* BOOKING SUMMARY CARD */
    .glass-card {
      background: rgba(255,255,255,.75); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
      border-radius: 20px; padding: 16px;
      border: 1px solid rgba(255,255,255,.9);
      box-shadow: 0 4px 24px rgba(12,36,97,.07), inset 0 1px 0 rgba(255,255,255,1);
    }
    .summary-row { display: flex; justify-content: space-between; font-size: 12px; color: var(--muted); margin-bottom: 10px; }
    .summary-row:last-child { margin-bottom: 0; }
    .summary-row strong { color: var(--blue-900); font-weight: 600; }

    /* PAYMENT METHODS */
    .method-card {
      background: rgba(255,255,255,.75); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
      border: 1.5px solid rgba(255,255,255,.9);
      border-radius: 16px; padding: 14px 16px; display: flex; align-items: center;
      justify-content: space-between; cursor: pointer; transition: all .2s; margin-bottom: 10px;
      box-shadow: 0 4px 16px rgba(12,36,97,.06), inset 0 1px 0 rgba(255,255,255,1);
    }
    .method-card:last-child { margin-bottom: 0; }
    .method-card.active { border-color: var(--blue-500); background: rgba(37,99,235,.1); }
    .method-left { display: flex; align-items: center; gap: 12px; }
    .method-icon {
      width: 42px; height: 42px; border-radius: 12px;
      background: rgba(37,99,235,.1); display: flex; align-items: center; justify-content: center;
    }
    .method-icon svg { width: 20px; height: 20px; stroke: var(--blue-500); fill: none; stroke-width: 1.8; }
    .method-name { font-size: 13px; font-weight: 700; color: var(--blue-900); }
    .method-desc { font-size: 10px; color: var(--muted); margin-top: 2px; }
    .radio {
      width: 18px; height: 18px; border-radius: 50%;
      border: 2px solid rgba(12,36,97,.2); flex-shrink: 0; transition: all .2s;
    }
    .method-card.active .radio { border: 5px solid var(--blue-500); }

    /* TOTAL */
    .total-row {
      display: flex; justify-content: space-between;
      font-size: 15px; font-weight: 700; color: var(--blue-900);
      border-top: 1px dashed rgba(12,36,97,.15); padding-top: 12px; margin-top: 4px;
    }
    .total-row span:last-child { color: var(--blue-500); }

    /* FOOTER BTN */
    .footer-btn {
      position: absolute; bottom: 20px; left: 20px; right: 20px;
      padding: 15px; border: none; border-radius: 18px;
      background: #1D4ED8; color: white; font-size: 14px; font-weight: 700;
      cursor: pointer; font-family: 'DM Sans', sans-serif;
      box-shadow: 0 8px 20px rgba(29,78,216,.35);
    }

    html.dark-mode body { background: #020617; }
    html.dark-mode .phone { border-color: #0f172a !important; background: linear-gradient(165deg, #0f172a 0%, #111827 30%, #1f2937 60%, #0f172a 100%) !important; }
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
        <div class="page-title">Pembayaran</div>
      </div>
    </div>

    <div class="prop-info">
      <div class="prop-tag" id="propTag"></div>
      <div class="prop-name" id="propName"></div>
      <div class="prop-loc">
        <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
        <span id="propLoc"></span>
      </div>
    </div>

    <div class="section">
      <div class="sec-label">Detail Pesanan</div>
      <div class="glass-card">
        <div class="summary-row"><span>Check-in</span><strong id="sumCheckin"></strong></div>
        <div class="summary-row"><span>Check-out</span><strong id="sumCheckout"></strong></div>
        <div class="summary-row"><span>Guests</span><strong id="sumGuest"></strong></div>
      </div>
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
        <div class="summary-row"><span>Tax & Service Fee</span><strong>Included</strong></div>
        <div class="total-row"><span>Total Payment</span><span id="sumFinal"></span></div>
      </div>
    </div>

  </div>
  <button class="footer-btn" id="payBtn">Bayar Sekarang</button>
</div>

<script src="db.js"></script>
<script>
  window.addEventListener('load', function() {
    const p = new URLSearchParams(window.location.search);
    const villaId = p.get('id') || '';
    const checkin = p.get('checkin') || '';
    const checkout = p.get('checkout') || '';
    const guest = p.get('guest') || '';
    const total = p.get('total') || '0';

<<<<<<< HEAD
const params = new URLSearchParams(window.location.search);

const villaId = params.get('id') || '';
const checkin = params.get('checkin') || '';
const checkout = params.get('checkout') || '';
const guest = params.get('guest') || '';
const total = params.get('total') || '';

const villa = villaDatabase.find(v => v.id == villaId);

const content = document.getElementById('payment-content');

if (!villa) {

    content.innerHTML = `
        <h2 style="
            padding:40px;
            text-align:center;
            color:#0f172a;
        ">
            Villa not found 😭
        </h2>
    `;

} else {

    const formattedTotal =
        new Intl.NumberFormat('id-ID', {
            style:'currency',
            currency:'IDR',
            maximumFractionDigits:0
        }).format(total);

    content.innerHTML = `

        <h1 class="page-title">
            Payment
        </h1>

        <div class="booking-card">

            <img
                src="${villa.imageUrl}"
                class="booking-image"
            >

            <div class="booking-detail">

                <p class="villa-type">
                    ${villa.type}
                </p>

                <h2 class="villa-name">
                    ${villa.name}
                </h2>

                <p class="villa-location">
                    📍 ${villa.locationDetail}
                </p>

                <div class="summary-row">
                    <span>Check-in</span>
                    <span>${checkin}</span>
                </div>

                <div class="summary-row">
                    <span>Check-out</span>
                    <span>${checkout}</span>
                </div>

                <div class="summary-row">
                    <span>Guests</span>
                    <span>${guest}</span>
                </div>

            </div>

        </div>

        <h3 class="section-title">
            Payment Method
        </h3>

        <div class="payment-methods">

            <div class="method-card active">

                <div class="method-left">

                    <div class="method-icon">
                        💳
                    </div>

                    <div>
                        <div class="method-name">
                            Credit Card
                        </div>

                        <div class="method-desc">
                            Visa, Mastercard, JCB
                        </div>
                    </div>

                </div>

                <div class="radio"></div>

            </div>

            <div class="method-card">

                <div class="method-left">

                    <div class="method-icon">
                        🏦
                    </div>

                    <div>
                        <div class="method-name">
                            Bank Transfer
                        </div>

                        <div class="method-desc">
                            BCA, Mandiri, BNI
                        </div>
                    </div>

                </div>

                <div class="radio"></div>

            </div>

            <div class="method-card">

                <div class="method-left">

                    <div class="method-icon">
                        📱
                    </div>

                    <div>
                        <div class="method-name">
                            E-Wallet
                        </div>

                        <div class="method-desc">
                            GoPay, OVO, DANA
                        </div>
                    </div>

                </div>

                <div class="radio"></div>

            </div>

        </div>

        <h3 class="section-title">
            Payment Summary
        </h3>

        <div class="payment-summary">

            <div class="summary-row">
                <span>Room Price</span>
                <span>${formattedTotal}</span>
            </div>

            <div class="summary-row">
                <span>Tax Included</span>
                <span>Included</span>
            </div>

            <div class="summary-row">
                <span>Service Fee</span>
                <span>Included</span>
            </div>

            <div class="total-row">
                <span>Total Payment</span>
                <span>${formattedTotal}</span>
            </div>

        </div>

    `;

    const methods =
        document.querySelectorAll('.method-card');

    methods.forEach(method => {

        method.addEventListener('click', () => {

            methods.forEach(m =>
                m.classList.remove('active')
            );

            method.classList.add('active');

        });
=======
    const db = typeof allDatabase !== 'undefined' ? allDatabase : [];
    const villa = db.find(v => v.id === villaId);
    const fmt = n => new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', maximumFractionDigits:0 }).format(n);

    if (!villa) {
      document.querySelector('.scroll').innerHTML = '<h2 style="padding:60px 20px;text-align:center;color:#0c2461;">Properti tidak ditemukan</h2>';
      return;
    }

    document.getElementById('heroImg').src = villa.imageUrl;
    document.getElementById('propTag').innerText = villa.type;
    document.getElementById('propName').innerText = villa.name;
    document.getElementById('propLoc').innerText = villa.locationDetail;
    document.getElementById('sumCheckin').innerText = checkin;
    document.getElementById('sumCheckout').innerText = checkout;
    document.getElementById('sumGuest').innerText = guest;
    document.getElementById('sumTotal').innerText = fmt(total);
    document.getElementById('sumFinal').innerText = fmt(total);
>>>>>>> 3c8d84c96f5776433556482924a7228cd393e4b3

    document.querySelectorAll('.method-card').forEach(m => {
      m.addEventListener('click', () => {
        document.querySelectorAll('.method-card').forEach(x => x.classList.remove('active'));
        m.classList.add('active');
      });
    });

<<<<<<< HEAD
}

async function completePayment(){

    if (!villa) return;

    const bookingData = {

        villaId: villa.id,
        villaName: villa.name,
        imageUrl: villa.imageUrl,

        checkin: checkin,
        checkout: checkout,

        guest: guest,

        total: total,

        paymentMethod:
            document.querySelector('.method-card.active .method-name')
            .innerText,

        bookedAt:
            new Date().toISOString()

    };

    await fetch('save_booking.php', {

=======
    document.getElementById('payBtn').onclick = async function() {
      const method = document.querySelector('.method-card.active').dataset.method;
      await fetch('save_booking.php', {
>>>>>>> 3c8d84c96f5776433556482924a7228cd393e4b3
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ villaId: villa.id, villaName: villa.name, imageUrl: villa.imageUrl, checkin, checkout, guest, total, paymentMethod: method, bookedAt: new Date().toISOString() })
      });
      alert('Pembayaran Berhasil!');
      window.location.href = 'home.php';
    };
  });
</script>
<<<<<<< HEAD
=======
<script src="theme.js"></script>
>>>>>>> 3c8d84c96f5776433556482924a7228cd393e4b3
</body>
</html>
