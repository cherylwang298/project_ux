<?php
session_start();
require '_data.php';
require '_head.php';
$b = $_SESSION['booking'] ?? ['booking_id'=>'STE-DEMO001','type'=>'hotel','hotel_name'=>'The Alana Surabaya','checkin'=>date('Y-m-d',strtotime('+5 days')),'checkout'=>date('Y-m-d',strtotime('+7 days')),'nights'=>2,'total'=>1525000,'guest_name'=>'Ceri Wijaya','guest_email'=>'ceri@email.com','payment_method'=>'ovo','status'=>'confirmed','cancellation'=>'Gratis batalkan hingga 24 jam sebelum check-in','created_at'=>date('Y-m-d H:i:s')];
$type = $b['type'] ?? 'hotel';
$picons=['ovo'=>'💜 OVO','gopay'=>'💚 GoPay','transfer_bca'=>'🏦 Transfer BCA','credit_card'=>'💳 Kartu Kredit'];
$plab=$picons[$b['payment_method']]??ucwords(str_replace('_',' ',$b['payment_method']));
$guestName = $b['guest_name'] ?? $b['pax_name'] ?? '-';
$guestEmail = $b['guest_email'] ?? $b['pax_email'] ?? '-';
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Booking Berhasil! — agoda</title><?=$font?><?=$css?>
<style>.confirm-wrap{padding:calc(var(--nav-h)+20px) 20px 100px;}</style>
</head><body>
<?=$blobs?>

<div class="confetti-wrap" id="confettiWrap"></div>

<?=header_bar('Konfirmasi')?>

<!-- Progress -->
<div class="progress-bar-wrap" style="padding-top:calc(var(--nav-h)+16px);">
  <div class="progress-steps">
    <div class="progress-track"><div class="progress-fill" style="width:100%"></div></div>
    <div class="step-item done"><div class="step-dot done">✓</div><div class="step-label"><?=$type==='hotel'?'Hotel':($type==='flight'?'Pesawat':'Aktivitas')?></div></div>
    <div class="step-item done"><div class="step-dot done">✓</div><div class="step-label">Detail</div></div>
    <div class="step-item done"><div class="step-dot done">✓</div><div class="step-label">Bayar</div></div>
  </div>
</div>

<div class="confirm-wrap">
  <div style="text-align:center;margin-bottom:24px;">
    <div class="success-anim" id="successAnim">✓</div>
    <h1 class="confirm-title">Booking Berhasil!</h1>
    <p class="confirm-sub">Konfirmasi dikirim ke <strong><?=htmlspecialchars($guestEmail)?></strong></p>
    <div class="booking-id-chip">🎟 <?=$b['booking_id']?></div>
  </div>

  <div class="receipt">
    <div class="receipt-head">
      <?php if($type === 'hotel'): ?>
      <div class="receipt-head-name">🏨 <?=htmlspecialchars($b['hotel_name']??'-')?></div>
      <?php elseif($type === 'flight'): ?>
      <div class="receipt-head-name">✈️ <?=htmlspecialchars($b['airline']??'-')?></div>
      <?php else: ?>
      <div class="receipt-head-name"><?=htmlspecialchars(($b['img_emoji']??'🎯').' '.($b['activity_name']??'-'))?></div>
      <?php endif; ?>
      <div class="receipt-head-id">ID: <?=$b['booking_id']?></div>
    </div>
    <div class="receipt-body">
      <div class="receipt-row"><span class="r-label">Nama</span><span class="r-val"><?=htmlspecialchars($guestName)?></span></div>
      <?php if($type === 'hotel'): ?>
      <div class="receipt-row"><span class="r-label">Check-in</span><span class="r-val"><?=fd($b['checkin']??'')?></span></div>
      <div class="receipt-row"><span class="r-label">Check-out</span><span class="r-val"><?=fd($b['checkout']??'')?></span></div>
      <div class="receipt-row"><span class="r-label">Durasi</span><span class="r-val"><?=$b['nights']??0?> Malam</span></div>
      <?php elseif($type === 'flight'): ?>
      <div class="receipt-row"><span class="r-label">Rute</span><span class="r-val"><?=htmlspecialchars(($b['from']??'-').' → '.($b['to']??'-'))?></span></div>
      <div class="receipt-row"><span class="r-label">Tanggal</span><span class="r-val"><?=fd($b['dep_date']??'')?></span></div>
      <div class="receipt-row"><span class="r-label">Berangkat</span><span class="r-val"><?=htmlspecialchars($b['dep_time']??'-')?></span></div>
      <div class="receipt-row"><span class="r-label">Tiba</span><span class="r-val"><?=htmlspecialchars($b['arr_time']??'-')?></span></div>
      <div class="receipt-row"><span class="r-label">Kelas</span><span class="r-val"><?=htmlspecialchars($b['class']??'-')?></span></div>
      <?php else: ?>
      <div class="receipt-row"><span class="r-label">Lokasi</span><span class="r-val"><?=htmlspecialchars($b['location']??'-')?></span></div>
      <div class="receipt-row"><span class="r-label">Tanggal</span><span class="r-val"><?=fd($b['visit_date']??'')?></span></div>
      <div class="receipt-row"><span class="r-label">Peserta</span><span class="r-val"><?=($b['persons']??1)?> orang</span></div>
      <?php endif; ?>
      <div class="receipt-row"><span class="r-label">Pembayaran</span><span class="r-val"><?=$plab?></span></div>
      <div class="receipt-row" style="border-bottom:none;"><span class="r-label">Status</span><span class="r-val" style="color:var(--c-green);">✓ Dikonfirmasi</span></div>
    </div>
    <div class="receipt-total"><span class="l">Total Dibayar</span><span class="r"><?=rp($b['total'] ?? $b['price'] ?? 0)?></span></div>
  </div>

  <?php if($type === 'hotel' && isset($b['cancellation'])): ?>
  <div style="background:var(--c-green-soft);border:1px solid var(--c-green-border);border-radius:var(--r-md);padding:12px 14px;margin-bottom:16px;">
    <div style="font-size:9px;color:var(--c-green);font-weight:700;text-transform:uppercase;letter-spacing:0.7px;margin-bottom:3px;">Kebijakan Pembatalan</div>
    <div style="font-size:12px;color:var(--c-text);"><?=htmlspecialchars($b['cancellation'])?></div>
  </div>
  <?php endif; ?>

  <div class="action-grid">
    <button class="action-btn" onclick="alert('Struk tersimpan!')"><span style="font-size:24px;">📄</span>Simpan Struk</button>
    <button class="action-btn" onclick="shareNow()"><span style="font-size:24px;">🔗</span>Bagikan</button>
    <a href="orders.php" class="action-btn"><span style="font-size:24px;">📋</span>Pesanan Saya</a>
    <a href="index.php" class="action-btn"><span style="font-size:24px;">🏠</span>Beranda</a>
  </div>

  <a href="cancel.php?id=<?=urlencode($b['booking_id'])?>" class="cancel-btn-link">✕ Batalkan Booking Ini</a>
</div>

<?=nav('orders')?>
<script src="assets/app.js"></script>
<script>
setTimeout(()=>{const a=document.getElementById('successAnim');if(a)a.classList.add('show');},120);
setTimeout(spawnConfetti,300);
function shareNow(){if(navigator.share)navigator.share({title:'agoda',text:'Booking berhasil — ID: <?=$b['booking_id']?>'});else alert('Link disalin!');}
</script>
</body></html>
