<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agoda Redesign - Phone Frame</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Body sebagai background luar frame */
        body {
            background-color: #e2e8f0; /* Warna abu-abu lembut agar frame HP menonjol */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* FRAME HP (Simulasi Mockup) */
        .phone-frame {
            width: 375px; /* Lebar standar iPhone */
            height: 812px; /* Tinggi standar iPhone */
            background: white;
            border-radius: 40px; /* Sudut melengkung khas HP modern */
            border: 8px solid #2d3436; /* Frame fisik HP */
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden; /* Konten tidak keluar dari frame */
            display: flex;
            flex-direction: column;
        }

        /* Notch HP (Opsional untuk estetika) */
        .phone-notch {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 25px;
            background: #2d3436;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            z-index: 1000;
        }

        /* AREA KONTEN (Di dalam frame) */
        .content-area {
            flex: 1;
            overflow-y: auto; /* Bisa di-scroll di dalam HP */
            scrollbar-width: none; /* Sembunyikan scrollbar Firefox */
            padding-bottom: 80px; /* Ruang untuk nav bar */
        }
        .content-area::-webkit-scrollbar { display: none; }

        /* HEADER & MENU (Mengikuti desain sebelumnya tapi disesuaikan frame) */
        .header {
            padding: 40px 20px 50px;
            background: linear-gradient(135deg, #008170 0%, #005f52 100%);
            color: white;
            text-align: left;
        }

        .category-wrapper {
            display: flex;
            justify-content: space-around;
            margin-top: -25px;
            padding: 0 10px;
            gap: 8px;
        }

        .cat-card {
            flex: 1;
            background: white;
            padding: 12px 5px;
            border-radius: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border: 1px solid #eee;
        }

        .cat-icon { font-size: 20px; margin-bottom: 5px; }
        .cat-card span { font-size: 10px; font-weight: 600; color: #444; }

        .section-title { padding: 20px 20px 10px; font-size: 16px; }
        
        .f-card {
            margin: 0 20px 15px;
            height: 200px;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .f-card img { width: 100%; height: 100%; object-fit: cover; }
        
        .f-info {
            position: absolute;
            bottom: 0; width: 100%;
            padding: 15px;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
        }

        .price { color: #4ade80; font-weight: bold; font-size: 16px; }

        /* BOTTOM NAV (Melayang di dalam frame) */
        .nav-bar {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            width: 85%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .nav-item { text-align: center; font-size: 9px; color: #aaa; }
        .nav-item.active { color: #008170; font-weight: bold; }
    </style>
</head>
<body>

    <div class="phone-frame">
        <div class="phone-notch"></div> <div class="content-area">
            <header class="header">
                <p style="font-size: 12px; opacity: 0.8;">Halo, Laurensia!</p>
                <h2 style="font-size: 18px;">Cari Hotel di Surabaya ✨</h2>
            </header>

            <div class="category-wrapper">
                <div class="cat-card">
                    <div class="cat-icon">🏨</div>
                    <span>Hotel</span>
                </div>
                <div class="cat-card">
                    <div class="cat-icon">🏡</div>
                    <span>Villa</span>
                </div>
                <div class="cat-card">
                    <div class="cat-icon">🏢</div>
                    <span>Apart</span>
                </div>
                <div class="cat-card">
                    <div class="cat-icon">🎒</div>
                    <span>Hostel</span>
                </div>
            </div>

            <h3 class="section-title">Aktivitas Terakhirmu</h3>

            <div class="f-card">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500" alt="Hotel">
                <div class="f-info">
                    <h4 style="font-size: 14px;">Wisma Wisata Wiratama</h4>
                    <p style="font-size: 11px; opacity: 0.8;">Batu, Jawa Timur</p>
                    <div class="price">Rp 272.129</div>
                    <p style="font-size: 9px;">Harga sudah termasuk pajak</p>
                </div>
            </div>

            <div class="f-card">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500" alt="Hotel">
                <div class="f-info">
                    <h4 style="font-size: 14px;">Rose Garden Hotel</h4>
                    <p style="font-size: 11px; opacity: 0.8;">Surabaya, Indonesia</p>
                    <div class="price">Rp 1.250.000</div>
                    <p style="font-size: 9px;">Harga sudah termasuk pajak</p>
                </div>
            </div>
        </div>

        <nav class="nav-bar">
            <div class="nav-item active">🏠<br>Awal</div>
            <div class="nav-item">🔍<br>Explore</div>
            <div class="nav-item">📅<br>Pesanan</div>
            <div class="nav-item">👤<br>Profil</div>
        </nav>
    </div>

</body>
</html>