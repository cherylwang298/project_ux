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

        .card-details { padding: 16px; }
        .property-type { font-size: 11px; text-transform: uppercase; font-weight: 700; color: #008170; margin-bottom: 4px; letter-spacing: 0.5px; }
        .property-name { font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .property-location { font-size: 12px; color: #64748b; display: flex; align-items: center; gap: 4px; margin-bottom: 12px; }
        .card-footer { display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px solid #f1f5f9; padding-top: 12px; }
        .facilities-summary { display: flex; gap: 8px; font-size: 11px; color: #64748b; }
        .price-box { text-align: right; }
        .final-price { font-size: 16px; font-weight: 700; color: #008170; }
        .tax-inclusive { font-size: 9px; color: #94a3b8; margin-top: 2px; }

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

        /* ========================================== */
        /* COMPONENT: ADVANCED FILTER BOTTOM SHEET */
        /* ========================================== */
        .modal-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.6); /* Backdrop buram */
            z-index: 200;
            display: none;
        }

        .filter-drawer {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            background: white;
            border-radius: 24px 24px 0 0;
            z-index: 201;
            padding: 24px 20px 30px;
            transform: translateY(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            max-height: 75%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 -10px 25px -5px rgba(0,0,0,0.1);
        }

        /* State trigger via Class JavaScript */
        .phone-frame.modal-open .modal-overlay { display: block; }
        .phone-frame.modal-open .filter-drawer { transform: translateY(0); }

        .drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .drawer-title { font-size: 16px; font-weight: 700; color: #1e293b; }
        .close-drawer { font-size: 20px; color: #94a3b8; cursor: pointer; border: none; background: transparent; }

        .drawer-body {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            scrollbar-width: none;
        }
        .drawer-body::-webkit-scrollbar { display: none; }

        .filter-group { margin-bottom: 20px; }
        .group-label { font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 10px; }
        
        /* Styled Input Elements */
        .custom-select, .custom-input {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            font-size: 13px;
            color: #334155;
            outline: none;
            background: #f8fafc;
        }

        .checkbox-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        /* Checkbox disamarkan jadi pills visual yang clean agar tidak padat */
        .facility-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 12px;
            color: #475569;
            cursor: pointer;
            background: #f8fafc;
        }
        .facility-option input { cursor: pointer; }

        .drawer-footer {
            display: flex;
            gap: 12px;
        }
        .btn-reset {
            flex: 1;
            padding: 14px;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: white;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
        }
        .btn-apply {
            flex: 2;
            padding: 14px;
            border-radius: 14px;
            border: none;
            background: #008170;
            font-size: 13px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 129, 112, 0.2);
        }
    </style>
</head>
<body>

    <div class="phone-frame" id="app-frame">
        <div class="phone-notch"></div> 
        
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

        <!-- /* PANEL LAUNCHER: MODAL BOTTOM DRAWER */ -->
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
                        <label class="facility-option">
                            <input type="checkbox" name="facility" value="🏊‍♂️ Pool"> 🏊‍♂️ Pool
                        </label>
                        <label class="facility-option">
                            <input type="checkbox" name="facility" value="🌅 Balcony"> 🌅 Balcony
                        </label>
                        <label class="facility-option">
                            <input type="checkbox" name="facility" value="📶 Wifi"> 📶 Wifi
                        </label>
                        <label class="facility-option">
                            <input type="checkbox" name="facility" value="🌳 Garden"> 🌳 Garden
                        </label>
                    </div>
                </div>
            </div>

            <div class="drawer-footer">
                <button class="btn-reset" onclick="resetAdvancedFilter()">Reset</button>
                <button class="btn-apply" onclick="applyAdvancedFilter()">Terapkan Filter</button>
            </div>
        </div>

        <nav class="nav-bar">
            <div class="nav-item">🏠<br>Awal</div>
            <div class="nav-item active">🔍<br>Explore</div>
            <div class="nav-item">📅<br>Pesanan</div>
            <div class="nav-item">👤<br>Profil</div>
        </nav>
    </div>

    <script src="db.js"></script>

    <script>
        const frame = document.getElementById('app-frame');
        
        // --- LOGIKA MENGATUR VISIBILITAS DRAWER MODAL ---
        document.getElementById('open-filter-btn').addEventListener('click', () => frame.classList.add('modal-open'));
        document.getElementById('close-filter-btn').addEventListener('click', () => frame.classList.remove('modal-open'));
        document.getElementById('modal-backdrop').addEventListener('click', () => frame.classList.remove('modal-open'));

        // --- RENDER COMPONENT UTAMA VILLA ---
        function renderVillas(villas) {
            const container = document.getElementById('villa-container');
            const totalText = document.getElementById('total-results');
            totalText.innerText = `Found ${villas.length} properties`;
            container.innerHTML = "";
            
            if (villas.length === 0) {
                container.innerHTML = `<p style="text-align:center; color:#94a3b8; margin-top:40px; font-size:13px;">Villa tidak ditemukan. Coba ganti pengaturan filter.</p>`;
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
            
            // Ambil seluruh check-list fasilitas
            const checkedBoxes = document.querySelectorAll('input[name="facility"]:checked');
            const selectedFacilities = Array.from(checkedBoxes).map(cb => cb.value);

            // Penyaringan Array data utama db.js
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
            frame.classList.remove('modal-open'); // Tutup drawer otomatis setelah diterapkan
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

        // kombinasi dengan quick filter
        if (budgetActive) {
            result = result.filter(v => v.pricePerNight < 1000000);
        }

        if (poolActive) {
            result = result.filter(v => v.facilities.includes("🏊‍♂️ Pool"));
        }

        // live search
        result = result.filter(villa =>
            villa.name.toLowerCase().includes(keyword) ||
            villa.city.toLowerCase().includes(keyword) ||
            villa.locationDetail.toLowerCase().includes(keyword)
        );

        renderVillas(result);
    });


        // Jalankan render awal saat document selesai dimuat
        window.onload = () => renderVillas(villaDatabase);
    </script>
</body>
</html>