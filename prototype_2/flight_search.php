<?php require_once 'config.php'; checkLogin(); ?>
<?php headHtml('Cari Penerbangan','
.swap-btn{width:40px;height:40px;background:var(--primary);border-radius:50%;border:none;color:#fff;font-size:20px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.route-row{display:flex;align-items:flex-end;gap:10px;}
.route-row .input-wrap{flex:1;}
.class-row{display:flex;gap:8px;margin-bottom:12px;}
.class-pill{flex:1;text-align:center;padding:10px;border-radius:40px;font-size:14px;font-weight:600;cursor:pointer;border:1.5px solid var(--border);background:#fff;color:#374151;transition:.15s;}
.class-pill.active{background:var(--primary);color:#fff;border-color:var(--primary);}
.pass-row{display:flex;align-items:center;justify-content:space-between;background:#fff;border:1.5px solid var(--border);border-radius:14px;padding:12px 16px;margin-bottom:12px;}
.pass-controls{display:flex;align-items:center;gap:14px;}
.pass-btn{width:32px;height:32px;border-radius:50%;border:1.5px solid var(--primary);background:#fff;color:var(--primary);font-size:20px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-weight:700;}
.pass-num{font-size:18px;font-weight:700;min-width:24px;text-align:center;}
') ?>
</head>
<body>
<div class="page-header">
  <a href="home.php" class="back-btn">←</a>
  <h2>✈️ Cari Penerbangan</h2>
</div>

<div class="container">
  <form method="GET" action="flight_results.php" id="flightForm">
    <div class="card" style="padding:20px;">

      <!-- Route -->
      <div class="route-row">
        <div class="input-wrap">
          <label>Dari</label>
          <select name="origin" id="originSel" required>
            <option value="">Pilih kota asal</option>
            <?php foreach ($cities as $name => $code): ?>
            <option value="<?= htmlspecialchars($name) ?>" <?= ($name==='Jakarta')?'selected':'' ?>><?= $name ?> (<?= $code ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="button" class="swap-btn" id="swapBtn" title="Tukar">⇄</button>
        <div class="input-wrap">
          <label>Ke</label>
          <select name="destination" id="destSel" required>
            <option value="">Pilih kota tujuan</option>
            <?php foreach ($cities as $name => $code): ?>
            <option value="<?= htmlspecialchars($name) ?>" <?= ($name==='Denpasar (Bali)')?'selected':'' ?>><?= $name ?> (<?= $code ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- Date -->
      <div class="input-wrap">
        <label>Tanggal Berangkat</label>
        <input type="date" name="date" value="<?= date('Y-m-d', strtotime('+3 days')) ?>" min="<?= date('Y-m-d') ?>" required>
      </div>

      <!-- Class -->
      <label style="font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:8px;">Kelas</label>
      <div class="class-row">
        <div class="class-pill active" id="eco" onclick="setClass('Economy')">💺 Ekonomi</div>
        <div class="class-pill" id="biz" onclick="setClass('Business')">👔 Bisnis</div>
      </div>
      <input type="hidden" name="class" id="classInput" value="Economy">

      <!-- Passengers -->
      <label style="font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:8px;">Penumpang</label>
      <div class="pass-row">
        <span>👥 Dewasa</span>
        <div class="pass-controls">
          <button type="button" class="pass-btn" onclick="changePass(-1)">−</button>
          <span class="pass-num" id="passNum">1</span>
          <button type="button" class="pass-btn" onclick="changePass(1)">+</button>
        </div>
      </div>
      <input type="hidden" name="passengers" id="passInput" value="1">

      <button type="submit" class="btn btn-primary" style="margin-top:6px;">🔍 Cari Penerbangan</button>
    </div>
  </form>

  <!-- Popular Routes -->
  <div class="section-title"><h3>🔥 Rute Populer</h3></div>
  <?php foreach ($popular_routes as $r): ?>
  <a href="flight_results.php?origin=<?= urlencode($r['from']) ?>&destination=<?= urlencode($r['to']) ?>&date=<?= date('Y-m-d', strtotime('+3 days')) ?>&class=Economy&passengers=1"
     style="display:flex;align-items:center;justify-content:space-between;background:#fff;border-radius:14px;padding:14px 16px;margin-bottom:10px;border:1px solid var(--border);box-shadow:var(--shadow);">
    <div style="display:flex;align-items:center;gap:10px;">
      <div style="width:36px;height:36px;background:#EEF2FF;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;">✈️</div>
      <div>
        <div style="font-weight:700;font-size:14px;"><?= $r['from'] ?> → <?= $r['to'] ?></div>
        <div style="font-size:11px;color:var(--gray);">Mulai dari</div>
      </div>
    </div>
    <div style="font-weight:700;color:var(--accent);font-size:15px;">$<?= $r['price'] ?></div>
  </a>
  <?php endforeach; ?>
</div>

<?php renderNav('home'); ?>
<script>
let pass = 1;
function changePass(d){ pass = Math.max(1, Math.min(9, pass+d)); document.getElementById('passNum').textContent=pass; document.getElementById('passInput').value=pass; }
function setClass(c){
  document.getElementById('classInput').value=c;
  document.getElementById('eco').className='class-pill'+(c==='Economy'?' active':'');
  document.getElementById('biz').className='class-pill'+(c==='Business'?' active':'');
}
document.getElementById('swapBtn').onclick=()=>{
  const o=document.getElementById('originSel'),d=document.getElementById('destSel'),tmp=o.value;
  o.value=d.value; d.value=tmp;
};
document.getElementById('flightForm').onsubmit=function(e){
  const o=document.getElementById('originSel').value,d=document.getElementById('destSel').value;
  if(!o||!d){e.preventDefault();alert('Pilih kota asal dan tujuan.');return;}
  if(o===d){e.preventDefault();alert('Kota asal dan tujuan tidak boleh sama.');return;}
};
</script>
</body>
</html>