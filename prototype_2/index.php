<?php
session_start();
require '_data.php';
require '_head.php';
if(!isset($_SESSION['saved_guest'])) $_SESSION['saved_guest']=['name'=>'Budi Santoso','email'=>'budi@email.com','phone'=>'+62 812-3456-7890'];
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>agoda — Hotel, Pesawat & Aktivitas</title><?=$font?><?=$css?>
</head><body>

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
    <form class="search-form" method="GET" action="results.php" id="hotelSearchForm">
      <div class="search-field">
        <span class="field-icon">📍</span>
        <div class="field-content"><label>Tujuan</label><input type="text" name="location" placeholder="Surabaya, Jawa Timur" value="Surabaya"></div>
      </div>
      <div class="search-row">
        <div class="search-field half">
          <span class="field-icon">📅</span>
          <div class="field-content">
            <label>Check-in</label>
            <input type="date" name="checkin" id="hotelCheckin" value="<?=date('Y-m-d',strtotime('+1 day'))?>" min="<?=date('Y-m-d')?>">
          </div>
        </div>
        <div class="search-field half">
          <span class="field-icon">📅</span>
          <div class="field-content">
            <label>Check-out</label>
            <input type="date" name="checkout" id="hotelCheckout" value="<?=date('Y-m-d',strtotime('+3 days'))?>" min="<?=date('Y-m-d',strtotime('+2 days'))?>">
          </div>
        </div>
      </div>
      <div class="search-field">
        <span class="field-icon">👤</span>
        <div class="field-content"><label>Tamu & Kamar</label>
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
    <form class="search-form" method="GET" action="flights.php" id="flightSearchForm">
      <div class="search-row">
        <div class="search-field half" onclick="openFlightCityModal('from')" style="cursor: pointer;">
          <span class="field-icon">🛫</span>
          <div class="field-content">
            <label>Dari</label>
            <input type="text" name="from" placeholder="SUB - Surabaya" value="Surabaya" readonly style="background:transparent;cursor:pointer;font-weight:700;">
          </div>
        </div>
        <div class="search-field half" onclick="openFlightCityModal('to')" style="cursor: pointer;">
          <span class="field-icon">🛬</span>
          <div class="field-content">
            <label>Ke</label>
            <input type="text" name="to" placeholder="CGK - Jakarta" value="Jakarta" readonly style="background:transparent;cursor:pointer;font-weight:700;">
          </div>
        </div>
      </div>
      <div class="search-row">
        <div class="search-field half">
          <span class="field-icon">📅</span>
          <div class="field-content">
            <label>Berangkat</label>
            <input type="date" name="dep_date" value="<?=date('Y-m-d',strtotime('+1 day'))?>" min="<?=date('Y-m-d')?>">
          </div>
        </div>
        <div class="search-field half">
          <span class="field-icon">👤</span>
          <div class="field-content">
            <label>Penumpang</label>
            <select name="pax">
              <option>1 Dewasa</option>
              <option>2 Dewasa</option>
              <option>3 Dewasa</option>
              <option>4 Dewasa</option>
              <option>5 Dewasa</option>
            </select>
          </div>
        </div>
      </div>
      <button type="submit" class="btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        Cari Penerbangan
      </button>
    </form>
  </div>

  <!-- ACTIVITY SEARCH -->
  <div id="tab-activity" class="tab-content search-card glass" style="display:none;flex-direction:column;gap:0;">
    <form class="search-form" method="GET" action="activities.php">
      <div class="search-field">
        <span class="field-icon">📍</span>
        <div class="field-content"><label>Kota Tujuan</label><input type="text" name="city" placeholder="Surabaya, Jawa Timur" value="Surabaya"></div>
      </div>
      <div class="search-row">
        <div class="search-field half">
          <span class="field-icon">📅</span>
          <div class="field-content">
            <label>Tanggal</label>
            <input type="date" name="date" value="<?=date('Y-m-d',strtotime('+1 day'))?>" min="<?=date('Y-m-d')?>">
          </div>
        </div>
        <div class="search-field half">
          <span class="field-icon">🎭</span>
          <div class="field-content">
            <label>Kategori</label>
            <select name="category">
              <option>Semua</option>
              <option>Wisata Sejarah</option>
              <option>Food Tour</option>
              <option>Bahari</option>
              <option>Hiburan</option>
            </select>
          </div>
        </div>
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
        <div class="promo-bg" style="background:linear-gradient(135deg,#E2196F,#FF6B35)"></div>
        <div class="promo-body">
          <div>
            <div class="promo-title">Diskon 30%</div>
            <div class="promo-desc">Hotel bintang 4 & 5 pilihan</div>
          </div>
          <span class="promo-badge">HEMAT30</span>
        </div>
      </div>
      <div class="promo-card">
        <div class="promo-bg" style="background:linear-gradient(135deg,#0288D1,#26C6DA)"></div>
        <div class="promo-body">
          <div>
            <div class="promo-title">Tiket Pesawat Murah</div>
            <div class="promo-desc">Mulai Rp 99.000 ke semua rute</div>
          </div>
          <span class="promo-badge" style="color:#0288D1;">TERBANG</span>
        </div>
      </div>
      <div class="promo-card">
        <div class="promo-bg" style="background:linear-gradient(135deg,#00B87A,#26D0CE)"></div>
        <div class="promo-body">
          <div>
            <div class="promo-title">Aktivitas Seru</div>
            <div class="promo-desc">Gratis untuk 2 orang pertama</div>
          </div>
          <span class="promo-badge" style="color:#00B87A;">FUN2FREE</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FILTER CHIPS -->
<div style="padding:0 20px 4px;">
  <div class="filter-chips">
    <button class="chip active" onclick="chipSelect(this)">Semua</button>
    <button class="chip" onclick="chipSelect(this)">💰 Budget</button>
    <button class="chip" onclick="chipSelect(this)">⭐ Top Rated</button>
    <button class="chip" onclick="chipSelect(this)">🏊 Kolam Renang</button>
    <button class="chip" onclick="chipSelect(this)">🍳 Sarapan</button>
    <button class="chip" onclick="chipSelect(this)">🆓 Free Cancel</button>
  </div>
</div>

<!-- HOTEL LIST -->
<section class="section-wrap">
  <div class="section-header">
    <span class="section-title">🏨 Hotel Terbaik</span>
    <a href="results.php" class="see-all">Lihat Semua →</a>
  </div>
  <div class="hotel-list">
    <?php foreach($HOTELS as $h):
      $fp = $h['base_price'] + $h['base_price']*$h['tax_rate'] + $h['service_fee'];
    ?>
    <a href="hotel.php?id=<?=$h['id']?>" class="hotel-card">
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

<!-- PROFILE MODAL -->
<div class="modal-overlay" id="profileModal" onclick="closeModal('profileModal')">
  <div class="modal-sheet" onclick="event.stopPropagation()">
    <div class="modal-handle"></div>
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
      <div style="width:52px;height:52px;border-radius:50%;background:var(--a-grad);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:900;color:#fff;flex-shrink:0;">
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

<!-- City Selection Modal -->
<div class="city-modal-overlay" id="flightCityModal">
  <div class="city-modal-sheet" onclick="event.stopPropagation()">
    <div class="city-modal-handle"></div>
    <div style="font-size: 18px; font-weight: 800; margin-bottom: 16px;" id="flightModalTitle">Pilih Kota Asal</div>
    
    <div style="position: relative; margin-bottom: 20px;">
      <input type="text" id="flightCitySearch" placeholder="Cari kota atau bandara..." 
             style="width:100%; padding: 14px; border-radius: 14px; border: 1.5px solid rgba(0,0,0,0.1); font-size: 14px; font-family: var(--f);">
      <div id="flightAutocompleteResults" class="autocomplete-results"></div>
    </div>
    
    <div style="font-size: 11px; color: var(--c-text3); font-weight: 700; margin-bottom: 12px;">✈️ Kota Populer</div>
    <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;" id="flightPopularCities"></div>
    
    <div style="font-size: 11px; color: var(--c-text3); font-weight: 700; margin-bottom: 12px;">🌍 Semua Kota</div>
    <div id="flightAllCities" style="max-height: 300px; overflow-y: auto;"></div>
  </div>
</div>

<?=nav('index')?>
<?=$js?>

<script>
// Initialize flight city modal with data
const flightCitiesData = <?= json_encode($INDONESIA_CITIES) ?>;
initFlightCityModal(flightCitiesData);

console.log('✅ Page loaded, switchTab available:', typeof switchTab === 'function');
</script>
</body></html>