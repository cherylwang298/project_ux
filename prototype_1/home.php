<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agoda Redesign - Seamless Gradient</title>
    
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
           PHONE FRAME (Smooth Gradient Blue to White)
        ========================== */
        .phone-frame {
            width: 375px; 
            height: 812px; 
            border-radius: 45px; 
            border: 10px solid #111; 
            position: relative;
            
            /* Gradient yang disesuaikan dengan gambar referensi */
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

        /* =========================
           ANIMATED BLOBS (Dibuat lebih subtle biar kayak awan/glow)
        ========================== */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(8px);
            opacity: 0.6; /* Diturunkan opacitynya biar teks lebih kebaca */
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
        .content-area {
            flex: 1;
            overflow-y: auto; 
            scrollbar-width: none; 
            padding-bottom: 120px; /* Ditambah dikit biar gak nabrak navbar bawah */
            position: relative;
            z-index: 10; 
        }
        .content-area::-webkit-scrollbar { display: none; }

        .header {
            padding: 0;
            margin-bottom: 18px;
            color: #16324f;
        }

        .header p {
            font-size: 14px;
            font-weight: 500;
            color: rgba(22,50,79,0.8);
            margin-bottom: 6px;
        }

        .search-bar {
            height: 52px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            display: flex;
            align-items: center;
            padding: 0 18px;
            gap: 10px;
            font-size: 13px;
            color: rgba(22,50,79,0.7);
            margin-bottom: 18px;
            border: 1px solid rgba(255,255,255,0.8);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .quick-search {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            margin-bottom: 18px;
            scrollbar-width: none;
        }

        .quick-search::-webkit-scrollbar {
            display: none;
        }

        .quick-chip {
            white-space: nowrap;

            padding: 10px 14px;

            border-radius: 999px;

            background: rgba(255,255,255,0.45);

            border: 1px solid rgba(255,255,255,0.7);

            backdrop-filter: blur(14px);

            font-size: 11px;
            font-weight: 500;

            color: #16324f;

            box-shadow:
                0 4px 12px rgba(0,0,0,.05);
        }

        /* =========================
           GLASS CARDS (Kategori)
        ========================== */
        .category-wrapper {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .cat-card {
            flex: 1;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 18px;
            padding: 14px 2px; /* Padding disesuaikan biar text ga kepotong */
            display: flex;
            flex-direction: column;
            align-items: center;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 8px 20px rgba(90,140,190,.12);
        }

        .cat-icon { font-size: 22px; margin-bottom: 6px; }
        
        .cat-card span {
            font-size: 11px;
            font-weight: 500;
            color: #16324f;
            text-align: center;
            width: 100%;
        }

        /* =========================
           HERO PANE (Glassmorphism Container)
        ========================== */
        .hero-pane {
            margin: 72px 20px 24px;
            padding: 22px;
            border-radius: 32px;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 10px 30px rgba(120, 170, 220, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        /* =========================
           CONTENT SHEET (Sekarang nyatu sama background!)
        ========================== */
        .content-sheet {
            position: relative;
            /* Semua background, box-shadow, dan border-radius dihapus biar nyatu */
            padding-top: 10px;
        }

        .section-title {
            padding: 0 24px 15px;
            font-size: 16px;
            font-weight: 600;
            color: #16324f;
        }

        .trust-banner {
            margin: 0 24px 24px;

            padding: 16px;

            border-radius: 24px;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.8),
                    rgba(255,255,255,.55)
                );

            backdrop-filter: blur(18px);

            display: flex;
            align-items: center;
            gap: 14px;

            border: 1px solid rgba(255,255,255,.7);

            box-shadow:
                0 10px 25px rgba(0,0,0,.05);
        }

        .trust-icon {
            width: 42px;
            height: 42px;

            border-radius: 50%;

            background: #DDF5E8;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;

            color: #249B61;
        }

        .trust-banner h4 {
            font-size: 14px;
            color: #16324f;
            margin-bottom: 2px;
        }

        .trust-banner p {
            font-size: 11px;
            color: rgba(22,50,79,.7);
        }

        .recommend-scroll {
            display: flex;
            gap: 16px;

            overflow-x: auto;

            padding: 0 24px 10px;

            scrollbar-width: none;
        }

        .recommend-scroll::-webkit-scrollbar {
            display: none;
        }

        .recommend-card {
            min-width: 220px;

            border-radius: 28px;

            overflow: hidden;

            background: white;

            box-shadow:
                0 12px 25px rgba(0,0,0,.08);
        }

        .recommend-card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }

        .recommend-info {
            padding: 14px;
        }

        .recommend-tag {
            display: inline-block;

            padding: 5px 10px;

            border-radius: 999px;

            background: #EAF4FF;

            color: #367CCF;

            font-size: 10px;
            font-weight: 600;

            margin-bottom: 10px;
        }

        .recommend-info h4 {
            font-size: 15px;
            color: #16324f;

            margin-bottom: 4px;
        }

        .recommend-info p {
            font-size: 11px;
            color: rgba(22,50,79,.7);

            margin-bottom: 10px;
        }

        .recommend-price {
            font-size: 16px;
            font-weight: 700;

            color: #367CCF;
        }

        .filter-row {
            display: flex;
            gap: 10px;

            padding: 0 24px 18px;

            overflow-x: auto;

            scrollbar-width: none;
        }

        .filter-row::-webkit-scrollbar {
            display: none;
        }

        .filter-btn {
            padding: 10px 14px;

            border-radius: 999px;

            background: rgba(255,255,255,.5);

            border: 1px solid rgba(255,255,255,.8);

            font-size: 11px;
            font-weight: 500;

            color: #16324f;

            white-space: nowrap;
        }

        .active-filter {
            background: #16324f;
            color: white;
        }
        
        /* =========================
           VILLA CARDS
        ========================== */
        .f-card {
            margin: 0 24px 18px;
            height: 220px;
            border-radius: 28px;
            overflow: hidden;
            background: white;
            box-shadow: 0 12px 30px rgba(0,0,0,.08);
            position: relative;
            transition: .3s ease;
        }
        
        .f-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 40px rgba(0,0,0,.12);
        }

        .f-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .f-info {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 18px;
            background: linear-gradient(to top, rgba(0,0,0,.75), rgba(0,0,0,.0));
            color: white;
        }

        .f-info h4 { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
        .f-info .location {
            font-size: 11px;
            color: rgba(255,255,255,0.85);
            margin-bottom: 8px;
        }
        
        .price-wrapper { display: flex; justify-content: space-between; align-items: flex-end; }
        .f-info .price { color: #AEE2FF; font-weight: 700; font-size: 16px; }
        .f-info .tax-info { font-size: 9px; color: rgba(255,255,255,0.7);}

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
            background: linear-gradient(
                90deg,
                #fefeffc6 0%,
                #eaf4ffcd 100%
            );
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 45px rgba(0,0,0,.22);
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 100;
        }

        a { text-decoration: none; color: black; opacity: .7;}
        .nav-item {
            color: rgba(255,255,255,.55);
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
            color: black;
            font-weight: 600;
            transform: translateY(-2px);
            padding: 10px 16px;
            background: linear-gradient( 180deg, rgba(255,255,255,.16), rgba(255,255,255,.08) ); box-shadow: 0 0 18px rgba(120,180,255,.35);
            text-shadow: 0 0 10px rgba(255,255,255,.35);
        }
        .nav-icon { font-size: 20px; }
    </style>
</head>
<body>

    <div class="phone-frame">
        <div class="phone-notch"></div>
        <div class="blob blob-top"></div>
        
        <div class="content-area">

            <div class="hero-pane">

                <header class="header">
                    <p>Halo, Jessica!</p>
                </header>

                <div class="search-bar">
                    🔍 Cari hotel atau destinasi
                </div>

                <div class="quick-search">
                    <div class="quick-chip">📍 Surabaya • Besok</div>
                    <div class="quick-chip">🔥 Promo Weekend</div>
                    <div class="quick-chip">💸 Termurah</div>
                </div>
    
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

            </div>

            <div class="content-sheet">
                <!-- <div class="trust-banner">
                    <div class="trust-icon">✔</div>

                    <div>
                        <h4>No Hidden Fees</h4>
                        <p>Harga yang ditampilkan sudah termasuk pajak.</p>
                    </div>
                </div> -->

                <div class="filter-row">
                    <div class="filter-btn active-filter">Termurah</div>
                    <div class="filter-btn">Terdekat</div>
                    <div class="filter-btn">Rating Tinggi</div>
                </div>

                <h3 class="section-title">Rekomendasi Untukmu</h3>

                <div class="recommend-scroll">

                    <div class="recommend-card">
                        <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=500">

                        <div class="recommend-info">
                            <span class="recommend-tag">Best Value</span>

                            <h4>Oakwood Hotel</h4>

                            <p>⭐ 4.8 • Dekat pusat kota</p>

                            <div class="recommend-price">
                                Rp 489.000
                            </div>
                        </div>
                    </div>

                    <div class="recommend-card">
                        <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=500">

                        <div class="recommend-info">
                            <span class="recommend-tag">Last Minute</span>

                            <h4>Skyline Suites</h4>

                            <p>⭐ 4.7 • Free breakfast</p>

                            <div class="recommend-price">
                                Rp 620.000
                            </div>
                        </div>
                    </div>

                </div>

                <h3 class="section-title">Aktivitas Terakhirmu</h3>
    
                <div class="f-card">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500" alt="Hotel">
                    <div class="f-info">
                        <h4>Wisma Wisata Wiratama</h4>
                        <p class="location">Batu, Jawa Timur</p>
                        <div class="price-wrapper">
                            <div>
                                <div class="price">Rp 272.129</div>
                                <p class="tax-info">Harga sudah termasuk pajak</p>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="f-card">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500" alt="Hotel">
                    <div class="f-info">
                        <h4>Rose Garden Hotel</h4>
                        <p class="location">Surabaya, Indonesia</p>
                        <div class="price-wrapper">
                            <div>
                                <div class="price">Rp 1.250.000</div>
                                <p class="tax-info">Harga sudah termasuk pajak</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <nav class="nav-bar">
            <div class="nav-item active">
                <span class="nav-icon">🏠</span>
                <span>Awal</span>
            </div>
            <div class="nav-item">
                <a href="explore.php" style="display: flex; flex-direction: column; align-items: center; gap: 6px;">
                    <span class="nav-icon">🔍</span>
                    <span>Explore</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="pesanan.php" style="display: flex; flex-direction: column; align-items: center; gap: 6px;">
                    <span class="nav-icon">📅</span>
                    <span>Pesanan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="" style="display: flex; flex-direction: column; align-items: center; gap: 6px;">
                    <span class="nav-icon">👤</span>
                    <span>Profil</span>
                </a>
            </div>
        </nav>
    </div>

</body>
</html>