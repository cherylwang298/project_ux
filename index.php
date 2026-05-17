<?php
session_start();
require '_data.php';
require '_head.php';
if(!isset($_SESSION['saved_guest'])) $_SESSION['saved_guest']=['name'=>'Ceri Wijaya','email'=>'ceri@email.com','phone'=>'+62 812-3456-7890'];
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>StayEase</title><?=$font?><?=$css?>
</head><body>

<header class="app-header">
  <div class="header-inner">
    <div class="logo"><div class="logo-mark">S</div><span class="logo-text">StayEase</span></div>
    <button class="icon-btn" onclick="toggleModal('profileModal')">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </button>
  </div>
</header>

<section class="hero-section">
  <div class="hero-tag">✦ Harga sudah termasuk pajak</div>
  <h1 class="hero-title">Temukan Hotel<br><span>Impianmu</span></h1>
  <p class="hero-sub">✓ Transparan · Tanpa biaya tersembunyi</p>

  <div class="search-card glass">
    <form class="search-form" method="GET" action="results.php">
      <div class="search-field">
        <span class="field-icon">📍</span>
        <div class="field-content"><label>Tujuan</label><input type="text" name="location" placeholder="Surabaya, Jawa Timur" value="Surabaya"></div>
      </div>
      <div class="search-row">
        <div class="search-field half"><span class="field-icon">📅</span><div class="field-content"><label>Check-in</label><input type="date" name="checkin" value="<?=date('Y-m-d',strtotime('+1 day'))?>"></div></div>
        <div class="search-field half"><span class="field-icon">📅</span><div class="field-content"><label>Check-out</label><input type="date" name="checkout" value="<?=date('Y-m-d',strtotime('+3 days'))?>"></div></div>
      </div>
      <div class="search-field">
        <span class="field-icon">👤</span>
        <div class="field-content"><label>Tamu</label><select name="guests"><option>1 Tamu, 1 Kamar</option><option>2 Tamu, 1 Kamar</option><option>3 Tamu, 2 Kamar</option></select></div>
      </div>
      <button type="submit" class="btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        Cari Hotel
      </button>
    </form>
  </div>
</section>

<div class="quick-filter-bar">
  <div class="filter-chips">
    <button class="chip active" onclick="chipSelect(this)">Semua</button>
    <button class="chip" onclick="chipSelect(this)">💰 Budget</button>
    <button class="chip" onclick="chipSelect(this)">⭐ Top Rated</button>
    <button class="chip" onclick="chipSelect(this)">🏊 Pool</button>
    <button class="chip" onclick="chipSelect(this)">🍳 Sarapan</button>
  </div>
</div>

<section class="section-wrap">
  <div class="section-header">
    <span class="section-title">Pilihan Terbaik</span>
    <a href="results.php" class="see-all">Lihat Semua →</a>
  </div>
  <div class="hotel-list">
    <?php foreach($HOTELS as $h):
      $fp = $h['base_price'] + $h['base_price']*$h['tax_rate'] + $h['service_fee'];
    ?>
    <a href="hotel.php?id=<?=$h['id']?>" class="hotel-card">
      <div class="hotel-img-wrap">
        <div class="hotel-img-bg" style="background:<?=$h['grad']?>"></div>
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
          <div style="text-align:center">
            <div class="rating-badge"><?=$h['rating']?></div>
            <span class="rating-count"><?=number_format($h['reviews'])?></span>
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

<!-- Profile bottom sheet -->
<div class="modal-overlay" id="profileModal" onclick="closeModal('profileModal')">
  <div class="modal-sheet" onclick="event.stopPropagation()">
    <div class="modal-handle"></div>
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px;">
      <div style="width:50px;height:50px;border-radius:50%;background:linear-gradient(135deg,#5B5FEF,#7C3AED);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;color:#fff;flex-shrink:0;"><?=strtoupper(substr($_SESSION['saved_guest']['name'],0,1))?></div>
      <div>
        <div style="font-size:16px;font-weight:700;letter-spacing:-0.3px;"><?=$_SESSION['saved_guest']['name']?></div>
        <div style="font-size:12px;color:var(--c-text3);margin-top:1px;"><?=$_SESSION['saved_guest']['email']?></div>
      </div>
    </div>
    <a href="orders.php" class="btn-primary" style="margin-bottom:10px;display:flex;">📋 Pesanan Saya</a>
    <a href="profile.php" class="btn-outline">👤 Lihat Profil Lengkap</a>
  </div>
</div>

<?=nav('index')?>
<script src="assets/app.js"></script>
</body></html>
