<?php require_once 'config.php'; checkLogin();
if (empty($_SESSION['last_hotel_ticket'])) { header('Location: home.php'); exit; }
$ticket = $_SESSION['last_hotel_ticket'];
$hotel  = $ticket['hotel'];
?>
<?php headHtml('Hotel Booked!','
.success-circle{width:80px;height:80px;background:#DCFCE7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:40px;margin:0 auto 16px;}
.booking-code{background:var(--primary);color:#fff;border-radius:16px;padding:16px;text-align:center;margin-bottom:14px;}
.booking-code .code{font-size:26px;font-weight:800;letter-spacing:3px;margin-bottom:4px;}
.qr-grid{display:grid;grid-template-columns:repeat(8,1fr);gap:2px;width:140px;margin:0 auto 8px;}
.qr-cell{aspect-ratio:1;background:var(--primary);border-radius:2px;}
.qr-cell.white{background:#fff;}
.ticket-row{display:flex;justify-content:space-between;font-size:13px;padding:6px 0;border-bottom:1px solid var(--border);}
.ticket-row:last-child{border-bottom:none;}
') ?>
</head>
<body>
<div class="container" style="padding-top:30px;">
  <div style="text-align:center;margin-bottom:24px;">
    <div class="success-circle">✅</div>
    <h2 style="font-size:22px;font-weight:800;">Hotel Berhasil Dipesan!</h2>
    <p style="color:var(--gray);margin-top:6px;">Konfirmasi dikirim ke email kamu.</p>
  </div>

  <div class="booking-code">
    <div class="code"><?= $ticket['booking_code'] ?></div>
    <div style="font-size:12px;opacity:.75;">Kode Booking Hotel</div>
  </div>

  <div style="background:#F9FAFB;border-radius:14px;padding:16px;text-align:center;margin-bottom:14px;border:2px dashed var(--border);">
    <div class="qr-grid" id="qrGrid"></div>
    <p style="font-size:12px;color:var(--gray);">QR Check-in</p>
  </div>

  <div class="card">
    <div style="display:flex;gap:12px;align-items:flex-start;margin-bottom:14px;">
      <img src="<?= $hotel['img'] ?>" style="width:70px;height:70px;border-radius:12px;object-fit:cover;" alt="">
      <div>
        <h3 style="font-size:15px;font-weight:700;"><?= $hotel['name'] ?></h3>
        <div style="font-size:12px;color:var(--gray);"><?= $hotel['city'] ?></div>
        <div style="font-size:12px;color:#F59E0B;"><?= str_repeat('★',$hotel['stars']) ?></div>
      </div>
    </div>
    <div class="ticket-row"><span style="color:var(--gray);">Tipe Kamar</span><span style="font-weight:600;"><?= $ticket['room_name'] ?></span></div>
    <div class="ticket-row"><span style="color:var(--gray);">Check-in</span><span style="font-weight:600;"><?= date('D, d M Y',strtotime($ticket['checkin'])) ?></span></div>
    <div class="ticket-row"><span style="color:var(--gray);">Check-out</span><span style="font-weight:600;"><?= date('D, d M Y',strtotime($ticket['checkout'])) ?></span></div>
    <div class="ticket-row"><span style="color:var(--gray);">Kamar / Tamu</span><span style="font-weight:600;"><?= $ticket['rooms'] ?> kamar · <?= $ticket['guests'] ?> tamu</span></div>
    <div class="ticket-row"><span style="color:var(--gray);">Durasi</span><span style="font-weight:600;"><?= $ticket['nights'] ?> malam</span></div>
    <div class="ticket-row"><span style="color:var(--gray);">Pembayaran</span><span style="font-weight:600;"><?= $paymentMethods[$ticket['payment']]['label'] ?? $ticket['payment'] ?></span></div>
    <div class="ticket-row" style="font-size:16px;font-weight:800;"><span style="color:#111;">Total</span><span style="color:var(--primary);">$<?= $ticket['total'] ?></span></div>
    <p style="font-size:11px;color:var(--gray);margin-top:8px;">Dipesan: <?= $ticket['booked_at'] ?></p>
  </div>

  <a href="tickets.php" class="btn btn-outline" style="margin-bottom:10px;">🎫 Lihat Semua Tiket</a>
  <a href="home.php" class="btn btn-primary">🏠 Kembali ke Beranda</a>
</div>

<script>
const p=[1,1,1,1,1,1,1,0,1,0,0,0,1,0,0,1,1,0,1,1,1,0,1,0,1,0,1,1,1,0,1,0,1,0,1,1,1,0,1,0,1,0,0,0,1,0,1,1,1,1,1,1,1,1,0,1,0,1,0,0,0,1,0,1];
const g=document.getElementById('qrGrid');
p.forEach(v=>{const c=document.createElement('div');c.className='qr-cell'+(v?'':' white');g.appendChild(c);});
</script>
</body>
</html>