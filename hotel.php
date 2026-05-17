<?php
session_start();
require '_data.php';
require '_head.php';
$id = (int)($_GET['id']??1);
$h = $HOTELS[array_search($id,array_column($HOTELS,'id'))];
$checkin  = $_GET['checkin']  ?? date('Y-m-d',strtotime('+1 day'));
$checkout = $_GET['checkout'] ?? date('Y-m-d',strtotime('+3 days'));
$nights   = max(1,(strtotime($checkout)-strtotime($checkin))/86400);
$base_tot = $h['base_price'] * $nights;
$tax_tot  = $base_tot * $h['tax_rate'];
$final    = $base_tot + $tax_tot + $h['service_fee'];
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title><?=$h['name']?> — StayEase</title><?=$font?><?=$css?>
</head><body>

<!-- Fullscreen hero image with back btn overlaid -->
<div class="detail-hero">
  <div class="detail-hero-img" style="background:<?=$h['grad']?>;display:flex;align-items:center;justify-content:center;font-size:72px;opacity:.35">🏨</div>
  <div class="detail-overlay"></div>
  <!-- Back button — positioned over hero -->
  <a href="javascript:history.back()" class="back-btn">←</a>
  <div class="share-btn">⬆</div>
  <!-- Badge — small, bottom of image -->
  <span style="position:absolute;bottom:44px;left:20px;background:rgba(0,0,0,0.38);backdrop-filter:blur(8px);color:#fff;font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px;letter-spacing:0.3px;"><?=$h['badge']?></span>
</div>

<div class="detail-body">

  <!-- ── Card 1: Name + rating ── -->
  <div class="detail-title-card glass" style="position:relative;padding-right:72px;">
    <div class="detail-name"><?=$h['name']?></div>
    <div class="detail-stars-row">
      <span class="star-gold"><?=str_repeat('★',$h['stars'])?></span>
      <span class="star-label"><?=$h['stars']?> Bintang</span>
    </div>
    <div class="detail-loc-row">
      <span class="detail-loc">📍 <?=$h['loc_full']?></span>
    </div>
    <div style="margin-top:4px;"><span class="detail-dist">🚶 <?=$h['dist']?></span></div>
    <!-- Rating badge absolute -->
    <div style="position:absolute;top:16px;right:16px;text-align:center;">
      <div class="detail-rating-num"><?=$h['rating']?></div>
      <span style="font-size:9px;color:var(--c-text3);display:block;margin-top:3px;"><?=number_format($h['reviews'])?> ulasan</span>
    </div>
  </div>

  <!-- ── Strip: dates + nights (visual, no clutter) ── -->
  <div class="detail-info-strip glass">
    <div class="strip-item">
      <span class="strip-label">Check-in</span>
      <span class="strip-val"><?=fds($checkin)?></span>
    </div>
    <div class="strip-divider"></div>
    <div class="strip-item">
      <span class="strip-label"><?=$nights?> Malam</span>
      <span class="strip-val">→</span>
    </div>
    <div class="strip-divider"></div>
    <div class="strip-item">
      <span class="strip-label">Check-out</span>
      <span class="strip-val"><?=fds($checkout)?></span>
    </div>
  </div>

  <!-- ── Fasilitas (compact chips, no header bloat) ── -->
  <div style="margin-bottom:12px;">
    <div class="sec-label">Fasilitas</div>
    <div class="amenity-compact">
      <?php foreach($h['amenities'] as $a): ?>
      <span class="amenity-chip"><?=$a?></span>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- ── Cancel policy — small inline tag ── -->
  <div style="margin-bottom:16px;display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
    <span class="cancel-tag">📋 <?=$h['cancel_policy']?></span>
  </div>

  <!-- ── Price breakdown ── -->
  <div class="sec-label">Rincian Harga</div>
  <div class="price-breakdown glass" style="border-radius:var(--r-lg);overflow:hidden;margin-bottom:10px;">
    <div class="price-br-row"><span class="l"><?=rp($h['base_price'])?> × <?=$nights?> malam</span><span class="r"><?=rp($base_tot)?></span></div>
    <div class="price-br-row"><span class="l">Pajak (11%)</span><span class="r"><?=rp($tax_tot)?></span></div>
    <div class="price-br-row"><span class="l">Biaya layanan</span><span class="r"><?=rp($h['service_fee'])?></span></div>
    <div class="price-br-total"><span class="l">Total</span><span class="r"><?=rp($final)?></span></div>
    <div class="incl-note">✓ Tidak ada biaya tambahan saat pembayaran</div>
  </div>

  <!-- ── Reviews (2, compact) ── -->
  <div class="sec-label" style="margin-top:16px;">Ulasan Tamu</div>
  <div class="review-card glass">
    <div class="reviewer-row">
      <div class="reviewer-av" style="background:linear-gradient(135deg,#667eea,#764ba2)">A</div>
      <div><div class="reviewer-name">Andi S.</div><div class="reviewer-date">2 hari lalu · ⭐⭐⭐⭐⭐</div></div>
    </div>
    <p class="review-text">Kamar bersih, staf ramah. Lokasi sangat strategis. Sarapan variatif!</p>
  </div>
  <div class="review-card glass">
    <div class="reviewer-row">
      <div class="reviewer-av" style="background:linear-gradient(135deg,#f093fb,#f5576c)">R</div>
      <div><div class="reviewer-name">Rina M.</div><div class="reviewer-date">5 hari lalu · ⭐⭐⭐⭐</div></div>
    </div>
    <p class="review-text">Pool-nya keren banget. Worth it banget sama harganya!</p>
  </div>

</div>

<!-- Sticky bar — consistent width button -->
<div class="sticky-bar glass-strong">
  <div class="sticky-price-wrap">
    <div class="sticky-tag">✓ Sudah incl. pajak & layanan</div>
    <div class="sticky-amount"><?=rp($final)?></div>
    <div class="sticky-sub"><?=$nights?> malam total</div>
  </div>
  <a href="checkout.php?id=<?=$h['id']?>&checkin=<?=$checkin?>&checkout=<?=$checkout?>&nights=<?=$nights?>&total=<?=$final?>" class="btn-primary" style="width:148px;flex-shrink:0;padding:14px 0;">
    Pesan Sekarang
  </a>
</div>

<script src="assets/app.js"></script>
</body></html>
