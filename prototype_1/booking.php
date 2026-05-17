<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Villa</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Inter', sans-serif;
        }

        body{
            background:#e2e8f0;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .phone-frame{
            width:375px;
            height:812px;
            background:#f8fafc;
            border-radius:40px;
            border:8px solid #2d3436;
            overflow:hidden;
            position:relative;
            box-shadow:0 25px 50px rgba(0,0,0,0.3);
        }

        .phone-notch{
            position:absolute;
            top:0;
            left:50%;
            transform:translateX(-50%);
            width:150px;
            height:25px;
            background:#2d3436;
            border-bottom-left-radius:15px;
            border-bottom-right-radius:15px;
            z-index:999;
        }

        .content{
            height:100%;
            overflow-y:auto;
            padding-bottom:120px;
        }

        .content::-webkit-scrollbar{
            display:none;
        }

        .hero-image{
            width:100%;
            height:260px;
            object-fit:cover;
        }

        .booking-wrapper{
            padding:20px;
        }

        .villa-type{
            font-size:12px;
            font-weight:700;
            color:#008170;
            text-transform:uppercase;
            margin-bottom:6px;
        }

        .villa-name{
            font-size:22px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:8px;
        }

        .villa-location{
            font-size:13px;
            color:#64748b;
            margin-bottom:18px;
        }

        .price-box{
            background:white;
            border-radius:18px;
            padding:18px;
            margin-bottom:20px;
            border:1px solid #e2e8f0;
        }

        .price-label{
            font-size:12px;
            color:#64748b;
            margin-bottom:4px;
        }

        .price{
            font-size:24px;
            font-weight:700;
            color:#008170;
        }

        .section-title{
            font-size:15px;
            font-weight:700;
            margin-bottom:14px;
            color:#1e293b;
        }

        .booking-card{
            background:white;
            border-radius:20px;
            padding:18px;
            border:1px solid #e2e8f0;
            margin-bottom:20px;
        }

        .booking-group{
            margin-bottom:16px;
        }

        .booking-group label{
            display:block;
            font-size:12px;
            font-weight:600;
            margin-bottom:8px;
            color:#475569;
        }

        .booking-input{
            width:100%;
            padding:14px;
            border-radius:14px;
            border:1px solid #cbd5e1;
            background:#f8fafc;
            font-size:14px;
            outline:none;
        }

        .available-dates{
            display:flex;
            flex-wrap:wrap;
            gap:8px;
            margin-top:10px;
        }

        .date-pill{
            padding:8px 12px;
            border-radius:999px;
            background:#dcfce7;
            color:#166534;
            font-size:11px;
            font-weight:600;
        }

        .summary-card{
            background:#f0fdf4;
            border:1px solid #bbf7d0;
            border-radius:18px;
            padding:18px;
        }

        .summary-row{
            display:flex;
            justify-content:space-between;
            margin-bottom:10px;
            font-size:13px;
            color:#334155;
        }

        .summary-total{
            border-top:1px dashed #94a3b8;
            padding-top:12px;
            margin-top:12px;
            display:flex;
            justify-content:space-between;
            font-size:16px;
            font-weight:700;
            color:#0f172a;
        }

        .book-btn{
            position:absolute;
            bottom:20px;
            left:50%;
            transform:translateX(-50%);
            width:85%;
            border:none;
            background:#008170;
            color:white;
            padding:16px;
            border-radius:18px;
            font-size:14px;
            font-weight:700;
            cursor:pointer;
            box-shadow:0 10px 20px rgba(0,129,112,0.25);
        }
    </style>
</head>
<body>

<div class="phone-frame">
    <div class="phone-notch"></div>

    <div class="content" id="booking-content"></div>

    <button class="book-btn" onclick="goToPayment()">
    Continue Booking
</button>
</div>

<script src="db.js"></script>

<script>
    const params = new URLSearchParams(window.location.search);
    const villaId = params.get('id');

    const villa = villaDatabase.find(v => v.id === villaId);

    const content = document.getElementById('booking-content');

    const formattedPrice = new Intl.NumberFormat('id-ID', {
        style:'currency',
        currency:'IDR',
        maximumFractionDigits:0
    }).format(villa.pricePerNight);

    content.innerHTML = `
        <img src="${villa.imageUrl}" class="hero-image">

        <div class="booking-wrapper">

            <p class="villa-type">${villa.type}</p>
            <h1 class="villa-name">${villa.name}</h1>
            <p class="villa-location">📍 ${villa.locationDetail}</p>

            <div class="price-box">
                <p class="price-label">Harga per malam</p>
                <div class="price">${formattedPrice}</div>
            </div>

            <h3 class="section-title">Tanggal Tersedia</h3>

            <div class="available-dates">
                <div class="date-pill">20 Jul</div>
                <div class="date-pill">21 Jul</div>
                <div class="date-pill">22 Jul</div>
                <div class="date-pill">24 Jul</div>
                <div class="date-pill">25 Jul</div>
            </div>

            <br>

            <h3 class="section-title">Booking Detail</h3>

            <div class="booking-card">

                <div class="booking-group">
                    <label>Check-in</label>
                    <input 
                        type="date"
                        id="checkin-date"
                        class="booking-input"
                    >
                </div>

                <div class="booking-group">
                    <label>Check-out</label>
                    <input 
                        type="date"
                        id="checkout-date"
                        class="booking-input"
                    >
                </div>

                <div class="booking-group">
                    <label>Jumlah Guest</label>

                    <select id="guest-count" class="booking-input">
                        <option>1 Guest</option>
                        <option>2 Guests</option>
                        <option>3 Guests</option>
                        <option>4 Guests</option>
                        <option>5 Guests</option>
                        <option>6 Guests</option>
                    </select>
                </div>

            </div>

            <h3 class="section-title">Payment Summary</h3>

            <div class="summary-card">

                <div class="summary-row">
                    <span>Harga per malam</span>
                    <span>${formattedPrice}</span>
                </div>

                <div class="summary-row">
                    <span>Jumlah malam</span>
                    <span id="night-count">0 malam</span>
                </div>

                <div class="summary-row">
                    <span>Service Fee</span>
                    <span>Rp 75.000</span>
                </div>

                <div class="summary-total">
                    <span>Total</span>
                    <span id="total-price">Rp 0</span>
                </div>

            </div>

        </div>
    `;

    function calculateTotal() {

        const checkin =
            new Date(document.getElementById('checkin-date').value);

        const checkout =
            new Date(document.getElementById('checkout-date').value);

        if (!checkin || !checkout) return;

        const diffTime = checkout - checkin;

        const nights =
            diffTime / (1000 * 60 * 60 * 24);

        if (nights > 0) {

            const serviceFee = 75000;

            const total =
                (villa.pricePerNight * nights) + serviceFee;

            document.getElementById('night-count')
                .innerText = `${nights} malam`;

            document.getElementById('total-price')
                .innerText = new Intl.NumberFormat(
                    'id-ID',
                    {
                        style:'currency',
                        currency:'IDR',
                        maximumFractionDigits:0
                    }
                ).format(total);
        }
    }

    document.addEventListener('change', function(e){

        if(
            e.target.id === 'checkin-date' ||
            e.target.id === 'checkout-date'
        ){
            calculateTotal();
        }

    });

    function goToPayment() {

    const checkin =
        document.getElementById('checkin-date').value;

    const checkout =
        document.getElementById('checkout-date').value;

    const guest =
        document.getElementById('guest-count').value;

    const total =
        document.getElementById('total-price')
        .innerText
        .replace(/[^\d]/g, '');

    if (!checkin || !checkout) {
        alert("Pilih tanggal terlebih dahulu");
        return;
    }

    window.location.href =
        `payment.php?id=${villa.id}
        &checkin=${checkin}
        &checkout=${checkout}
        &guest=${guest}
        &total=${total}`;
}
</script>

</body>
</html>