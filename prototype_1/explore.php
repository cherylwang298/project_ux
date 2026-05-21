<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agoda Redesign - Explore Page</title>
    
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
           ANIMATED BLOBS
        ========================== */
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
        .content-area {
            flex: 1;
            overflow-y: auto; 
            scrollbar-width: none; 
            padding-bottom: 120px; 
            position: relative;
            z-index: 10;
        }
        .content-area::-webkit-scrollbar { display: none; }

        /* SEARCH HEADER - Glassmorphism */
        .search-header {
            padding: 65px 20px 15px; /* Tambah padding atas biar ga nabrak notch */
            position: sticky;
            top: 0;
            z-index: 90;
            background: linear-gradient(to bottom, rgba(147, 198, 249, 0.9) 0%, rgba(147, 198, 249, 0.0) 100%);
        }

        .search-bar-container {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            padding: 12px 14px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.8);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .search-icon { margin-right: 10px; font-size: 16px; color: #16324f; }
        
        .search-input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            color: #16324f;
            width: 100%;
        }
        .search-input::placeholder { color: rgba(22,50,79,0.5); }

        /* SMART FILTER (Horizontal Scroll) */
        .filter-container {
            display: flex;
            gap: 10px;
            padding: 5px 20px 15px;
            overflow-x: auto;
            scrollbar-width: none;
            position: relative;
            z-index: 10;
        }
        .filter-container::-webkit-scrollbar { display: none; }

        .filter-pill {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            color: #16324f;
            white-space: nowrap;
            border: 1px solid rgba(255,255,255,0.8);
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(90,140,190,.08);
        }

        .filter-pill.active {
            background: rgba(147, 198, 249, 0.3);
            border-color: rgba(255,255,255,0.9);
            color: #16324f;
            font-weight: 600;
        }

        .filter-pill.more {
            background: rgba(255, 255, 255, 0.2);
            border: 1px dashed rgba(22,50,79,0.3);
        }

        /* SECTION TITLE & RESULT COUNT */
        .result-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px 15px;
            position: relative;
            z-index: 10;
        }

        .result-title { font-size: 16px; font-weight: 600; color: #16324f; }
        .result-count { font-size: 12px; font-weight: 500; color: rgba(22,50,79,0.7); }

        /* CLEAN EXPLORE CARDS - Glassmorphism */
        .explore-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            margin: 0 20px 18px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.9);
            transition: .3s ease;
            position: relative;
            z-index: 10;
        }
        .explore-card:hover { transform: translateY(-4px); box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08); }

        .card-image-wrapper { position: relative; height: 180px; width: 100%; }
        .card-image-wrapper img { width: 100%; height: 100%; object-fit: cover; }

        .rating-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(4px);
            padding: 6px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
            color: #16324f;
            display: flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .card-details { padding: 18px; }
        .property-type { font-size: 11px; font-weight: 600; color: #7DA0C4; margin-bottom: 4px; }
        .property-name { font-size: 16px; font-weight: 600; color: #16324f; margin-bottom: 4px; }
        .property-location { font-size: 12px; color: rgba(22,50,79,0.7); margin-bottom: 14px; }
        .card-footer { display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px solid rgba(255,255,255,0.6); padding-top: 14px; }
        
        .facilities-summary { display: flex; gap: 8px; font-size: 11px; color: rgba(22,50,79,0.7); }
        .facilities-summary span { background: rgba(255,255,255,0.5); padding: 4px 8px; border-radius: 8px; }
        
        .price-box { text-align: right; }
        .final-price { font-size: 16px; font-weight: 700; color: #AEE2FF; text-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        .tax-inclusive { font-size: 9px; color: rgba(22,50,79,0.6); margin-top: 2px; }

        /* =========================
           FLOATING GLASS NAVBAR (Matches Home)
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

        /* ========================================== */
        /* COMPONENT: ADVANCED FILTER BOTTOM SHEET */
        /* ========================================== */
        .modal-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(22, 50, 79, 0.4); 
            backdrop-filter: blur(4px);
            z-index: 200;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .filter-drawer {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 32px 32px 0 0;
            z-index: 201;
            padding: 24px 24px 40px;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-height: 80%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 -10px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.8);
        }

        .phone-frame.modal-open .modal-overlay { display: block; opacity: 1; }
        .phone-frame.modal-open .filter-drawer { transform: translateY(0); }

        .drawer-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .drawer-title { font-size: 18px; font-weight: 600; color: #16324f; }
        .close-drawer { font-size: 20px; color: #7DA0C4; cursor: pointer; border: none; background: transparent; }

        .drawer-body { flex: 1; overflow-y: auto; margin-bottom: 20px; scrollbar-width: none; }
        .drawer-body::-webkit-scrollbar { display: none; }

        .filter-group { margin-bottom: 24px; }
        .group-label { font-size: 13px; font-weight: 600; color: #16324f; margin-bottom: 12px; }
        
        .custom-select, .custom-input {
            width: 100%;
            padding: 14px;
            border-radius: 16px;
            border: 1px solid rgba(22,50,79,0.1);
            font-size: 13px;
            color: #16324f;
            outline: none;
            background: rgba(255,255,255,0.8);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }

        .checkbox-container { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .facility-option {
            display: flex; align-items: center; gap: 8px;
            padding: 12px; border: 1px solid rgba(22,50,79,0.1);
            border-radius: 14px; font-size: 12px; font-weight: 500;
            color: #16324f; cursor: pointer; background: rgba(255,255,255,0.8);
        }

        .drawer-footer { display: flex; gap: 12px; }
        .btn-reset {
            flex: 1; padding: 16px; border-radius: 18px;
            border: 1px solid rgba(22,50,79,0.2); background: white;
            font-size: 14px; font-weight: 600; color: #16324f; cursor: pointer;
        }
        .btn-apply {
            flex: 2; padding: 16px; border-radius: 18px; border: none;
            background: #16324f; font-size: 14px; font-weight: 600;
            color: white; cursor: pointer; box-shadow: 0 8px 20px rgba(22,50,79,0.2);
        }
    </style>
</head>
<body>

    <div class="phone-frame" id="app-frame">
        <div class="phone-notch"></div> 
        <div class="blob blob-top"></div>
        
        <div class="search-header">
            <div class="search-bar-container">
                <span class="search-icon">🔍</span>
                <input type="text" class="search-input" id="search-keyword" placeholder="Cari kota (Batu / Bali / Bandung)...">
            </div>
        </div>

        <div class="filter-container">
            <div class="filter-pill" id="pill-budget" onclick="quickFilterPrice()">💰 < Rp 1 Juta</div>
            <div class="filter-pill" id="pill-pool" onclick="quickFilterPool()">🏊‍♂️ Pool Only</div>
            <div class="filter-pill more" id="open-filter-btn">⚡ Filter Lainnya</div>
        </div>

        <div class="content-area">
            <div class="result-meta">
                <h3 class="result-title">Eksplorasi Villa</h3>
                <span class="result-count" id="total-results">Found 0 properties</span>
            </div>

            <div id="villa-container"></div>
        </div>

        <div class="modal-overlay" id="modal-backdrop"></div>
        <div class="filter-drawer">
            <div class="drawer-header">
                <h3 class="drawer-title">Filter Pencarian</h3>
                <button class="close-drawer" id="close-filter-btn">✕</button>
            </div>
            
            <div class="drawer-body">
                <div class="filter-group">
                    <p class="group-label">Destinasi / Lokasi</p>
                    <select class="custom-select" id="filter-city">
                        <option value="">Semua Kota</option>
                        <option value="Batu">Batu</option>
                        <option value="Bali">Bali</option>
                        <option value="Bandung">Bandung</option>
                    </select>
                </div>

                <div class="filter-group">
                    <p class="group-label">Budget Maksimal (Per Malam)</p>
                    <input type="number" class="custom-input" id="filter-budget" placeholder="Contoh: 1000000">
                </div>

                <div class="filter-group">
                    <p class="group-label">Fasilitas Unggulan</p>
                    <div class="checkbox-container">
                        <label class="facility-option"><input type="checkbox" name="facility" value="🏊‍♂️ Pool"> 🏊‍♂️ Pool</label>
                        <label class="facility-option"><input type="checkbox" name="facility" value="🌅 Balcony"> 🌅 Balcony</label>
                        <label class="facility-option"><input type="checkbox" name="facility" value="📶 Wifi"> 📶 Wifi</label>
                        <label class="facility-option"><input type="checkbox" name="facility" value="🌳 Garden"> 🌳 Garden</label>
                    </div>
                </div>
            </div>

            <div class="drawer-footer">
                <button class="btn-reset" onclick="resetAdvancedFilter()">Reset</button>
                <button class="btn-apply" onclick="applyAdvancedFilter()">Terapkan Filter</button>
            </div>
        </div>

        <nav class="nav-bar">
            <div class="nav-item">
                <a href="home.php" style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <span class="nav-icon">🏠</span>
                    <span>Awal</span>
                </a>
            </div>
            <div class="nav-item active">
                <span class="nav-icon">🔍</span>
                <span>Explore</span>
            </div>
            <div class="nav-item">
                <a href="pesanan.php" style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <span class="nav-icon">📅</span>
                    <span>Pesanan</span>
                </a>
            </div>
            <div class="nav-item">
                <span class="nav-icon">👤</span>
                <span>Profil</span>
            </div>
        </nav>
    </div>

    <script src="db.js"></script>

    <script>
        const frame = document.getElementById('app-frame');
        
        // --- LOGIKA MENGATUR VISIBILITAS DRAWER MODAL ---
        document.getElementById('open-filter-btn').addEventListener('click', () => {
            frame.classList.add('modal-open');
            // Sedikit trik agar transisi overlay lebih mulus
            setTimeout(() => document.getElementById('modal-backdrop').style.opacity = '1', 10);
        });
        
        const closeModal = () => {
            document.getElementById('modal-backdrop').style.opacity = '0';
            setTimeout(() => frame.classList.remove('modal-open'), 300); // Tunggu animasi selesai
        };

        document.getElementById('close-filter-btn').addEventListener('click', closeModal);
        document.getElementById('modal-backdrop').addEventListener('click', closeModal);

        // --- RENDER COMPONENT UTAMA VILLA ---
        function renderVillas(villas) {
            const container = document.getElementById('villa-container');
            const totalText = document.getElementById('total-results');
            totalText.innerText = `Found ${villas.length} properties`;
            container.innerHTML = "";
            
            if (villas.length === 0) {
                container.innerHTML = `<p style="text-align:center; color:#16324f; opacity:0.6; margin-top:40px; font-size:13px; font-weight:500;">Villa tidak ditemukan. Coba ganti pengaturan filter.</p>`;
                return;
            }

            villas.forEach(villa => {
                const facilitiesHtml = villa.facilities.map(f => `<span>${f}</span>`).join('');
                const formattedPrice = new Intl.NumberFormat('id-ID', {
                    style: 'currency', currency: 'IDR', maximumFractionDigits: 0
                }).format(villa.pricePerNight);

                container.innerHTML += `
                   <div class="explore-card" onclick="openDetail('${villa.id}')">
                        <div class="card-image-wrapper">
                            <img src="${villa.imageUrl}" alt="${villa.name}">
                            <div class="rating-badge">⭐ ${villa.rating}</div>
                        </div>
                        <div class="card-details">
                            <p class="property-type">${villa.type}</p>
                            <h4 class="property-name">${villa.name}</h4>
                            <p class="property-location">📍 ${villa.locationDetail}</p>
                            <div class="card-footer">
                                <div class="facilities-summary">${facilitiesHtml}</div>
                                <div class="price-box">
                                    <p class="final-price">${formattedPrice}</p>
                                    <p class="tax-inclusive">Harga sudah termasuk pajak</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        // --- LOGIKA PENGOPERASIAN FILTER LANJUTAN (Advanced) ---
        function applyAdvancedFilter() {
            const selectedCity = document.getElementById('filter-city').value;
            const maxBudget = document.getElementById('filter-budget').value;
            
            const checkedBoxes = document.querySelectorAll('input[name="facility"]:checked');
            const selectedFacilities = Array.from(checkedBoxes).map(cb => cb.value);

            const filteredData = villaDatabase.filter(villa => {
                if (selectedCity && villa.city !== selectedCity) return false;
                if (maxBudget && villa.pricePerNight > parseInt(maxBudget)) return false;
                if (selectedFacilities.length > 0) {
                    const matchAll = selectedFacilities.every(f => villa.facilities.includes(f));
                    if (!matchAll) return false;
                }
                return true;
            });

            renderVillas(filteredData);
            closeModal(); 
        }

        function resetAdvancedFilter() {
            document.getElementById('filter-city').value = "";
            document.getElementById('filter-budget').value = "";
            document.querySelectorAll('input[name="facility"]').forEach(cb => cb.checked = false);
            renderVillas(villaDatabase);
        }

        // --- LOGIKA QUICK FILTER (Pills Cepat Di Atas) ---
        let budgetActive = false;
        function quickFilterPrice() {
            budgetActive = !budgetActive;
            document.getElementById('pill-budget').classList.toggle('active', budgetActive);
            executeCombinedQuickFilters();
        }

        let poolActive = false;
        function quickFilterPool() {
            poolActive = !poolActive;
            document.getElementById('pill-pool').classList.toggle('active', poolActive);
            executeCombinedQuickFilters();
        }

        function executeCombinedQuickFilters() {
            let result = [...villaDatabase];
            if (budgetActive) result = result.filter(v => v.pricePerNight < 1000000);
            if (poolActive) result = result.filter(v => v.facilities.includes("🏊‍♂️ Pool"));
            renderVillas(result);
        }

        function openDetail(id) {
            window.location.href = `accom_detail.php?id=${id}`;
        }

        // --- LIVE SEARCH ---
        document.getElementById('search-keyword').addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            let result = [...villaDatabase];

            if (budgetActive) result = result.filter(v => v.pricePerNight < 1000000);
            if (poolActive) result = result.filter(v => v.facilities.includes("🏊‍♂️ Pool"));

            result = result.filter(villa =>
                villa.name.toLowerCase().includes(keyword) ||
                villa.city.toLowerCase().includes(keyword) ||
                villa.locationDetail.toLowerCase().includes(keyword)
            );

            renderVillas(result);
        });

        // Jalankan render awal
        window.onload = () => {
            // Biar gak error pas pertama load kalau file db.js belum ada datanya
            if(typeof villaDatabase !== 'undefined') {
                renderVillas(villaDatabase);
            }
        };
    </script>
</body>
</html>