<?php require_once 'config.php'; checkLogin();
if (empty($_SESSION['last_ticket'])) { header('Location: home.php'); exit; }
$ticket = $_SESSION['last_ticket'];
$f = $ticket['flight'];
?>
<?php headHtml('Booking Berhasil','
.success-circle{width:80px;height:80px;background:#DCFCE7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:40px;margin:0 auto 16px;}
.booking-code{background:var(--primary);color:#fff;border-radius:16px;padding:16px;text-align:center;margin-bottom:14px;}
.booking-code .code{font-size:26px;font-weight:800;letter-spacing:3px;margin-bottom:4px;}
.booking-code .sub{font-size:12px;opacity:.75;}
.ticket-detail{background:#F9FAFB;border-radius:14px;padding:14px;margin-bottom:10px;}
.ticket-row{display:flex;justify-content:space-between;font-size:13px;padding:5px 0;border-bottom:1px solid var(--border);}
.ticket-row:last-child{border-bottom:none;}
.ticket-row .label{color:var(--gray);}
.ticket-row .value{font-weight:600;text-align:right;}
.qr-placeholder{background:#F3F4F6;border-radius:14px;padding:20px;text-align:center;margin-bottom:14px;border:2px dashed var(--border);}
.qr-placeholder .qr-grid{display:grid;grid-template-columns:repeat(8,1fr);gap:2px;width:140px;margin:0 auto 8px;}
.qr-cell{aspect-ratio:1;background:var(--primary);border-radius:2px;}
.qr-cell.white{background:#fff;}
') ?>
</head>
<body>
<div class="container" style="padding-top:30px;">

  <div style="text-align:center;margin-bottom:24px;">
    <div class="success-circle">✅</div>
    <h2 style="font-size:22px;font-weight:800;">Booking Berhasil!</h2>
    <p style="color:var(--gray);margin-top:6px;">Tiket kamu telah dikonfirmasi.</p>
  </div>

  <div class="booking-code">
    <div class="code"><?= $ticket['booking_code'] ?></div>
    <div class="sub">Kode Booking · Simpan kode ini</div>
  </div>

  <!-- QR Code Placeholder -->
  <div class="qr-placeholder">
    <div class="qr-grid" id="qrGrid"></div>
    <p style="font-size:12px;color:var(--gray);">Tunjukkan QR ini saat check-in</p>
  </div>

  <!-- Flight Details -->
  <div class="card">
    <h3 style="margin-bottom:12px;">✈️ Detail Penerbangan</h3>
    <div class="ticket-detail">
      <div class="ticket-row"><span class="label">Maskapai</span><span class="value"><?= $f['airline'] ?> (<?= $f['flight_num'] ?>)</span></div>
      <div class="ticket-row"><span class="label">Rute</span><span class="value"><?= $f['origin'] ?> → <?= $f['destination'] ?></span></div>
      <div class="ticket-row"><span class="label">Tanggal</span><span class="value"><?= date('D, d M Y', strtotime($ticket['date'])) ?></span></div>
      <div class="ticket-row"><span class="label">Jam</span><span class="value"><?= $f['departure'] ?> – <?= $f['arrival'] ?></span></div>
      <div class="ticket-row"><span class="label">Kelas</span><span class="value"><?= $f['class'] ?></span></div>
      <div class="ticket-row"><span class="label">Penumpang</span><span class="value"><?= $ticket['passengers'] ?> orang</span></div>
    </div>

    <?php if (!empty($ticket['addons'])): ?>
    <h3 style="margin:12px 0 8px;">➕ Layanan Tambahan</h3>
    <div class="ticket-detail">
      <?php foreach ($ticket['addons'] as $a): ?>
      <div class="ticket-row"><span class="label"><?= $a['icon'] ?> <?= $a['label'] ?></span><span class="value">+$<?= $a['price'] * $ticket['passengers'] ?></span></div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <h3 style="margin:12px 0 8px;">💳 Pembayaran</h3>
    <div class="ticket-detail">
      <div class="ticket-row"><span class="label">Metode</span><span class="value"><?= $paymentMethods[$ticket['payment']]['label'] ?? $ticket['payment'] ?></span></div>
      <div class="ticket-row"><span class="label">Subtotal Tiket</span><span class="value">$<?= $ticket['subtotal'] ?></span></div>
      <?php if ($ticket['discount'] > 0): ?>
      <div class="ticket-row" style="color:green;"><span class="label">Diskon <?= $ticket['discount'] ?>%</span><span class="value">-$<?= round($ticket['subtotal']*$ticket['discount']/100) ?></span></div>
      <?php endif; ?>
      <div class="ticket-row" style="font-size:15px;font-weight:800;"><span class="label" style="color:#111;">Total Dibayar</span><span class="value" style="color:var(--primary);">$<?= $ticket['total'] ?></span></div>
    </div>
    <p style="font-size:11px;color:var(--gray);margin-top:8px;">Dipesan: <?= $ticket['booked_at'] ?></p>
  </div>

  <a href="tickets.php" class="btn btn-outline" style="margin-bottom:10px;">🎫 Lihat Semua Tiket</a>
  <a href="home.php" class="btn btn-primary">🏠 Kembali ke Beranda</a>
</div>

<script>
// Generate pseudo-QR
const grid = document.getElementById('qrGrid');
const pattern = [1,1,1,1,1,1,1,0,1,0,0,0,1,0,0,1,1,0,1,1,1,0,1,0,1,0,1,1,1,0,1,0,1,0,1,1,1,0,1,0,1,0,0,0,1,0,1,1,1,1,1,1,1,1,0,1,0,1,0,0,0,1,0,1];
pattern.forEach(v=>{const c=document.createElement('div');c.className='qr-cell'+(v?'':' white');grid.appendChild(c);});
</script>
</body>
</html>