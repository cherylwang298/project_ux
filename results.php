<?php
// results.php
session_start();
require '_data.php';
require '_head.php';
$location=$_GET['location']??'Surabaya';
$checkin=$_GET['checkin']??date('Y-m-d',strtotime('+1 day'));
$checkout=$_GET['checkout']??date('Y-m-d',strtotime('+3 days'));
$nights=max(1,(strtotime($checkout)-strtotime($checkin))/86400);
$sort=$_GET['sort']??'recommended';
$budget=(int)($_GET['budget']??0);
$minr=(float)($_GET['min_rating']??0);
$list=$HOTELS;
if($budget>0) $list=array_filter($list,fn($h)=>$h['base_price']<=$budget);
if($minr>0)   $list=array_filter($list,fn($h)=>$h['rating']>=$minr);
if($sort==='price_asc')  usort($list,fn($a,$b)=>$a['base_price']-$b['base_price']);
if($sort==='price_desc') usort($list,fn($a,$b)=>$b['base_price']-$a['base_price']);
if($sort==='rating')     usort($list,fn($a,$b)=>$b['rating']<=>$a['rating']);
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Hasil Pencarian — StayEase</title><?=$font?><?=$css?>
</head><body>
<header class="app-header">
  <div class="header-inner">
    <a href="index.php" class="back-btn" style="position:static;width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.7);border:1px solid rgba(255,255,255,0.8);backdrop-filter:blur(12px);display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:var(--c-text);box-shadow:var(--sh-sm);">←</a>
    <div style="flex:1;text-align:center;"><div style="font-size:14px;font-weight:700;letter-spacing:-0.3px;"><?=htmlspecialchars($location)?></div><div style="font-size:10px;color:var(--c-text3);"><?=fds($checkin)?> – <?=fds($checkout)?> · <?=$nights?> malam</div></div>
    <button class="icon-btn" onclick="toggleModal('filterSheet')">⚙️</button>
  </div>
</header>
<div class="page-content">
  <div class="filter-chips" style="padding:0 0 14px;">
    <a href="?location=<?=urlencode($location)?>&checkin=<?=$checkin?>&checkout=<?=$checkout?>&sort=recommended" class="chip <?=$sort==='recommended'?'active':''?>">✦ Rekomendasi</a>
    <a href="?location=<?=urlencode($location)?>&checkin=<?=$checkin?>&checkout=<?=$checkout?>&sort=price_asc" class="chip <?=$sort==='price_asc'?'active':''?>">💰 Termurah</a>
    <a href="?location=<?=urlencode($location)?>&checkin=<?=$checkin?>&checkout=<?=$checkout?>&sort=rating" class="chip <?=$sort==='rating'?'active':''?>">⭐ Rating</a>
    <a href="?location=<?=urlencode($location)?>&checkin=<?=$checkin?>&checkout=<?=$checkout?>&budget=500000" class="chip <?=$budget==500000?'active':''?>">🏷️ &lt;500rb</a>
  </div>
  <div style="font-size:12px;color:var(--c-text2);font-weight:500;margin-bottom:14px;"><?=count($list)?> hotel ditemukan</div>
  <div class="hotel-list">
    <?php foreach($list as $h):$fp=$h['base_price']+$h['base_price']*$h['tax_rate']+$h['service_fee']; ?>
    <a href="hotel.php?id=<?=$h['id']?>&checkin=<?=$checkin?>&checkout=<?=$checkout?>" class="hotel-card">
      <div class="hotel-img-wrap">
        <div class="hotel-img-bg" style="background:<?=$h['grad']?>"></div>
        <div class="hotel-img-overlay"></div>
        <span class="hotel-badge"><?=$h['badge']?></span>
        <div class="hotel-stars"><?=str_repeat('★',$h['stars'])?></div>
      </div>
      <div class="hotel-body">
        <div class="hotel-row1">
          <div><div class="hotel-name"><?=$h['name']?></div><div class="hotel-loc">📍 <?=$h['location']?> · <?=$h['dist']?></div></div>
          <div style="text-align:center"><div class="rating-badge"><?=$h['rating']?></div><span class="rating-count"><?=number_format($h['reviews'])?></span></div>
        </div>
        <div class="pills-row"><?php foreach(array_slice($h['amenities'],0,3) as $a): ?><span class="pill"><?=$a?></span><?php endforeach; ?></div>
        <div style="font-size:10px;color:var(--c-green);font-weight:600;margin-bottom:8px;">📋 <?=$h['cancel_policy']?></div>
        <div class="price-row-card">
          <div class="price-tag"><span class="label">✓ Sudah incl. pajak</span><span class="amount"><?=rp($fp)?><span class="per">/malam</span></span></div>
          <div class="btn-ghost">Pilih →</div>
        </div>
      </div>
    </a>
    <?php endforeach; ?>
    <?php if(empty($list)): ?>
    <div style="text-align:center;padding:48px 0;"><div style="font-size:48px;margin-bottom:12px;">🔍</div><div style="font-size:16px;font-weight:700;">Tidak ada hasil</div><p style="color:var(--c-text2);margin-top:8px;font-size:13px;">Coba ubah filter</p></div>
    <?php endif; ?>
  </div>
</div>

<!-- Advanced filter -->
<div class="modal-overlay filter-sheet" id="filterSheet" onclick="closeModal('filterSheet')">
  <div class="modal-sheet" onclick="event.stopPropagation()">
    <div class="modal-handle"></div>
    <div class="modal-title">Filter Lanjutan</div>
    <form method="GET">
      <input type="hidden" name="location" value="<?=htmlspecialchars($location)?>">
      <input type="hidden" name="checkin" value="<?=$checkin?>">
      <input type="hidden" name="checkout" value="<?=$checkout?>">
      <div class="filter-group">
        <div class="filter-group-title">Budget Maks / Malam</div>
        <div class="range-val" id="bLabel">Rp 1.500.000</div>
        <input type="range" name="budget" min="200000" max="1500000" step="50000" value="1500000" oninput="document.getElementById('bLabel').textContent='Rp '+Number(this.value).toLocaleString('id-ID')">
      </div>
      <div class="filter-group">
        <div class="filter-group-title">Rating Minimum</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
          <?php foreach([0,3.5,4.0,4.5] as $r): ?>
          <label style="display:flex;align-items:center;gap:6px;padding:8px 14px;border-radius:20px;border:1px solid rgba(0,0,0,0.1);background:rgba(255,255,255,0.6);cursor:pointer;font-size:12px;font-weight:600;"><input type="radio" name="min_rating" value="<?=$r?>" <?=$r==0?'checked':''?> style="accent-color:var(--c-accent)"> <?=$r==0?'Semua':'⭐ '.$r.'+'?></label>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="filter-group">
        <div class="filter-group-title">Urutkan</div>
        <?php foreach(['recommended'=>'✦ Rekomendasi','price_asc'=>'💰 Termurah','price_desc'=>'💸 Termahal','rating'=>'⭐ Rating'] as $v=>$l): ?>
        <label class="sort-opt"><input type="radio" name="sort" value="<?=$v?>" <?=$sort===$v?'checked':''?>><?=$l?></label>
        <?php endforeach; ?>
      </div>
      <button type="submit" class="btn-primary">Terapkan</button>
    </form>
  </div>
</div>

<?=nav('search')?>
<script src="assets/app.js"></script>
</body></html>
