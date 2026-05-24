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

        /* ── SCROLLABLE REAL MAP CONTAINER ── */
        .map-canvas-container {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        /* Menghilangkan watermark teks bawaan leaflet biar clean */
        .leaflet-control-attribution { display: none !important; }
        .leaflet-control-zoom { display: none !important; }

        /* ── CUSTOM BALON PIN MAPS LEAFLET ── */
       /* ── FIX PIN MAPS AGAR BULAT SEMPURNA ── */
        .custom-marker-icon {
            background: transparent;
            border: none;
        }
        .map-marker-holder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 54px; /* Kunci lebar container utama pin */
            height: 62px; /* Kunci tinggi container utama pin */
        }
        .map-marker-bubble {
            width: 50px !important;  /* Paksa lebar mutlak 50px */
            height: 50px !important; /* Paksa tinggi mutlak 50px */
            max-width: 50px;
            max-height: 50px;
            background: white;
            border-radius: 50% !important; /* Paksa bulat sempurna */
            padding: 3px;
            box-shadow: 0 6px 16px rgba(12,36,97,0.22);
            border: 1px solid rgba(0,0,0,0.05);
            overflow: hidden; /* Potong gambar yang keluar dari lingkaran */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .map-marker-bubble img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important; /* Potong gambar secara proporsional di tengah lingkaran */
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
            flex-shrink: 0; /* Mencegah segitiga gepeng atau terdistorsi */
        }

        /* ── TOP UI CONTROLLER ── */
        .floating-top-ui {
            position: absolute;
            top: 82px; left: 20px; right: 20px;
            z-index: 100;
            pointer-events: none; /* Supaya klik di sela-sela element tembus ke map */
        }
        .floating-top-ui * { pointer-events: auto; } /* Aktifkan klik hanya untuk input/button */
        
        .discover-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px; font-weight: 700;
            color: var(--blue-900); margin-bottom: 16px;
            text-shadow: 0 2px 10px rgba(255,255,255,0.5); /* Supaya tetap terbaca jelas di atas map */
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
        .card-title { font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--blue-900); margin-bottom: 3px; }
        .card-loc { font-size: 10px; color: var(--muted); display: flex; align-items: center; gap: 2px; margin-bottom: 8px; }
        .card-loc svg { width: 9px; height: 9px; fill: var(--blue-500); }
        
        .card-price-row { display: flex; align-items: baseline; gap: 2px; }
        .card-price { font-size: 14px; font-weight: 700; color: #4a86f7; }
        .card-price span { font-size: 10px; font-weight: 400; color: var(--muted); }

        /* FAB RE-CENTER MAP LOCATION BUTTON */
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
            width: 48px;
            height: 5px;
            margin: 8px auto 10px;
            border-radius: 999px;
            background: rgba(12,36,97,.18);
        }
        .phone-frame.modal-open .modal-overlay { display: block; opacity: 1; }
        .phone-frame.modal-open .filter-drawer { transform: translateY(0); }

        .drawer-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; gap: 12px; }
        .drawer-title { font-family: 'DM Sans', sans-serif; font-size: 18px; font-weight: 700; color: var(--blue-900); }
        .close-drawer { width: 34px; height: 34px; background: rgba(12,36,97,0.08); border: none; border-radius: 12px; cursor: pointer; color: var(--blue-900); font-weight: bold; display: flex; align-items: center; justify-content: center; }
        .close-drawer:hover { background: rgba(12,36,97,0.14); }
        .drawer-body { flex: 1; overflow-y: auto; margin-bottom: 18px; scrollbar-width: none; }
        .drawer-body::-webkit-scrollbar { display: none; }

        .drawer-subtitle { font-size: 12px; color: rgba(12,36,97,.64); margin-bottom: 16px; line-height: 1.5; }
        .drawer-actions { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 18px; }
        .drawer-pill { padding: 10px 14px; border-radius: 999px; background: rgba(37,99,235,.08); color: #1D4ED8; font-size: 11px; font-weight: 700; border: 1px solid rgba(37,99,235,.14); }

        .card-action-row { display: flex; justify-content: space-between; gap: 10px; margin-bottom: 12px; }
        .wishlist-btn, .compare-btn {
            flex: 1;
            border: 1px solid rgba(12,36,97,.15);
            border-radius: 14px;
            background: rgba(255,255,255,.96);
            color: #0c2461;
            font-size: 11px;
            font-weight: 700;
            padding: 10px 0;
            cursor: pointer;
            transition: all .2s;
            min-width: 0;
        }
        .wishlist-btn.active, .compare-btn.active {
            border-color: #2563EB;
            background: rgba(37,99,235,.14);
            color: #1D4ED8;
        }
        .wishlist-btn:hover, .compare-btn:hover { transform: translateY(-1px); border-color: rgba(37,99,235,.25); }
        
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
                <input type="text" class="search-input" id="search-keyword" placeholder="Search villa or destination">
                <button class="filter-trigger-btn" onclick="openFilter()" aria-label="Open Filter">
                    <svg viewBox="0 0 24 24"><path d="M3 6h18M6 12h12M9 18h6" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
                </button>
            </div>

            <div class="quick-chips-row">
                <div class="q-chip active" id="chip-all" onclick="filterCityQuick('')">Semua</div>
                <div class="q-chip" id="chip-ubud" onclick="filterCityQuick('Ubud')">Ubud</div>
                <div class="q-chip" id="chip-kuta" onclick="filterCityQuick('Kuta')">Kuta</div>
                <div class="q-chip" id="chip-batu" onclick="filterCityQuick('Batu')">Batu</div>
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
        <div class="filter-drawer">
            <div class="drawer-handle"></div>
            <div class="drawer-header">
                <div>
                    <h3 class="drawer-title">Filter Pencarian</h3>
                    <p class="drawer-subtitle">Temukan villa yang paling pas, bandingkan pilihan, dan lanjut booking dengan mudah.</p>
                </div>
                <button class="close-drawer" id="close-filter-btn">✕</button>
            </div>
            <div class="drawer-actions">
                <span class="drawer-pill">Fokus</span>
                <span class="drawer-pill">Bandingkan</span>
                <span class="drawer-pill">Eksekusi</span>
            </div>
            <div class="drawer-body">
                <div class="filter-group">
                    <p class="group-label">Destinasi / Lokasi</p>
                    <select class="custom-select" id="filter-city">
                        <option value="">Semua Kota</option>
                        <option value="Ubud">Ubud</option>
                        <option value="Kuta">Kuta</option>
                        <option value="Batu">Batu</option>
                    </select>
                </div>

                <div class="filter-group">
                    <p class="group-label">Budget Maksimal (Per Malam)</p>
                    <input type="number" class="custom-input" id="filter-budget" placeholder="Contoh: 1000000">
                </div>

                <div class="filter-group">
                    <p class="group-label">Fasilitas Utama</p>
                    <div class="checkbox-container">
                        <label class="facility-option"><input type="checkbox" name="facility" value="WiFi"> 📶 WiFi</label>
                        <label class="facility-option"><input type="checkbox" name="facility" value="Pool"> mapped 🏊‍♂️ Pool</label>
                        <label class="facility-option"><input type="checkbox" name="facility" value="AC"> ❄️ AC</label>
                        <label class="facility-option"><input type="checkbox" name="facility" value="Resto"> 🍔 Resto</label>
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
        
        // Titik Koordinat Ubud, Bali sebagai Center Target Utama Properti
        const defaultMapCenter = [-8.5069, 115.2625]; 

        // --- INISIALISASI MAPS ENGINE (LEAFLET) ---
        function initMapEngine() {
            // Pasang canvas Leaflet ke elemen HTML kita
            myLiveMap = L.map('realLiveMap', {
                zoomControl: false // Sembunyikan tombol +/- bawaan browser desktop
            }).setView(defaultMapCenter, 14); // Set lokasi awal di Ubud dengan tingkat zoom 14

            // Gunakan skin map CartoDB Positron supaya warnanya minimalis, cerah, & estetik mirip mockup
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 19
            }).addTo(myLiveMap);

            // Buat grup layer khusus untuk wadah penampung pin dinamis
            mapMarkersLayerGroup = L.layerGroup().addTo(myLiveMap);
        }

        // --- RE-CENTER MAP FUNCTION ---
        function recenterMap() {
            if (myLiveMap) {
                myLiveMap.flyTo(defaultMapCenter, 14, { animate: true, duration: 1.5 });
            }
        }

        // --- OPEN/CLOSE FILTER DRAWER ---
        function openFilter() { frame.classList.add('modal-open'); }
        function closeModal() { frame.classList.remove('modal-open'); }
        document.getElementById('close-filter-btn').addEventListener('click', closeModal);
        document.getElementById('modal-backdrop').addEventListener('click', closeModal);

        // --- FILTER DATA ENGINE ---
        function getFilteredVillas() {
            const keyword = searchInput.value.trim().toLowerCase();
            const selectedCity = document.getElementById('filter-city').value || activeCityFilter;
            const maxBudget = document.getElementById('filter-budget').value;
            const checkedBoxes = document.querySelectorAll('input[name="facility"]:checked');
            const selectedFacilities = Array.from(checkedBoxes).map(cb => cb.value);

            let result = [...villaDatabase];

            if (selectedCity) result = result.filter(v => v.city === selectedCity);
            if (maxBudget) result = result.filter(v => v.pricePerNight <= parseInt(maxBudget, 10));
            if (selectedFacilities.length > 0) {
                result = result.filter(v => selectedFacilities.every(f => v.facilities.includes(f)));
            }
            if (keyword) {
                result = result.filter(v =>
                    v.name.toLowerCase().includes(keyword) ||
                    v.city.toLowerCase().includes(keyword)
                );
            }
            return result;
        }

        // --- MASTER RENDER PROCESS ---
        function render() {
            const villas = getFilteredVillas();
            renderHorizontalCards(villas);
            renderLiveMapPins(villas);
        }

        function renderHorizontalCards(villas) {
            if (villas.length === 0) {
                sliderContainer.innerHTML = `<div style="background:white; padding:12px 20px; border-radius:14px; font-size:11px; color:var(--blue-900); margin:0 auto; pointer-events:auto;">Properti tidak ditemukan</div>`;
                return;
            }

            sliderContainer.innerHTML = villas.map(villa => {
                const formattedPrice = villa.pricePerNight > 0 ? (villa.pricePerNight / 1000) + 'rb' : '-';
                return `
                    <div class="explore-card" onclick="openDetail('${villa.id}')">
                        <div class="card-img-container">
                            <img src="${villa.imageUrl}" alt="${villa.name}">
                            <div class="card-badge-rating">⭐ ${villa.rating || '4.5'}</div>
                        </div>
                        <div class="card-info">
                            <h4 class="card-title">${villa.name}</h4>
                            <div class="card-loc">
                                <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                ${villa.locationDetail || villa.city}
                            </div>
                            <div class="card-price-row">
                                <div class="card-price">Rp ${formattedPrice}</div>
                                <div class="card-price" style="font-size:10px; color:var(--muted); font-weight:400;">/ malam</div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function renderLiveMapPins(villas) {
            // Reset/bersihkan pin peta lama
            mapMarkersLayerGroup.clearLayers();

            villas.forEach((villa, index) => {
                // Set sebaran koordinat geospasial real di sekitar Ubud jika di db.js belum kamu set lat/lng-nya
                let lat = villa.lat || (-8.5050 - (index * 0.0040));
                let lng = villa.lng || (115.2600 + (index * 0.0050));

                // Cetak elemen Balon Pin Kaca persis mockup kita ke format Leaflet Marker
                const markerHtml = `
                    <div class="map-marker-holder">
                        <div class="map-marker-bubble">
                            <img src="${villa.imageUrl}" alt="${villa.name}">
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

                // Pasang marker ke peta real
                const marker = L.marker([lat, lng], { icon: customMarkerIcon });
                marker.on('click', () => { openDetail(villa.id); });
                mapMarkersLayerGroup.addLayer(marker);
            });
        }

        // --- QUICK FILTER CHIPS HANDLER ---
        function filterCityQuick(cityName) {
            activeCityFilter = cityName;
            document.querySelectorAll('.q-chip').forEach(chip => chip.classList.remove('active'));
            
            if (cityName === '') document.getElementById('chip-all').classList.add('active');
            if (cityName === 'Ubud') document.getElementById('chip-ubud').classList.add('active');
            if (cityName === 'Kuta') document.getElementById('chip-kuta').classList.add('active');
            if (cityName === 'Batu') document.getElementById('chip-batu').classList.add('active');
            
            render();
            
            // Otomatis geser kamera fokus map jika klik kota Ubud
            if (cityName === 'Ubud' && myLiveMap) {
                myLiveMap.panTo(defaultMapCenter);
            }
        }

        function applyAdvancedFilter() { closeModal(); render(); }

        function resetAdvancedFilter() {
            document.getElementById('filter-city').value = "";
            document.getElementById('filter-budget').value = "";
            document.querySelectorAll('input[name="facility"]:checked').forEach(cb => cb.checked = false);
            activeCityFilter = '';
            filterCityQuick('');
        }

        function openDetail(id) { window.location.href = `accom_detail.php?id=${id}`; }

        searchInput.addEventListener('input', render);

        // Jalankan peta dan render komponen setelah halaman ter-load sempurna
        window.onload = () => {
            initMapEngine();
            if (typeof villaDatabase !== 'undefined') { render(); }
        };
    </script>
</body>
</html>