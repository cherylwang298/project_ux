<?php require_once 'config.php'; checkLogin();

// Get unique hotel cities
$hotelCities = array_unique(array_column($hotels, 'city'));
sort($hotelCities);
?>
<?php headHtml('Cari Hotel','
.pass-row{display:flex;align-items:center;justify-content:space-between;background:#fff;border:1.5px solid var(--border);border-radius:14px;padding:12px 16px;margin-bottom:12px;}
.pass-controls{display:flex;align-items:center;gap:12px;}
.pass-btn{width:30px;height:30px;border-radius:50%;border:1.5px solid var(--primary);background:#fff;color:var(--primary);font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-weight:700;}
.pass-num{font-size:16px;font-weight:700;min-width:20px;text-align:center;}
') ?>
</head>
<body>
<div class="page-header">
  <a href="home.php" class="back-btn">←</a>
  <h2>🏨 Cari Hotel</h2>
</div>

<div class="container">
  <form method="GET" action="hotel_results.php">
    <div class="card" style="padding:20px;">
      <div class="input-wrap">
        <label>Kota Tujuan</label>
        <select name="city" required>
          <option value="">Pilih kota</option>
          <?php foreach ($hotelCities as $c): ?>
          <option value="<?= htmlspecialchars($c) ?>"><?= $c ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
        <div class="input-wrap">
          <label>Check-In</label>
          <input type="date" name="checkin" value="<?= date('Y-m-d', strtotime('+3 days')) ?>" min="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="input-wrap">
          <label>Check-Out</label>
          <input type="date" name="checkout" value="<?= date('Y-m-d', strtotime('+6 days')) ?>" min="<?= date('Y-m-d', strtotime('+4 days')) ?>" required>
        </div>
      </div>

      <label style="font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:8px;">Kamar</label>
      <div class="pass-row" style="margin-bottom:12px;">
        <span>🛏️ Kamar</span>
        <div class="pass-controls">
          <button type="button" class="pass-btn" onclick="changeVal('rooms',-1)">−</button>
          <span class="pass-num" id="roomsNum">1</span>
          <button type="button" class="pass-btn" onclick="changeVal('rooms',1)">+</button>
        </div>
        <input type="hidden" name="rooms" id="roomsInput" value="1">
      </div>
      <div class="pass-row">
        <span>👥 Tamu</span>
        <div class="pass-controls">
          <button type="button" class="pass-btn" onclick="changeVal('guests',-1)">−</button>
          <span class="pass-num" id="guestsNum">2</span>
          <button type="button" class="pass-btn" onclick="changeVal('guests',1)">+</button>
        </div>
        <input type="hidden" name="guests" id="guestsInput" value="2">
      </div>

      <button type="submit" class="btn btn-primary" style="margin-top:16px;">🔍 Cari Hotel</button>
    </div>
  </form>

  <!-- Popular hotel cities -->
  <div class="section-title"><h3>🔥 Kota Populer</h3></div>
  <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:16px;">
    <?php $popularCities = ['Denpasar (Bali)'=>'🌴','Bandung'=>'🏔️','Jakarta'=>'🌆','Yogyakarta'=>'🏛️','Surabaya'=>'🏙️','Lombok'=>'🏖️']; ?>
    <?php foreach ($popularCities as $city => $icon): ?>
    <a href="hotel_results.php?city=<?= urlencode($city) ?>&checkin=<?= date('Y-m-d',strtotime('+3 days')) ?>&checkout=<?= date('Y-m-d',strtotime('+6 days')) ?>&rooms=1&guests=2"
       style="background:#fff;border-radius:14px;padding:14px 10px;text-align:center;border:1px solid var(--border);box-shadow:var(--shadow);">
      <div style="font-size:26px;margin-bottom:6px;"><?= $icon ?></div>
      <div style="font-size:11px;font-weight:600;"><?= $city ?></div>
    </a>
    <?php endforeach; ?>
  </div>
</div>

<?php renderNav('home'); ?>
<script>
const counts = {rooms:1, guests:2};
function changeVal(k,d){
  counts[k]=Math.max(1,Math.min(k==='rooms'?9:20,counts[k]+d));
  document.getElementById(k+'Num').textContent=counts[k];
  document.getElementById(k+'Input').value=counts[k];
}
</script>
</body>
</html>