<?php
session_start();
require '_data.php';
require '_head.php';
if(!isset($_SESSION['saved_guest'])) $_SESSION['saved_guest']=['name'=>'Budi Santoso','email'=>'budi@email.com','phone'=>'+62 812-3456-7890'];
$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));
$dayafter = date('Y-m-d', strtotime('+3 days'));
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>agoda — Hotel, Pesawat &amp; Aktivitas</title><?=$font?><?=$css?>
</head><body>
<?=$blobs?>

<header class="app-header">
  <div class="header-inner">
    <div class="logo"><div class="logo-mark">a</div><span class="logo-text">agoda</span></div>
    <button class="icon-btn" onclick="toggleModal('profileModal')">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </button>
  </div>
</header>

<!-- HERO -->
<section class="hero-section">
  <div class="hero-tag">✦ Harga Dijamin Termurah</div>
  <h1 class="hero-title">Rencanakan<br>Perjalanan<br><span class="brand">Impianmu</span></h1>
  <p class="hero-sub">Hotel · Pesawat · Aktivitas — Semua di satu tempat</p>

  <!-- TAB SWITCHER -->
  <div class="booking-tabs">
    <button class="booking-tab active" data-tab="hotel" onclick="switchTab('hotel')">
      <span class="tab-icon">🏨</span>Hotel
    </button>
    <button class="booking-tab" data-tab="flight" onclick="switchTab('flight')">
      <span class="tab-icon">✈️</span>Pesawat
    </button>
    <button class="booking-tab" data-tab="activity" onclick="switchTab('activity')">
      <span class="tab-icon">🎯</span>Aktivitas
    </button>
  </div>

  <!-- HOTEL SEARCH -->
  <div id="tab-hotel" class="tab-content search-card glass" style="display:flex;flex-direction:column;gap:0;">
    <form class="search-form" method="GET" action="results.php" id="hotelForm">
      <div class="search-field" onclick="openCityModal('hotel')" style="cursor:pointer;">
        <span class="field-icon">📍</span>
        <div class="field-content"><label>Tujuan</label>
          <input type="text" name="location" id="hotelCity" placeholder="Surabaya, Jawa Timur" value="Surabaya" readonly style="cursor:pointer;"></div>
      </div>
      <div class="search-row">
        <div class="search-field half"><span class="field-icon">📅</span><div class="field-content"><label>Check-in</label>
          <input type="date" name="checkin" id="hotelCheckin" value="<?=$tomorrow?>" min="<?=$today?>" onchange="enforceHotelDates()"></div></div>
        <div class="search-field half"><span class="field-icon">📅</span><div class="field-content"><label>Check-out</label>
          <input type="date" name="checkout" id="hotelCheckout" value="<?=$dayafter?>" min="<?=date('Y-m-d',strtotime('+2 days'))?>" onchange="enforceHotelDates()"></div></div>
      </div>
      <div class="search-field">
        <span class="field-icon">👤</span>
        <div class="field-content"><label>Tamu &amp; Kamar</label>
          <select name="guests">
            <option>1 Tamu, 1 Kamar</option>
            <option>2 Tamu, 1 Kamar</option>
            <option>3 Tamu, 2 Kamar</option>
            <option>4 Tamu, 2 Kamar</option>
          </select>
        </div>
      </div>
      <button type="submit" class="btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        Cari Hotel
      </button>
    </form>
  </div>

  <!-- FLIGHT SEARCH -->
  <div id="tab-flight" class="tab-content search-card glass" style="display:none;flex-direction:column;gap:0;">
    <form class="search-form" method="GET" action="flights.php" id="flightForm">
      <div class="search-row">
        <div class="search-field half" onclick="openCityModal('flight_from')" style="cursor:pointer;">
          <span class="field-icon">🛫</span>
          <div class="field-content"><label>Dari</label>
            <input type="text" name="from" id="flightFrom" placeholder="SUB - Surabaya" value="Surabaya" readonly style="cursor:pointer;"></div>
        </div>
        <div class="search-field half" onclick="openCityModal('flight_to')" style="cursor:pointer;">
          <span class="field-icon">🛬</span>
          <div class="field-content"><label>Ke</label>
            <input type="text" name="to" id="flightTo" placeholder="CGK - Jakarta" value="Jakarta" readonly style="cursor:pointer;"></div>
        </div>
      </div>
      <!-- Hidden fields for city codes -->
      <input type="hidden" name="from_code" id="flightFromCode" value="SUB">
      <input type="hidden" name="to_code" id="flightToCode" value="CGK">
      <div class="search-row">
        <div class="search-field half"><span class="field-icon">📅</span><div class="field-content"><label>Berangkat</label>
          <input type="date" name="dep_date" id="flightDate" value="<?=$tomorrow?>" min="<?=$today?>"></div></div>
        <div class="search-field half"><span class="field-icon">👤</span><div class="field-content"><label>Penumpang</label>
          <select name="pax"><option>1 Dewasa</option><option>2 Dewasa</option><option>3 Dewasa</option></select>
        </div></div>
      </div>
      <button type="submit" class="btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21 4 19.5 2.5S18 2 16.5 3.5L13 7 4.8 5.2l-2.5 2.5 5.5 5.5L4.8 16l-2.5 2.5L8 21l4.5-4.5 5.5 5.5z"/></svg>
        Cari Penerbangan
      </button>
    </form>
  </div>

  <!-- ACTIVITY SEARCH -->
  <div id="tab-activity" class="tab-content search-card glass" style="display:none;flex-direction:column;gap:0;">
    <form class="search-form" method="GET" action="activities.php" id="activityForm">
      <div class="search-field" onclick="openCityModal('activity')" style="cursor:pointer;">
        <span class="field-icon">📍</span>
        <div class="field-content"><label>Kota Tujuan</label>
          <input type="text" name="city" id="activityCity" placeholder="Surabaya, Jawa Timur" value="Surabaya" readonly style="cursor:pointer;"></div>
      </div>
      <div class="search-row">
        <div class="search-field half"><span class="field-icon">📅</span><div class="field-content"><label>Tanggal</label>
          <input type="date" name="date" id="activityDate" value="<?=$tomorrow?>" min="<?=$today?>"></div></div>
        <div class="search-field half"><span class="field-icon">🎭</span><div class="field-content"><label>Kategori</label>
          <select name="category"><option>Semua</option><option>Wisata Sejarah</option><option>Food Tour</option><option>Bahari</option><option>Hiburan</option></select>
        </div></div>
      </div>
      <button type="submit" class="btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        Cari Aktivitas
      </button>
    </form>
  </div>
</section>

<!-- PROMO BANNERS -->
<div class="section-wrap" style="padding-top:4px;">
  <div class="section-header">
    <span class="section-title">Penawaran Spesial</span>
    <span class="see-all">Semua →</span>
  </div>
  <div class="promo-scroll">
    <div class="promo-track">
      <div class="promo-card">
        <div class="promo-bg" style="background:linear-gradient(135deg,#A8D8C8,#7B9FD4)"></div>
        <div class="promo-body">
          <div>
            <div class="promo-title">Diskon 30%</div>
            <div class="promo-desc">Hotel bintang 4 &amp; 5 pilihan</div>
          </div>
          <span class="promo-badge">HEMAT30</span>
        </div>
      </div>
      <div class="promo-card">
        <div class="promo-bg" style="background:linear-gradient(135deg,#B8CCEF,#A8D8E8)"></div>
        <div class="promo-body">
          <div>
            <div class="promo-title">Tiket Pesawat Murah</div>
            <div class="promo-desc">Mulai Rp 99.000 ke semua rute</div>
          </div>
          <span class="promo-badge" style="color:#5A8EC8;">TERBANG</span>
        </div>
      </div>
      <div class="promo-card">
        <div class="promo-bg" style="background:linear-gradient(135deg,#B5E2D8,#A8D8C8)"></div>
        <div class="promo-body">
          <div>
            <div class="promo-title">Aktivitas Seru</div>
            <div class="promo-desc">Gratis untuk 2 orang pertama</div>
          </div>
          <span class="promo-badge" style="color:#5BB896;">FUN2FREE</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FILTER CHIPS -->
<div style="padding:0 20px 4px;">
  <div class="filter-chips" id="homeFilterChips">
    <button class="chip active" onclick="homeFilter('all',this)">Semua</button>
    <button class="chip" onclick="homeFilter('budget',this)">💰 Budget</button>
    <button class="chip" onclick="homeFilter('top',this)">⭐ Top Rated</button>
    <button class="chip" onclick="homeFilter('pool',this)">🏊 Kolam Renang</button>
    <button class="chip" onclick="homeFilter('breakfast',this)">🍳 Sarapan</button>
    <button class="chip" onclick="homeFilter('freecancel',this)">🆓 Free Cancel</button>
  </div>
</div>

<!-- HOTEL LIST -->
<section class="section-wrap" id="hotelSection">
  <div class="section-header">
    <span class="section-title">🏨 Hotel Terbaik</span>
    <a href="results.php" class="see-all">Lihat Semua →</a>
  </div>
  <div class="hotel-list" id="hotelList">
    <?php foreach($HOTELS as $h):
      $fp = $h['base_price'] + $h['base_price']*$h['tax_rate'] + $h['service_fee'];
      $is_budget  = $h['base_price'] <= 300000 ? 'true' : 'false';
      $is_top     = $h['rating'] >= 9.0 ? 'true' : 'false';
      $has_pool   = in_array('Kolam Renang',$h['amenities']) ? 'true' : 'false';
      $has_bfast  = in_array('Sarapan',$h['amenities']) ? 'true' : 'false';
      $freecancel = strpos($h['cancel_policy'],'Gratis batalkan') !== false ? 'true' : 'false';
    ?>
    <a href="hotel.php?id=<?=$h['id']?>" class="hotel-card"
       data-budget="<?=$is_budget?>" data-top="<?=$is_top?>"
       data-pool="<?=$has_pool?>" data-breakfast="<?=$has_bfast?>" data-freecancel="<?=$freecancel?>">
      <div class="hotel-img-wrap">
        <div class="hotel-img-bg" style="background:<?=$h['grad']?>"><span style="font-size:72px;opacity:.3;"><?=$h['img_emoji']?></span></div>
        <div class="hotel-img-overlay"></div>
        <span class="hotel-badge"><?=$h['badge']?></span>
        <div class="hotel-stars"><?=str_repeat('★',$h['stars'])?></div>
      </div>
      <div class="hotel-body">
        <div class="hotel-row1">
          <div>
            <div class="hotel-name"><?=$h['name']?></div>
            <div class="hotel-loc">📍 <?=$h['location']?> · <?=$h['dist']?></div>
          </div>
          <div style="text-align:right">
            <div class="rating-badge"><?=$h['rating']?></div>
            <div class="rating-label"><?=rating_label($h['rating'])?></div>
            <div class="rating-label"><?=number_format($h['reviews'])?> ulasan</div>
          </div>
        </div>
        <div class="pills-row">
          <?php foreach(array_slice($h['amenities'],0,3) as $a): ?><span class="pill"><?=$a?></span><?php endforeach; ?>
        </div>
        <div class="price-row-card">
          <div class="price-tag">
            <span class="label">✓ Sudah incl. pajak</span>
            <span class="amount"><?=rp($fp)?><span class="per">/malam</span></span>
          </div>
          <div class="btn-ghost">Lihat →</div>
        </div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- FLIGHTS SECTION -->
<section class="section-wrap" style="padding-top:4px;">
  <div class="section-header">
    <span class="section-title">✈️ Penerbangan Populer</span>
    <a href="flights.php" class="see-all">Semua →</a>
  </div>
  <?php foreach(array_slice($FLIGHTS,0,2) as $f): ?>
  <a href="flights.php" class="flight-card">
    <div class="flight-head">
      <div>
        <div class="airline-name"><?=$f['logo']?> <?=$f['airline']?></div>
        <div class="flight-class"><?=$f['class']?></div>
      </div>
      <div class="airline-logo"><?=$f['logo']?></div>
    </div>
    <div class="flight-body">
      <div class="flight-route">
        <div class="route-end">
          <div class="code"><?=$f['from']?></div>
          <div class="city"><?=$f['from_city']?></div>
          <div class="time"><?=$f['dep']?></div>
        </div>
        <div class="route-mid">
          <div class="route-line">
            <div class="route-dot"></div>
            <div class="route-dash"></div>
            <div class="route-plane">✈</div>
            <div class="route-dash"></div>
            <div class="route-dot"></div>
          </div>
          <div class="route-dur"><?=$f['duration']?></div>
          <div class="route-stops"><?=$f['stops']?></div>
        </div>
        <div class="route-end" style="text-align:right">
          <div class="code"><?=$f['to']?></div>
          <div class="city"><?=$f['to_city']?></div>
          <div class="time"><?=$f['arr']?></div>
        </div>
      </div>
      <div class="flight-footer">
        <div class="flight-seats">🔥 <?=$f['seats']?> kursi tersisa</div>
        <div>
          <div class="flight-price"><?=rp($f['price'])?></div>
          <div class="flight-price-sub">per orang</div>
        </div>
      </div>
    </div>
  </a>
  <?php endforeach; ?>
</section>

<!-- ACTIVITIES SECTION -->
<section class="section-wrap" style="padding-top:4px;">
  <div class="section-header">
    <span class="section-title">🎯 Aktivitas Seru</span>
    <a href="activities.php" class="see-all">Semua →</a>
  </div>
  <?php foreach(array_slice($ACTIVITIES,0,2) as $act): ?>
  <a href="activities.php" class="activity-card">
    <div class="activity-img" style="background:<?=$act['grad']?>">
      <div class="activity-overlay"></div>
      <span class="activity-emoji"><?=$act['img_emoji']?></span>
      <span class="activity-cat"><?=$act['category']?></span>
    </div>
    <div class="activity-body">
      <div class="activity-name"><?=$act['name']?></div>
      <div class="activity-loc">📍 <?=$act['location']?></div>
      <div class="activity-meta">
        <span class="activity-dur">⏱ <?=$act['duration']?></span>
        <div class="rating-badge" style="font-size:12px;padding:3px 8px;"><?=$act['rating']?></div>
        <span style="font-size:10px;color:var(--c-text3);font-weight:700;"><?=number_format($act['reviews'])?> ulasan</span>
      </div>
      <div class="activity-footer">
        <div>
          <div class="activity-price"><?=rp($act['price'])?></div>
          <div class="activity-price-sub">per orang</div>
        </div>
        <div class="btn-ghost">Pesan →</div>
      </div>
    </div>
  </a>
  <?php endforeach; ?>
</section>

<!-- ══════════════════════════════════════
     CITY PICKER MODAL
══════════════════════════════════════ -->
<div class="modal-overlay" id="cityModal" onclick="closeCityModal()">
  <div class="modal-sheet" onclick="event.stopPropagation()" style="max-height:85vh;display:flex;flex-direction:column;">
    <div class="modal-handle"></div>
    <div class="modal-title" id="cityModalTitle">Pilih Kota</div>
    <!-- Search bar -->
    <div style="padding:0 0 12px;">
      <div style="display:flex;align-items:center;gap:10px;background:rgba(255,255,255,0.7);border:1.5px solid rgba(0,0,0,0.1);border-radius:14px;padding:10px 14px;">
        <svg width="16" height="16" fill="none" stroke="var(--c-text3)" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input type="text" id="citySearch" placeholder="Cari kota..." oninput="filterCities()"
          style="border:none;background:transparent;outline:none;width:100%;font-size:14px;font-family:var(--f);font-weight:500;color:var(--c-text);">
      </div>
    </div>
    <!-- City list -->
    <div id="cityList" style="overflow-y:auto;flex:1;display:flex;flex-direction:column;gap:4px;padding-right:2px;"></div>
  </div>
</div>

<!-- PROFILE MODAL -->
<div class="modal-overlay" id="profileModal" onclick="closeModal('profileModal')">
  <div class="modal-sheet" onclick="event.stopPropagation()">
    <div class="modal-handle"></div>
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
      <div style="width:52px;height:52px;border-radius:50%;background:var(--a-grad2);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:900;color:#fff;flex-shrink:0;">
        <?=strtoupper(substr($_SESSION['saved_guest']['name'],0,1))?>
      </div>
      <div>
        <div style="font-size:16px;font-weight:800;letter-spacing:-0.3px;"><?=$_SESSION['saved_guest']['name']?></div>
        <div style="font-size:12px;color:var(--c-text3);margin-top:1px;"><?=$_SESSION['saved_guest']['email']?></div>
      </div>
    </div>
    <a href="orders.php" class="btn-primary" style="margin-bottom:10px;display:flex;">📋 Pesanan Saya</a>
    <a href="profile.php" class="btn-outline">👤 Lihat Profil Lengkap</a>
  </div>
</div>

<?=nav('index')?>
<script src="assets/app.js"></script>
<script>
// ── Indonesian cities with IATA codes ──
const CITIES_HOTEL = [
  {name:'Surabaya',sub:'Jawa Timur',code:'SUB'},
  {name:'Jakarta',sub:'DKI Jakarta',code:'CGK'},
  {name:'Bali',sub:'Bali',code:'DPS'},
  {name:'Bandung',sub:'Jawa Barat',code:'BDO'},
  {name:'Yogyakarta',sub:'DI Yogyakarta',code:'JOG'},
  {name:'Medan',sub:'Sumatera Utara',code:'KNO'},
  {name:'Makassar',sub:'Sulawesi Selatan',code:'UPG'},
  {name:'Semarang',sub:'Jawa Tengah',code:'SRG'},
  {name:'Palembang',sub:'Sumatera Selatan',code:'PLM'},
  {name:'Manado',sub:'Sulawesi Utara',code:'MDC'},
  {name:'Balikpapan',sub:'Kalimantan Timur',code:'BPN'},
  {name:'Lombok',sub:'Nusa Tenggara Barat',code:'LOP'},
  {name:'Batam',sub:'Kepulauan Riau',code:'BTH'},
  {name:'Pekanbaru',sub:'Riau',code:'PKU'},
  {name:'Solo',sub:'Jawa Tengah',code:'SOC'},
  {name:'Malang',sub:'Jawa Timur',code:'MLG'},
  {name:'Pontianak',sub:'Kalimantan Barat',code:'PNK'},
  {name:'Jayapura',sub:'Papua',code:'DJJ'},
  {name:'Ambon',sub:'Maluku',code:'AMQ'},
  {name:'Kupang',sub:'Nusa Tenggara Timur',code:'KOE'},
];
const CITIES_FLIGHT = [...CITIES_HOTEL];
const CITIES_ACTIVITY = CITIES_HOTEL.map(c=>({name:c.name,sub:c.sub,code:c.code}));

let cityModalTarget = null;
let allCities = [];
let showCode = false;

function openCityModal(target) {
  cityModalTarget = target;
  const titles = {
    hotel: 'Pilih Kota Tujuan Hotel',
    flight_from: 'Pilih Kota Asal Penerbangan',
    flight_to: 'Pilih Kota Tujuan Penerbangan',
    activity: 'Pilih Kota Aktivitas'
  };
  document.getElementById('cityModalTitle').textContent = titles[target] || 'Pilih Kota';
  showCode = (target === 'flight_from' || target === 'flight_to');
  allCities = showCode ? CITIES_FLIGHT : (target === 'activity' ? CITIES_ACTIVITY : CITIES_HOTEL);
  document.getElementById('citySearch').value = '';
  renderCities(allCities);
  toggleModal('cityModal');
}

function closeCityModal() { closeModal('cityModal'); }

function renderCities(cities) {
  const list = document.getElementById('cityList');
  list.innerHTML = cities.map(c => {
    const codeSpan = showCode ? `<span style="font-size:12px;font-weight:800;color:var(--a-main2);background:rgba(123,159,212,0.15);padding:3px 8px;border-radius:8px;margin-left:6px;">${c.code}</span>` : '';
    return `<div onclick="selectCity(${JSON.stringify(c).replace(/"/g,'&quot;')})" style="display:flex;align-items:center;justify-content:space-between;padding:13px 14px;border-radius:14px;background:rgba(255,255,255,0.65);border:1.5px solid rgba(255,255,255,0.85);cursor:pointer;transition:background .1s;" onmousedown="this.style.background='rgba(168,216,200,0.35)'" onmouseup="this.style.background='rgba(255,255,255,0.65)'" ontouchstart="this.style.background='rgba(168,216,200,0.35)'" ontouchend="this.style.background='rgba(255,255,255,0.65)'">
      <div>
        <div style="font-size:14px;font-weight:700;letter-spacing:-0.2px;">${c.name}</div>
        <div style="font-size:11px;color:var(--c-text3);margin-top:1px;">${c.sub}</div>
      </div>
      ${codeSpan}
    </div>`;
  }).join('');
}

function filterCities() {
  const q = document.getElementById('citySearch').value.toLowerCase();
  renderCities(allCities.filter(c => c.name.toLowerCase().includes(q) || c.sub.toLowerCase().includes(q) || c.code.toLowerCase().includes(q)));
}

function selectCity(c) {
  if (cityModalTarget === 'hotel') {
    document.getElementById('hotelCity').value = c.name;
  } else if (cityModalTarget === 'flight_from') {
    document.getElementById('flightFrom').value = c.code + ' - ' + c.name;
    document.getElementById('flightFromCode').value = c.code;
  } else if (cityModalTarget === 'flight_to') {
    document.getElementById('flightTo').value = c.code + ' - ' + c.name;
    document.getElementById('flightToCode').value = c.code;
  } else if (cityModalTarget === 'activity') {
    document.getElementById('activityCity').value = c.name;
  }
  closeCityModal();
}

// ── Date restrictions ──
const today = new Date(); today.setHours(0,0,0,0);
function toDateStr(d) { return d.toISOString().split('T')[0]; }

function enforceHotelDates() {
  const ci = document.getElementById('hotelCheckin');
  const co = document.getElementById('hotelCheckout');
  // checkin must be >= today
  if (ci.value < toDateStr(today)) ci.value = toDateStr(today);
  // checkout must be at least checkin + 1 day
  const minCo = new Date(ci.value); minCo.setDate(minCo.getDate()+1);
  co.min = toDateStr(minCo);
  if (co.value < toDateStr(minCo)) co.value = toDateStr(minCo);
}
// Run on load
enforceHotelDates();

// ── Homepage filter chips ──
function homeFilter(type, btn) {
  document.querySelectorAll('#homeFilterChips .chip').forEach(c => c.classList.remove('active'));
  btn.classList.add('active');
  const cards = document.querySelectorAll('#hotelList .hotel-card');
  cards.forEach(card => {
    let show = false;
    if (type === 'all')        show = true;
    else if (type === 'budget')     show = card.dataset.budget === 'true';
    else if (type === 'top')        show = card.dataset.top === 'true';
    else if (type === 'pool')       show = card.dataset.pool === 'true';
    else if (type === 'breakfast')  show = card.dataset.breakfast === 'true';
    else if (type === 'freecancel') show = card.dataset.freecancel === 'true';
    card.style.display = show ? 'block' : 'none';
  });
}
</script>
</body></html>
