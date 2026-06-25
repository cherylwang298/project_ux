<?php
require 'config.php';
requireAuth();

$ref = trim((string)($_GET['ref'] ?? ''));
if ($ref === '') {
    flashSet('error', 'Booking reference not found.');
    header('Location: riwayat.php');
    exit;
}

$user = auth();
$b = getBookingByRef($ref);
if (!$b || (int)($b['user_id'] ?? 0) !== (int)$user['id']) {
    flashSet('error', 'Booking not found.');
    header('Location: riwayat.php');
    exit;
}

$item = $b['_item'] ?? null;
if (!$item && !empty($b['property_id'])) {
    $item = getProperty((int)$b['property_id']);
}
if (!$item || !is_array($item)) {
    $item = [];
}

function rv_val($arr, string $key, string $default = '-') {
    if (!is_array($arr)) return $default;
    $v = $arr[$key] ?? $default;
    if (is_array($v)) return $default;
    $v = trim((string)$v);
    return $v !== '' ? $v : $default;
}
function rv_date($date) {
    $t = strtotime((string)$date);
    return $t ? date('d M Y', $t) : '-';
}
function rv_nights($in, $out) {
    $a = strtotime((string)$in);
    $b = strtotime((string)$out);
    if (!$a || !$b || $b <= $a) return 1;
    return max(1, (int)ceil(($b - $a) / 86400));
}

$type = strtolower(rv_val($item, 'type', $b['booking_type'] ?? 'hotel'));
$typeLabel = ucfirst($type);
$name = rv_val($item, 'name', $type === 'villa' ? 'Villa Booking' : 'Hotel Booking');
$location = rv_val($item, 'location', '-');
$image = rv_val($item, 'image_url', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1400&q=80');
$checkin = $b['check_in'] ?? date('Y-m-d');
$checkout = $b['check_out'] ?? date('Y-m-d', strtotime('+1 day'));
$nights = rv_nights($checkin, $checkout);
$guests = max(1, (int)($b['guests'] ?? 1));
$total = (float)($b['total_amount'] ?? 0);
$subtotal = $total > 0 ? $total / 1.11 : 0;
$tax = $total - $subtotal;
$status = ucfirst((string)($b['status'] ?? 'confirmed'));
$guestName = $b['guest_name'] ?? ($user['name'] ?? 'Guest');
$guestEmail = $b['guest_email'] ?? ($user['email'] ?? '-');
$guestPhone = $b['guest_phone'] ?? ($user['phone'] ?? '-');
$paymentLabels = ['bank_transfer'=>'Bank Transfer','gopay'=>'GoPay','ovo'=>'OVO','qris'=>'QRIS','credit_card'=>'Credit Card'];
$payment = $paymentLabels[$b['payment_method'] ?? ''] ?? ($b['payment_method'] ?? '-');
$amenities = !empty($item['amenities']) && is_array($item['amenities']) ? $item['amenities'] : ['Free WiFi','Air Conditioning','Private Bathroom'];
$room = !empty($b['room']) && is_array($b['room']) ? $b['room'] : null;
$displayName = $name;
if ($type === 'hotel' && $room && !empty($room['name'])) {
    $displayName .= ' · ' . $room['name'];
}
$accent = $type === 'villa' ? '#00b8d9' : '#004ce2';
$accent2 = $type === 'villa' ? '#00d2ff' : '#3267ff';

$pricePerNight = $nights > 0 ? ($subtotal / $nights) : $subtotal;

echo htmlHead('Booking Confirmed', <<<CSS
body{background:radial-gradient(circle at top right,rgba(0,210,255,.14),transparent 36%),radial-gradient(circle at top left,rgba(0,76,226,.10),transparent 34%),#f8f9ff}.receipt-page{padding-top:130px;padding-bottom:80px;min-height:100vh}.receipt-card{background:rgba(255,255,255,.9);backdrop-filter:blur(30px);-webkit-backdrop-filter:blur(30px);border:1px solid rgba(195,197,216,.45);box-shadow:0 24px 70px rgba(0,76,226,.12)}.ticket-header{background:linear-gradient(135deg,#111c2d 0%,{$accent} 62%,{$accent2} 100%)}.info-card{background:rgba(246,248,255,.84);border:1px solid rgba(195,197,216,.38)}.success-pill{background:rgba(34,197,94,.12);color:#15803d;border:1px solid rgba(34,197,94,.28)}@keyframes successPop{0%{transform:scale(.4);opacity:0}60%{transform:scale(1.12);opacity:1}100%{transform:scale(1);opacity:1}}@keyframes checkPulse{0%,100%{box-shadow:0 0 0 0 rgba(34,197,94,.22)}50%{box-shadow:0 0 0 14px rgba(34,197,94,0)}}@keyframes cDrop{0%{transform:translateY(-30px) rotate(0deg);opacity:1}100%{transform:translateY(110vh) rotate(720deg);opacity:0}}.check-success{animation:successPop .55s cubic-bezier(.22,1,.36,1),checkPulse 2.4s ease-in-out infinite}.confetti-piece{position:fixed;top:-30px;z-index:9999;pointer-events:none;animation-name:cDrop;animation-timing-function:linear;animation-iteration-count:infinite}@media print{.no-print{display:none!important}body{background:white!important}.receipt-page{padding-top:20px!important}.receipt-card{box-shadow:none!important}}
CSS);
?>
<body class="text-on-background min-h-screen">
<?= navbar('riwayat.php') ?>
<div id="confettiLayer"></div>

<main class="receipt-page px-5 md:px-16 max-w-[1280px] mx-auto" style="display:block;visibility:visible;opacity:1;transform:none;">
  <?= renderFlash() ?>
  <section class="text-center mb-8">
    <div class="check-success w-24 h-24 rounded-full bg-green-100 border-4 border-green-300 flex items-center justify-center mx-auto mb-4 shadow-xl relative">
      <span class="material-symbols-outlined icon-fill text-green-600 text-6xl">check_circle</span>
    </div>
    <div class="inline-flex items-center gap-2 success-pill rounded-full px-4 py-2 mb-4 text-sm font-bold">
      <span class="material-symbols-outlined text-[18px] icon-fill">verified</span> Booking Confirmed
    </div>
    <h1 class="text-3xl md:text-5xl font-extrabold text-on-surface tracking-tight mb-2">Your <?= h($typeLabel) ?> is Booked</h1>
    <p class="text-on-surface-variant">Ref: <span class="font-bold text-primary"><?= h($ref) ?></span></p>
  </section>

  <section class="max-w-5xl mx-auto receipt-card rounded-[2rem] overflow-hidden">
    <div class="ticket-header p-6 md:p-8 text-white relative overflow-hidden">
      <div class="absolute inset-0 opacity-15 bg-cover bg-center" style="background-image:url('<?= h($image) ?>')"></div>
      <div class="absolute inset-0 bg-black/25"></div>
      <div class="relative z-10">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-5 mb-8">
          <div>
            <div class="inline-flex items-center gap-2 bg-white/15 border border-white/20 rounded-full px-3 py-1 mb-4 text-xs font-bold">
              <span class="material-symbols-outlined text-[16px]"><?= $type === 'hotel' ? 'hotel' : 'villa' ?></span><?= h($typeLabel) ?>
            </div>
            <h2 class="text-3xl md:text-5xl font-extrabold tracking-tight mb-2"><?= h($displayName) ?></h2>
            <p class="text-white/75 flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">location_on</span><?= h($location) ?></p>
          </div>
          <div class="text-left md:text-right">
            <p class="text-white/60 text-xs uppercase tracking-wider mb-1">Booking Ref</p>
            <p class="font-mono font-extrabold text-lg"><?= h($ref) ?></p>
            <p class="text-white/60 text-xs mt-1"><?= h(rv_date($b['created_at'] ?? date('Y-m-d'))) ?></p>
          </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
          <div class="bg-white/12 border border-white/15 rounded-2xl p-3"><p class="text-white/55 text-xs mb-1">Check-in</p><p class="font-bold text-sm"><?= h(rv_date($checkin)) ?></p></div>
          <div class="bg-white/12 border border-white/15 rounded-2xl p-3"><p class="text-white/55 text-xs mb-1">Check-out</p><p class="font-bold text-sm"><?= h(rv_date($checkout)) ?></p></div>
          <div class="bg-white/12 border border-white/15 rounded-2xl p-3"><p class="text-white/55 text-xs mb-1">Guests</p><p class="font-bold text-sm"><?= $guests ?> guest<?= $guests > 1 ? 's' : '' ?></p></div>
          <div class="bg-white/12 border border-white/15 rounded-2xl p-3"><p class="text-white/55 text-xs mb-1">Status</p><p class="font-bold text-sm"><?= h($status) ?></p></div>
        </div>
      </div>
    </div>

    <div class="p-6 md:p-8">
      <section class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
        <div class="info-card rounded-3xl p-5 lg:col-span-2">
          <h2 class="font-extrabold text-on-surface text-lg mb-4">Stay Details</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="bg-white/70 border border-outline-variant/30 rounded-2xl p-4"><span class="material-symbols-outlined text-primary mb-2">calendar_month</span><p class="text-xs text-outline">Duration</p><p class="font-bold text-on-surface"><?= $nights ?> night<?= $nights > 1 ? 's' : '' ?></p></div>
            <div class="bg-white/70 border border-outline-variant/30 rounded-2xl p-4"><span class="material-symbols-outlined text-primary mb-2">group</span><p class="text-xs text-outline">Guests</p><p class="font-bold text-on-surface"><?= $guests ?> guest<?= $guests > 1 ? 's' : '' ?></p></div>
            <div class="bg-white/70 border border-outline-variant/30 rounded-2xl p-4"><span class="material-symbols-outlined text-primary mb-2">payments</span><p class="text-xs text-outline">Payment</p><p class="font-bold text-on-surface"><?= h($payment) ?></p></div>
          </div>
        </div>
        <div class="info-card rounded-3xl p-5">
          <h2 class="font-extrabold text-on-surface text-lg mb-4">Guest</h2>
          <div class="flex items-start gap-3"><div class="w-11 h-11 rounded-full bg-primary-fixed flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-primary">person</span></div><div class="min-w-0"><p class="font-bold text-on-surface truncate"><?= h($guestName) ?></p><p class="text-xs text-outline truncate"><?= h($guestEmail) ?></p><p class="text-xs text-outline truncate"><?= h($guestPhone) ?></p></div></div>
        </div>
      </section>

      <?php if ($type === 'hotel' && $room): ?>
      <section class="info-card rounded-3xl p-5 mb-6">
        <h2 class="font-extrabold text-on-surface mb-4">Room Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
          <div class="bg-white/70 border border-outline-variant/30 rounded-2xl p-4"><p class="text-xs text-outline">Room Type</p><p class="font-bold text-on-surface"><?= h(rv_val($room,'name','Selected Room')) ?></p></div>
          <div class="bg-white/70 border border-outline-variant/30 rounded-2xl p-4"><p class="text-xs text-outline">Bed</p><p class="font-bold text-on-surface"><?= h(rv_val($room,'bed','-')) ?></p></div>
          <div class="bg-white/70 border border-outline-variant/30 rounded-2xl p-4"><p class="text-xs text-outline">Max Guests</p><p class="font-bold text-on-surface"><?= h(rv_val($room,'max_guests',(string)$guests)) ?></p></div>
        </div>
        <?php if (!empty($room['amenities']) && is_array($room['amenities'])): ?><div class="flex flex-wrap gap-2"><?php foreach($room['amenities'] as $am): ?><span class="px-3 py-1 rounded-full bg-primary-fixed text-primary text-xs font-bold"><?= h((string)$am) ?></span><?php endforeach; ?></div><?php endif; ?>
      </section>
      <?php endif; ?>

      <section class="info-card rounded-3xl p-5 mb-6"><h2 class="font-extrabold text-on-surface mb-4">Amenities</h2><div class="grid grid-cols-2 md:grid-cols-4 gap-3"><?php foreach(array_slice($amenities,0,8) as $am): ?><div class="bg-white/70 border border-outline-variant/30 rounded-2xl p-3 flex items-center gap-2"><span class="material-symbols-outlined text-primary text-[18px]">check_circle</span><span class="text-sm font-semibold text-on-surface truncate"><?= h((string)$am) ?></span></div><?php endforeach; ?></div></section>

      <section class="info-card rounded-3xl p-5 mb-6"><h2 class="font-extrabold text-on-surface mb-4">Payment Summary</h2><div class="space-y-3 text-sm"><div class="flex justify-between text-on-surface-variant"><span><?= formatRupiah($pricePerNight) ?> × <?= $nights ?> night<?= $nights > 1 ? 's' : '' ?></span><span><?= formatRupiah($subtotal) ?></span></div><div class="flex justify-between text-on-surface-variant"><span>Tax 11%</span><span><?= formatRupiah($tax) ?></span></div><div class="pt-3 border-t border-outline-variant/30 flex justify-between items-center"><span class="font-extrabold text-on-surface text-lg">Total</span><span class="font-extrabold text-primary text-2xl"><?= formatRupiah($total) ?></span></div></div></section>

      <section class="text-center border-t border-outline-variant/30 pt-6">
        <p class="text-xs text-outline uppercase tracking-wider mb-3">Show this QR code at check-in</p>
        <div class="bg-white p-3 rounded-2xl border border-outline-variant/40 shadow-sm inline-block mb-5"><svg width="110" height="110" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="white"/><?php $seed=abs(crc32($ref)); for($y=0;$y<10;$y++){ for($x=0;$x<10;$x++){ $finder=($x<3&&$y<3)||($x>6&&$y<3)||($x<3&&$y>6); $random=(($seed >> (($x+$y)%16)) & 1)===1; if($finder||$random) echo "<rect x='".($x*10)."' y='".($y*10)."' width='8' height='8' rx='1' fill='#111c2d'/>"; }} ?></svg></div>
        <div class="flex flex-col sm:flex-row gap-3 justify-center no-print"><button onclick="window.print()" class="px-6 py-3 rounded-full bg-primary text-white font-bold text-sm shadow-lg hover:opacity-90 transition-all flex items-center justify-center gap-2"><span class="material-symbols-outlined text-[18px]">print</span>Print Ticket</button><a href="riwayat.php" class="px-6 py-3 rounded-full bg-primary-fixed text-primary font-bold text-sm hover:bg-primary hover:text-white transition-all flex items-center justify-center gap-2"><span class="material-symbols-outlined text-[18px]">history</span>My Bookings</a><a href="home.php" class="px-6 py-3 rounded-full border border-primary text-primary font-bold text-sm hover:bg-primary hover:text-white transition-all flex items-center justify-center gap-2"><span class="material-symbols-outlined text-[18px]">travel_explore</span>Book Another Stay</a></div>
      </section>
    </div>
  </section>
</main>

<script>
(function(){
  if('scrollRestoration' in history){history.scrollRestoration='manual';}
  function forceShow(){window.scrollTo(0,0);document.body.style.overflow='auto';const main=document.querySelector('main');if(main){main.style.display='block';main.style.visibility='visible';main.style.opacity='1';main.style.transform='none';}}
  function createConfetti(){const layer=document.getElementById('confettiLayer');if(!layer)return;const icons=['✅','✨','🎉','🏨','🌴'];for(let i=0;i<36;i++){const piece=document.createElement('div');piece.className='confetti-piece';piece.textContent=icons[Math.floor(Math.random()*icons.length)];piece.style.left=Math.random()*100+'vw';piece.style.fontSize=(14+Math.random()*18)+'px';piece.style.animationDuration=(3+Math.random()*3)+'s';piece.style.animationDelay=(Math.random()*1.5)+'s';layer.appendChild(piece);setTimeout(()=>piece.remove(),7000);}}
  forceShow();
  document.addEventListener('DOMContentLoaded',function(){forceShow();createConfetti();});
  window.addEventListener('pageshow',forceShow);
})();
</script>
</body>
</html>
