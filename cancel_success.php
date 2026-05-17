<?php
session_start();
require '_head.php';
$bid=$_GET['id']??'';
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Pembatalan Berhasil — StayEase</title><?=$font?><?=$css?>
</head><body>
<?=header_bar('Pembatalan')?>
<div style="min-height:100dvh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:40px 24px;text-align:center;">
  <div style="width:80px;height:80px;border-radius:50%;background:var(--c-red-soft);border:2px solid var(--c-red-border);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:36px;animation:popIn .5s cubic-bezier(.34,1.56,.64,1) both;">✕</div>
  <h1 style="font-size:24px;font-weight:800;letter-spacing:-0.5px;margin-bottom:6px;">Booking Dibatalkan</h1>
  <p style="font-size:13px;color:var(--c-text2);margin-bottom:6px;">Pesanan <code style="color:var(--c-accent);font-family:monospace;"><?=htmlspecialchars($bid)?></code> berhasil dibatalkan.</p>
  <p style="font-size:12px;color:var(--c-text3);margin-bottom:28px;">Dana refund (jika ada) akan kembali dalam 3–5 hari kerja.</p>
  <div style="display:flex;flex-direction:column;gap:10px;width:100%;max-width:320px;">
    <a href="orders.php" class="btn-primary" style="display:flex;">Lihat Semua Pesanan</a>
    <a href="index.php" class="btn-outline">Cari Hotel Lain</a>
  </div>
</div>
<script src="assets/app.js"></script>
</body></html>
