<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agoda Redesign - Explore Page</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #e2e8f0; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* FRAME HP */
        .phone-frame {
            width: 375px; 
            height: 812px; 
            background: #f8fafc;
            border-radius: 40px; 
            border: 8px solid #2d3436; 
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden; 
            display: flex;
            flex-direction: column;
        }

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

        /* AREA KONTEN (Scrollable) */
        .content-area {
            flex: 1;
            overflow-y: auto; 
            scrollbar-width: none; 
            padding-bottom: 90px; 
        }
        .content-area::-webkit-scrollbar { display: none; }

        /* SEARCH HEADER */
        .search-header {
            padding: 45px 20px 15px;
            background: white;
            border-bottom: 1px solid #edf2f7;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .search-bar-container {
            display: flex;
            align-items: center;
            background: #f1f5f9;
            padding: 10px 14px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
        }

        .search-icon {
            margin-right: 10px;
            font-size: 16px;
            color: #64748b;
        }

        .search-input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
            color: #334155;
            width: 100%;
        }

        /* SMART FILTER (Horizontal Scroll) */
        .filter-container {
            display: flex;
            gap: 8px;
            padding: 12px 20px;
            background: white;
            overflow-x: auto;
            scrollbar-width: none;
            border-bottom: 1px solid #edf2f7;
        }
        .filter-container::-webkit-scrollbar { display: none; }

        .filter-pill {
            display: flex;
            align-items: center;
            gap: 4px;
            background: #f1f5f9;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            color: #475569;
            white-space: nowrap;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-pill.active {
            background: #e6f3f1;
            color: #008170;
            border-color: #008170;
        }

        .filter-pill.more {
            background: #ffffff;
            border: 1px dashed #cbd5e1;
        }

        /* SECTION TITLE & RESULT COUNT */
        .result-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px 10px;
        }

        .result-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
        }

        .result-count {
            font-size: 12px;
            color: #64748b;
        }

        /* CLEAN EXPLORE CARDS */
        .explore-card {
            background: white;
            margin: 0 20px 16px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
        }

        .card-image-wrapper {
            position: relative;
            height: 180px;
            width: 100%;
        }

        .card-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rating-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.95);
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 3px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card-details {
            padding: 16px;
        }

        .property-type {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            color: #008170;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .property-name {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .property-location {
            font-size: 12px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 12px;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-top: 1px solid #f1f5f9;
            padding-top: 12px;
        }

        .facilities-summary {
            font-size: 11px;
            color: #64748b;
            display: flex;
            gap: 8px;
        }

        .price-box {
            text-align: right;
        }

        .final-price {
            font-size: 16px;
            font-weight: 700;
            color: #008170;
        }

        .tax-inclusive {
            font-size: 9px;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* BOTTOM NAV */
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            z-index: 100;
        }
        
        .nav-item { text-align: center; font-size: 9px; color: #aaa; text-decoration: none; }
        .nav-item.active { color: #008170; font-weight: bold; }
    </style>
</head>
<body>

    <div class="phone-frame">
        <div class="phone-notch"></div> 
        
        <div class="search-header">
            <div class="search-bar-container">
                <span class="search-icon">🔍</span>
                <input type="text" class="search-input" value="Batu, Malang" placeholder="Cari lokasi atau nama villa...">
            </div>
        </div>

        <div class="filter-container">
            <div class="filter-pill active">💰 < Rp 1 Juta</div>
            <div class="filter-pill">👥 2 Tamu</div>
            <div class="filter-pill">🏊‍♂️ Kolam Renang</div>
            <div class="filter-pill">📍 Dekat Wisata</div>
            <div class="filter-pill more">⚡ Filter Lainnya</div>
        </div>

        <div class="content-area">
            <div class="result-meta">
                <h3 class="result-title">Villa Populer di Batu</h3>
                <span class="result-count">Found 24 properties</span>
            </div>

            <div class="explore-card">
                <div class="card-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=500" alt="Villa">
                    <div class="rating-badge">⭐ 4.8</div>
                </div>
                <div class="card-details">
                    <p class="property-type">Villa & Balcony</p>
                    <h4 class="property-name">Sky View Private Villa</h4>
                    <p class="property-location">📍 Oro-Oro Ombo, Batu (500m dari Jatim Park 2)</p>
                    
                    <div class="card-footer">
                        <div class="facilities-summary">
                            <span>🏊‍♂️ Pool</span>
                            <span>🌅 Balcony</span>
                            <span>📶 Wifi</span>
                        </div>
                        <div class="price-box">
                            <p class="final-price">Rp 850.000</p>
                            <p class="tax-inclusive">Harga sudah termasuk pajak</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="explore-card">
                <div class="card-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=500" alt="Villa">
                    <div class="rating-badge">⭐ 4.6</div>
                </div>
                <div class="card-details">
                    <p class="property-type">Villa Rumah</p>
                    <h4 class="property-name">Green Pine Family Homestay</h4>
                    <p class="property-location">📍 Songgokerto, Batu</p>
                    
                    <div class="card-footer">
                        <div class="facilities-summary">
                            <span>👪 Fam Room</span>
                            <span>🌳 Garden</span>
                            <span>📶 Wifi</span>
                        </div>
                        <div class="price-box">
                            <p class="final-price">Rp 620.000</p>
                            <p class="tax-inclusive">Harga sudah termasuk pajak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="nav-bar">
            <div class="nav-item">🏠<br>Awal</div>
            <div class="nav-item active">🔍<br>Explore</div>
            <div class="nav-item">📅<br>Pesanan</div>
            <div class="nav-item">👤<br>Profil</div>
        </nav>
    </div>

</body>
</html>