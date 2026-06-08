<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staycation App - Explore</title>
    
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <style>
        *, *::before, *::after { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }

        :root {
            --blue-900: #0c2461;
            --blue-500: #2563EB;
            --blue-400: #3B82F6;
            --muted: #64748b;
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-blur: blur(20px);
            --glass-border: rgba(255, 255, 255, 0.5);
        }

        body {
            background: #b8cfe8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden; 
            padding: 24px 16px;
            font-family: 'DM Sans', sans-serif;
        }

        /* ── PHONE FRAME ── */
        .phone-frame {
            width: 375px;
            height: 812px;
            border-radius: 44px;
            border: 9px solid #18181b;
            position: relative;
            background: #f0f4f8;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 40px 80px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.12);
        }

        .phone-notch {
            position: absolute;
            top: 8px; left: 50%;
            transform: translateX(-50%);
            width: 100px; height: 26px;
            background: #18181b;
            border-radius: 14px;
            z-index: 600;
        }

        /* ── STATUS BAR ── */
        .statusbar {
            position: absolute;
            top: 0; left: 0; right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 42px 24px 0;
            font-size: 11px;
            font-weight: 600;
            color: var(--blue-900);
            letter-spacing: .3px;
            z-index: 500;
            pointer-events: none;
        }
        .statusbar .icons { display: flex; gap: 5px; align-items: center; }
        .statusbar .icons svg { width: 14px; height: 14px; fill: var(--blue-900); }

        /* ── REAL MAP CONTAINER ── */
        .map-canvas-container {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .leaflet-control-attribution { display: none !important; }
        .leaflet-control-zoom { display: none !important; }

        /* ── FIX PIN MAPS BULAT PERFECT ── */
        .custom-marker-icon {
            background: transparent;
            border: none;
        }
        .map-marker-holder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 62px;
        }
        .map-marker-bubble {
            width: 50px !important;
            height: 50px !important;
            max-width: 50px;
            max-height: 50px;
            background: white;
            border-radius: 50% !important;
            padding: 3px;
            box-shadow: 0 6px 16px rgba(12,36,97,0.22);
            border: 1px solid rgba(0,0,0,0.05);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .map-marker-bubble img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            border-radius: 50% !important;
            display: block;
        }
        .map-marker-arrow {
            width: 0; height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 8px solid white;
            margin-top: -1px;
            filter: drop-shadow(0 2px 2px rgba(12,36,97,0.15));
            flex-shrink: 0;
        }

        /* ── TOP UI CONTROLLER ── */
        .floating-top-ui {
            position: absolute;
            top: 82px; left: 20px; right: 20px;
            z-index: 100;
            pointer-events: none;
        }
        .floating-top-ui * { pointer-events: auto; }
        
        .discover-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px; font-weight: 700;
            color: var(--blue-900); margin-bottom: 16px;
            text-shadow: 0 2px 10px rgba(255,255,255,0.5);
        }

        .search-bar-wrap {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 20px;
            padding: 0 8px 0 16px;
            height: 52px;
            box-shadow: 0 8px 24px rgba(12,36,97,0.08);
        }
        .search-icon { width: 16px; height: 16px; fill: none; stroke: #a0aec0; stroke-width: 2.5; margin-right: 10px; }
        .search-input {
            flex: 1; border: none; outline: none;
            font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--blue-900);
        }
        .search-input::placeholder { color: #babcbe; }
        
        .filter-trigger-btn {
            width: 36px; height: 36px;
            background: #4a86f7; border: none; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
        }
        .filter-trigger-btn svg { width: 16px; height: 16px; fill: white; }

        /* QUICK CHIPS ROW */
        .quick-chips-row {
            display: flex; gap: 8px; margin-top: 16px;
            overflow-x: auto; scrollbar-width: none;
        }
        .quick-chips-row::-webkit-scrollbar { display: none; }
        .q-chip {
            white-space: nowrap; padding: 8px 18px;
            border-radius: 999px; font-size: 11px; font-weight: 600;
            cursor: pointer; background: white; color: #64748b;
            box-shadow: 0 4px 10px rgba(12,36,97,0.04);
            border: 1px solid rgba(255,255,255,0.8);
            transition: all 0.2s;
        }
        .q-chip.active { background: #4a86f7; color: white; border-color: transparent; box-shadow: 0 4px 12px rgba(74,134,247,0.25); }

        /* ── BOTTOM UI CONTROLLER ── */
        .floating-bottom-ui {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding-bottom: 104px; 
            z-index: 100;
            display: flex; flex-direction: column; gap: 16px;
            pointer-events: none; 
        }

        .featured-scroll {
            display: flex; gap: 14px; padding: 0 20px;
            overflow-x: auto; scrollbar-width: none;
            scroll-snap-type: x mandatory;
            pointer-events: auto; 
        }
        .featured-scroll::-webkit-scrollbar { display: none; }

        .explore-card {
            min-width: 210px; max-width: 210px;
            background: white; border-radius: 24px;
            overflow: hidden; flex-shrink: 0;
            box-shadow: 0 10px 26px rgba(12,36,97,0.08);
            scroll-snap-align: start;
            cursor: pointer;
            border: 1px solid rgba(0,0,0,0.02);
        }
        .card-img-container { position: relative; width: 100%; height: 115px; }
        .card-img-container img { width: 100%; height: 100%; object-fit: cover; }
        .card-badge-rating {
            position: absolute; top: 10px; right: 10px;
            background: rgba(255,255,255,0.95); padding: 3px 8px;
            border-radius: 8px; font-size: 9px; font-weight: 700;
            color: var(--blue-900); display: flex; align-items: center; gap: 2px;
        }

        .card-info { padding: 12px 14px 14px; }
        .card-title { font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--blue-900); margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .card-loc { font-size: 10px; color: var(--muted); display: flex; align-items: center; gap: 2px; margin-bottom: 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .card-loc svg { width: 9px; height: 9px; fill: var(--blue-500); flex-shrink: 0; }
        
        .card-price-row { display: flex; align-items: baseline; gap: 2px; }
        .card-price { font-size: 14px; font-weight: 700; color: #4a86f7; }

        /* FAB RE-CENTER LOCATION BUTTON */
        .fab-center-location {
            width: 46px; height: 46px;
            background: #4a86f7; border: none; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto; cursor: pointer; pointer-events: auto;
            box-shadow: 0 6px 16px rgba(74,134,247,0.35);
        }
        .fab-center-location svg { width: 18px; height: 18px; fill: white; }

        /* ── CLASS NAVIGATION BAR ── */
        .nav-bar {
            position: absolute;
            bottom: 20px; left: 20px; right: 20px;
            height: 68px; border-radius: 28px;
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            box-shadow: 0 10px 32px rgba(12,36,97,0.06);
            display: flex; justify-content: space-around; align-items: center;
            z-index: 200;
        }
        .nav-item { display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 10px 12px; flex: 1; text-decoration: none;}
        .nav-item svg { width: 20px; height: 20px; fill: none; stroke: #a0aec0; stroke-width: 2; }
        .nav-item span { font-size: 9px; font-weight: 600; color: #a0aec0; }
        .nav-item.active svg { stroke: #4a86f7; }
        .nav-item.active span { color: #4a86f7; font-weight: 700; }

        /* ── BOTTOM DRAWER FILTER SYSTEM ── */
        .modal-overlay {
            position: absolute;
            inset: 0; background: rgba(12, 36, 97, 0.3);
            backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
            z-index: 400; display: none; opacity: 0; transition: opacity 0.3s;
        }
        .filter-drawer {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            background: linear-gradient(180deg, rgba(255,255,255,.98) 0%, #F8FBFF 100%);
            border-radius: 32px 32px 0 0;
            z-index: 450; padding: 16px 18px 30px;
            transform: translateY(100%);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            max-height: 80%; display: flex; flex-direction: column;
            box-shadow: 0 -18px 44px rgba(0,0,0,.16);
            border-top: 1px solid rgba(37,99,235,.14);
        }
        .drawer-handle {
            width: 48px; height: 5px;
            margin: 8px auto 10px; border-radius: 999px;
            background: rgba(12,36,97,.18);
        }
        .phone-frame.modal-open .modal-overlay { display: block; opacity: 1; }
        .phone-frame.modal-open .filter-drawer { transform: translateY(0); }

        .drawer-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; gap: 12px; }
        .drawer-title { font-family: 'DM Sans', sans-serif; font-size: 18px; font-weight: 700; color: var(--blue-900); }
        .close-drawer { width: 34px; height: 34px; background: rgba(12,36,97,0.08); border: none; border-radius: 12px; cursor: pointer; color: var(--blue-900); font-weight: bold; display: flex; align-items: center; justify-content: center; }
        
        .drawer-body { flex: 1; overflow-y: auto; margin-bottom: 18px; scrollbar-width: none; }
        .drawer-body::-webkit-scrollbar { display: none; }
        .drawer-subtitle { font-size: 11px; color: rgba(12,36,97,.64); margin-bottom: 14px; line-height: 1.5; }
        
        .filter-group { margin-bottom: 16px; }
        .group-label { font-size: 12px; font-weight: 700; color: var(--blue-900); margin-bottom: 8px; }
        .custom-select, .custom-input {
            width: 100%; padding: 12px; border-radius: 12px;
            border: 1px solid rgba(12,36,97,.1); font-size: 12px; color: var(--blue-900);
            background: white; outline: none; font-family: 'DM Sans', sans-serif;
        }

        .checkbox-container { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .facility-option {
            display: flex; align-items: center; gap: 6px; padding: 10px;
            border: 1px solid rgba(12,36,97,.08); border-radius: 10px;
            font-size: 11px; color: var(--blue-900); background: white; cursor: pointer;
        }

        .drawer-footer { display: flex; gap: 10px; }
        .btn-reset { flex: 1; padding: 12px; border-radius: 12px; border: 1px solid #cbd5e1; background: white; font-size: 12px; font-weight: 600; color: #64748b; cursor: pointer; }
        .btn-apply { flex: 1; padding: 12px; border-radius: 12px; border: none; background: #4a86f7; font-size: 12px; font-weight: 600; color: white; cursor: pointer; box-shadow: 0 4px 12px rgba(74,134,247,0.25); }
    </style>
</head>
<body>

    <div class="phone-frame" id="app-frame">
        <div class="phone-notch"></div> 

        <div class="statusbar">
            <span>9:41</span>
            <div class="icons">
                <svg viewBox="0 0 24 24"><rect x="2" y="14" width="3" height="6" rx="1"/><rect x="7" y="10" width="3" height="10" rx="1"/><rect x="12" y="6" width="3" height="14" rx="1"/><rect x="17" y="2" width="3" height="18" rx="1" opacity=".35"/></svg>
                <svg viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0M8.53 16.11a6 6 0 016.95 0M12 20h.01" stroke="#0c2461" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
                <svg viewBox="0 0 24 24"><rect x="2" y="7" width="18" height="10" rx="2" stroke="#0c2461" stroke-width="1.5" fill="none"/><rect x="3" y="8" width="13" height="8" rx="1" fill="#0c2461"/><path d="M20 10v4" stroke="#0c2461" stroke-width="1.5" stroke-linecap="round"/></svg>
            </div>
        </div>

        <div class="map-canvas-container" id="realLiveMap"></div>

        <div class="floating-top-ui">
            <h2 class="discover-title">Discover</h2>
            <div class="search-bar-wrap">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" class="search-input" id="search-keyword" placeholder="Search accommodation or city...">
                <button class="filter-trigger-btn" onclick="openFilter()" aria-label="Open Filter">
                    <svg viewBox="0 0 24 24"><path d="M3 6h18M6 12h12M9 18h6" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
                </button>
            </div>

            <div class="quick-chips-row">
                <div class="q-chip active" id="chip-all" onclick="filterCityQuick('')">Semua</div>
                <div class="q-chip" id="chip-ubud" onclick="filterCityQuick('Ubud')">Ubud</div>
                <div class="q-chip" id="chip-kuta" onclick="filterCityQuick('Kuta')">Kuta</div>
                <div class="q-chip" id="chip-batu" onclick="filterCityQuick('Batu')">Batu</div>
                <div class="q-chip" id="chip-surabaya" onclick="filterCityQuick('Surabaya')">Surabaya</div>
            </div>
        </div>

        <div class="floating-bottom-ui">
            <button class="fab-center-location" id="fabLocationCenter" onclick="recenterMap()" aria-label="Center Location">
                <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
            </button>

            <div class="featured-scroll" id="villa-horizontal-slider"></div>
        </div>

        <nav class="nav-bar">
            <a href="home.php" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1V9.5z"/><path d="M9 21V12h6v9"/></svg>
                <span>Home</span>
            </a>
            <div class="nav-item active">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <span>Explore</span>
            </div>
            <a href="flight.php" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M2 12l19-6-3 6 3 6-19-6z"/><path d="M12 6v12"/></svg>
                <span>Flight</span>
            </a>
            <a href="pesanan.php" class="nav-item">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                <span>Pesanan</span>
            </a>
            <a href="profile.php" class="nav-item">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span>Profile</span>
            </a>
        </nav>

        <div class="modal-overlay" id="modal-backdrop"></div>
        <div class="filter-drawer" id="filterDrawer">
            <div class="drawer-handle"></div>
            <div class="drawer-header">
                <div>
                    <h3 class="drawer-title">Filter Pencarian</h3>
                    <p class="drawer-subtitle">Temukan hotel, villa, atau apartemen yang paling pas sesuai budget.</p>
                </div>
                <button class="close-drawer" id="close-filter-btn">✕</button>
            </div>
            <div class="drawer-body">
                <div class="filter-group">
                    <p class="group-label">Destinasi / Kota</p>
                    <select class="custom-select" id="filter-city">
                        <option value="">Semua Kota</option>
                        <option value="Bali">Bali</option>
                        <option value="Batu">Batu</option>
                        <option value="Surabaya">Surabaya</option>
                    </select>
                </div>

                <div class="filter-group">
                    <p class="group-label">Budget Maksimal (Per Malam)</p>
                    <input type="number" class="custom-input" id="filter-budget" placeholder="Contoh: 1000000">
                </div>

                <div class="filter-group">
                    <p class="group-label">Fasilitas Utama</p>
                    <div class="checkbox-container">
<label class="facility-option"><input type="checkbox" name="facility" value="Wifi"> 
                            <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M5 12.55a11 11 0 0114.08 0" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"/><path d="M1.42 9a16 16 0 0121.16 0" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"/><path d="M8.53 16.11a6 6 0 016.95 0" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="20" r="0.5"/></svg>
                            WiFi</label>
                        <label class="facility-option"><input type="checkbox" name="facility" value="Pool"> 
                            <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M2 17c2 2 4 2 6 0s4-2 6 0 4 2 6 0" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"/><path d="M3 10c2-2 4-2 6 0s4 2 6 0 4-2 6 0" fill="none" stroke="#0c2461" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="6" r="1.5" fill="#0c2461"/></svg>
                            Pool</label>
                        <label class="facility-option"><input type="checkbox" name="facility" value="Garden"> 
                            <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M12 21s-7-4.6-7-11a5 5 0 0110 0c0-1.5 1.6-3 3-3 1.8 0 3 1.6 3 3 0 6.4-9 11-9 11z" fill="none" stroke="#0c2461" stroke-width="2" stroke-linejoin="round"/></svg>
                            Garden</label>
                        <label class="facility-option"><input type="checkbox" name="facility" value="Gym"> 
                            <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M3 10h3m12 0h3" stroke="#0c2461" stroke-width="2" stroke-linecap="round"/><path d="M6 7v10m12-10v10" stroke="#0c2461" stroke-width="2" stroke-linecap="round"/><path d="M8 9h8" stroke="#0c2461" stroke-width="2" stroke-linecap="round"/></svg>
                            Gym</label>
                    </div>
                </div>
            </div>

            <div class="drawer-footer">
                <button class="btn-reset" onclick="resetAdvancedFilter()">Reset</button>
                <button class="btn-apply" onclick="applyAdvancedFilter()">Terapkan Filter</button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script src="db.js"></script>

    <script>
        const frame = document.getElementById('app-frame');
        const searchInput = document.getElementById('search-keyword');
        const sliderContainer = document.getElementById('villa-horizontal-slider');

        let myLiveMap;
        let mapMarkersLayerGroup;
        let activeCityFilter = '';
        
        // Titik Koordinat Pusat Wilayah Utama
        const regionCenters = {
            'ubud': [-8.5069, 115.2625],
            'bali': [-8.4095, 115.1889],
            'batu': [-7.8712, 112.5268],
            'surabaya': [-7.2575, 112.7521],
            'default': [-8.4095, 115.1889] // Default Center ke Bali agar mencakup area luas
        };

        // --- INISIALISASI MAPS ENGINE (LEAFLET) ---
        function initMapEngine() {
            myLiveMap = L.map('realLiveMap', {
                zoomControl: false
            }).setView(regionCenters.default, 10); // Mulai zoom level sedikit menjauh agar terlihat sebarannya

            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 19
            }).addTo(myLiveMap);

            mapMarkersLayerGroup = L.layerGroup().addTo(myLiveMap);
        }

        // --- RE-CENTER MAP FUNCTION ---
        function recenterMap() {
            if (myLiveMap) {
                let targetCenter = regionCenters.default;
                if (activeCityFilter) {
                    targetCenter = regionCenters[activeCityFilter.toLowerCase()] || regionCenters.default;
                }
                myLiveMap.flyTo(targetCenter, activeCityFilter === 'Surabaya' || activeCityFilter === 'Batu' ? 12 : 11, { 
                    animate: true, 
                    duration: 1.2 
                });
            }
        }

        // --- OPEN/CLOSE FILTER DRAWER ---
        function openFilter() { frame.classList.add('modal-open'); }
        function closeModal() { frame.classList.remove('modal-open'); }
        document.getElementById('close-filter-btn').addEventListener('click', closeModal);
        document.getElementById('modal-backdrop').addEventListener('click', closeModal);

        // --- MASTER DATA ENGINE COMBINER ---
        function getFilteredVillas() {
            const keyword = searchInput.value.trim().toLowerCase();
            const selectedCity = document.getElementById('filter-city').value;
            const maxBudget = document.getElementById('filter-budget').value;
            const checkedBoxes = document.querySelectorAll('input[name="facility"]:checked');
            const selectedFacilities = Array.from(checkedBoxes).map(cb => cb.value);

            // Penggabungan data master aman jika salah satu database kosong/tidak terbaca
            let result = [];
            if (typeof hotelDatabase !== 'undefined') result = [...result, ...hotelDatabase];
            if (typeof villaDatabase !== 'undefined') result = [...result, ...villaDatabase];
            if (typeof apartmentDatabase !== 'undefined') result = [...result, ...apartmentDatabase];

            // 1. Filter Berdasarkan Quick Chips atau Dropdown Advanced Filter
            if (selectedCity) {
                result = result.filter(v => v.city.toLowerCase() === selectedCity.toLowerCase());
            } else if (activeCityFilter) {
                if (activeCityFilter === 'Ubud' || activeCityFilter === 'Kuta') {
                    // Ubud & Kuta disaring melalui kedekatan string detail lokasi karena di db masuk kota Bali
                    result = result.filter(v => v.locationDetail.toLowerCase().includes(activeCityFilter.toLowerCase()));
                } else {
                    result = result.filter(v => v.city.toLowerCase() === activeCityFilter.toLowerCase());
                }
            }

            // 2. Filter Berdasarkan Budget Maksimal
            if (maxBudget) {
                result = result.filter(v => v.pricePerNight <= parseInt(maxBudget, 10));
            }

            // 3. Filter Berdasarkan Kelengkapan Fasilitas Checklist
            if (selectedFacilities.length > 0) {
                result = result.filter(v => selectedFacilities.every(f => v.facilities.some(vf => vf.toLowerCase().includes(f.toLowerCase()))));
            }

            // 4. Filter Berdasarkan Kotak Pencarian Keyword Nama/Kota
            if (keyword) {
                result = result.filter(v =>
                    v.name.toLowerCase().includes(keyword) ||
                    v.city.toLowerCase().includes(keyword) ||
                    v.locationDetail.toLowerCase().includes(keyword)
                );
            }
            return result;
        }

        // --- MASTER RENDER PROCESS ---
        function render() {
            const properties = getFilteredVillas();
            renderHorizontalCards(properties);
            renderLiveMapPins(properties);
        }

        function renderHorizontalCards(properties) {
            if (properties.length === 0) {
                sliderContainer.innerHTML = `<div style="background:white; padding:12px 20px; border-radius:14px; font-size:11px; color:var(--blue-900); margin:0 auto; pointer-events:auto; text-align:center;">Properti tidak ditemukan</div>`;
                return;
            }

            sliderContainer.innerHTML = properties.map(item => {
                const priceInRb = Math.round(item.pricePerNight / 1000);
                return `
                    <div class="explore-card" onclick="openDetail('${item.id}')">
                        <div class="card-img-container">
                            <img src="${item.imageUrl}" alt="${item.name}">
                            <div class="card-badge-rating">⭐ ${item.rating || '4.5'}</div>
                        </div>
                        <div class="card-info">
                            <h4 class="card-title">${item.name}</h4>
                            <div class="card-loc">
                                <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                ${item.locationDetail || item.city}
                            </div>
                            <div class="card-price-row">
                                <div class="card-price">Rp ${priceInRb}rb</div>
                                <div class="card-price" style="font-size:10px; color:var(--muted); font-weight:400;">/ malam</div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function renderLiveMapPins(properties) {
            mapMarkersLayerGroup.clearLayers();
            if (properties.length === 0) return;

            // Koordinat Geospasial Mockup Real-World Berdasarkan Wilayah
            const baseCoordinates = {
                'batu': [-7.8712, 112.5268],
                'surabaya': [-7.2575, 112.7521],
                'bali': [-8.5069, 115.2625] // default ke Ubud agar pin terfokus rata
            };

            properties.forEach((item, index) => {
                // Gunakan koordinat dari db jika ada, jika tidak buat koordinat acak terstruktur di sekitar wilayah kota tersebut
                let base = baseCoordinates[item.city.toLowerCase()] || baseCoordinates['bali'];
                
                // Atur arah acak sedikit berbeda agar pin tidak menumpuk di satu titik pusat kota yang sama
                let lat = item.lat || (base[0] + (index * 0.0045) * (index % 2 === 0 ? 1 : -1));
                let lng = item.lng || (base[1] + (index * 0.0060) * (index % 3 === 0 ? 1 : -1));

                const markerHtml = `
                    <div class="map-marker-holder">
                        <div class="map-marker-bubble">
                            <img src="${item.imageUrl}" alt="${item.name}">
                        </div>
                        <div class="map-marker-arrow"></div>
                    </div>
                `;

                const customMarkerIcon = L.divIcon({
                    html: markerHtml,
                    className: 'custom-marker-icon',
                    iconSize: [50, 58],
                    iconAnchor: [25, 58]
                });

                const marker = L.marker([lat, lng], { icon: customMarkerIcon });
                marker.on('click', () => { openDetail(item.id); });
                mapMarkersLayerGroup.addLayer(marker);
            });

            // Geser posisi peta secara dinamis mengikuti sebaran sekelompok data baru yang ter-render
            if (properties.length > 0) {
                const firstItem = properties[0];
                let centerRegion = regionCenters[firstItem.city.toLowerCase()] || regionCenters.default;
                if (activeCityFilter === 'Ubud' || activeCityFilter === 'Kuta') centerRegion = regionCenters.ubud;
                
                myLiveMap.panTo(centerRegion);
            }
        }

        // --- QUICK FILTER CHIPS HANDLER ---
        function filterCityQuick(cityName) {
            activeCityFilter = cityName;
            document.querySelectorAll('.q-chip').forEach(chip => chip.classList.remove('active'));
            
            if (cityName === '') document.getElementById('chip-all').classList.add('active');
            if (cityName === 'Ubud') document.getElementById('chip-ubud').classList.add('active');
            if (cityName === 'Kuta') document.getElementById('chip-kuta').classList.add('active');
            if (cityName === 'Batu') document.getElementById('chip-batu').classList.add('active');
            if (cityName === 'Surabaya') document.getElementById('chip-surabaya').classList.add('active');
            
            // Samakan isi input filter dropdown jika quick chip ditekan
            document.getElementById('filter-city').value = cityName === 'Ubud' || cityName === 'Kuta' ? 'Bali' : cityName;
            
            render();
            recenterMap();
        }

        function applyAdvancedFilter() { 
            closeModal(); 
            render(); 
        }

        function resetAdvancedFilter() {
            document.getElementById('filter-city').value = "";
            document.getElementById('filter-budget').value = "";
            document.querySelectorAll('input[name="facility"]:checked').forEach(cb => cb.checked = false);
            activeCityFilter = '';
            filterCityQuick('');
        }

        function openDetail(id) { 
            window.location.href = `accom_detail.php?id=${id}`; 
        }

        searchInput.addEventListener('input', render);

        // --- INTI WINDOW LOAD CHECKER ---
        window.onload = () => {
            initMapEngine();
            // Cek ke-tiga tipe database agar sinkronisasi data master 100% aman ter-load
            if (typeof villaDatabase !== 'undefined' || typeof hotelDatabase !== 'undefined' || typeof apartmentDatabase !== 'undefined') { 
                render(); 
            }
        };
    </script>
</body>
</html>