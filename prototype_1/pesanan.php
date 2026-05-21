<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agoda Redesign - Pesanan Saya</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #cbd5e1; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* =========================
           PHONE FRAME & BACKGROUND
        ========================== */
        .phone-frame {
            width: 375px; 
            height: 812px; 
            border-radius: 45px; 
            border: 10px solid #111; 
            position: relative;
            
            background: linear-gradient(
                180deg,
                #93C6F9 0%,
                #C2E0FD 25%,
                #EAF4FF 50%,
                #FFFFFF 100%
            );
            overflow: hidden; 
            display: flex;
            flex-direction: column;
            box-shadow: 0 35px 70px rgba(0, 0, 0, .30), inset 0 0 0 1px rgba(255, 255, 255, .08);
        }

        .phone-notch {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 110px;
            height: 28px;
            background: #111;
            border-radius: 20px;
            z-index: 1000;
        }

        /* ANIMATED BLOBS */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(8px);
            opacity: 0.6; 
            z-index: 0;
        }
        .blob-top {
            width: 420px;
            height: 420px;
            background: linear-gradient(135deg, rgba(255,255,255,0.8), rgba(255,255,255,0.2));
            top: -150px;
            right: -100px;
            animation: blobMove 10s ease-in-out infinite;
        }

        @keyframes blobMove {
            0%, 100% { transform: rotate(0deg) scale(1); border-radius: 42% 58% 63% 37% / 45% 40% 60% 55%; }
            50% { transform: rotate(10deg) scale(1.05); border-radius: 58% 42% 37% 63% / 50% 60% 40% 50%; }
        }

        /* =========================
           CONTENT AREA
        ========================== */
        .content {
            flex: 1;
            overflow-y: auto; 
            scrollbar-width: none; 
            padding: 70px 20px 120px; 
            position: relative;
            z-index: 10;
        }

        .content::-webkit-scrollbar { display: none; }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #16324f;
            margin-bottom: 20px;
            padding-left: 5px;
        }

        /* =========================
           BOOKING CARDS - Glassmorphism
        ========================== */
        .booking-card {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 24px;
            overflow: hidden;
            margin-bottom: 18px;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            transition: .3s ease;
        }

        .booking-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
        }

        .booking-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .booking-detail {
            padding: 18px;
        }

        .villa-type {
            font-size: 11px;
            font-weight: 700;
            color: #7DA0C4;
            text-transform: uppercase;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .villa-name {
            font-size: 18px;
            font-weight: 600;
            color: #16324f;
            margin-bottom: 8px;
        }

        .villa-location {
            font-size: 12px;
            color: rgba(22,50,79,0.8);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.6);
            margin-bottom: 12px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 12px;
            color: #16324f;
            font-weight: 500;
        }

        .summary-value {
            font-weight: 600;
            color: #16324f;
        }

        .card-actions {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.6);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 12px;
            background: rgba(147, 198, 249, 0.3);
            color: #16324f;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .cancel-btn {
            background: transparent;
            border: 1px solid rgba(230, 57, 70, 0.5);
            color: #e63946;
            padding: 6px 14px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .cancel-btn:hover {
            background: rgba(230, 57, 70, 0.1);
        }

        /* =========================
           EMPTY STATE
        ========================== */
        .empty-state {
            margin-top: 80px;
            text-align: center;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(16px);
            padding: 40px 20px;
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 10px 30px rgba(120, 170, 220, 0.1);
        }

        .empty-icon {
            font-size: 50px;
            margin-bottom: 16px;
        }

        .empty-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #16324f;
        }

        .empty-desc {
            font-size: 13px;
            color: rgba(22,50,79,0.7);
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .explore-btn {
            background: #16324f;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(22,50,79,0.2);
        }

        /* =========================
           FLOATING GLASS NAVBAR
        ========================== */
        .nav-bar {
            position: absolute;
            bottom: 24px;
            left: 24px;
            right: 24px;
            height: 74px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 100;
        }
        
        a { text-decoration: none; color: inherit; }
        
        .nav-item {
            color: #7DA0C4;
            transition: .3s;
            padding: 10px 14px;
            border-radius: 18px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-size: 10px;
        }

        .nav-item.active {
            color: #16324f;
            font-weight: 600;
            transform: translateY(-2px);
            background: rgba(147, 198, 249, 0.2);
        }

        .nav-icon { font-size: 20px; }

    </style>
</head>
<body>

<div class="phone-frame">
    <div class="phone-notch"></div>
    <div class="blob blob-top"></div>

    <div class="content">
        <h1 class="page-title">Pesanan Saya</h1>
        <div id="booking-container"></div>
    </div>

    <nav class="nav-bar">
        <div class="nav-item">
            <a href="home.php" style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                <span class="nav-icon">🏠</span>
                <span>Awal</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="explore.php" style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                <span class="nav-icon">🔍</span>
                <span>Explore</span>
            </a>
        </div>
        <div class="nav-item active">
            <span class="nav-icon">📅</span>
            <span>Pesanan</span>
        </div>
        <div class="nav-item">
            <a href="profile.php" style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                <span class="nav-icon">👤</span>
                <span>Profil</span>
            </a>
        </div>
    </nav>
</div>

<script>
async function loadBookings() {
    try {
        const response = await fetch('bookings.json');
        
        // Cek kalau fetch gagal (misal file gak ada)
        if (!response.ok) throw new Error('File tidak ditemukan');
        
        const bookings = await response.json();
        const container = document.getElementById('booking-container');

        if (bookings.length === 0) {
            showEmptyState(container);
            return;
        }

        bookings.reverse().forEach(booking => {
            const formattedTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(booking.total);

            container.innerHTML += `
                <div class="booking-card">
                    <img src="${booking.imageUrl}" class="booking-image" alt="Villa Image">
                    
                    <div class="booking-detail">
                        <p class="villa-type">📍 Berhasil Dipesan</p>
                        <h2 class="villa-name">${booking.villaName}</h2>
                        <p class="villa-location">📅 ${booking.checkin} → ${booking.checkout}</p>
                        
                        <div class="divider"></div>

                        <div class="summary-row">
                            <span>Total Tamu</span>
                            <span class="summary-value">${booking.guest}</span>
                        </div>
                        <div class="summary-row">
                            <span>Metode Bayar</span>
                            <span class="summary-value">${booking.paymentMethod}</span>
                        </div>
                        <div class="summary-row">
                            <span>Total Tagihan</span>
                            <span class="summary-value">${formattedTotal}</span>
                        </div>

                        <div class="card-actions">
                            <div class="status-badge">✓ Lunas</div>
                            <button class="cancel-btn" onclick="alert('Fitur pembatalan sedang diproses.')">Batalkan</button>
                        </div>
                    </div>
                </div>
            `;
        });
    } catch (error) {
        // Tampilkan empty state kalau json belum dibuat/error
        const container = document.getElementById('booking-container');
        showEmptyState(container);
    }
}

function showEmptyState(container) {
    container.innerHTML = `
        <div class="empty-state">
            <div class="empty-icon">🧳</div>
            <div class="empty-title">Belum Ada Pesanan</div>
            <div class="empty-desc">Yuk mulai booking penginapan impianmu dan buat momen liburan tak terlupakan! ✨</div>
            <a href="explore.php" class="explore-btn">Cari Penginapan</a>
        </div>
    `;
}

loadBookings();
</script>

</body>
</html>