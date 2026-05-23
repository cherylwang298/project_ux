<?php
session_start();
require '_data.php';
require '_head.php';
$bid=$_GET['id']??'';
$o=null;
foreach(($_SESSION['orders']??[]) as $x){if($x['booking_id']===$bid){$o=$x;break;}}
if(!$o)$o=['booking_id'=>$bid?:'STE-DEMO','hotel_name'=>'The Alana Surabaya','checkin'=>date('Y-m-d',strtotime('+5 days')),'checkout'=>date('Y-m-d',strtotime('+7 days')),'nights'=>2,'total'=>1525000,'guest_name'=>'Ceri Wijaya','guest_email'=>'ceri@email.com','guest_phone'=>'+62 812-3456-7890','payment_method'=>'ovo','status'=>'confirmed','cancellation'=>'Gratis batalkan hingga 24 jam sebelum check-in','created_at'=>date('Y-m-d H:i:s')];
$picons=['ovo'=>'💜 OVO','gopay'=>'💚 GoPay','transfer_bca'=>'🏦 Transfer BCA','credit_card'=>'💳 Kartu Kredit'];
$plab=$picons[$o['payment_method']]??$o['payment_method'];
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Detail Pesanan — StayEase</title><?=$font?><?=$css?>
</head><body>
<?=$blobs?>
<?=header_bar('Detail Pesanan','orders.php')?>
<div class="page-content">
  <!-- Status -->
  <div style="text-align:center;margin-bottom:20px;">
    <?php if($o['status']==='confirmed'): ?>
    <div style="display:inline-flex;align-items:center;gap:8px;background:var(--c-green-soft);border:1.5px solid var(--c-green-border);border-radius:20px;padding:8px 18px;">
      <span style="color:var(--c-green);font-size:18px;">✓</span>
      <span style="font-weight:700;color:var(--c-green);font-size:14px;">Booking Aktif</span>
    </div>
    <?php else: ?>
    <div style="display:inline-flex;align-items:center;gap:8px;background:var(--c-red-soft);border:1.5px solid var(--c-red-border);border-radius:20px;padding:8px 18px;">
      <span style="color:var(--c-red);font-size:18px;">✕</span>
      <span style="font-weight:700;color:var(--c-red);font-size:14px;">Dibatalkan</span>
    </div>
    <?php endif; ?>
  </div>

  <div class="receipt">
    <div class="receipt-head"><div class="receipt-head-name"><?=htmlspecialchars($o['hotel_name'])?></div><div class="receipt-head-id">ID: <?=$o['booking_id']?></div></div>
    <div class="receipt-body">
      <div class="receipt-row"><span class="r-label">Nama Tamu</span><span class="r-val"><?=htmlspecialchars($o['guest_name'])?></span></div>
      <div class="receipt-row"><span class="r-label">Email</span><span class="r-val" style="font-size:12px;"><?=htmlspecialchars($o['guest_email']??'-')?></span></div>
      <div class="receipt-row"><span class="r-label">Check-in</span><span class="r-val"><?=fd($o['checkin'])?></span></div>
      <div class="receipt-row"><span class="r-label">Check-out</span><span class="r-val"><?=fd($o['checkout'])?></span></div>
      <div class="receipt-row"><span class="r-label">Durasi</span><span class="r-val"><?=$o['nights']?> Malam</span></div>
      <div class="receipt-row" style="border-bottom:none;"><span class="r-label">Pembayaran</span><span class="r-val"><?=$plab?></span></div>
    </div>
    <div class="receipt-total"><span class="l">Total Dibayar</span><span class="r"><?=rp($o['total'])?></span></div>
  </div>

  <?php if(!empty($o['cancellation'])): ?>
  <div style="background:<?=$o['status']==='confirmed'?'var(--c-green-soft)':'var(--c-red-soft)'?>;border:1px solid <?=$o['status']==='confirmed'?'var(--c-green-border)':'var(--c-red-border)'?>;border-radius:var(--r-md);padding:12px 14px;margin-bottom:16px;">
    <div style="font-size:9px;color:<?=$o['status']==='confirmed'?'var(--c-green)':'var(--c-red)'?>;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;margin-bottom:3px;">Kebijakan Pembatalan</div>
    <div style="font-size:12px;color:var(--c-text);"><?=htmlspecialchars($o['cancellation'])?></div>
  </div>
  <?php endif; ?>

  <div class="action-grid" style="margin-bottom:12px;">
    <button class="action-btn" onclick="alert('Struk tersimpan!')"><span style="font-size:22px;">📄</span>Simpan Struk</button>
    <button class="action-btn" onclick="if(navigator.share)navigator.share({title:'Booking',text:'<?=addslashes($o['hotel_name'])?>'});else alert('Link disalin!')"><span style="font-size:22px;">🔗</span>Bagikan</button>
  </div>

  <?php if($o['status']==='confirmed'): ?>
  <a href="cancel.php?id=<?=urlencode($o['booking_id'])?>" class="cancel-btn-link">✕ Batalkan Booking Ini</a>
  <?php endif; ?>

  <a href="orders.php" class="btn-outline" style="margin-top:10px;display:block;text-align:center;">← Kembali ke Pesanan Saya</a>
</div>
<script src="assets/app.js"></script>
</body></html>
