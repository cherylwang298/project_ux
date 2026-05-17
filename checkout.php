<?php
session_start();
require '_data.php';
require '_head.php';

$id       = (int)($_GET['id']??1);
$hidx     = array_search($id,array_column($HOTELS,'id'));
$h        = $HOTELS[$hidx];
$checkin  = $_GET['checkin']  ?? date('Y-m-d',strtotime('+1 day'));
$checkout = $_GET['checkout'] ?? date('Y-m-d',strtotime('+3 days'));
$nights   = (int)($_GET['nights']??2);
$total    = (float)($_GET['total']??0);
$guest    = $_SESSION['saved_guest'] ?? ['name'=>'','email'=>'','phone'=>''];

// Save contacts in session
if(!isset($_SESSION['contacts'])){
  $_SESSION['contacts'] = [
    ['id'=>1,'name'=>'Ceri Wijaya','email'=>'ceri@email.com','phone'=>'+62 812-3456-7890','color'=>'#5B5FEF'],
    ['id'=>2,'name'=>'Mama','email'=>'mama@gmail.com','phone'=>'+62 813-9876-5432','color'=>'#7C3AED'],
  ];
}

// Handle add contact via POST
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['add_contact'])){
  $newC = ['id'=>time(),'name'=>$_POST['nc_name']??'','email'=>$_POST['nc_email']??'','phone'=>$_POST['nc_phone']??'','color'=>'#00C896'];
  if($newC['name']) $_SESSION['contacts'][] = $newC;
  header('Location: checkout.php?id='.$id.'&checkin='.$checkin.'&checkout='.$checkout.'&nights='.$nights.'&total='.urlencode($total));
  exit;
}

// Handle booking
if($_SERVER['REQUEST_METHOD']==='POST' && !isset($_POST['add_contact'])){
  $_SESSION['booking'] = [
    'booking_id'=>'STE-'.strtoupper(substr(md5(time()),0,8)),
    'hotel_id'=>$id,'hotel_name'=>$h['name'],
    'checkin'=>$checkin,'checkout'=>$checkout,'nights'=>$nights,'total'=>$total,
    'guest_name'=>$_POST['guest_name']??$guest['name'],
    'guest_email'=>$_POST['guest_email']??$guest['email'],
    'guest_phone'=>$_POST['guest_phone']??$guest['phone'],
    'payment_method'=>$_POST['payment_method']??'ovo',
    'status'=>'confirmed','created_at'=>date('Y-m-d H:i:s'),
    'cancellation'=>$h['cancel_policy'],
  ];
  $_SESSION['saved_guest'] = ['name'=>$_POST['guest_name'],'email'=>$_POST['guest_email'],'phone'=>$_POST['guest_phone']];
  if(!isset($_SESSION['orders'])) $_SESSION['orders']=[];
  $_SESSION['orders'][] = $_SESSION['booking'];
  header('Location: confirm.php'); exit;
}
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Checkout — StayEase</title><?=$font?><?=$css?>
</head><body>

<?=header_bar('Checkout','hotel.php?id='.$id.'&checkin='.$checkin.'&checkout='.$checkout)?>

<!-- Progress -->
<div class="progress-bar-wrap" style="padding-top:calc(var(--nav-h)+16px);">
  <div class="progress-steps">
    <div class="progress-track"><div class="progress-fill" style="width:33%"></div></div>
    <div class="step-item done"><div class="step-dot done">✓</div><div class="step-label">Hotel</div></div>
    <div class="step-item active"><div class="step-dot active">2</div><div class="step-label">Detail</div></div>
    <div class="step-item"><div class="step-dot">3</div><div class="step-label">Bayar</div></div>
  </div>
</div>

<form method="POST" id="coForm">
<div style="padding:16px 20px 120px;">

  <!-- Hotel mini -->
  <div class="hotel-mini-card glass" style="margin-bottom:16px;">
    <div class="hotel-mini-img" style="background:<?=$h['grad']?>">🏨</div>
    <div style="flex:1;min-width:0;">
      <div class="hotel-mini-name"><?=$h['name']?></div>
      <div class="hotel-mini-dates"><?=fds($checkin)?> → <?=fds($checkout)?> · <?=$nights?> malam</div>
    </div>
    <div class="hotel-mini-price"><?=rp($total)?></div>
  </div>

  <!-- ── Data Tamu ── -->
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
    <div class="form-sec-label" style="margin-bottom:0;">Data Tamu</div>
    <button type="button" onclick="openContactPicker()" style="background:var(--c-accent-soft);color:var(--c-accent);border:none;border-radius:20px;padding:6px 12px;font-size:11px;font-weight:700;cursor:pointer;font-family:var(--f);">+ Pilih / Tambah</button>
  </div>

  <div id="autofillBadge" style="display:none;align-items:center;gap:7px;background:var(--c-green-soft);border:1px solid var(--c-green-border);border-radius:var(--r-sm);padding:9px 12px;margin-bottom:10px;font-size:11px;color:var(--c-green);font-weight:600;">
    ✓ <span>Data diisi otomatis</span>
  </div>

  <div class="form-card glass" style="border-radius:var(--r-lg);overflow:hidden;margin-bottom:16px;">
    <div class="form-group">
      <div class="form-label-row">Nama Lengkap</div>
      <input class="form-input" type="text" id="guest_name" name="guest_name" value="<?=htmlspecialchars($guest['name'])?>" placeholder="Nama sesuai KTP/Paspor" required>
    </div>
    <div class="form-group">
      <div class="form-label-row">Email</div>
      <input class="form-input" type="email" id="guest_email" name="guest_email" value="<?=htmlspecialchars($guest['email'])?>" placeholder="email@kamu.com" required>
    </div>
    <div class="form-group" style="border-bottom:none;">
      <div class="form-label-row">Nomor HP</div>
      <input class="form-input" type="tel" id="guest_phone" name="guest_phone" value="<?=htmlspecialchars($guest['phone'])?>" placeholder="+62 8xx-xxxx-xxxx" required>
    </div>
  </div>

  <!-- ── Tambahan Opsional ── -->
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
    <div class="form-sec-label" style="margin-bottom:0;">Tambahan Opsional</div>
    <span style="font-size:10px;background:rgba(0,0,0,0.06);color:var(--c-text3);border-radius:20px;padding:3px 9px;font-weight:600;">Pilih jika butuh</span>
  </div>
  <div class="upsell-list glass" style="border-radius:var(--r-lg);margin-bottom:16px;">
    <div class="upsell-item"><span class="upsell-emoji">🛡️</span><div><div class="upsell-name">Asuransi Perjalanan</div><div class="upsell-price">+Rp 35.000 · perlindungan pembatalan</div></div><div class="upsell-check"><input type="checkbox" name="insurance" data-price="35000"></div></div>
    <div class="upsell-item"><span class="upsell-emoji">🍳</span><div><div class="upsell-name">Sarapan Premium</div><div class="upsell-price">+Rp 75.000/orang · buffet internasional</div></div><div class="upsell-check"><input type="checkbox" name="breakfast" data-price="75000"></div></div>
    <div class="upsell-item" style="border-bottom:none;"><span class="upsell-emoji">🚗</span><div><div class="upsell-name">Jemputan Bandara</div><div class="upsell-price">+Rp 120.000 · maks 4 penumpang</div></div><div class="upsell-check"><input type="checkbox" name="transfer" data-price="120000"></div></div>
  </div>

  <!-- ── Pembayaran ── -->
  <div class="form-sec-label">Metode Pembayaran</div>
  <div class="payment-options glass" style="border-radius:var(--r-lg);margin-bottom:16px;">
    <div class="payment-option selected" onclick="selectPayment(this)">
      <input type="radio" name="payment_method" value="ovo" checked>
      <div class="pay-icon" style="background:rgba(98,0,234,.1)">💜</div>
      <div><div class="pay-name">OVO</div><div class="pay-desc">Saldo Rp 2.500.000</div></div>
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

  <!-- ── Price summary ── -->
  <div class="checkout-summary glass" style="border-radius:var(--r-lg);">
    <div class="cs-row"><span class="l">Harga kamar</span><span class="r" id="baseAmt"><?=rp($total)?></span></div>
    <div class="cs-row"><span class="l">Tambahan opsional</span><span class="r" id="extraAmt" style="color:var(--c-text3);">Rp 0</span></div>
    <div class="cs-total"><span class="l">Total</span><span class="r" id="grandTotal"><?=rp($total)?></span></div>
    <div class="cs-incl">✓ Sudah termasuk pajak & layanan — tidak ada biaya tersembunyi</div>
  </div>

  <p style="font-size:11px;color:var(--c-text3);text-align:center;margin-top:14px;line-height:1.5;">Dengan melanjutkan kamu menyetujui <span style="color:var(--c-accent);">Syarat & Ketentuan</span> StayEase</p>
</div>

<!-- Sticky bar -->
<div class="sticky-bar glass-strong">
  <div class="sticky-price-wrap">
    <div class="sticky-tag">✓ Aman & terenkripsi</div>
    <div class="sticky-amount" id="stickyAmt"><?=rp($total)?></div>
  </div>
  <button type="submit" class="btn-primary" style="width:148px;flex-shrink:0;padding:14px 0;" id="payBtn">
    Bayar Sekarang
  </button>
</div>
</form>

<!-- ── Contact Picker Modal (Shopee-style) ── -->
<div class="modal-overlay" id="contactModal" onclick="closeModal('contactModal')">
  <div class="modal-sheet" onclick="event.stopPropagation()" style="padding-bottom:32px;max-height:85vh;overflow-y:auto;">
    <div class="modal-handle"></div>
    <div class="modal-title">Pilih Data Tamu</div>

    <div class="contact-list" id="contactList">
      <?php foreach($_SESSION['contacts'] as $c): ?>
      <div class="contact-item" onclick="selectContactJS(<?=htmlspecialchars(json_encode($c))?>)">
        <div class="contact-av" style="background:<?=$c['color']?>"><?=strtoupper(substr($c['name'],0,1))?></div>
        <div class="contact-info">
          <div class="contact-name"><?=htmlspecialchars($c['name'])?></div>
          <div class="contact-detail"><?=htmlspecialchars($c['email'])?> · <?=htmlspecialchars($c['phone'])?></div>
        </div>
        <div class="contact-check"><svg width="12" height="12" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Add new contact -->
    <div style="margin-top:8px;">
      <button type="button" onclick="showAddForm()" class="add-contact-btn" style="width:100%;border:none;font-family:var(--f);font-size:14px;">
        <div style="width:42px;height:42px;border-radius:50%;background:var(--c-accent-soft);border:2px dashed rgba(91,95,239,0.3);display:flex;align-items:center;justify-content:center;font-size:20px;">+</div>
        Tambah Data Baru
      </button>
    </div>

    <!-- Add form (hidden by default) -->
    <div id="addContactForm" style="display:none;margin-top:14px;">
      <form method="POST" action="checkout.php?id=<?=$id?>&checkin=<?=$checkin?>&checkout=<?=$checkout?>&nights=<?=$nights?>&total=<?=urlencode($total)?>">
        <input type="hidden" name="add_contact" value="1">
        <div style="font-size:11px;font-weight:700;color:var(--c-text3);text-transform:uppercase;letter-spacing:0.7px;margin-bottom:10px;">Data Baru</div>
        <div class="form-card glass" style="border-radius:var(--r-md);overflow:hidden;margin-bottom:10px;">
          <div class="form-group"><div class="form-label-row">Nama</div><input class="form-input" type="text" name="nc_name" placeholder="Nama lengkap" required></div>
          <div class="form-group"><div class="form-label-row">Email</div><input class="form-input" type="email" name="nc_email" placeholder="email@kamu.com"></div>
          <div class="form-group" style="border-bottom:none;"><div class="form-label-row">No. HP</div><input class="form-input" type="tel" name="nc_phone" placeholder="+62..."></div>
        </div>
        <button type="submit" class="btn-primary">Simpan Data</button>
      </form>
    </div>
  </div>
</div>

<script src="assets/app.js"></script>
<script>
const BASE = <?=$total?>;
function updateTotals(){
  let extra=0;
  document.querySelectorAll('.upsell-check input:checked').forEach(cb=>extra+=parseFloat(cb.dataset.price||0));
  const t=BASE+extra;
  const f=n=>'Rp '+n.toLocaleString('id-ID');
  document.getElementById('extraAmt').textContent=extra>0?f(extra):'Rp 0';
  document.getElementById('grandTotal').textContent=f(t);
  document.getElementById('stickyAmt').textContent=f(t);
}
function openContactPicker(){ toggleModal('contactModal'); }
function selectContactJS(c){
  document.getElementById('guest_name').value=c.name;
  document.getElementById('guest_email').value=c.email;
  document.getElementById('guest_phone').value=c.phone;
  closeModal('contactModal');
  const b=document.getElementById('autofillBadge');
  b.style.display='flex';
  b.querySelector('span').textContent='Data diisi dari: '+c.name;
}
function showAddForm(){
  const f=document.getElementById('addContactForm');
  f.style.display=f.style.display==='none'?'block':'none';
}
document.getElementById('coForm').addEventListener('submit',function(){
  const btn=document.getElementById('payBtn');
  btn.innerHTML='⏳ Memproses...';
  btn.disabled=true;
  setTimeout(()=>{btn.disabled=false;},8000);
});
</script>
</body></html>
