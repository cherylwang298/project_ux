<?php
session_start();
require '_data.php';
require '_head.php';
$id       = (int)($_GET['id'] ?? 1);
$h        = $HOTELS[array_search($id, array_column($HOTELS,'id'))];
$today    = date('Y-m-d');
$checkin  = $_GET['checkin']  ?? date('Y-m-d', strtotime('+1 day'));
$checkout = $_GET['checkout'] ?? date('Y-m-d', strtotime('+3 days'));
// Enforce: checkin >= today
if ($checkin < $today) $checkin = $today;
// Enforce: checkout >= checkin + 1 day
$min_checkout = date('Y-m-d', strtotime($checkin . ' +1 day'));
if ($checkout <= $checkin) $checkout = $min_checkout;
$nights   = max(1, (strtotime($checkout)-strtotime($checkin))/86400);
$base_tot = $h['base_price'] * $nights;
$tax_tot  = $base_tot * $h['tax_rate'];
$final    = $base_tot + $tax_tot + $h['service_fee'];
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title><?=$h['name']?> — agoda</title><?=$font?><?=$css?>
</head><body>
<?=$blobs?>

<!-- HERO IMAGE -->
<div class="detail-hero">
  <div class="detail-hero-img" style="background:<?=$h['grad']?>">
    <span style="font-size:90px;opacity:.28;"><?=$h['img_emoji']?></span>
  </div>
  <div class="detail-overlay"></div>
  <a href="javascript:history.back()" class="back-btn">←</a>
  <div class="share-btn" onclick="shareNow()">⬆</div>
  <span style="position:absolute;bottom:44px;left:20px;background:var(--a-grad2);color:#fff;font-size:10px;font-weight:800;padding:4px 12px;border-radius:20px;letter-spacing:0.3px;"><?=$h['badge']?></span>
</div>

<div class="detail-body">

  <!-- Title card -->
  <div class="detail-title-card glass" style="position:relative;padding-right:72px;">
    <div class="detail-name"><?=$h['name']?></div>
    <div class="detail-stars-row">
      <span class="star-gold"><?=str_repeat('★',$h['stars'])?></span>
      <span class="star-label"><?=$h['stars']?> Bintang · <?=$h['category']?></span>
    </div>
    <div class="detail-loc-row">
      <span class="detail-loc">📍 <?=$h['loc_full']?></span>
    </div>
    <div style="margin-top:4px;"><span class="detail-dist">🚶 <?=$h['dist']?></span></div>
    <p style="font-size:12px;color:var(--c-text2);margin-top:8px;line-height:1.6;font-weight:500;"><?=$h['desc']?></p>
    <!-- Rating -->
    <div style="position:absolute;top:16px;right:16px;text-align:center;">
      <div class="detail-rating-num"><?=$h['rating']?></div>
      <div class="detail-rating-label"><?=rating_label($h['rating'])?></div>
      <div class="detail-rating-count"><?=number_format($h['reviews'])?> ulasan</div>
    </div>
  </div>

  <!-- Date strip -->
  <div class="detail-info-strip glass">
    <div class="strip-item">
      <span class="strip-label">Check-in</span>
      <span class="strip-val"><?=fds($checkin)?></span>
    </div>
    <div class="strip-divider"></div>
    <div class="strip-item">
      <span class="strip-label"><?=$nights?> Malam</span>
      <span class="strip-val" style="background:var(--a-grad2);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">→</span>
    </div>
    <div class="strip-divider"></div>
    <div class="strip-item">
      <span class="strip-label">Check-out</span>
      <span class="strip-val"><?=fds($checkout)?></span>
    </div>
  </div>

  <!-- Fasilitas -->
  <div style="margin-bottom:12px;">
    <div class="sec-label">Fasilitas</div>
    <div class="amenity-compact">
      <?php foreach($h['amenities'] as $a): ?>
      <span class="amenity-chip">✓ <?=$a?></span>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Cancel policy -->
  <div style="margin-bottom:16px;">
    <span class="cancel-tag">📋 <?=$h['cancel_policy']?></span>
  </div>

  <!-- Price breakdown -->
  <div class="sec-label">Rincian Harga (<?=$nights?> malam)</div>
  <div class="price-breakdown glass" style="border-radius:var(--r-lg);overflow:hidden;margin-bottom:14px;">
    <div class="price-br-row"><span class="l"><?=rp($h['base_price'])?> × <?=$nights?> malam</span><span class="r"><?=rp($base_tot)?></span></div>
    <div class="price-br-row"><span class="l">Pajak (11%)</span><span class="r"><?=rp($tax_tot)?></span></div>
    <div class="price-br-row"><span class="l">Biaya layanan</span><span class="r"><?=rp($h['service_fee'])?></span></div>
    <div class="price-br-total"><span class="l">Total <?=$nights?> malam</span><span class="r"><?=rp($final)?></span></div>
    <div class="incl-note">✓ Tidak ada biaya tambahan saat pembayaran</div>
  </div>

  <!-- Reviews -->
  <div class="sec-label" style="margin-top:16px;">Ulasan Tamu</div>

  <!-- Review stars summary -->
  <div class="glass" style="border-radius:var(--r-lg);padding:14px;margin-bottom:10px;display:flex;align-items:center;gap:16px;">
    <div style="text-align:center;min-width:60px;">
      <div style="font-size:36px;font-weight:900;color:var(--a-red);letter-spacing:-1px;"><?=$h['rating']?></div>
      <div style="font-size:10px;color:var(--c-text3);font-weight:700;"><?=rating_label($h['rating'])?></div>
      <div style="color:#FFB800;font-size:13px;letter-spacing:-1px;">★★★★★</div>
    </div>
    <div style="flex:1;">
      <?php foreach(['Kebersihan'=>95,'Fasilitas'=>90,'Lokasi'=>88,'Layanan'=>92] as $k=>$v): ?>
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:5px;">
        <span style="font-size:10px;color:var(--c-text3);font-weight:700;min-width:60px;"><?=$k?></span>
        <div style="flex:1;height:4px;background:rgba(0,0,0,0.08);border-radius:2px;">
          <div style="width:<?=$v?>%;height:100%;background:var(--a-grad2);border-radius:2px;"></div>
        </div>
        <span style="font-size:10px;font-weight:800;color:var(--a-red);"><?=number_format($v/10,1)?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="review-card glass">
    <div class="reviewer-row">
      <div class="reviewer-av" style="background:linear-gradient(135deg,#A8D8C8,#7B9FD4)">A</div>
      <div><div class="reviewer-name">Andi S.</div><div class="reviewer-date">2 hari lalu · <span style="color:#FFB800;">★★★★★</span></div></div>
    </div>
    <p class="review-text">Kamar bersih dan nyaman, staf sangat ramah. Lokasi sangat strategis. Sarapan sangat bervariasi dan enak!</p>
  </div>
  <div class="review-card glass">
    <div class="reviewer-row">
      <div class="reviewer-av" style="background:linear-gradient(135deg,#B8CCEF,#A8D8E8)">R</div>
      <div><div class="reviewer-name">Rina M.</div><div class="reviewer-date">5 hari lalu · <span style="color:#FFB800;">★★★★</span></div></div>
    </div>
    <p class="review-text">Kolam renangnya keren banget dan ada view kota. Worth it banget sama harganya!</p>
  </div>
  <div class="review-card glass">
    <div class="reviewer-row">
      <div class="reviewer-av" style="background:linear-gradient(135deg,#B5E2D8,#A8D8C8)">D</div>
      <div><div class="reviewer-name">Dika P.</div><div class="reviewer-date">1 minggu lalu · <span style="color:#FFB800;">★★★★★</span></div></div>
    </div>
    <p class="review-text">Check-in cepat, kamar sesuai foto bahkan lebih bagus. Pasti balik lagi kesini!</p>
  </div>

</div>

<!-- Sticky bar -->
<div class="sticky-bar glass">
  <div class="sticky-price-wrap">
    <div class="sticky-tag">✓ Sudah incl. pajak & layanan</div>
    <div class="sticky-amount"><?=rp($final)?></div>
    <div class="sticky-sub"><?=$nights?> malam total · <?=rp($h['base_price'])?>/malam</div>
  </div>
  <a href="checkout.php?id=<?=$h['id']?>&checkin=<?=$checkin?>&checkout=<?=$checkout?>&nights=<?=$nights?>&total=<?=$final?>" class="btn-primary">
    Pesan Sekarang
  </a>
</div>

<script src="assets/app.js"></script>
<script>
function shareNow(){
  if(navigator.share) navigator.share({title:'<?=addslashes($h['name'])?> — agoda',text:'Cek hotel ini di agoda!'});
  else alert('Link disalin!');
}
</script>
</body></html>