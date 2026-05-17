<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>

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
            box-shadow:0 25px 50px rgba(0,0,0,0.25);
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
            font-size:24px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:20px;
        }

        .booking-card{
            background:white;
            border-radius:24px;
            overflow:hidden;
            margin-bottom:18px;
            border:1px solid #e2e8f0;
            box-shadow:0 4px 12px rgba(0,0,0,0.05);
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
            font-weight:700;
            color:#008170;
            text-transform:uppercase;
            margin-bottom:5px;
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
            margin-bottom:14px;
        }

        .summary-row{
            display:flex;
            justify-content:space-between;
            margin-bottom:10px;
            font-size:13px;
            color:#334155;
        }

        .status-badge{
            margin-top:14px;
            display:inline-block;
            padding:8px 14px;
            border-radius:999px;
            background:#dcfce7;
            color:#166534;
            font-size:11px;
            font-weight:700;
        }

        .empty-state{
            margin-top:120px;
            text-align:center;
            color:#94a3b8;
        }

        .empty-icon{
            font-size:60px;
            margin-bottom:16px;
        }

        .empty-title{
            font-size:18px;
            font-weight:700;
            margin-bottom:8px;
            color:#334155;
        }

        .empty-desc{
            font-size:13px;
            line-height:1.5;
        }

        .nav-bar{
            position:absolute;
            bottom:15px;
            left:50%;
            transform:translateX(-50%);
            width:85%;
            background:rgba(255,255,255,0.95);
            backdrop-filter:blur(10px);
            display:flex;
            justify-content:space-around;
            padding:10px 0;
            border-radius:20px;
            box-shadow:0 5px 15px rgba(0,0,0,0.15);
        }

        .nav-item{
            text-align:center;
            font-size:9px;
            color:#94a3b8;
            text-decoration:none;
        }

        .nav-item.active{
            color:#008170;
            font-weight:700;
        }

    </style>
</head>
<body>

<div class="phone-frame">

    <div class="phone-notch"></div>

    <div class="content">

        <h1 class="page-title">
            Pesanan Saya
        </h1>

        <div id="booking-container"></div>

    </div>

    <nav class="nav-bar">

        <a href="home.php" class="nav-item">
            🏠<br>Awal
        </a>

        <a href="explore.php" class="nav-item">
            🔍<br>Explore
        </a>

        <a href="pesanan.php" class="nav-item active">
            📅<br>Pesanan
        </a>

        <a href="#" class="nav-item">
            👤<br>Profil
        </a>

    </nav>

</div>

<script>

async function loadBookings(){

    const response =
        await fetch('bookings.json');

    const bookings =
        await response.json();

    const container =
        document.getElementById('booking-container');

    if(bookings.length === 0){

        container.innerHTML = `

            <div class="empty-state">

                <div class="empty-icon">
                    🧳
                </div>

                <div class="empty-title">
                    Belum Ada Pesanan
                </div>

                <div class="empty-desc">
                    Yuk mulai booking villa impianmu ✨
                </div>

            </div>

        `;

        return;

    }

    bookings.reverse().forEach(booking => {

        const formattedTotal =
            new Intl.NumberFormat(
                'id-ID',
                {
                    style:'currency',
                    currency:'IDR',
                    maximumFractionDigits:0
                }
            ).format(booking.total);

        container.innerHTML += `

            <div class="booking-card">

                <img
                    src="${booking.imageUrl}"
                    class="booking-image"
                >

                <div class="booking-detail">

                    <p class="villa-type">
                        BOOKED VILLA
                    </p>

                    <h2 class="villa-name">
                        ${booking.villaName}
                    </h2>

                    <p class="villa-location">
                        📅 ${booking.checkin}
                        → ${booking.checkout}
                    </p>

                    <div class="summary-row">
                        <span>Guests</span>
                        <span>${booking.guest}</span>
                    </div>

                    <div class="summary-row">
                        <span>Payment Method</span>
                        <span>${booking.paymentMethod}</span>
                    </div>

                    <div class="summary-row">
                        <span>Total Payment</span>
                        <span>${formattedTotal}</span>
                    </div>

                    <div class="status-badge">
                        ✓ Paid
                    </div>

                </div>

            </div>

        `;

    });

}

loadBookings();

</script>

</body>
</html>