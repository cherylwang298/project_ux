<?php require_once 'config.php'; checkLogin();

// Save flight to session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['flight']) && !isset($_POST['confirm']) && !isset($_POST['apply_promo'])) {
    $_SESSION['temp_booking'] = [
        'flight'     => json_decode($_POST['flight'], true),
        'passengers' => max(1,(int)$_POST['passengers']),
        'date'       => $_POST['date'],
    ];
    $_SESSION['temp_discount'] = 0;
    header('Location: booking_checkout.php'); exit;
}

if (empty($_SESSION['temp_booking'])) { header('Location: flight_search.php'); exit; }

$book   = $_SESSION['temp_booking'];
$flight = $book['flight'];
$pass   = $book['passengers'];
$subtotal = $flight['price'] * $pass;
$safetyFee = 3 * $pass;

// Apply promo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_promo'])) {
    $code = strtoupper(trim($_POST['promo_code'] ?? ''));
    $_SESSION['temp_discount'] = $promoCodes[$code] ?? 0;
    $_SESSION['promo_msg'] = isset($promoCodes[$code]) ? "✅ Diskon {$promoCodes[$code]}% berhasil diterapkan!" : '❌ Kode promo tidak valid.';
}

// Confirm booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    $selAddons = [];
    $addonTotal = 0;
    foreach ($addons as $k => $a) {
        if (!empty($_POST[$k])) { $selAddons[$k] = $a; $addonTotal += $a['price'] * $pass; }
    }
    $discount    = (int)($_SESSION['temp_discount'] ?? 0);
    $grossTotal  = $subtotal + $safetyFee + $addonTotal;
    $finalTotal  = round($grossTotal * (100 - $discount) / 100);
    $ticket = [
        'id'          => 'TKT'.rand(10000,99999),
        'booking_code'=> 'SVY'.strtoupper(substr(uniqid(),7)),
        'type'        => 'flight',
        'flight'      => $flight,
        'passengers'  => $pass,
        'date'        => $book['date'],
        'addons'      => $selAddons,
        'safety_fee'  => $safetyFee,
        'discount'    => $discount,
        'payment'     => $_POST['payment_method'] ?? '-',
        'subtotal'    => $subtotal,
        'total'       => $finalTotal,
        'booked_at'   => date('d M Y, H:i'),
    ];
    $_SESSION['tickets'][] = $ticket;
    $_SESSION['last_ticket'] = $ticket;
    unset($_SESSION['temp_booking'], $_SESSION['temp_discount'], $_SESSION['promo_msg']);
    header('Location: payment_success.php'); exit;
}

$discount  = (int)($_SESSION['temp_discount'] ?? 0);
$promoMsg  = $_SESSION['promo_msg'] ?? '';
unset($_SESSION['promo_msg']);
?>
<?php headHtml('Checkout','
.flight-summary{background:var(--primary);color:#fff;border-radius:16px;padding:16px;margin-bottom:14px;}
.flight-summary .times{display:flex;align-items:center;gap:8px;margin:10px 0;}
.flight-summary .time{font-size:22px;font-weight:800;}
.flight-summary .label{font-size:11px;opacity:.7;}
.flight-summary .line{flex:1;height:1px;background:rgba(255,255,255,.3);position:relative;}
.flight-summary .dur{font-size:10px;background:rgba(255,255,255,.15);padding:2px 8px;border-radius:40px;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);white-space:nowrap;}
.addon-item{display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid var(--border);}
.addon-item:last-child{border-bottom:none;}
.addon-icon{font-size:20px;width:32px;text-align:center;}
.addon-label{flex:1;font-size:14px;}
.addon-price{font-size:13px;color:var(--gray);}
.addon-item input[type=checkbox]{width:20px;height:20px;accent-color:var(--primary);}
.pay-method{display:flex;align-items:center;gap:10px;padding:11px 14px;border:1.5px solid var(--border);border-radius:12px;margin-bottom:8px;cursor:pointer;transition:.15s;}
.pay-method.selected{border-color:var(--primary);background:#EEF2FF;}
.pay-method input{display:none;}
.pay-icon{font-size:20px;width:28px;text-align:center;}
.pay-label{font-size:14px;font-weight:500;}
.pay-group-title{font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:.05em;margin:14px 0 8px;}
.total-row{display:flex;justify-content:space-between;font-size:14px;padding:6px 0;}
.total-grand{font-size:18px;font-weight:800;color:var(--primary);}
.promo-row{display:flex;gap:8px;}
.promo-row input{flex:1;padding:12px 14px;border:1.5px solid var(--border);border-radius:12px;font-size:14px;outline:none;}
.promo-row input:focus{border-color:var(--primary);}
.promo-row button{padding:12px 18px;background:var(--primary);color:#fff;border:none;border-radius:12px;font-weight:700;cursor:pointer;}
') ?>
</head>
<body>
<div class="page-header">
  <a href="flight_search.php" class="back-btn">←</a>
  <h2>Checkout</h2>
</div>

<div class="container">
<form method="POST" id="checkoutForm">

  <!-- Flight Summary -->
  <div class="flight-summary">
    <div style="font-size:13px;opacity:.8;"><?= $flight['airline'] ?> · <?= $flight['flight_num'] ?> · <?= $flight['class'] ?></div>
    <div class="times">
      <div><div class="time"><?= $flight['departure'] ?></div><div class="label"><?= $flight['origin'] ?></div></div>
      <div class="line"><div class="dur"><?= $flight['duration'] ?></div></div>
      <div style="text-align:right;"><div class="time"><?= $flight['arrival'] ?></div><div class="label"><?= $flight['destination'] ?></div></div>
    </div>
    <div style="font-size:12px;opacity:.8;"><?= date('D, d M Y', strtotime($book['date'])) ?> · <?= $pass ?> Penumpang</div>
  </div>

  <!-- Add-ons -->
  <div class="card">
    <h3 style="margin-bottom:12px;">➕ Layanan Tambahan</h3>
    <?php foreach ($addons as $k => $a): ?>
    <label class="addon-item" style="cursor:pointer;">
      <input type="checkbox" name="<?= $k ?>">
      <div class="addon-icon"><?= $a['icon'] ?></div>
      <div class="addon-label"><?= $a['label'] ?></div>
      <div class="addon-price">+$<?= $a['price'] ?>/org</div>
    </label>
    <?php endforeach; ?>
  </div>

  <!-- Promo Code -->
  <div class="card">
    <h3 style="margin-bottom:10px;">🎫 Kode Promo</h3>
    <div class="promo-row">
      <input type="text" name="promo_code" placeholder="VOYAGE10 / HEMAT20 / INDONESIA" value="">
      <button type="submit" name="apply_promo">Pakai</button>
    </div>
    <?php if ($promoMsg): ?>
    <p style="margin-top:8px;font-size:13px;<?= $discount>0?'color:green':'color:var(--accent)' ?>"><?= $promoMsg ?></p>
    <?php elseif ($discount > 0): ?>
    <p style="margin-top:8px;font-size:13px;color:green;">✅ Diskon <?= $discount ?>% aktif!</p>
    <?php endif; ?>
  </div>

  <!-- Payment Method -->
  <div class="card">
    <h3 style="margin-bottom:4px;">💳 Metode Pembayaran</h3>
    <p class="pay-group-title">Transfer Bank</p>
    <?php foreach (['bank_bca','bank_mandiri','bank_bni','bank_bri'] as $k): ?>
    <label class="pay-method" onclick="selectPay(this)">
      <input type="radio" name="payment_method" value="<?= $k ?>" <?= $k==='bank_bca'?'checked':'' ?>>
      <div class="pay-icon"><?= $paymentMethods[$k]['icon'] ?></div>
      <div class="pay-label"><?= $paymentMethods[$k]['label'] ?></div>
    </label>
    <?php endforeach; ?>
    <p class="pay-group-title">Dompet Digital</p>
    <?php foreach (['gopay','ovo','dana'] as $k): ?>
    <label class="pay-method" onclick="selectPay(this)">
      <input type="radio" name="payment_method" value="<?= $k ?>">
      <div class="pay-icon"><?= $paymentMethods[$k]['icon'] ?></div>
      <div class="pay-label"><?= $paymentMethods[$k]['label'] ?></div>
    </label>
    <?php endforeach; ?>
    <p class="pay-group-title">Lainnya</p>
    <?php foreach (['bri_va','cc_visa','cc_mc','alfamart','indomaret','paylater'] as $k): ?>
    <label class="pay-method" onclick="selectPay(this)">
      <input type="radio" name="payment_method" value="<?= $k ?>">
      <div class="pay-icon"><?= $paymentMethods[$k]['icon'] ?></div>
      <div class="pay-label"><?= $paymentMethods[$k]['label'] ?></div>
    </label>
    <?php endforeach; ?>
  </div>

  <!-- Total Summary -->
  <div class="card" id="priceBox">
    <h3 style="margin-bottom:10px;">💰 Rincian Biaya</h3>
    <div class="total-row"><span>Harga tiket (<?= $pass ?> org × $<?= $flight['price'] ?>)</span><span>$<?= $subtotal ?></span></div>
    <div class="total-row"><span>Safety fee</span><span>$<?= $safetyFee ?></span></div>
    <div class="total-row" id="addonRow" style="display:none;"><span>Layanan tambahan</span><span id="addonAmt">$0</span></div>
    <?php if ($discount > 0): ?>
    <div class="total-row" style="color:green;"><span>Diskon <?= $discount ?>%</span><span id="discountAmt">-$0</span></div>
    <?php endif; ?>
    <hr style="margin:10px 0;border-color:var(--border);">
    <div class="total-row total-grand"><span>Total Bayar</span><span id="grandTotal">$<?= round(($subtotal+$safetyFee)*(100-$discount)/100) ?></span></div>
  </div>

  <button type="submit" name="confirm" class="btn btn-accent" style="margin-bottom:16px;">✅ Konfirmasi & Bayar</button>
</form>
</div>

<?php renderNav('home'); ?>
<script>
const base = <?= $subtotal + $safetyFee ?>;
const disc = <?= $discount ?>;
const addonPrices = <?= json_encode(array_map(fn($a)=>$a['price'], $addons)) ?>;
const pass = <?= $pass ?>;

function selectPay(el){
  document.querySelectorAll('.pay-method').forEach(e=>e.classList.remove('selected'));
  el.classList.add('selected');
  el.querySelector('input').checked=true;
}
// Init first
document.querySelectorAll('.pay-method')[0]?.classList.add('selected');

document.querySelectorAll('input[type=checkbox]').forEach(cb=>{
  cb.addEventListener('change', updateTotal);
});

function updateTotal(){
  let addonTotal=0;
  <?php foreach ($addons as $k=>$a): ?>
  if(document.querySelector('input[name="<?= $k ?>"]')?.checked) addonTotal+=<?= $a['price'] ?>*pass;
  <?php endforeach; ?>
  const gross = base + addonTotal;
  const final = Math.round(gross*(100-disc)/100);
  document.getElementById('grandTotal').textContent='$'+final;
  if(addonTotal>0){
    document.getElementById('addonRow').style.display='flex';
    document.getElementById('addonAmt').textContent='$'+addonTotal;
  } else {
    document.getElementById('addonRow').style.display='none';
  }
  const discElem = document.getElementById('discountAmt');
  if(discElem) discElem.textContent='-$'+Math.round(gross*disc/100);
}
</script>
</body>
</html>