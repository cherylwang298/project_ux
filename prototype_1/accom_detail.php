<!-- detail.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Villa</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Inter',sans-serif;
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
            background:#fff;
            border-radius:40px;
            border:8px solid #2d3436;
            overflow:hidden;
            position:relative;
            box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);
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
            z-index:100;
        }

        .content{
            height:100%;
            overflow-y:auto;
            padding-bottom:100px;
            scrollbar-width:none;
        }

        .content::-webkit-scrollbar{
            display:none;
        }

        .hero-image{
            width:100%;
            height:280px;
            object-fit:cover;
        }

        .detail-body{
            padding:20px;
        }

        .villa-type{
            color:#008170;
            font-size:12px;
            font-weight:700;
            text-transform:uppercase;
            margin-bottom:6px;
        }

        .villa-name{
            font-size:22px;
            font-weight:700;
            color:#1e293b;
            margin-bottom:8px;
        }

        .villa-location{
            font-size:13px;
            color:#64748b;
            margin-bottom:18px;
        }

        .rating-box{
            background:#f1f5f9;
            padding:10px 14px;
            border-radius:14px;
            display:inline-flex;
            gap:8px;
            align-items:center;
            font-size:13px;
            font-weight:600;
            margin-bottom:20px;
        }

        .section-title{
            font-size:15px;
            font-weight:700;
            color:#1e293b;
            margin-bottom:12px;
        }

        .description{
            font-size:13px;
            line-height:1.7;
            color:#475569;
            margin-bottom:24px;
        }

        .facility-list{
            display:flex;
            flex-wrap:wrap;
            gap:10px;
            margin-bottom:28px;
        }

        .facility-pill{
            background:#f1f5f9;
            border:1px solid #e2e8f0;
            padding:10px 14px;
            border-radius:14px;
            font-size:12px;
            color:#475569;
        }

        .booking-bar{
            position:absolute;
            bottom:0;
            left:0;
            right:0;
            background:white;
            border-top:1px solid #e2e8f0;
            padding:16px 20px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .price{
            font-size:20px;
            font-weight:700;
            color:#008170;
        }

        .price-note{
            font-size:10px;
            color:#94a3b8;
        }

        .book-btn{
            border:none;
            background:#008170;
            color:white;
            padding:14px 22px;
            border-radius:16px;
            font-size:13px;
            font-weight:700;
            cursor:pointer;
        }

        .back-btn{
            position:absolute;
            top:40px;
            left:16px;
            z-index:200;
            width:38px;
            height:38px;
            border-radius:50%;
            border:none;
            background:rgba(255,255,255,0.9);
            cursor:pointer;
            font-size:16px;
        }
    </style>
</head>
<body>

<div class="phone-frame">

    <div class="phone-notch"></div>

    <button class="back-btn" onclick="history.back()">←</button>

    <div class="content" id="detail-container"></div>

</div>

<script src="db.js"></script>

<script>
    const params = new URLSearchParams(window.location.search);
    const villaId = params.get('id');

    const villa = villaDatabase.find(v => v.id === villaId);

    const container = document.getElementById('detail-container');

    if (!villa) {
        container.innerHTML = `
            <div style="padding:40px;text-align:center;">
                <h2>Villa tidak ditemukan</h2>
            </div>
        `;
    } else {

        const formattedPrice = new Intl.NumberFormat('id-ID', {
            style:'currency',
            currency:'IDR',
            maximumFractionDigits:0
        }).format(villa.pricePerNight);

        const facilities = villa.facilities
            .map(f => `<div class="facility-pill">${f}</div>`)
            .join('');

        container.innerHTML = `
            <img src="${villa.imageUrl}" class="hero-image">

            <div class="detail-body">

                <div class="villa-type">${villa.type}</div>

                <div class="villa-name">${villa.name}</div>

                <div class="villa-location">
                    📍 ${villa.locationDetail}
                </div>

                <div class="rating-box">
                    ⭐ ${villa.rating}
                    <span style="color:#64748b;">Excellent Rating</span>
                </div>

                <div class="section-title">Deskripsi</div>

                <div class="description">
                    Nikmati pengalaman menginap premium dengan fasilitas lengkap,
                    lokasi strategis, suasana nyaman, dan desain modern yang cocok
                    untuk staycation maupun liburan keluarga.
                </div>

                <div class="section-title">Fasilitas</div>

                <div class="facility-list">
                    ${facilities}
                </div>

            </div>

            <div class="booking-bar">
                <div>
                    <div class="price">${formattedPrice}</div>
                    <div class="price-note">
                        Harga sudah termasuk pajak
                    </div>
                </div>

                <button class="book-btn">
                    Booking Sekarang
                </button>
            </div>
        `;
    }
</script>

</body>
</html>