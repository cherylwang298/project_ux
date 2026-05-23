<?php
session_start();
require '_data.php';
require '_head.php';
if(empty($_SESSION['orders'])){
  $_SESSION['orders']=[
    ['booking_id'=>'STE-A8C3F1E2','hotel_name'=>'The Alana Surabaya','checkin'=>date('Y-m-d',strtotime('+5 days')),'checkout'=>date('Y-m-d',strtotime('+7 days')),'nights'=>2,'total'=>1525000,'guest_name'=>'Ceri Wijaya','payment_method'=>'ovo','status'=>'confirmed','cancellation'=>'Gratis batalkan hingga 24 jam sebelum check-in','created_at'=>date('Y-m-d H:i:s'),'guest_email'=>'ceri@email.com','guest_phone'=>'+62 812-3456-7890'],
    ['booking_id'=>'STE-D2F8B91C','hotel_name'=>'Swiss-Belinn Surabaya','checkin'=>date('Y-m-d',strtotime('-10 days')),'checkout'=>date('Y-m-d',strtotime('-8 days')),'nights'=>2,'total'=>625000,'guest_name'=>'Ceri Wijaya','payment_method'=>'gopay','status'=>'cancelled','cancellation'=>'Non-refundable','created_at'=>date('Y-m-d H:i:s',strtotime('-12 days')),'guest_email'=>'ceri@email.com','guest_phone'=>'+62 812-3456-7890'],
  ];
}
$orders=array_reverse($_SESSION['orders']);
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Pesanan Saya — StayEase</title><?=$font?><?=$css?>
</head><body>
<?=$blobs?>

<?=header_bar('Pesanan Saya')?>

<div class="page-content">
  <h1 class="page-title">Pesanan Saya</h1>
  <p class="page-subtitle"><?=count($orders)?> pesanan</p>

  <!-- Filter tabs -->
  <div class="filter-chips" style="padding:0 0 14px;">
    <button class="chip active" onclick="filterOrders('all',this)">Semua</button>
    <button class="chip" onclick="filterOrders('confirmed',this)">✓ Aktif</button>
    <button class="chip" onclick="filterOrders('cancelled',this)">✕ Dibatalkan</button>
  </div>

  <div id="orderList">
  <?php foreach($orders as $o): ?>
  <div class="order-card glass" data-status="<?=$o['status']?>" style="margin-bottom:12px;">
    <div class="order-head">
      <div>
        <div class="order-hotel-name"><?=htmlspecialchars($o['hotel_name'])?></div>
        <div style="font-size:10px;color:var(--c-text3);font-family:monospace;margin-top:2px;"><?=$o['booking_id']?></div>
      </div>
      <span class="status-pill <?=$o['status']==='confirmed'?'s-confirmed':'s-cancelled'?>">
        <?=$o['status']==='confirmed'?'✓ Aktif':'✕ Dibatalkan'?>
      </span>
    </div>

    <!-- Stay strip -->
    <div style="background:rgba(0,0,0,0.04);border-radius:var(--r-md);padding:10px 12px;display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
      <div style="text-align:center;">
        <div style="font-size:9px;color:var(--c-text3);font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Check-in</div>
        <div style="font-size:14px;font-weight:800;letter-spacing:-0.3px;"><?=fds($o['checkin'])?></div>
      </div>
      <div style="font-size:11px;color:var(--c-text3);"><?=$o['nights']?> malam →</div>
      <div style="text-align:center;">
        <div style="font-size:9px;color:var(--c-text3);font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Check-out</div>
        <div style="font-size:14px;font-weight:800;letter-spacing:-0.3px;"><?=fds($o['checkout'])?></div>
      </div>
    </div>

    <div class="order-meta">👤 <?=htmlspecialchars($o['guest_name'])?></div>
    <div class="order-price"><?=rp($o['total'])?></div>

    <div class="order-actions-row">
      <a href="order_detail.php?id=<?=urlencode($o['booking_id'])?>" class="btn-ghost" style="display:flex;align-items:center;justify-content:center;padding:10px;font-size:12px;">📄 Detail</a>
      <?php if($o['status']==='confirmed'): ?>
      <a href="cancel.php?id=<?=urlencode($o['booking_id'])?>" style="flex:1;display:flex;align-items:center;justify-content:center;padding:10px;font-size:12px;font-weight:700;color:var(--c-red);background:var(--c-red-soft);border:1px solid var(--c-red-border);border-radius:var(--r-sm);text-decoration:none;">✕ Batalkan</a>
      <?php else: ?>
      <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:10px;font-size:12px;font-weight:600;color:var(--c-text3);">Selesai</div>
      <?php endif; ?>
    </div>
  </div>
  <?php endforeach; ?>
  </div>
</div>

<?=nav('orders')?>
<script src="assets/app.js"></script>
<script>
function filterOrders(s,btn){
  document.querySelectorAll('.filter-chips .chip').forEach(c=>c.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.order-card').forEach(c=>{c.style.display=(s==='all'||c.dataset.status===s)?'block':'none';});
}
</script>
</body></html>
