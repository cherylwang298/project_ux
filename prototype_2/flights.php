<?php
session_start();
require '_data.php';
require '_head.php';
$from = $_GET['from'] ?? 'Surabaya';
$to   = $_GET['to']   ?? 'Jakarta';
$dep  = $_GET['dep_date'] ?? date('Y-m-d', strtotime('+1 day'));
$sort = $_GET['sort'] ?? 'recommended';
$today = date('Y-m-d');
// Enforce dep date not in past
if ($dep < $today) $dep = $today;

$list = $FLIGHTS;
if($sort === 'price_asc')  usort($list, fn($a,$b) => $a['price'] - $b['price']);
if($sort === 'price_desc') usort($list, fn($a,$b) => $b['price'] - $a['price']);
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Cari Penerbangan — agoda</title><?=$font?><?=$css?>
</head><body>
<?=$blobs?>

<header class="app-header">
  <div class="header-inner">
    <a href="index.php" class="hb-back">←</a>
    <div style="text-align:center;">
      <div style="font-size:14px;font-weight:800;letter-spacing:-0.3px;"><?=htmlspecialchars($from)?> → <?=htmlspecialchars($to)?></div>
      <div style="font-size:10px;color:var(--c-text3);"><?=fd($dep)?> · <?=count($list)?> penerbangan</div>
    </div>
    <button class="icon-btn" onclick="toggleModal('filterSheet')">⚙️</button>
  </div>
</header>

<div class="page-content">
  <!-- Search edit bar -->
  <div class="glass" style="border-radius:var(--r-lg);padding:12px 14px;margin-bottom:14px;display:flex;align-items:center;gap:10px;cursor:pointer;" onclick="toggleModal('editSearchModal')">
    <span style="font-size:18px;">✈️</span>
    <div style="flex:1;">
      <div style="font-size:13px;font-weight:700;"><?=htmlspecialchars($from)?> → <?=htmlspecialchars($to)?></div>
      <div style="font-size:11px;color:var(--c-text3);"><?=fd($dep)?></div>
    </div>
    <span style="font-size:11px;color:var(--c-accent);font-weight:700;">Ubah →</span>
  </div>

  <!-- Sort chips -->
  <div class="filter-chips" style="padding:0 0 14px;">
    <a href="?from=<?=urlencode($from)?>&to=<?=urlencode($to)?>&dep_date=<?=$dep?>&sort=recommended" class="chip <?=$sort==='recommended'?'active':''?>">✦ Terbaik</a>
    <a href="?from=<?=urlencode($from)?>&to=<?=urlencode($to)?>&dep_date=<?=$dep?>&sort=price_asc" class="chip <?=$sort==='price_asc'?'active':''?>">💰 Termurah</a>
    <a href="?from=<?=urlencode($from)?>&to=<?=urlencode($to)?>&dep_date=<?=$dep?>&sort=price_desc" class="chip <?=$sort==='price_desc'?'active':''?>">💸 Termahal</a>
  </div>

  <div style="font-size:12px;color:var(--c-text2);font-weight:600;margin-bottom:14px;"><?=count($list)?> penerbangan ditemukan</div>

  <?php foreach($list as $f): ?>
  <div class="flight-card" onclick="bookFlight(<?=$f['id']?>,<?=htmlspecialchars(json_encode($f),ENT_QUOTES)?>)">
    <div class="flight-head">
      <div>
        <div class="airline-name"><?=$f['logo']?> <?=$f['airline']?></div>
        <div class="flight-class"><?=$f['airline_code']?> · <?=$f['class']?></div>
      </div>
      <div style="text-align:right;">
        <div style="font-size:11px;color:rgba(255,255,255,0.85);font-weight:700;"><?=fd($dep)?></div>
        <div style="font-size:10px;color:rgba(255,255,255,0.65);margin-top:1px;"><?=$f['stops']?></div>
      </div>
    </div>
    <div class="flight-body">
      <div class="flight-route">
        <div class="route-end">
          <div class="code"><?=$f['from']?></div>
          <div class="city"><?=$f['from_city']?></div>
          <div class="time"><?=$f['dep']?></div>
        </div>
        <div class="route-mid">
          <div class="route-line">
            <div class="route-dot"></div>
            <div class="route-dash"></div>
            <div class="route-plane">✈</div>
            <div class="route-dash"></div>
            <div class="route-dot"></div>
          </div>
          <div class="route-dur"><?=$f['duration']?></div>
          <div class="route-stops"><?=$f['stops']?></div>
        </div>
        <div class="route-end" style="text-align:right;">
          <div class="code"><?=$f['to']?></div>
          <div class="city"><?=$f['to_city']?></div>
          <div class="time"><?=$f['arr']?></div>
        </div>
      </div>
      <div class="flight-footer">
        <div>
          <div class="flight-seats">🔥 <?=$f['seats']?> kursi tersisa</div>
          <div style="font-size:10px;color:var(--c-green);font-weight:700;margin-top:2px;">✓ Bagasi 20kg</div>
        </div>
        <div style="text-align:right;">
          <div class="flight-price"><?=rp($f['price'])?></div>
          <div class="flight-price-sub">per orang · sudah incl. pajak</div>
        </div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<!-- Edit Search Modal -->
<div class="modal-overlay" id="editSearchModal" onclick="closeModal('editSearchModal')">
  <div class="modal-sheet" onclick="event.stopPropagation()">
    <div class="modal-handle"></div>
    <div class="modal-title">Ubah Pencarian</div>
    <form method="GET" id="editFlightForm">
      <div class="search-field" onclick="openCityModal('flight_from')" style="cursor:pointer;margin-bottom:10px;background:rgba(255,255,255,0.65);border:1.5px solid rgba(255,255,255,0.85);border-radius:14px;padding:12px 14px;">
        <span class="field-icon">🛫</span>
        <div class="field-content"><label>Dari</label>
          <input type="text" name="from" id="flightFrom" value="<?=htmlspecialchars($from)?>" readonly style="cursor:pointer;background:transparent;border:none;outline:none;font-family:var(--f);font-weight:600;">
        </div>
      </div>
      <div class="search-field" onclick="openCityModal('flight_to')" style="cursor:pointer;margin-bottom:10px;background:rgba(255,255,255,0.65);border:1.5px solid rgba(255,255,255,0.85);border-radius:14px;padding:12px 14px;">
        <span class="field-icon">🛬</span>
        <div class="field-content"><label>Ke</label>
          <input type="text" name="to" id="flightTo" value="<?=htmlspecialchars($to)?>" readonly style="cursor:pointer;background:transparent;border:none;outline:none;font-family:var(--f);font-weight:600;">
        </div>
      </div>
      <input type="hidden" name="from_code" id="flightFromCode" value="">
      <input type="hidden" name="to_code" id="flightToCode" value="">
      <div style="margin-bottom:10px;background:rgba(255,255,255,0.65);border:1.5px solid rgba(255,255,255,0.85);border-radius:14px;padding:12px 14px;">
        <label style="font-size:10px;color:var(--c-text3);font-weight:700;display:block;margin-bottom:4px;">Tanggal Berangkat</label>
        <input type="date" name="dep_date" value="<?=$dep?>" min="<?=$today?>" style="width:100%;border:none;background:transparent;font-family:var(--f);font-size:14px;font-weight:600;outline:none;">
      </div>
      <button type="submit" class="btn-primary">Cari Penerbangan</button>
    </form>
  </div>
</div>

<!-- Filter modal -->
<div class="modal-overlay filter-sheet" id="filterSheet" onclick="closeModal('filterSheet')">
  <div class="modal-sheet" onclick="event.stopPropagation()">
    <div class="modal-handle"></div>
    <div class="modal-title">Filter Penerbangan</div>
    <form method="GET">
      <input type="hidden" name="from" value="<?=htmlspecialchars($from)?>">
      <input type="hidden" name="to" value="<?=htmlspecialchars($to)?>">
      <input type="hidden" name="dep_date" value="<?=$dep?>">
      <div class="filter-group">
        <div class="filter-group-title">Urutkan</div>
        <?php foreach(['recommended'=>'✦ Terbaik','price_asc'=>'💰 Harga Termurah','price_desc'=>'💸 Harga Termahal'] as $v=>$l): ?>
        <label class="sort-opt"><input type="radio" name="sort" value="<?=$v?>" <?=$sort===$v?'checked':''?>><?=$l?></label>
        <?php endforeach; ?>
      </div>
      <div class="filter-group">
        <div class="filter-group-title">Maskapai</div>
        <div style="display:flex;flex-direction:column;gap:8px;">
          <?php foreach(array_unique(array_column($FLIGHTS,'airline')) as $al): ?>
          <label style="display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:var(--r-md);border:1.5px solid rgba(0,0,0,0.08);background:rgba(255,255,255,0.60);cursor:pointer;font-size:13px;font-weight:700;">
            <input type="checkbox" name="airline[]" value="<?=$al?>" checked style="accent-color:var(--a-red);"> <?=$al?>
          </label>
          <?php endforeach; ?>
        </div>
      </div>
      <button type="submit" class="btn-primary">Terapkan Filter</button>
    </form>
  </div>
</div>

<!-- Flight Checkout Modal -->
<div class="modal-overlay" id="flightCheckoutModal" onclick="closeModal('flightCheckoutModal')">
  <div class="modal-sheet" onclick="event.stopPropagation()" style="max-height:90vh;overflow-y:auto;">
    <div class="modal-handle"></div>
    <div class="modal-title">Pesan Tiket Pesawat</div>

    <!-- Flight summary -->
    <div class="glass" id="fcSummary" style="border-radius:var(--r-lg);padding:14px;margin-bottom:16px;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
        <div>
          <div style="font-size:13px;font-weight:800;" id="fcAirline">-</div>
          <div style="font-size:10px;color:var(--c-text3);" id="fcClass">-</div>
        </div>
        <div style="font-size:20px;" id="fcLogo">✈️</div>
      </div>
      <div class="flight-route" style="margin-bottom:8px;">
        <div class="route-end">
          <div class="code" id="fcFrom">-</div>
          <div class="city" id="fcFromCity">-</div>
          <div class="time" id="fcDep">-</div>
        </div>
        <div class="route-mid">
          <div class="route-line"><div class="route-dot"></div><div class="route-dash"></div><div class="route-plane">✈</div><div class="route-dash"></div><div class="route-dot"></div></div>
          <div class="route-dur" id="fcDur">-</div>
        </div>
        <div class="route-end" style="text-align:right;">
          <div class="code" id="fcTo">-</div>
          <div class="city" id="fcToCity">-</div>
          <div class="time" id="fcArr">-</div>
        </div>
      </div>
      <div style="border-top:1px solid rgba(0,0,0,0.06);padding-top:10px;display:flex;justify-content:space-between;">
        <span style="font-size:12px;color:var(--c-text2);font-weight:600;" id="fcDate">-</span>
        <span style="font-size:16px;font-weight:700;color:var(--a-main2);" id="fcPrice">-</span>
      </div>
    </div>

    <!-- Passenger data -->
    <form method="POST" action="confirm_flight.php" id="fcForm">
      <input type="hidden" name="flight_id" id="fcFlightId">
      <input type="hidden" name="dep_date" value="<?=$dep?>">
      <div class="form-sec-label">Data Penumpang</div>
      <div class="form-card glass" style="border-radius:var(--r-lg);overflow:hidden;margin-bottom:16px;">
        <div class="form-group">
          <div class="form-label-row">Nama Lengkap</div>
          <input class="form-input" type="text" name="pax_name" id="fcName" placeholder="Nama sesuai KTP/Paspor" required>
        </div>
        <div class="form-group">
          <div class="form-label-row">Email</div>
          <input class="form-input" type="email" name="pax_email" id="fcEmail" placeholder="email@kamu.com" required>
        </div>
        <div class="form-group" style="border-bottom:none;">
          <div class="form-label-row">Nomor HP</div>
          <input class="form-input" type="tel" name="pax_phone" id="fcPhone" placeholder="+62 8xx-xxxx-xxxx" required>
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
        <div class="cs-row"><span class="l">Harga tiket</span><span class="r" id="fcTotalDisp">-</span></div>
        <div class="cs-row"><span class="l">Pajak & biaya</span><span class="r">Sudah termasuk</span></div>
        <div class="cs-total"><span class="l">Total</span><span class="r" id="fcGrandTotal">-</span></div>
        <div class="cs-incl">✓ Harga sudah termasuk semua pajak</div>
      </div>
      <button type="submit" class="btn-primary">Konfirmasi Pemesanan →</button>
    </form>
  </div>
</div>

<!-- City picker modal (shared) -->
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
const CITIES_FLIGHT = [
  {name:'Surabaya',sub:'Jawa Timur',code:'SUB'},
  {name:'Jakarta',sub:'DKI Jakarta',code:'CGK'},
  {name:'Bali',sub:'Bali',code:'DPS'},
  {name:'Bandung',sub:'Jawa Barat',code:'BDO'},
  {name:'Yogyakarta',sub:'DI Yogyakarta',code:'JOG'},
  {name:'Medan',sub:'Sumatera Utara',code:'KNO'},
  {name:'Makassar',sub:'Sulawesi Selatan',code:'UPG'},
  {name:'Semarang',sub:'Jawa Tengah',code:'SRG'},
  {name:'Palembang',sub:'Sumatera Selatan',code:'PLM'},
  {name:'Manado',sub:'Sulawesi Utara',code:'MDC'},
  {name:'Balikpapan',sub:'Kalimantan Timur',code:'BPN'},
  {name:'Lombok',sub:'Nusa Tenggara Barat',code:'LOP'},
  {name:'Batam',sub:'Kepulauan Riau',code:'BTH'},
  {name:'Solo',sub:'Jawa Tengah',code:'SOC'},
  {name:'Malang',sub:'Jawa Timur',code:'MLG'},
];

let cityModalTarget = null;
let allCities = CITIES_FLIGHT;

function openCityModal(target) {
  cityModalTarget = target;
  const titles = {flight_from:'Pilih Kota Asal', flight_to:'Pilih Kota Tujuan'};
  document.getElementById('cityModalTitle').textContent = titles[target] || 'Pilih Kota';
  document.getElementById('citySearch').value = '';
  renderCities(CITIES_FLIGHT);
  toggleModal('cityModal');
}
function closeCityModal() { closeModal('cityModal'); }
function renderCities(cities) {
  const list = document.getElementById('cityList');
  list.innerHTML = cities.map(c => {
    return `<div onclick='selectCity(${JSON.stringify(c)})' style="display:flex;align-items:center;justify-content:space-between;padding:13px 14px;border-radius:14px;background:rgba(255,255,255,0.65);border:1.5px solid rgba(255,255,255,0.85);cursor:pointer;" ontouchstart="this.style.background='rgba(168,216,200,0.35)'" ontouchend="this.style.background='rgba(255,255,255,0.65)'">
      <div>
        <div style="font-size:14px;font-weight:700;">${c.name}</div>
        <div style="font-size:11px;color:var(--c-text3);">${c.sub}</div>
      </div>
      <span style="font-size:12px;font-weight:800;color:var(--a-main2);background:rgba(123,159,212,0.15);padding:3px 8px;border-radius:8px;">${c.code}</span>
    </div>`;
  }).join('');
}
function filterCities() {
  const q = document.getElementById('citySearch').value.toLowerCase();
  renderCities(CITIES_FLIGHT.filter(c => c.name.toLowerCase().includes(q) || c.code.toLowerCase().includes(q)));
}
function selectCity(c) {
  if (cityModalTarget === 'flight_from') {
    document.getElementById('flightFrom').value = c.code + ' - ' + c.name;
    document.getElementById('flightFromCode').value = c.code;
  } else {
    document.getElementById('flightTo').value = c.code + ' - ' + c.name;
    document.getElementById('flightToCode').value = c.code;
  }
  closeCityModal();
}

// Flight booking checkout modal
function bookFlight(id, f) {
  document.getElementById('fcFlightId').value = id;
  document.getElementById('fcAirline').textContent = f.logo + ' ' + f.airline;
  document.getElementById('fcClass').textContent = f.airline_code + ' · ' + f.flight_class;
  document.getElementById('fcLogo').textContent = f.logo;
  document.getElementById('fcFrom').textContent = f.from;
  document.getElementById('fcFromCity').textContent = f.from_city;
  document.getElementById('fcDep').textContent = f.dep;
  document.getElementById('fcTo').textContent = f.to;
  document.getElementById('fcToCity').textContent = f.to_city;
  document.getElementById('fcArr').textContent = f.arr;
  document.getElementById('fcDur').textContent = f.duration;
  document.getElementById('fcDate').textContent = '<?=fd($dep)?>';
  const priceStr = 'Rp ' + f.price.toLocaleString('id-ID');
  document.getElementById('fcPrice').textContent = priceStr;
  document.getElementById('fcTotalDisp').textContent = priceStr;
  document.getElementById('fcGrandTotal').textContent = priceStr;

  // Prefill from session if available
  <?php if(isset($_SESSION['saved_guest'])): ?>
  document.getElementById('fcName').value = '<?=addslashes($_SESSION['saved_guest']['name'])?>';
  document.getElementById('fcEmail').value = '<?=addslashes($_SESSION['saved_guest']['email'])?>';
  document.getElementById('fcPhone').value = '<?=addslashes($_SESSION['saved_guest']['phone'])?>';
  <?php endif; ?>

  toggleModal('flightCheckoutModal');
}

// Handle flight form submission → store booking in session via confirm_flight.php
document.getElementById('fcForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('confirm_flight.php', { method:'POST', body: fd })
    .then(r => r.json())
    .then(data => {
      if (data.success) window.location.href = 'confirm.php?type=flight&booking_id=' + data.booking_id;
      else alert('Terjadi kesalahan, silakan coba lagi.');
    }).catch(() => {
      // Fallback: submit normally
      this.submit();
    });
});
</script>
</body></html>
