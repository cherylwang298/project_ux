<!-- accom.php -->
<?php

// $type = $_GET['type'] ?? 'hotel';

// $title =
// $type === 'villa'
// ? 'Luxury Villas'
// : 'Best Hotels';

// $desc =
// $type === 'villa'
// ? 'Nikmati villa private dengan view terbaik.'
// : 'Temukan hotel nyaman untuk staycation.';
$type = $_GET['type'] ?? 'hotel';

switch($type){
    case 'villa':
        $title = 'Luxury Villas';
        $desc = 'Nikmati villa private dengan view terbaik.';
        break;

    case 'apartemen':
        $title = 'Modern Apartments';
        $desc = 'Temukan apartemen nyaman untuk perjalanan bisnis maupun liburan.';
        break;

    default:
        $title = 'Best Hotels';
        $desc = 'Temukan hotel nyaman untuk staycation.';
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= ucfirst($type) ?></title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<style>

/* PASTE STYLE DARI flight.php */
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}

body{
  background:#b8cfe8;
  min-height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  font-family:'DM Sans',sans-serif;
}

.phone{
  width:375px;
  height:812px;
  border-radius:44px;
  border:9px solid #18181b;
  overflow:hidden;
  position:relative;

  background:linear-gradient(
    165deg,
    #1e57b8 0%,
    #2563EB 18%,
    #4A90D9 36%,
    #82B8F0 54%,
    #C5DEFF 72%,
    #EBF4FF 88%,
    #F5F9FF 100%
  );
}

/* BACK BUTTON STYLE (SAMA FLIGHT) */
.back-btn{
  width:38px;
  height:38px;
  border-radius:14px;

  background:rgba(255,255,255,.18);
  border:1px solid rgba(255,255,255,.2);

  backdrop-filter:blur(18px);

  display:flex;
  align-items:center;
  justify-content:center;

  color:white;
  text-decoration:none;

  font-size:18px;
  font-weight:700;
}

/* KEEP YOUR ORIGINAL STYLE */
.scroll{
  height:100%;
  overflow-y:auto;
  padding-bottom:120px;
}

.scroll::-webkit-scrollbar{
  display:none;
}

.notch{
  position:absolute;
  top:8px;
  left:50%;
  transform:translateX(-50%);
  width:100px;
  height:26px;
  border-radius:14px;
  background:#111;
}

.statusbar{
  padding:42px 24px 0;
  display:flex;
  justify-content:space-between;
  color:white;
  font-size:11px;
}

.topbar{
  padding:12px 20px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.greeting{
  color:rgba(255,255,255,.8);
  font-size:12px;
}

.name{
  color:white;
  font-size:18px;
  font-weight:700;
  font-family:'Playfair Display',serif;
}

.avatar{
  width:40px;
  height:40px;
  border-radius:50%;
  background:white;
  color:#2563EB;
  display:flex;
  justify-content:center;
  align-items:center;
  font-weight:700;
}

.hero{
  margin:0 16px;
  border-radius:24px;
  padding:20px;
  background:linear-gradient(
    135deg,
    rgba(13,40,120,.9),
    rgba(30,87,185,.7)
  );
  color:white;
}

.hero-eyebrow{
  font-size:10px;
  opacity:.7;
  margin-bottom:8px;
}

.hero h2{
  font-size:24px;
  line-height:1.3;
  margin-bottom:8px;
  font-family:'Playfair Display',serif;
}

.hero p{
  font-size:11px;
  line-height:1.6;
  opacity:.8;
}

.search-box{
  margin:18px 16px 0;
  background:rgba(255,255,255,.35);
  backdrop-filter:blur(20px);
  border-radius:24px;
  padding:18px;
}

.input{
  width:100%;
  height:50px;
  border:none;
  outline:none;
  border-radius:16px;
  margin-bottom:12px;
  padding:0 16px;
  font-size:13px;
}

.row{
  display:flex;
  gap:10px;
}

.btn{
  width:100%;
  height:52px;
  border:none;
  border-radius:18px;
  background:#2563EB;
  color:white;
  font-weight:700;
}

.sec-head{
  padding:22px 16px 12px;
}

.title{
  font-size:16px;
  font-weight:700;
  color:#0c2461;
  font-family:'Playfair Display',serif;
}

.featured-scroll{
  display:flex;
  gap:14px;
  overflow-x:auto;
  padding:0 16px;
}

.featured-scroll::-webkit-scrollbar{
  display:none;
}

.feat-card{
  width:220px;
  min-width:220px;
  background:white;
  border-radius:22px;
  overflow:hidden;
}

.feat-card img{
  width:100%;
  height:130px;
  object-fit:cover;
}

.feat-info{
  padding:14px;
}

.feat-tag{
  display:inline-block;
  background:#EFF6FF;
  color:#2563EB;
  font-size:10px;
  padding:4px 10px;
  border-radius:999px;
  margin-bottom:8px;
}

.feat-info h5{
  font-size:14px;
  margin-bottom:6px;
}

.loc{
  font-size:11px;
  color:#64748b;
  margin-bottom:10px;
}

.feat-bottom{
  display:flex;
  justify-content:space-between;
}

.feat-price{
  font-size:14px;
  font-weight:700;
  color:#2563EB;
}

.navbar {
  position: absolute;
  left: 14px;
  right: 14px;
  bottom: 16px;
  height: 68px;
  border-radius: 26px;
  background: rgba(255, 255, 255, 0.22);
  backdrop-filter: blur(28px) saturate(160%);
  -webkit-backdrop-filter: blur(28px) saturate(160%);
  border: 1px solid rgba(255, 255, 255, 0.45);
  box-shadow: 0 8px 32px rgba(30, 87, 185, .18), 0 2px 8px rgba(0, 0, 0, .08), inset 0 1px 0 rgba(255, 255, 255, .6);
  display: flex;
  justify-content: space-around;
  align-items: center;
  z-index: 200;
}

.nav-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 3px;
  padding: 10px 12px;
  border-radius: 16px;
  cursor: pointer;
  flex: 1;
}

.nav-item svg {
  width: 20px;
  height: 20px;
  fill: none;
  stroke: rgba(12, 36, 97, .4);
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
}

.nav-item span {
  font-size: 9px;
  font-weight: 600;
  color: rgba(12, 36, 97, .4);
}

.nav-item.active {
  background: rgba(255, 255, 255, .55);
  box-shadow: 0 2px 12px rgba(37, 99, 235, .15);
}

.nav-item.active svg {
  stroke: #1D4ED8;
}

.nav-item.active span {
  color: #1D4ED8;
}

.topbar{
  padding:16px 20px 8px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  position:relative;
}

.page-title{
  position:absolute;
  left:50%;
  transform:translateX(-50%);
  color:white;
  font-size:16px;
  font-weight:700;
  font-family:'Playfair Display',serif;
}

.empty{
  width:38px;
  height:38px;
}

/* DETAIL MODAL (ported from home.php) */
.detail-modal {
  display: none;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(12, 36, 97, 0.35);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  z-index: 400;
  align-items: flex-end;
}
.detail-modal.active { display: flex; }
.detail-content {
  width: 100%;
  height: 94%;
  background: #F5F9FF;
  border-radius: 36px 36px 0 0;
  overflow-y: auto;
  position: relative;
  scrollbar-width: none;
  animation: slideUp 0.38s cubic-bezier(0.16, 1, 0.3, 1) both;
}
.detail-content::-webkit-scrollbar { display: none; }
@keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
.detail-header { position: relative; width: 100%; }
.detail-header img { width: 100%; height: auto; display: block; object-fit: unset; }
.detail-close { position: absolute; top: 44px; left: 20px; width: 36px; height: 36px; background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: 50%; display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:220; color:white; box-shadow:0 4px 12px rgba(0,0,0,0.1); }
.detail-close svg { width:18px; height:18px; stroke:white; }
.detail-glass-panel { position: relative; background: rgba(255,255,255,0.92); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-top: 1px solid rgba(255,255,255,0.6); border-radius: 32px 32px 0 0; padding: 24px 20px 100px; z-index: 10; box-shadow: 0 -10px 32px rgba(0,0,0,0.06); }
.panel-handle { width: 36px; height:4px; background: rgba(12,36,97,0.15); border-radius:999px; margin:-12px auto 20px; }
.detail-title { font-family: 'Playfair Display', serif; font-size:22px; font-weight:700; color: #0c2461; line-height:1.3; margin-bottom:6px; }
.detail-location { display:flex; align-items:center; gap:4px; font-size:11px; color:#475569; margin-bottom:18px; }
.detail-rating { display:flex; align-items:center; gap:8px; margin-bottom:20px; }
.detail-stars svg { width:13px; height:13px; fill:#F59E0B; }
.detail-rating-text { font-size:12px; font-weight:700; color:#0c2461; }
.detail-description { font-size:12px; color:#334155; line-height:1.7; margin-bottom:22px; }
.detail-amenities { display:flex; gap:8px; flex-wrap:wrap; }
.detail-amenity { background: rgba(255,255,255,0.45); border:1px solid rgba(255,255,255,0.35); border-radius:10px; padding:6px 12px; font-size:11px; font-weight:600; color:#334155; display:flex; align-items:center; gap:6px; }
.modal-fixed-footer { position:absolute; bottom:0; left:0; right:0; height:85px; background: rgba(255,255,255,0.85); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border-top:1px solid rgba(255,255,255,0.5); display:flex; justify-content:space-between; align-items:center; padding:0 24px 10px; z-index:100; box-shadow:0 -6px 20px rgba(0,0,0,0.03); }
.modal-price-wrap { display:flex; flex-direction:column; }
.detail-price { font-size:18px; font-weight:700; color:#1D4ED8; }
.detail-button { padding:12px 28px; background:#1D4ED8; color:white; border:none; border-radius:14px; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 6px 16px rgba(29,78,216,0.25); }
.gradient-btn{ background: linear-gradient(90deg,#335eea,#5b3ef5); padding:14px 22px; border-radius:999px; font-size:14px; box-shadow:0 10px 30px rgba(59,130,246,0.2); }

/* design tweaks to match screenshot */
.detail-header img{ height:360px; object-fit:cover; border-radius: 24px 24px 0 0; }
.detail-badge{ display:inline-block; background:#EEF2FF; color:#334155; font-size:10px; font-weight:700; padding:6px 10px; border-radius:999px; margin-bottom:10px; letter-spacing:0.6px; }
.spec-row{ display:flex; gap:10px; margin-bottom:14px; }
.spec-card{ background:rgba(255,255,255,0.95); border-radius:12px; padding:10px 12px; display:flex; flex-direction:column; align-items:center; min-width:72px; box-shadow:0 6px 18px rgba(12,36,97,0.04); }
.spec-card .val{ font-weight:800; color:#0c2461; font-size:13px; }
.spec-card .lbl{ font-size:11px; color:#64748b; margin-top:6px; }

</style>
</head>

<body>

<div class="phone">

<div class="notch"></div>

<div class="scroll">

<div class="statusbar">
<span>9:41</span>
<span>🏨</span>
</div>

<div class="topbar">

  <a href="home.php" class="back-btn">
    ←
  </a>

  <div class="page-title">
    Accomodation Booking
  </div>

  <div class="empty"></div>

</div>

<div class="hero">

<div class="hero-eyebrow">
<?= strtoupper($type) ?> STAY
</div>

<h2>
<?= $title ?>
</h2>

<div style="
  margin-top:6px;
  font-size:11px;
  opacity:.85;
">
  <?= ucfirst($type) ?> • Stay Collection
</div>

<p>
<?= $desc ?>
</p>

</div>

<!-- REST FULLY UNCHANGED -->
<div class="search-box">

<div style="
  font-size:11px;
  color:#0c2461;
  font-weight:600;
  margin-bottom:10px;
">
  Search <?= ucfirst($type) ?>
</div>

<input type="text" id="destination" class="input" placeholder="Destination">

<div class="row">
  <input type="date" id="checkin" class="input" min="<?= date('Y-m-d') ?>">
  <input type="date" id="checkout" class="input" min="<?= date('Y-m-d') ?>">
</div>

<div class="row">
  <input type="number" id="guest" class="input" placeholder="Guest">
  <!-- <input type="number" id="room" class="input" placeholder="Room"> -->
</div>

<button class="btn" onclick="searchAccom()">
  Search <?= ucfirst($type) ?>
</button>

</div>

<div class="sec-head">
<div class="title">
Recommended <?= ucfirst($type) ?>
</div>
</div>

<div class="featured-scroll" id="featuredScroll"></div>

</div>

<nav class="navbar">

  <div class="nav-item">
    <a href="home.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5Z" />
        <path d="M9 21V12h6v9" />
      </svg>
      <span>Home</span>
    </a>
  </div>
  <div class="nav-item">
    <a href="explore.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8" />
        <path d="m21 21-4.35-4.35" />
      </svg>
      <span>Explore</span>
    </a>
  </div>
  <div class="nav-item">
    <a href="flight.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M2 12l19-6-3 6 3 6-19-6z" />
        <path d="M12 6v12" />
      </svg>
      <span>Flight</span>
    </a>
  </div>
  <div class="nav-item">
    <a href="pesanan.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="4" width="18" height="18" rx="2" />
        <path d="M16 2v4" />
        <path d="M8 2v4" />
        <path d="M3 10h18" />
      </svg>
      <span>Pesanan</span>
    </a>
  </div>
  <div class="nav-item">
    <a href="profile.php" style="display:flex; flex-direction:column; align-items:center; gap:3px; text-decoration:none; width:100%; height:100%; justify-content:center;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
        <circle cx="12" cy="7" r="4" />
      </svg>
      <span>Profil</span>
    </a>
  </div>

</nav>

<!-- DETAIL MODAL -->
<div class="detail-modal" id="detailModal">
  <div class="detail-content">
    <div class="detail-header">
      <img id="detailImg" src="" alt="Property Image">
      <button class="detail-close" onclick="closeDetail()" aria-label="Close">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </button>
    </div>

    <div class="detail-glass-panel">
      <div class="panel-handle"></div>
        <div class="detail-badge" id="detailBadge">PRIVATE POOL VILLA</div>
        <h2 class="detail-title" id="detailName">Nama Properti</h2>
        <div class="detail-location" id="detailLocation">📍 Lokasi</div>

        <div class="spec-row">
          <div class="spec-card">
            <div class="val"><span id="detailRating">4.9</span></div>
            <div class="lbl">Rating</div>
          </div>
          <div class="spec-card">
            <div class="val" id="detailPax">- pax</div>
            <div class="lbl">Kapasitas</div>
          </div>
          <div class="spec-card">
            <div class="val" id="detailDuration">-</div>
            <div class="lbl">Durasi</div>
          </div>
        </div>

        <div class="detail-description" id="detailDescription">Deskripsi properti akan muncul di sini.</div>

        <div class="detail-amenities" id="detailAmenities"></div>

        <div class="modal-fixed-footer">
          <div class="modal-price-wrap">
            <div class="detail-price" id="detailPrice">Rp 0</div>
            <div style="font-size:12px;color:#64748b">per malam</div>
          </div>
          <button class="detail-button gradient-btn" onclick="bookDetail(currentProp)">Pesan Sekarang</button>
        </div>
    </div>
  </div>
</div>

</div>

<script src="db.js"></script>
<script>
// set up date constraints and validation
;(function(){
  const today = new Date().toISOString().split('T')[0];
  const checkinEl = document.getElementById('checkin');
  const checkoutEl = document.getElementById('checkout');

  if(checkinEl) checkinEl.min = today;
  if(checkoutEl) checkoutEl.min = today;

  // when check-in changes, ensure checkout min is at least checkin
  if(checkinEl && checkoutEl){
    checkinEl.addEventListener('change', ()=>{
      const ci = checkinEl.value || today;
      checkoutEl.min = ci;
      if(checkoutEl.value && checkoutEl.value < ci){
        checkoutEl.value = ci;
      }
    });
  }
})();

const pageType = "<?= $type ?>";

function getAllProperties(){
  const result = [];
  if(typeof villaDatabase !== 'undefined') result.push(...villaDatabase);
  if(typeof hotelDatabase !== 'undefined') result.push(...hotelDatabase);
  if(typeof apartmentDatabase !== 'undefined') result.push(...apartmentDatabase);
  return result;
}

function getCategoryProperties(){
  switch(pageType){
    case 'villa':
      return typeof villaDatabase !== 'undefined' ? [...villaDatabase] : [];
    case 'apartemen':
      return typeof apartmentDatabase !== 'undefined' ? [...apartmentDatabase] : [];
    case 'hotel':
    default:
      return typeof hotelDatabase !== 'undefined' ? [...hotelDatabase] : [];
  }
}

function renderTopRecommendations(){
  const featuredScroll = document.getElementById('featuredScroll');
  if(!featuredScroll) return;

  const allProps = getCategoryProperties();
  const topProps = [...allProps].sort((a,b)=>b.rating - a.rating).slice(0,3);

  featuredScroll.innerHTML = topProps.map(prop => {
    const safePropJson = JSON.stringify(prop).replace(/'/g, "\\'").replace(/"/g, '&quot;');
    return `
      <div class="feat-card" onclick="openDetail(${safePropJson})">
        <img src="${prop.imageUrl}" alt="${prop.name}">
        <div class="feat-info">
          <div class="feat-tag">${prop.type}</div>
          <h5>${prop.name}</h5>
          <div class="loc">📍 ${prop.locationDetail}</div>
          <div class="feat-bottom">
            <div class="feat-price">Rp ${prop.pricePerNight.toLocaleString('id-ID')}</div>
            <div>⭐ ${prop.rating.toFixed(1)}</div>
          </div>
        </div>
      </div>
    `;
  }).join('');
}

renderTopRecommendations();

function searchAccom(){
  const destination = document.getElementById('destination').value.trim();
  const checkin = document.getElementById('checkin').value;
  const checkout = document.getElementById('checkout').value;
  const guest = document.getElementById('guest').value;
  // const room = document.getElementById('room').value;

  const today = new Date().toISOString().split('T')[0];

  if(!destination){
    alert('Please enter destination');
    return;
  }

  if(checkin && checkin < today){
    alert('Check-in date cannot be earlier than today');
    return;
  }

  if(checkout && checkout < today){
    alert('Check-out date cannot be earlier than today');
    return;
  }

  if(checkin && checkout && checkout < checkin){
    alert('Check-out cannot be earlier than check-in');
    return;
  }

  const searchData = {
    type: "<?= $type ?>",
    destination,
    checkin,
    checkout,
    guest
    // room
  };

  localStorage.setItem('accomSearch', JSON.stringify(searchData));
  window.location.href = 'accom-result.php';
}

let currentProp = null;
window.openDetail = function(prop){
  currentProp = prop;
  const modal = document.getElementById('detailModal');
  if(!modal) return;
  document.getElementById('detailImg').src = prop.imageUrl || '';
  document.getElementById('detailName').innerText = prop.name || '';
  document.getElementById('detailLocation').innerText = prop.locationDetail || '';
  document.getElementById('detailRating').innerText = (prop.rating||0).toFixed(1);
  document.getElementById('detailDescription').innerText = prop.description || (`Nikmati staycation premium di ${prop.name} yang berlokasi di ${prop.city}.`);

  // price formatting
  function formatRp(n){ return 'Rp ' + (Math.round(n)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
  document.getElementById('detailPrice').innerText = formatRp(prop.pricePerNight || 0);

  // facilities
  const amenEl = document.getElementById('detailAmenities');
  amenEl.innerHTML = '';
  if(Array.isArray(prop.facilities)){
    prop.facilities.forEach(f => {
      const d = document.createElement('div');
      d.className = 'detail-amenity';
      d.innerText = f;
      amenEl.appendChild(d);
    });
  }

  // badge / type
  const badge = document.getElementById('detailBadge');
  if(badge) badge.innerText = (prop.type || '').toUpperCase();

  // pax / duration
  const paxEl = document.getElementById('detailPax');
  const durEl = document.getElementById('detailDuration');
  if(paxEl) paxEl.innerText = (prop.capacity ? prop.capacity + ' pax' : '- pax');
  if(durEl) durEl.innerText = (prop.duration ? prop.duration : '-');

  modal.classList.add('active');
};

window.closeDetail = function(){
  const modal = document.getElementById('detailModal');
  if(modal) modal.classList.remove('active');
};

window.bookDetail = function(prop){
  if(!prop || !prop.id) return window.location.href = 'booking.php';
  const today = new Date().toISOString().split('T')[0];
  const checkinEl = document.getElementById('checkin');
  const checkoutEl = document.getElementById('checkout');
  let checkin = (checkinEl && checkinEl.value) ? checkinEl.value : today;
  let checkout = (checkoutEl && checkoutEl.value) ? checkoutEl.value : checkin;
  if (checkout < checkin) checkout = checkin;
  window.location.href = 'booking.php?id=' + encodeURIComponent(prop.id)
    + '&checkin=' + encodeURIComponent(checkin)
    + '&checkout=' + encodeURIComponent(checkout);
};
</script>

</body>
</html>