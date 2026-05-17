<?php
session_start();
require '_data.php';
require '_head.php';
$bid=$_GET['id']??'';
$o=null;$okey=null;
foreach(($_SESSION['orders']??[]) as $k=>$x){if($x['booking_id']===$bid){$o=$x;$okey=$k;break;}}
if($_SERVER['REQUEST_METHOD']==='POST'&&$o){
  if($okey!==null) $_SESSION['orders'][$okey]['status']='cancelled';
  if(isset($_SESSION['booking'])&&$_SESSION['booking']['booking_id']===$bid) $_SESSION['booking']['status']='cancelled';
  header('Location: cancel_success.php?id='.urlencode($bid)); exit;
}
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Batalkan Booking — StayEase</title><?=$font?><?=$css?>
</head><body>
<?=header_bar('Batalkan Booking','javascript:history.back()')?>
<div class="cancel-page">
  <?php if(!$o): ?>
    <div style="text-align:center;padding:48px 0;"><div style="font-size:48px;margin-bottom:12px;">❓</div><div style="font-size:18px;font-weight:700;">Pesanan tidak ditemukan</div><a href="orders.php" class="btn-primary" style="margin-top:20px;display:inline-flex;width:auto;padding:12px 24px;">Ke Pesanan Saya</a></div>
  <?php elseif($o['status']==='cancelled'): ?>
    <div style="text-align:center;padding:48px 0;"><div style="font-size:48px;margin-bottom:12px;">✕</div><div style="font-size:18px;font-weight:700;">Sudah Dibatalkan</div><a href="orders.php" class="btn-primary" style="margin-top:20px;display:inline-flex;width:auto;padding:12px 24px;">Kembali</a></div>
  <?php else: ?>
    <div style="text-align:center;margin-bottom:24px;">
      <div class="cancel-warning-icon" style="animation:popIn .4s cubic-bezier(.34,1.56,.64,1) both;">⚠️</div>
      <h1 style="font-size:22px;font-weight:800;letter-spacing:-0.5px;margin-bottom:6px;">Yakin Batalkan?</h1>
      <p style="font-size:13px;color:var(--c-text2);">Tindakan ini tidak dapat dibatalkan</p>
    </div>
    <div class="glass" style="border-radius:var(--r-xl);padding:16px;margin-bottom:14px;">
      <div style="font-size:10px;color:var(--c-text3);font-weight:700;text-transform:uppercase;letter-spacing:0.7px;margin-bottom:10px;">Detail Pesanan</div>
      <?php foreach(['Hotel'=>$o['hotel_name'],'Check-in'=>fd($o['checkin']),'Check-out'=>fd($o['checkout']),'Total'=>rp($o['total'])] as $k=>$v): ?>
      <div style="display:flex;justify-content:space-between;padding:8px 0;font-size:13px;border-bottom:1px solid rgba(0,0,0,0.05);"><span style="color:var(--c-text2);"><?=$k?></span><span style="font-weight:700;"><?=$v?></span></div>
      <?php endforeach; ?>
    </div>
    <div style="background:var(--c-red-soft);border:1px solid var(--c-red-border);border-radius:var(--r-md);padding:12px 14px;margin-bottom:16px;">
      <div style="font-size:9px;color:var(--c-red);font-weight:700;text-transform:uppercase;letter-spacing:0.7px;margin-bottom:3px;">Kebijakan Pembatalan</div>
      <div style="font-size:12px;"><?=htmlspecialchars($o['cancellation']??'')?></div>
    </div>
    <form method="POST">
      <button type="submit" class="btn-danger" style="margin-bottom:10px;">✕ Ya, Batalkan Booking</button>
      <a href="javascript:history.back()" class="btn-outline" style="display:block;text-align:center;padding:14px;">Tidak, Kembali</a>
    </form>
  <?php endif; ?>
</div>
<script src="assets/app.js"></script>
</body></html>
