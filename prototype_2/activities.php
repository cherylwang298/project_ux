<?php
session_start();
require '_data.php';
require '_head.php';
$city = $_GET['city'] ?? 'Surabaya';
$cat  = $_GET['category'] ?? 'Semua';
$today = date('Y-m-d');

// Filter activities by category
$filteredActivities = $ACTIVITIES;
if ($cat !== 'Semua') {
  $catMap = [
    'Sejarah' => 'Wisata Sejarah',
    'Kuliner' => 'Food Tour',
    'Bahari'  => 'Wisata Bahari',
    'Hiburan' => 'Hiburan Indoor',
  ];
  $search = $catMap[$cat] ?? $cat;
  $filteredActivities = array_filter($ACTIVITIES, fn($a) => $a['category'] === $search);
}
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Aktivitas &amp; Wisata — agoda</title><?=$font?><?=$css?>
</head><body>
<?=$blobs?>

<header class="app-header">
  <div class="header-inner">
    <a href="index.php" class="hb-back">←</a>
    <div style="text-align:center;">
      <div style="font-size:14px;font-weight:800;letter-spacing:-0.3px;">Aktivitas di <?=htmlspecialchars($city)?></div>
      <div style="font-size:10px;color:var(--c-text3);"><?=count($filteredActivities)?> aktivitas tersedia</div>
    </div>
    <button class="icon-btn" onclick="openCityModal('activity')">📍</button>
  </div>
</header>

<div class="page-content">
  <!-- Category chips — now functional via GET -->
  <div class="filter-chips" style="padding:0 0 14px;">
    <a href="?city=<?=urlencode($city)?>&category=Semua" class="chip <?=$cat==='Semua'?'active':''?>">🎯 Semua</a>
    <a href="?city=<?=urlencode($city)?>&category=Sejarah" class="chip <?=$cat==='Sejarah'?'active':''?>">🏛️ Sejarah</a>
    <a href="?city=<?=urlencode($city)?>&category=Kuliner" class="chip <?=$cat==='Kuliner'?'active':''?>">🍜 Kuliner</a>
    <a href="?city=<?=urlencode($city)?>&category=Bahari" class="chip <?=$cat==='Bahari'?'active':''?>">🚢 Bahari</a>
    <a href="?city=<?=urlencode($city)?>&category=Hiburan" class="chip <?=$cat==='Hiburan'?'active':''?>">🎮 Hiburan</a>
  </div>

  <div style="font-size:12px;color:var(--c-text2);font-weight:600;margin-bottom:14px;"><?=count($filteredActivities)?> aktivitas ditemukan di <strong><?=htmlspecialchars($city)?></strong></div>

  <?php if(empty($filteredActivities)): ?>
  <div style="text-align:center;padding:40px 20px;color:var(--c-text3);">
    <div style="font-size:40px;margin-bottom:12px;">🔍</div>
    <div style="font-size:14px;font-weight:700;">Tidak ada aktivitas ditemukan</div>
    <div style="font-size:12px;margin-top:6px;">Coba pilih kategori lain</div>
  </div>
  <?php endif; ?>

  <?php foreach($filteredActivities as $act): ?>
  <div class="activity-card glass" onclick="openActivityCheckout(<?=htmlspecialchars(json_encode($act),ENT_QUOTES)?>)">
    <div class="activity-img" style="background:<?=$act['grad']?>">
      <div class="activity-overlay"></div>
      <span class="activity-emoji"><?=$act['img_emoji']?></span>
      <span class="activity-cat"><?=$act['category']?></span>
      <span class="hotel-badge" style="top:10px;bottom:auto;"><?=$act['badge']?></span>
    </div>
    <div class="activity-body">
      <div class="activity-name"><?=$act['name']?></div>
      <div class="activity-loc">📍 <?=$act['location']?></div>
      <p style="font-size:11px;color:var(--c-text2);line-height:1.55;margin-bottom:8px;"><?=$act['desc']?></p>
      <div class="activity-meta">
        <span class="activity-dur">⏱ <?=$act['duration']?></span>
        <div class="rating-badge" style="font-size:12px;padding:3px 8px;"><?=$act['rating']?></div>
        <span style="font-size:10px;color:var(--c-text3);font-weight:700;"><?=number_format($act['reviews'])?> ulasan</span>
      </div>
      <div style="display:flex;flex-wrap:wrap;gap:5px;margin-bottom:10px;">
        <?php foreach($act['includes'] as $inc): ?>
        <span style="font-size:10px;padding:3px 9px;background:var(--c-green-soft);border:1px solid var(--c-green-border);border-radius:20px;color:var(--c-green);font-weight:700;">✓ <?=$inc?></span>
        <?php endforeach; ?>
      </div>
      <div class="activity-footer">
        <div>
          <div class="activity-price"><?=rp($act['price'])?></div>
          <div class="activity-price-sub">per orang · sudah incl. pajak</div>
        </div>
        <button class="btn-primary" style="width:auto;padding:11px 18px;font-size:12px;"
          onclick="event.stopPropagation();openActivityCheckout(<?=htmlspecialchars(json_encode($act),ENT_QUOTES)?>)">Pesan →</button>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<!-- Activity Checkout Modal -->
<div class="modal-overlay" id="activityCheckoutModal" onclick="closeModal('activityCheckoutModal')">
  <div class="modal-sheet" onclick="event.stopPropagation()" style="max-height:90vh;overflow-y:auto;">
    <div class="modal-handle"></div>
    <div class="modal-title">Pesan Aktivitas</div>

    <!-- Activity summary -->
    <div class="glass" id="acSummary" style="border-radius:var(--r-lg);padding:14px;margin-bottom:16px;display:flex;gap:14px;align-items:center;">
      <div style="font-size:42px;flex-shrink:0;" id="acEmoji">🎯</div>
      <div style="flex:1;">
        <div style="font-size:14px;font-weight:800;margin-bottom:2px;" id="acName">-</div>
        <div style="font-size:11px;color:var(--c-text3);" id="acLoc">-</div>
        <div style="font-size:11px;color:var(--c-text3);" id="acDur">-</div>
      </div>
      <div style="text-align:right;">
        <div style="font-size:16px;font-weight:700;color:var(--a-main2);" id="acPrice">-</div>
        <div style="font-size:10px;color:var(--c-text3);">per orang</div>
      </div>
    </div>

    <form method="POST" action="confirm_activity.php" id="acForm">
      <input type="hidden" name="activity_id" id="acActivityId">
      <!-- Date -->
      <div class="form-sec-label">Tanggal Kunjungan</div>
      <div style="margin-bottom:14px;background:rgba(255,255,255,0.65);border:1.5px solid rgba(255,255,255,0.85);border-radius:14px;padding:12px 14px;">
        <input type="date" name="visit_date" id="acDate" value="<?=date('Y-m-d',strtotime('+1 day'))?>" min="<?=$today?>" style="width:100%;border:none;background:transparent;font-family:var(--f);font-size:14px;font-weight:600;outline:none;">
      </div>

      <!-- Persons -->
      <div class="form-sec-label">Jumlah Orang</div>
      <div style="margin-bottom:14px;background:rgba(255,255,255,0.65);border:1.5px solid rgba(255,255,255,0.85);border-radius:14px;padding:12px 14px;">
        <select name="persons" id="acPersons" onchange="updateActivityTotal()" style="width:100%;border:none;background:transparent;font-family:var(--f);font-size:14px;font-weight:600;outline:none;">
          <option value="1">1 Orang</option>
          <option value="2">2 Orang</option>
          <option value="3">3 Orang</option>
          <option value="4">4 Orang</option>
          <option value="5">5 Orang</option>
        </select>
      </div>

      <!-- Guest data -->
      <div class="form-sec-label">Data Pemesan</div>
      <div class="form-card glass" style="border-radius:var(--r-lg);overflow:hidden;margin-bottom:16px;">
        <div class="form-group">
          <div class="form-label-row">Nama Lengkap</div>
          <input class="form-input" type="text" name="guest_name" id="acName2" placeholder="Nama sesuai KTP" required>
        </div>
        <div class="form-group">
          <div class="form-label-row">Email</div>
          <input class="form-input" type="email" name="guest_email" id="acEmail" placeholder="email@kamu.com" required>
        </div>
        <div class="form-group" style="border-bottom:none;">
          <div class="form-label-row">Nomor HP</div>
          <input class="form-input" type="tel" name="guest_phone" id="acPhone" placeholder="+62 8xx-xxxx-xxxx" required>
        </div>
      </div>

      <!-- Payment -->
      <div class="form-sec-label">Metode Pembayaran</div>
      <div class="payment-options glass" style="border-radius:var(--r-lg);margin-bottom:16px;">
        <div class="payment-option selected" onclick="selectPayment(this)">
          <input type="radio" name="payment_method" value="ovo" checked>
          <div class="pay-icon" style="background:rgba(98,0,234,.1)">💜</div>
          <div><div class="pay-name">OVO</div><div class="pay-desc">Bayar dengan saldo OVO</div></div>
        </div>
        <div class="payment-option" onclick="selectPayment(this)">
          <input type="radio" name="payment_method" value="gopay">
          <div class="pay-icon" style="background:rgba(0,170,79,.1)">💚</div>
          <div><div class="pay-name">GoPay</div><div class="pay-desc">Bayar dengan saldo GoPay</div></div>
        </div>
        <div class="payment-option" onclick="selectPayment(this)">
          <input type="radio" name="payment_method" value="transfer_bca">
          <div class="pay-icon" style="background:rgba(0,82,165,.1)">🏦</div>
          <div><div class="pay-name">Transfer BCA</div><div class="pay-desc">Virtual Account otomatis</div></div>
        </div>
        <div class="payment-option" style="border-bottom:none;" onclick="selectPayment(this)">
          <input type="radio" name="payment_method" value="credit_card">
          <div class="pay-icon" style="background:rgba(255,149,0,.1)">💳</div>
          <div><div class="pay-name">Kartu Kredit/Debit</div><div class="pay-desc">Visa, Mastercard, JCB</div></div>
        </div>
      </div>

      <!-- Summary -->
      <div class="checkout-summary glass" style="border-radius:var(--r-lg);margin-bottom:16px;">
        <div class="cs-row"><span class="l">Harga per orang</span><span class="r" id="acPriceRow">-</span></div>
        <div class="cs-row"><span class="l">Jumlah orang</span><span class="r" id="acPersonsRow">1</span></div>
        <div class="cs-total"><span class="l">Total</span><span class="r" id="acTotal">-</span></div>
        <div class="cs-incl">✓ Harga sudah termasuk semua pajak</div>
      </div>
      <button type="submit" class="btn-primary">Konfirmasi Pemesanan →</button>
    </form>
  </div>
</div>

<!-- City picker modal -->
<div class="modal-overlay" id="cityModal" onclick="closeCityModal()">
  <div class="modal-sheet" onclick="event.stopPropagation()" style="max-height:85vh;display:flex;flex-direction:column;">
    <div class="modal-handle"></div>
    <div class="modal-title" id="cityModalTitle">Pilih Kota</div>
    <div style="padding:0 0 12px;">
      <div style="display:flex;align-items:center;gap:10px;background:rgba(255,255,255,0.7);border:1.5px solid rgba(0,0,0,0.1);border-radius:14px;padding:10px 14px;">
        <svg width="16" height="16" fill="none" stroke="var(--c-text3)" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input type="text" id="citySearch" placeholder="Cari kota..." oninput="filterCities()"
          style="border:none;background:transparent;outline:none;width:100%;font-size:14px;font-family:var(--f);font-weight:500;color:var(--c-text);">
      </div>
    </div>
    <div id="cityList" style="overflow-y:auto;flex:1;display:flex;flex-direction:column;gap:4px;padding-right:2px;"></div>
  </div>
</div>

<?=nav('')?>
<script src="assets/app.js"></script>
<script>
const CITIES = [
  {name:'Surabaya',sub:'Jawa Timur'},{name:'Jakarta',sub:'DKI Jakarta'},
  {name:'Bali',sub:'Bali'},{name:'Bandung',sub:'Jawa Barat'},
  {name:'Yogyakarta',sub:'DI Yogyakarta'},{name:'Medan',sub:'Sumatera Utara'},
  {name:'Makassar',sub:'Sulawesi Selatan'},{name:'Semarang',sub:'Jawa Tengah'},
  {name:'Manado',sub:'Sulawesi Utara'},{name:'Lombok',sub:'Nusa Tenggara Barat'},
  {name:'Solo',sub:'Jawa Tengah'},{name:'Malang',sub:'Jawa Timur'},
];

let allCities = CITIES;
function openCityModal(t) {
  document.getElementById('citySearch').value = '';
  renderCities(CITIES);
  toggleModal('cityModal');
}
function closeCityModal() { closeModal('cityModal'); }
function renderCities(cities) {
  document.getElementById('cityList').innerHTML = cities.map(c =>
    `<div onclick="selectCity('${c.name}')" style="padding:13px 14px;border-radius:14px;background:rgba(255,255,255,0.65);border:1.5px solid rgba(255,255,255,0.85);cursor:pointer;" ontouchstart="this.style.background='rgba(168,216,200,0.35)'" ontouchend="this.style.background='rgba(255,255,255,0.65)'">
      <div style="font-size:14px;font-weight:700;">${c.name}</div>
      <div style="font-size:11px;color:var(--c-text3);">${c.sub}</div>
    </div>`
  ).join('');
}
function filterCities() {
  const q = document.getElementById('citySearch').value.toLowerCase();
  renderCities(CITIES.filter(c => c.name.toLowerCase().includes(q) || c.sub.toLowerCase().includes(q)));
}
function selectCity(name) {
  window.location.href = '?city=' + encodeURIComponent(name) + '&category=<?=urlencode($cat)?>';
}

// Activity checkout
let currentActivityPrice = 0;
function openActivityCheckout(act) {
  currentActivityPrice = act.price;
  document.getElementById('acActivityId').value = act.id;
  document.getElementById('acEmoji').textContent = act.img_emoji;
  document.getElementById('acName').textContent = act.name;
  document.getElementById('acLoc').textContent = '📍 ' + act.location;
  document.getElementById('acDur').textContent = '⏱ ' + act.duration;
  const priceStr = 'Rp ' + act.price.toLocaleString('id-ID');
  document.getElementById('acPrice').textContent = priceStr;

  // Prefill from session
  <?php if(isset($_SESSION['saved_guest'])): ?>
  document.getElementById('acName2').value = '<?=addslashes($_SESSION['saved_guest']['name'])?>';
  document.getElementById('acEmail').value = '<?=addslashes($_SESSION['saved_guest']['email'])?>';
  document.getElementById('acPhone').value = '<?=addslashes($_SESSION['saved_guest']['phone'])?>';
  <?php endif; ?>

  updateActivityTotal();
  toggleModal('activityCheckoutModal');
}

function updateActivityTotal() {
  const persons = parseInt(document.getElementById('acPersons').value) || 1;
  const total = currentActivityPrice * persons;
  document.getElementById('acPriceRow').textContent = 'Rp ' + currentActivityPrice.toLocaleString('id-ID');
  document.getElementById('acPersonsRow').textContent = persons + ' orang';
  document.getElementById('acTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

document.getElementById('acForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('confirm_activity.php', { method:'POST', body: fd })
    .then(r => r.json())
    .then(data => {
      if (data.success) window.location.href = 'confirm.php?type=activity&booking_id=' + data.booking_id;
      else this.submit();
    }).catch(() => this.submit());
});
</script>
</body></html>
