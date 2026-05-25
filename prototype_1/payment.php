<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Agoda Redesign</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Inter', sans-serif;
        }

        body{
            background:#e2e8f0;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
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
            padding:45px 20px 120px;
        }

        .content::-webkit-scrollbar{
            display:none;
        }

        .page-title{
            font-size:22px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:20px;
        }

        .booking-card{
            background:white;
            border-radius:22px;
            overflow:hidden;
            border:1px solid #e2e8f0;
            margin-bottom:20px;
        }

        .booking-image{
            width:100%;
            height:180px;
            object-fit:cover;
        }

        .booking-detail{
            padding:16px;
        }

        .villa-type{
            font-size:11px;
            color:#008170;
            font-weight:700;
            text-transform:uppercase;
            margin-bottom:6px;
        }

        .villa-name{
            font-size:18px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:6px;
        }

        .villa-location{
            font-size:12px;
            color:#64748b;
            margin-bottom:16px;
        }

        .summary-row{
            display:flex;
            justify-content:space-between;
            margin-bottom:12px;
            font-size:13px;
            color:#334155;
        }

        .section-title{
            font-size:15px;
            font-weight:700;
            color:#1e293b;
            margin-bottom:14px;
        }

        .payment-methods{
            display:flex;
            flex-direction:column;
            gap:12px;
            margin-bottom:20px;
        }

        .method-card{
            background:white;
            border:2px solid #e2e8f0;
            border-radius:18px;
            padding:16px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            cursor:pointer;
            transition:0.2s;
        }

        .method-card.active{
            border-color:#008170;
            background:#f0fdfa;
        }

        .method-left{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .method-icon{
            width:42px;
            height:42px;
            border-radius:12px;
            background:#f1f5f9;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:18px;
        }

        .method-name{
            font-size:14px;
            font-weight:600;
            color:#0f172a;
        }

        .method-desc{
            font-size:11px;
            color:#64748b;
            margin-top:2px;
        }

        .radio{
            width:18px;
            height:18px;
            border-radius:50%;
            border:2px solid #cbd5e1;
        }

        .method-card.active .radio{
            border:6px solid #008170;
        }

        .payment-summary{
            background:white;
            border-radius:20px;
            padding:18px;
            border:1px solid #e2e8f0;
        }

        .total-row{
            display:flex;
            justify-content:space-between;
            margin-top:14px;
            padding-top:14px;
            border-top:1px dashed #cbd5e1;
            font-size:17px;
            font-weight:700;
            color:#0f172a;
        }

        .pay-btn{
            position:absolute;
            bottom:20px;
            left:50%;
            transform:translateX(-50%);
            width:85%;
            padding:16px;
            border:none;
            border-radius:18px;
            background:#008170;
            color:white;
            font-size:15px;
            font-weight:700;
            cursor:pointer;
            box-shadow:0 10px 20px rgba(0,129,112,0.25);
        }
          html.dark-mode body {
            background: #020617;
            color: #e2e8f0;
        }
        html.dark-mode .phone,
        html.dark-mode .phone-frame {
            border-color: #0f172a !important;
            background: linear-gradient(165deg, #0f172a 0%, #111827 30%, #1f2937 60%, #0f172a 100%) !important;
            box-shadow: 0 40px 90px rgba(0,0,0,.8) !important;
        }
        html.dark-mode .payment-summary,
        html.dark-mode .card,
        html.dark-mode .detail-row,
        html.dark-mode .method-card,
        html.dark-mode .form-field,
        html.dark-mode .pay-action,
        html.dark-mode .btn,
        html.dark-mode .note-text {
            background: rgba(15,23,42,.92) !important;
            border-color: rgba(148,163,184,.2) !important;
            color: #e2e8f0 !important;
        }
        html.dark-mode .btn-primary,
        html.dark-mode .btn-confirm {
            background: rgba(37,99,235,.95) !important;
            color: white !important;
        }
        html.dark-mode input,
        html.dark-mode select,
        html.dark-mode textarea {
            background: rgba(15,23,42,.96) !important;
            color: #e2e8f0 !important;
            border-color: rgba(148,163,184,.3) !important;
        }
    </style>
</head>
<body>

<div class="phone-frame">

    <div class="phone-notch"></div>

    <div class="content" id="payment-content"></div>

    <button class="pay-btn" onclick="completePayment()">
        Pay Now
    </button>

</div>

<script src="db.js"></script>

<script>

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

    });

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

        method: 'POST',

        headers: {
            'Content-Type': 'application/json'
        },

        body: JSON.stringify(bookingData)

    });

    alert("Payment Successful! 🎉");

    window.location.href = "home.php";

}

</script>

    <script src="theme.js"></script>
</body>
</html>