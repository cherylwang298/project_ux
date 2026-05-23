<?php
session_start();
require '_data.php';
require '_head.php';
$city = $_GET['city'] ?? 'Surabaya';
$cat  = $_GET['category'] ?? 'Semua';
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Aktivitas & Wisata — agoda</title><?=$font?><?=$css?>
</head><body>

<header class="app-header">
  <div class="header-inner">
    <a href="index.php" class="hb-back">←</a>
    <div style="text-align:center;">
      <div style="font-size:14px;font-weight:800;letter-spacing:-0.3px;">Aktivitas di <?=htmlspecialchars($city)?></div>
      <div style="font-size:10px;color:var(--c-text3);"><?=count($ACTIVITIES)?> aktivitas tersedia</div>
    </div>
    <button class="icon-btn" onclick="toggleModal('filterSheet')">⚙️</button>
  </div>
</header>

<div class="page-content">
  <!-- Category chips -->
  <div class="filter-chips" style="padding:0 0 14px;">
    <button class="chip <?=$cat==='Semua'?'active':''?>" onclick="chipSelect(this)">🎯 Semua</button>
    <button class="chip <?=$cat==='Wisata Sejarah'?'active':''?>" onclick="chipSelect(this)">🏛️ Sejarah</button>
    <button class="chip <?=$cat==='Food Tour'?'active':''?>" onclick="chipSelect(this)">🍜 Kuliner</button>
    <button class="chip <?=$cat==='Wisata Bahari'?'active':''?>" onclick="chipSelect(this)">🚢 Bahari</button>
    <button class="chip <?=$cat==='Hiburan Indoor'?'active':''?>" onclick="chipSelect(this)">🎮 Hiburan</button>
  </div>

  <div style="font-size:12px;color:var(--c-text2);font-weight:600;margin-bottom:14px;"><?=count($ACTIVITIES)?> aktivitas ditemukan</div>

  <?php foreach($ACTIVITIES as $act): ?>
  <div class="activity-card glass" onclick="bookActivity(<?=$act['id']?>)">
    <div class="activity-img" style="background:<?=$act['grad']?>">
      <div class="activity-overlay"></div>
      <span class="activity-emoji"><?=$act['img_emoji']?></span>
      <span class="activity-cat"><?=$act['category']?></span>
      <span class="hotel-badge" style="top:10px;bottom:auto;"><?=$act['badge']?></span>
    </div>
    <div class="activity-body">
      <div class="activity-name"><?=$act['name']?></div>
      <div class="activity-loc">📍 <?=$act['location']?></div>
      <p style="font-size:11px;color:var(--c-text2);line-height:1.55;margin-bottom:8px;"><?=$act['desc']?></p>
      <div class="activity-meta">
        <span class="activity-dur">⏱ <?=$act['duration']?></span>
        <div class="rating-badge" style="font-size:12px;padding:3px 8px;"><?=$act['rating']?></div>
        <span style="font-size:10px;color:var(--c-text3);font-weight:700;"><?=number_format($act['reviews'])?> ulasan</span>
      </div>
      <!-- Includes -->
      <div style="display:flex;flex-wrap:wrap;gap:5px;margin-bottom:10px;">
        <?php foreach($act['includes'] as $inc): ?>
        <span style="font-size:10px;padding:3px 9px;background:var(--c-green-soft);border:1px solid var(--c-green-border);border-radius:20px;color:var(--c-green);font-weight:700;">✓ <?=$inc?></span>
        <?php endforeach; ?>
      </div>
      <div class="activity-footer">
        <div>
          <div class="activity-price"><?=rp($act['price'])?></div>
          <div class="activity-price-sub">per orang · sudah incl. pajak</div>
        </div>
        <button class="btn-primary" style="width:auto;padding:11px 18px;font-size:12px;" onclick="event.stopPropagation();bookActivity(<?=$act['id']?>)">Pesan →</button>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<?=nav('activities')?>
<script src="assets/app.js"></script>
<script>
function bookActivity(id) {
  alert('Pemesanan Aktivitas ID #' + id + '\n\nFitur ini akan mengarahkan ke halaman checkout aktivitas.');
}
</script>
</body></html>