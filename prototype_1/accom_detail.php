<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Villa</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --blue-900: #0c2461;
            --blue-500: #2563EB;
            --muted: #475569;
            /* Sedikit digelapkan agar tulisan di atas kaca tipis tetap kontras & terbaca */

            /* Nilai alpha diturunkan dari 0.75 menjadi 0.40 agar jauh lebih transparan */
            --glass-bg: rgba(255, 255, 255, 0.40);
            --glass-blur: blur(25px);
            /* Blur dinaikkan sedikit agar efek mewahnya makin berasa */
            --glass-border: rgba(255, 255, 255, 0.45);
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

        /* ── PHONE FRAME (Locked Size) ── */
        .phone-frame {
            width: 375px;
            height: 812px;
            border-radius: 44px;
            border: 9px solid #18181b;
            position: relative;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0, 0, 0, .35), inset 0 0 0 1px rgba(255, 255, 255, .12);
            background: #F5F9FF;
        }

        .notch {
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 26px;
            background: #18181b;
            border-radius: 14px;
            z-index: 300;
        }

        /* ── BACK BUTTON (Floating on Image) ── */
        .back-btn {
            position: absolute;
            top: 44px;
            left: 20px;
            z-index: 250;
            width: 36px;
            height: 36px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        /* ── SCROLL AREA INTERNAL ── */
        .content {
            height: 100%;
            overflow-y: auto;
            scrollbar-width: none;
            position: relative;
        }

        .content::-webkit-scrollbar {
            display: none;
        }

        /* ── HERO IMAGE (Top Area Full Screen Width) ── */
        .hero-banner-area {
            position: relative;
            width: 100%;
            height: 380px;
            /* Dipertinggi agar visual crop di atas megah */
            z-index: 1;
        }

        .hero-img-full {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .hero-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2) 0%, rgba(0, 0, 0, 0) 40%, rgba(0, 0, 0, 0.1) 100%);
        }

        /* ── GLASS MORPHISM PANEL CONTAINER ── */
        .glass-detail-panel {
            position: relative;
            margin-top: -60px;
            /* Memotong ke atas menimpa gambar hero */
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur) saturate(170%);
            -webkit-backdrop-filter: var(--glass-blur) saturate(170%);
            border-top: 1px solid var(--glass-border);
            border-radius: 32px 32px 0 0;
            padding: 24px 20px 110px;
            /* Jarak bawah longgar untuk CTA */
            z-index: 10;
            box-shadow: 0 -10px 32px rgba(0, 0, 0, 0.08);
            min-height: 492px;
        }

        /* Handle bar dekoratif ala bottom sheet */
        .panel-handle {
            width: 36px;
            height: 4px;
            background: rgba(12, 36, 97, 0.15);
            border-radius: 999px;
            margin: -12px auto 20px;
        }

        .modal-tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            background: #EFF6FF;
            color: #2563EB;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .5px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--blue-900);
            line-height: 1.3;
            margin-bottom: 6px;
        }

        .modal-loc {
            font-size: 12px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 20px;
        }

        .modal-loc svg {
            width: 12px;
            height: 12px;
            fill: var(--blue-500);
        }

        /* ── INFO CARDS (Grid Mini) ── */
        .info-cards {
            display: flex;
            gap: 10px;
            margin-bottom: 22px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 10px;
            border-radius: 14px;
            flex: 1;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .info-card .value {
            font-weight: 700;
            color: var(--blue-900);
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2px;
        }

        .info-card .value svg {
            width: 12px;
            height: 12px;
            fill: #F59E0B;
        }

        .info-card .label {
            font-size: 10px;
            color: var(--muted);
            margin-top: 1px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--blue-900);
            margin-bottom: 8px;
            letter-spacing: 0.2px;
        }

        .modal-desc {
            font-size: 12px;
            color: #475569;
            line-height: 1.7;
            margin-bottom: 22px;
        }

        /* ── AMENITIES ── */
        .modal-amenities {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .amenity {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 10px;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 600;
            color: #334155;
        }

        /* ── FLOATING FIXED FOOTER CTA ── */
        .fixed-booking-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 85px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-top: 1px solid rgba(255, 255, 255, 0.5);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 24px 10px;
            /* Padding bawah disesuaikan frame HP */
            z-index: 200;
            box-shadow: 0 -6px 20px rgba(0, 0, 0, 0.04);
        }

        .price-container {
            display: flex;
            flex-direction: column;
        }

        .modal-price {
            font-size: 18px;
            font-weight: 700;
            color: #1D4ED8;
        }

        .modal-price span {
            font-size: 10px;
            font-weight: 400;
            color: var(--muted);
        }

        .detail-button {
            padding: 12px 28px;
            background: #1D4ED8;
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(29, 78, 216, 0.25);
            transition: transform 0.15s;
        }

        .detail-button:active {
            transform: scale(0.97);
        }

        .notice {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 10px;
            border-radius: 12px;
            font-size: 11px;
            text-align: center;
            margin: 10px 0;
        }
        html.dark-mode body {
            background: #020617;
            color: #e2e8f0;
        }
        html.dark-mode .phone-frame,
        html.dark-mode .phone {
            border-color: #0f172a !important;
            background: linear-gradient(165deg, #0f172a 0%, #111827 30%, #1f2937 60%, #0f172a 100%) !important;
            box-shadow: 0 40px 90px rgba(0,0,0,.8) !important;
        }
        html.dark-mode .content-card,
        html.dark-mode .detail-card,
        html.dark-mode .gallery,
        html.dark-mode .info-row,
        html.dark-mode .facility-row,
        html.dark-mode .amenity,
        html.dark-mode .price-box,
        html.dark-mode .btn,
        html.dark-mode .sticky-footer {
            background: rgba(15,23,42,.92) !important;
            border-color: rgba(148,163,184,.2) !important;
            color: #e2e8f0 !important;
        }
        html.dark-mode .btn-primary,
        html.dark-mode .btn-book {
            background: rgba(37,99,235,.95) !important;
            color: white !important;
        }
        html.dark-mode input,
        html.dark-mode textarea,
        html.dark-mode .select-box {
            background: rgba(15,23,42,.96) !important;
            color: #e2e8f0 !important;
            border-color: rgba(148,163,184,.3) !important;
        }
.price-container{
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.modal-price{
    font-size:22px;
    font-weight:800;
    color:#1D4ED8;
    line-height:1;
    letter-spacing:-0.5px;
}

.price-subtitle{
    margin-top:4px;
    font-size:11px;
    color:#64748B;
    font-weight:500;
}
    </style>
</head>

<body>

    <div class="phone-frame">
        <div class="notch"></div>

        <button class="back-btn" onclick="history.back()" aria-label="Kembali">←</button>

        <div class="content" id="main-scroll-container">
            <div id="detail-dynamic-target"></div>
        </div>

        <!-- <div class="fixed-booking-bar" id="fixedFooter" style="display: none;">
            <div class="price-container">
                <div class="modal-price" id="footerPrice">Rp 000rb</div>
                <div class="modal-price<span>/ malam</span>" style="font-size:10px; color:var(--muted)"></div>
            </div>
            <button id="detailBookBtn" class="detail-button">Pesan Sekarang</button>
        </div> -->
        <div class="fixed-booking-bar" id="fixedFooter" style="display:none;">
    
    <div class="price-container">
        <div class="modal-price" id="footerPrice"></div>
        <div class="price-subtitle">per malam</div>
    </div>

    <button id="detailBookBtn" class="detail-button">
        Pesan Sekarang
    </button>

</div>
    </div>

    <script src="db.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const villaId = params.get('id');
            const checkin = params.get('checkin') || '';
            const checkout = params.get('checkout') || '';
            const guest = params.get('guest') || '';
            const dynamicTarget = document.getElementById('detail-dynamic-target');
            const fixedFooter = document.getElementById('fixedFooter');
            const footerPrice = document.getElementById('footerPrice');

            const placeholder = 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=900&auto=format&fit=crop&q=80';

            if (typeof villaDatabase === 'undefined') {
                dynamicTarget.innerHTML = `
            <div style="padding:100px 20px 20px; text-align:center;">
                <div class="notice">Data tidak tersedia — pastikan <strong>db.js</strong> ter-load.</div>
            </div>
        `;
                return;
            }

            let villa = null;
            if (villaId) {
                villa = villaDatabase.find(v => String(v.id) === String(villaId))
                     || hotelDatabase.find(v => String(v.id) === String(villaId))
                     || apartmentDatabase.find(v => String(v.id) === String(villaId));
            }

            let usedFallback = false;
            if (!villa) {
                if (villaDatabase.length > 0) {
                    usedFallback = true;
                    villa = villaDatabase[0];
                } else {
                    dynamicTarget.innerHTML = `
                <div style="padding:100px 20px 20px; text-align:center;">
                    <div class="notice">Belum ada data villa tersedia.</div>
                </div>
            `;
                    return;
                }
            }

            const img = villa.imageUrl || placeholder;
            const formattedPrice = (villa.pricePerNight || 0) > 0 ? new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(villa.pricePerNight) : '-';

            const rating = villa.rating || '-';
            const guests = villa.maxGuests || villa.guest || '-';
            const duration = villa.duration || '—';

            // Update Harga di Fixed Footer & Munculkan Footernya
            // footerPrice.innerHTML = `${formattedPrice}<span>/ malam</span>`;
            footerPrice.textContent = formattedPrice;
            fixedFooter.style.display = 'flex';

            // Render Struktur Layout Glass-Overlay Transparan menimpa Hero Image
            dynamicTarget.innerHTML = `
        <div class="hero-banner-area">
            <img src="${img}" class="hero-img-full" alt="${villa.name || ''}">
            <div class="hero-gradient"></div>
        </div>

        <div class="glass-detail-panel">
            <div class="panel-handle"></div>
            
            ${usedFallback ? '<div class="notice">ID tidak ditemukan — menampilkan properti default.</div>' : ''}
            
            <div class="modal-tag">${villa.type || 'Staycation'}</div>
            <h3 class="modal-title">${villa.name || ''}</h3>
            
            <div class="modal-loc">
                <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                ${villa.locationDetail || villa.city || '-'}
            </div>

            <div class="info-cards">
                <div class="info-card">
                    <div class="value"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> ${rating}</div>
                    <div class="label">Rating</div>
                </div>
                <div class="info-card">
                    <div class="value">${guests} pax</div>
                    <div class="label">Kapasitas</div>
                </div>
                <div class="info-card">
                    <div class="value">${duration}</div>
                    <div class="label">Durasi</div>
                </div>
            </div>

            <div class="section-title">Deskripsi</div>
            <div class="modal-desc">${villa.description || 'Tidak ada deskripsi lengkap untuk properti ini.'}</div>

            <div class="section-title">Fasilitas Utama</div>
            <div class="modal-amenities">
                ${(villa.facilities || []).map(f => `<div class="amenity">${f}</div>`).join('')}
            </div>
        </div>
    `;

            // Handler Navigasi ke Halaman Booking
            const detailBookBtn = document.getElementById('detailBookBtn');
            if (villa.id && detailBookBtn) {
                detailBookBtn.onclick = () => {
                    window.location.href =`booking.php?id=${encodeURIComponent(villa.id)}&checkin=${encodeURIComponent(checkin)}&checkout=${encodeURIComponent(checkout)}&guest=${encodeURIComponent(guest)}`;};
            } else if (detailBookBtn) {
                detailBookBtn.disabled = true;
                detailBookBtn.style.opacity = '.6';
            }
        });
    </script>

    <script src="theme.js"></script>
</body>

</html>