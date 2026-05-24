<?php require_once 'config.php'; checkLogin();
$tickets = array_reverse($_SESSION['tickets'] ?? []);
$tab = $_GET['tab'] ?? 'all';
if ($tab === 'flight') $tickets = array_filter($tickets, fn($t) => ($t['type'] ?? 'flight') === 'flight');
if ($tab === 'hotel')  $tickets = array_filter($tickets, fn($t) => ($t['type'] ?? 'flight') === 'hotel');
$tickets = array_values($tickets);
?>
<?php headHtml('Tiket Saya','
.tab-row{display:flex;gap:0;border-bottom:2px solid var(--border);margin-bottom:16px;}
.tab-link{flex:1;text-align:center;padding:12px;font-size:14px;font-weight:600;color:var(--gray);border-bottom:3px solid transparent;margin-bottom:-2px;cursor:pointer;text-decoration:none;}
.tab-link.active{color:var(--primary);border-bottom-color:var(--primary);}
.ticket-card{background:#fff;border-radius:20px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow);margin-bottom:14px;}
.ticket-header{background:var(--primary);color:#fff;padding:14px 16px;display:flex;justify-content:space-between;align-items:center;}
.ticket-header h3{font-size:14px;font-weight:700;}
.ticket-header .code{font-size:12px;opacity:.8;letter-spacing:1px;}
.ticket-body{padding:16px;}
.route-display{display:flex;align-items:center;gap:10px;margin-bottom:12px;}
.route-time{font-size:20px;font-weight:800;}
.route-code{font-size:11px;color:var(--gray);}
.route-line{flex:1;text-align:center;position:relative;}
.route-line::before{content:"";position:absolute;top:50%;left:0;right:0;height:1.5px;background:var(--border);}
.route-line span{background:#fff;position:relative;font-size:11px;color:var(--gray);padding:0 6px;}
.meta-row{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:12px;}
.ticket-footer{display:flex;justify-content:space-between;align-items:center;padding-top:12px;border-top:1px solid var(--border);}
.qr-mini{display:grid;grid-template-columns:repeat(6,1fr);gap:1.5px;width:52px;}
.qr-mini-cell{aspect-ratio:1;background:var(--primary);border-radius:1px;}
.qr-mini-cell.w{background:#fff;}
') ?>
</head>
<body>
<div class="page-header">
  <h2>🎫 Tiket Saya</h2>
</div>

<div class="container">
  <div class="tab-row">
    <a href="tickets.php?tab=all"    class="tab-link <?= $tab==='all'?'active':'' ?>">Semua</a>
    <a href="tickets.php?tab=flight" class="tab-link <?= $tab==='flight'?'active':'' ?>">✈️ Penerbangan</a>
    <a href="tickets.php?tab=hotel"  class="tab-link <?= $tab==='hotel'?'active':'' ?>">🏨 Hotel</a>
  </div>

  <?php if (empty($tickets)): ?>
  <div style="text-align:center;padding:60px 20px;">
    <div style="font-size:56px;margin-bottom:14px;">🎫</div>
    <h3>Belum ada tiket</h3>
    <p style="color:var(--gray);margin-top:6px;">Pesan penerbangan atau hotel sekarang!</p>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:20px;">
      <a href="flight_search.php" class="btn btn-primary">✈️ Penerbangan</a>
      <a href="hotel_search.php"  class="btn btn-outline">🏨 Hotel</a>
    </div>
  </div>
  <?php else: ?>

  <?php foreach ($tickets as $t): ?>
  <?php if (($t['type'] ?? 'flight') === 'flight'): $f = $t['flight']; ?>
  <div class="ticket-card">
    <div class="ticket-header">
      <div>
        <div style="font-size:11px;opacity:.7;text-transform:uppercase;letter-spacing:.05em;">✈️ Penerbangan</div>
        <h3><?= $f['airline'] ?> · <?= $f['flight_num'] ?></h3>
      </div>
      <div class="code"><?= $t['booking_code'] ?></div>
    </div>
    <div class="ticket-body">
      <div class="route-display">
        <div><div class="route-time"><?= $f['departure'] ?></div><div class="route-code"><?= $cities[$f['origin']] ?? '' ?></div></div>
        <div class="route-line"><span>✈️ <?= $f['duration'] ?></span></div>
        <div style="text-align:right;"><div class="route-time"><?= $f['arrival'] ?></div><div class="route-code"><?= $cities[$f['destination']] ?? '' ?></div></div>
      </div>
      <div class="meta-row">
        <span class="badge badge-primary"><?= date('d M Y',strtotime($t['date'])) ?></span>
        <span class="badge badge-primary"><?= $f['class'] ?></span>
        <span class="badge badge-primary"><?= $t['passengers'] ?> Penumpang</span>
      </div>
      <?php if (!empty($t['addons'])): ?>
      <div style="font-size:12px;color:var(--gray);margin-bottom:8px;">
        Add-ons: <?= implode(', ', array_map(fn($a)=>$a['icon'].' '.$a['label'], $t['addons'])) ?>
      </div>
      <?php endif; ?>
      <div class="ticket-footer">
        <div>
          <div style="font-size:11px;color:var(--gray);">Total Bayar</div>
          <div style="font-size:17px;font-weight:800;color:var(--primary);">$<?= $t['total'] ?></div>
          <div style="font-size:10px;color:var(--gray);"><?= $t['booked_at'] ?? '' ?></div>
        </div>
        <!-- Mini QR -->
        <div>
          <div class="qr-mini" id="qr_<?= $t['id'] ?>"></div>
          <div style="font-size:10px;color:var(--gray);text-align:center;margin-top:2px;">QR</div>
        </div>
      </div>
    </div>
  </div>

  <?php else: $h = $t['hotel']; ?>
  <div class="ticket-card">
    <div class="ticket-header" style="background:#0F766E;">
      <div>
        <div style="font-size:11px;opacity:.7;text-transform:uppercase;letter-spacing:.05em;">🏨 Hotel</div>
        <h3><?= $h['name'] ?></h3>
      </div>
      <div class="code"><?= $t['booking_code'] ?></div>
    </div>
    <div class="ticket-body">
      <div style="display:flex;gap:10px;align-items:center;margin-bottom:10px;">
        <img src="<?= $h['img'] ?>" style="width:56px;height:56px;border-radius:10px;object-fit:cover;" alt="">
        <div>
          <div style="font-weight:700;font-size:14px;"><?= $t['room_name'] ?></div>
          <div style="font-size:12px;color:var(--gray);">📍 <?= $h['city'] ?></div>
        </div>
      </div>
      <div class="meta-row">
        <span class="badge badge-primary">Check-in: <?= date('d M',strtotime($t['checkin'])) ?></span>
        <span class="badge badge-primary">Check-out: <?= date('d M',strtotime($t['checkout'])) ?></span>
        <span class="badge badge-primary"><?= $t['nights'] ?> mlm</span>
      </div>
      <div class="ticket-footer">
        <div>
          <div style="font-size:11px;color:var(--gray);">Total Bayar</div>
          <div style="font-size:17px;font-weight:800;color:#0F766E;">$<?= $t['total'] ?></div>
          <div style="font-size:10px;color:var(--gray);"><?= $t['booked_at'] ?? '' ?></div>
        </div>
        <div>
          <div class="qr-mini" id="qr_<?= $t['id'] ?>"></div>
          <div style="font-size:10px;color:var(--gray);text-align:center;margin-top:2px;">QR</div>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
  <?php endforeach; ?>

  <?php endif; ?>
</div>

<?php renderNav('tickets'); ?>
<script>
const qrP=[1,1,1,0,0,1,1,0,1,0,1,0,1,1,1,0,0,1,0,1,0,0,1,1,1,1,0,1,0,0,0,1,0,0,1,1];
document.querySelectorAll('[id^="qr_"]').forEach(g=>{
  qrP.forEach(v=>{const c=document.createElement('div');c.className='qr-mini-cell'+(v?'':' w');g.appendChild(c);});
});
</script>
</body>
</html>