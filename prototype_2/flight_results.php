<?php require_once 'config.php'; checkLogin();
$origin = $_GET['origin'] ?? '';
$dest   = $_GET['destination'] ?? '';
$date   = $_GET['date'] ?? date('Y-m-d');
$class  = $_GET['class'] ?? 'Economy';
$pass   = max(1, (int)($_GET['passengers'] ?? 1));
if (!$origin || !$dest || $origin === $dest) { header('Location: flight_search.php'); exit; }
$flights = getFlights($origin, $dest, $date, $class, $pass);
?>
<?php headHtml('Hasil Penerbangan',"
.route-summary{background:var(--primary);color:#fff;padding:14px 16px;border-radius:16px;margin-bottom:16px;}
.route-summary h3{font-size:16px;font-weight:800;}
.route-summary p{font-size:12px;opacity:.8;margin-top:4px;}
.flight-card{background:#fff;border-radius:20px;padding:16px;margin-bottom:12px;border:1px solid var(--border);box-shadow:var(--shadow);}
.airline-row{display:flex;align-items:center;gap:8px;margin-bottom:12px;}
.airline-logo{width:36px;height:36px;background:#EEF2FF;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;}
.airline-name{font-weight:700;font-size:14px;}
.flight-num{font-size:11px;color:var(--gray);}
.times-row{display:flex;align-items:center;gap:6px;margin-bottom:10px;}
.dep,.arr{flex:1;}
.dep{text-align:left;} .arr{text-align:right;}
.time{font-size:22px;font-weight:800;}
.city-name{font-size:11px;color:var(--gray);}
.dur-line{flex:1;text-align:center;position:relative;}
.dur-line::before{content:'';position:absolute;top:50%;left:0;right:0;height:1px;background:#D1D5DB;}
.dur-text{background:#fff;position:relative;font-size:10px;color:var(--gray);padding:0 6px;}
.flight-footer{display:flex;align-items:center;justify-content:space-between;}
.price-big{font-size:20px;font-weight:800;color:var(--primary);}
.seats-left{font-size:11px;color:var(--accent);margin-top:2px;}
.btn-select{background:var(--primary);color:#fff;border:none;padding:10px 20px;border-radius:40px;font-weight:700;font-size:14px;cursor:pointer;}
.sort-row{display:flex;gap:8px;margin-bottom:12px;overflow-x:auto;scrollbar-width:none;}
.sort-chip{flex-shrink:0;padding:7px 14px;border-radius:40px;font-size:12px;font-weight:600;border:1.5px solid var(--border);background:#fff;cursor:pointer;}
.sort-chip.active{background:var(--primary);color:#fff;border-color:var(--primary);}
.class-badge{display:inline-block;padding:3px 10px;border-radius:40px;font-size:11px;font-weight:600;background:#EEF2FF;color:var(--primary);margin-left:6px;}
") ?>
</head>
<body>
<div class="page-header">
  <a href="flight_search.php" class="back-btn">←</a>
  <div>
    <h2><?= htmlspecialchars($origin) ?> → <?= htmlspecialchars($dest) ?></h2>
  </div>
</div>

<div class="container">
  <div class="route-summary">
    <h3>✈️ <?= htmlspecialchars($origin) ?> → <?= htmlspecialchars($dest) ?></h3>
    <p><?= date('D, d M Y', strtotime($date)) ?> &nbsp;·&nbsp; <?= $class ?> <span class="class-badge"><?= $pass ?> Penumpang</span></p>
  </div>

  <div class="sort-row">
    <div class="sort-chip active">Teremurah</div>
    <div class="sort-chip">Tercepat</div>
    <div class="sort-chip">Berangkat Pagi</div>
    <div class="sort-chip">Maskapai</div>
  </div>

  <?php if (empty($flights)): ?>
  <div class="card" style="text-align:center;padding:40px;">
    <div style="font-size:48px;margin-bottom:12px;">😕</div>
    <h3>Tidak ada penerbangan</h3>
    <p style="color:var(--gray);margin-top:6px;">Coba rute atau tanggal lain.</p>
    <a href="flight_search.php" class="btn btn-primary" style="margin-top:16px;">Cari Lagi</a>
  </div>
  <?php else: ?>
  <?php usort($flights, fn($a,$b) => $a['price'] <=> $b['price']); ?>
  <?php foreach ($flights as $f): ?>
  <div class="flight-card">
    <div class="airline-row">
      <div class="airline-logo"><?= $f['logo'] ?></div>
      <div>
        <div class="airline-name"><?= $f['airline'] ?></div>
        <div class="flight-num"><?= $f['flight_num'] ?> &nbsp;·&nbsp; <?= $f['class'] ?></div>
      </div>
      <?php if ($f['seats_left'] <= 5): ?>
      <div style="margin-left:auto;" class="badge badge-accent">Sisa <?= $f['seats_left'] ?></div>
      <?php endif; ?>
    </div>
    <div class="times-row">
      <div class="dep">
        <div class="time"><?= $f['departure'] ?></div>
        <div class="city-name"><?= $cities[$f['origin']] ?? '' ?></div>
      </div>
      <div class="dur-line">
        <div class="dur-text">⏱ <?= $f['duration'] ?></div>
      </div>
      <div class="arr">
        <div class="time"><?= $f['arrival'] ?></div>
        <div class="city-name"><?= $cities[$f['destination']] ?? '' ?></div>
      </div>
    </div>
    <div class="flight-footer">
      <div>
        <div class="price-big">$<?= $f['price'] ?><span style="font-size:12px;font-weight:400;">/org</span></div>
        <div class="seats-left"><?= $f['seats_left'] ?> kursi tersisa</div>
      </div>
      <form method="POST" action="booking_checkout.php" style="margin:0;">
        <input type="hidden" name="flight" value="<?= htmlspecialchars(json_encode($f)) ?>">
        <input type="hidden" name="passengers" value="<?= $pass ?>">
        <input type="hidden" name="date" value="<?= $date ?>">
        <button type="submit" class="btn-select">Pilih →</button>
      </form>
    </div>
  </div>
  <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php renderNav('home'); ?>
</body>
</html>