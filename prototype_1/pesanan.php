<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agoda Redesign - Pesanan Saya</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue-900: #0c2461;
            --blue-700: #1e5799;
            --blue-500: #2563EB;
            --blue-400: #3B82F6;
            --blue-300: #60A5FA;
            --blue-100: #DBEAFE;
            --blue-50:  #EFF6FF;
        }

        body {
            background: #b8cfe8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px 16px;
            font-family: 'DM Sans', sans-serif;
        }

        /* =========================
           PHONE FRAME & BACKGROUND
        ========================== */
        .phone-frame {
            width: 375px;
            height: 812px;
            border-radius: 44px;
            border: 9px solid #18181b;
            position: relative;
            background: linear-gradient(165deg,
              #1e57b8 0%,
              #2563EB 18%,
              #4A90D9 36%,
              #82B8F0 54%,
              #C5DEFF 72%,
              #EBF4FF 88%,
              #F5F9FF 100%
            );
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 40px 80px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.12);
        }

        .phone-notch, .notch {
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 26px;
            background: #18181b;
            border-radius: 14px;
            z-index: 200;
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
            padding: 24px 16px 120px;
            position: relative;
            z-index: 10;
        }

        .content::-webkit-scrollbar { display: none; }

        .statusbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 16px 0;
            color: rgba(255,255,255,.95);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .3px;
        }

        .statusbar .icons { display: flex; gap: 6px; align-items: center; }
        .statusbar .icons svg {
            width: 14px;
            height: 14px;
            stroke: rgba(255,255,255,.95);
            fill: none;
            stroke-width: 1.6;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 16px 0;
        }

        .greeting {
            color: rgba(255,255,255,.85);
            font-size: 12px;
            font-weight: 400;
        }

        .name {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: white;
            letter-spacing: -.3px;
            margin-top: 4px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffd89b, #19547b);
            border: 2px solid rgba(255,255,255,.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 700;
        }

        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: #0c2461;
            margin-bottom: 12px;
            margin-top: 22px;
            padding-left: 5px;
            font-family: 'Playfair Display', serif;
        }

        .booking-tools {
            display: grid;
            gap: 12px;
            margin-bottom: 18px;
            padding-left: 5px;
        }

        .searchbar {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,.9);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 16px;
            padding: 0 14px;
            height: 50px;
            border: 1px solid rgba(255,255,255,.9);
            box-shadow: 0 4px 18px rgba(37,99,235,.1);
        }

        .searchbar svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            stroke: rgba(12,36,97,.5);
            fill: none;
            stroke-width: 1.8;
        }

        .booking-search {
            flex: 1;
            border: none;
            background: transparent;
            color: #0c2461;
            font-size: 13px;
            outline: none;
            font-family: 'DM Sans', sans-serif;
        }

        .booking-search::placeholder {
            color: rgba(12,36,97,.48);
        }

        .chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding-right: 5px;
        }

        .filter-chip {
            white-space: nowrap;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.75);
            color: #1e3a5f;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,.85);
            cursor: pointer;
            transition: all .2s ease;
        }

        .filter-chip.active {
            background: #1D4ED8;
            border-color: rgba(29,78,216,.5);
            color: white;
            box-shadow: 0 4px 14px rgba(29,78,216,.25);
            transform: translateY(-1px);
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
            bottom: 16px;
            left: 14px;
            right: 14px;
            height: 68px;
            border-radius: 26px;
            background: rgba(255,255,255,0.22);
            backdrop-filter: blur(28px) saturate(160%);
            -webkit-backdrop-filter: blur(28px) saturate(160%);
            border: 1px solid rgba(255,255,255,0.45);
            box-shadow: 0 8px 32px rgba(30,87,185,0.18), 0 2px 8px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.6);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0 12px;
            z-index: 100;
        }
        
        a { text-decoration: none; color: inherit; }
        
        .nav-item {
            display: flex;
            flex: 1;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 10px 12px;
            border-radius: 16px;
            text-align: center;
            font-size: 10px;
            color: rgba(12,36,97,.45);
            transition: .3s ease;
        }

        .nav-item svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: rgba(12,36,97,.45);
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .nav-item.active {
            background: rgba(255,255,255,.55);
            box-shadow: 0 2px 12px rgba(37,99,235,.15);
            color: #1D4ED8;
        }

        .nav-item.active svg {
            stroke: #1D4ED8;
        }

    </style>
</head>
<body>

<div class="phone-frame">
    <div class="phone-notch"></div>
    <div class="blob blob-top"></div>

    <div class="statusbar">
        <span>09:41</span>
        <div class="icons">
            <svg viewBox="0 0 24 24"><path d="M4 12h.01M9 12h.01M14 12h.01M19 12h.01"/></svg>
            <svg viewBox="0 0 24 24"><path d="M6 7c1.333-1.333 2.667-2 4-2s2.667.667 4 2c1.333 1.333 2.667 2 4 2"/><path d="M4 14c2-4 4-5 8-5s6 1 8 5"/><path d="M5 19h14"/></svg>
        </div>
    </div>
    <div class="topbar">
        <div>
            <div class="greeting">Hai, Ana</div>
            <div class="name">Pesanan Saya</div>
        </div>
        <div class="avatar">A</div>
    </div>
    <div class="content">
        <div class="booking-tools">
            <div class="searchbar">
                <svg viewBox="0 0 24 24"><circle cx="10" cy="10" r="6"/><path d="m21 21-4.35-4.35"/></svg>
                <input class="booking-search" id="booking-search" type="text" placeholder="Cari villa atau tanggal...">
            </div>
            <div class="chips">
                <div class="filter-chip active" data-method="All" id="chip-all" onclick="setMethodFilter('All')">Semua</div>
                <div class="filter-chip" data-method="E-Wallet" id="chip-ewallet" onclick="setMethodFilter('E-Wallet')">E-Wallet</div>
                <div class="filter-chip" data-method="Credit Card" id="chip-card" onclick="setMethodFilter('Credit Card')">Credit Card</div>
                <div class="filter-chip" data-method="Bank Transfer" id="chip-bank" onclick="setMethodFilter('Bank Transfer')">Bank Transfer</div>
            </div>
        </div>
        <div id="booking-container"></div>
    </div>

    <nav class="nav-bar">
        <a href="home.php" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5Z"/><path d="M9 21V12h6v9"/></svg>
            <span>Awal</span>
        </a>
        <a href="explore.php" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <span>Explore</span>
        </a>
        <a href="pesanan.php" class="nav-item active">
            <svg class="nav-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
            <span>Pesanan</span>
        </a>
        <a href="profile.php" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span>Profil</span>
        </a>
    </nav>
</div>

<script src="db.js"></script>
<script>
let bookingDatabase = [];
let activeMethodFilter = 'All';

async function loadBookings() {
    try {
        const response = await fetch('bookings.json');
        
        // Cek kalau fetch gagal (misal file gak ada)
        if (!response.ok) throw new Error('File tidak ditemukan');
        
        bookingDatabase = await response.json();
        renderBookings();

        document.getElementById('booking-search').addEventListener('input', renderBookings);
    } catch (error) {
        const container = document.getElementById('booking-container');
        showEmptyState(container);
    }
}

function setMethodFilter(method) {
    activeMethodFilter = method;
    document.querySelectorAll('.filter-chip').forEach(chip => chip.classList.toggle('active', chip.dataset.method === method));
    renderBookings();
}

function renderBookings() {
    const container = document.getElementById('booking-container');
    const searchValue = document.getElementById('booking-search').value.trim().toLowerCase();
    
    const filtered = bookingDatabase
        .filter(booking => {
            const matchesMethod = activeMethodFilter === 'All' || booking.paymentMethod === activeMethodFilter;
            const matchesSearch = searchValue === '' ||
                booking.villaName.toLowerCase().includes(searchValue) ||
                booking.checkin.toLowerCase().includes(searchValue) ||
                booking.checkout.toLowerCase().includes(searchValue);
            return matchesMethod && matchesSearch;
        })
        .sort((a, b) => new Date(b.bookedAt) - new Date(a.bookedAt));

    if (filtered.length === 0) {
        showEmptyState(container);
        return;
    }

    container.innerHTML = '';
    filtered.forEach(booking => {
function loadBookings() {
    // 1. Cek apakah sudah ada data pemesanan di localStorage
    let storedData = localStorage.getItem('agoda_bookings');
    
    // 2. Jika kosong (baru pertama kali buka web), tarik data dari db.js lalu simpan ke localStorage
    if (!storedData) {
        localStorage.setItem('agoda_bookings', JSON.stringify(initialDummyBookings));
        storedData = JSON.stringify(initialDummyBookings);
    }
    
    const bookings = JSON.parse(storedData);
    const container = document.getElementById('booking-container');

    // 3. Tampilkan empty state jika benar-benar kosong (misal tester menghapus semua pesanan nanti)
    if (bookings.length === 0) {
        showEmptyState(container);
        return;
    }

    // 4. Render kartu pesanan
    bookings.reverse().forEach(booking => {
        // Cocokkan villaId dengan database di db.js
        const villaDetail = villaDatabase.find(v => v.id === booking.villaId);
        
        if (villaDetail) {
            const formattedTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(booking.total);

            container.innerHTML += `
                <div class="booking-card">
                    <img src="${villaDetail.imageUrl}" class="booking-image" alt="Villa Image">
                    
                    <div class="booking-detail">
<<<<<<< HEAD
                        <p class="villa-type">Berhasil Dipesan</p>
                        <h2 class="villa-name">${booking.villaName}</h2>
                        <p class="villa-location">${booking.checkin} → ${booking.checkout}</p>
=======
                        <p class="villa-type">📍 Berhasil Dipesan</p>
                        <h2 class="villa-name">${villaDetail.name}</h2>
                        <p class="villa-location">📅 ${booking.checkin} → ${booking.checkout}</p>
>>>>>>> b17b88b4bd5a513c7e326456c7f6a77b1cdb3c66
                        
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
                            <div class="status-badge">${booking.paymentMethod}</div>
                            <button class="cancel-btn" onclick="alert('Fitur pembatalan sedang diproses.')">Batalkan</button>
                        </div>
                    </div>
                </div>
            `;
<<<<<<< HEAD
        });
=======
        }
    });
>>>>>>> b17b88b4bd5a513c7e326456c7f6a77b1cdb3c66
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

// Jalankan fungsi saat halaman dimuat
loadBookings();
</script>

</body>
</html>