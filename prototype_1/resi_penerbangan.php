<?php
require 'config.php';
requireAuth();

$ref = trim((string)($_GET['ref'] ?? ''));
if ($ref === '') { flashSet('error','Booking reference not found.'); header('Location: riwayat.php'); exit; }
$user = auth();
$b = getBookingByRef($ref);
if (!$b || (int)($b['user_id'] ?? 0) !== (int)$user['id']) { flashSet('error','Booking not found.'); header('Location: riwayat.php'); exit; }
$f = $b['_item'] ?? null;
if (!$f && !empty($b['flight_id'])) $f = getFlight((int)$b['flight_id']);
if (!$f || !is_array($f)) $f = [];
$returnFlight = $b['_return_item'] ?? null;
if (!$returnFlight && !empty($b['return_flight_id'])) $returnFlight = getFlight((int)$b['return_flight_id']);

function rv(array $a, string $k, string $d='-'): string { $v=$a[$k]??$d; return is_array($v)?$d:(trim((string)$v)!==''?(string)$v:$d); }
function rd($d): string { $t=$d?strtotime((string)$d):false; return $t?date('d M Y',$t):'-'; }
function rt($t): string { $s=$t?strtotime((string)$t):false; return $s?date('H:i',$s):(string)($t?:'-'); }
function addMin($t,$m): string { $s=strtotime((string)$t); return $s?date('H:i',$s+$m*60):'-'; }

$airline=rv($f,'airline','StayGo Air'); $airlineCode=rv($f,'airline_code','SG');
$fromCity=rv($f,'from_city','Jakarta'); $toCity=rv($f,'to_city','Bali'); $fromCode=rv($f,'from_code','CGK'); $toCode=rv($f,'to_code','DPS');
$depart=rt(rv($f,'departure_time','08:00')); $arrive=rt(rv($f,'arrival_time','10:05')); $duration=rv($f,'duration','2h 05m');
$flightDate=$b['flight_date'] ?? date('Y-m-d'); $returnDate=$b['return_date'] ?? null;
$trip=strtolower((string)($b['trip_type'] ?? 'oneway')); $isRound=$trip==='round' || $trip==='round_trip';
$seatClass=ucfirst((string)($b['seat_class'] ?? 'economy')); $pax=max(1,(int)($b['guests'] ?? 1));
$total=(float)($b['total_amount'] ?? 0); $status=ucfirst((string)($b['status'] ?? 'confirmed'));
$passengers=[];
if (!empty($b['passengers']) && is_array($b['passengers'])) $passengers=$b['passengers'];
if (!$passengers) $passengers=[['name'=>$b['guest_name'] ?? $user['name'] ?? 'Passenger','email'=>$b['guest_email'] ?? $user['email'] ?? '-','phone'=>$b['guest_phone'] ?? $user['phone'] ?? '-']];
while(count($passengers)<$pax) $passengers[]=['name'=>'Passenger '.(count($passengers)+1),'email'=>'-','phone'=>'-'];
$emoji=['Garuda Indonesia'=>'🦅','Lion Air'=>'🦁','Citilink'=>'🟢','Batik Air'=>'🎨','AirAsia'=>'🔴'][$airline] ?? '✈️';
$terminal=['T1','T2','T3'][abs(crc32($ref))%3]; $gate='G'.((abs(crc32($ref.'gate'))%30)+1);
$payL=['bank_transfer'=>'Bank Transfer','gopay'=>'GoPay','ovo'=>'OVO','qris'=>'QRIS','credit_card'=>'Credit Card']; $payment=$payL[$b['payment_method']??''] ?? ($b['payment_method'] ?? '-');

$retDepart=$returnFlight?rt(rv($returnFlight,'departure_time','18:00')):'18:00';
$retArrive=$returnFlight?rt(rv($returnFlight,'arrival_time','20:05')):addMin($retDepart,125);
$retFromCode=$returnFlight?rv($returnFlight,'from_code',$toCode):$toCode; $retToCode=$returnFlight?rv($returnFlight,'to_code',$fromCode):$fromCode;
$retFromCity=$returnFlight?rv($returnFlight,'from_city',$toCity):$toCity; $retToCity=$returnFlight?rv($returnFlight,'to_city',$fromCity):$fromCity;
if($isRound && !$returnDate) $returnDate=date('Y-m-d',strtotime($flightDate.' +3 days'));

echo htmlHead('Booking Confirmed — '.h($ref), <<<CSS
body{background:radial-gradient(circle at top right,rgba(0,210,255,.14),transparent 36%),radial-gradient(circle at top left,rgba(0,76,226,.10),transparent 34%),#f8f9ff}.receipt-page{padding-top:130px;padding-bottom:80px;min-height:100vh}.receipt-card{background:rgba(255,255,255,.88);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border:1px solid rgba(195,197,216,.45);box-shadow:0 24px 70px rgba(0,76,226,.12)}.ticket-header{background:linear-gradient(135deg,#111c2d 0%,#004ce2 60%,#00b8e6 100%)}.info-card{background:rgba(246,248,255,.82);border:1px solid rgba(195,197,216,.38)}.route-line{height:1px;background:linear-gradient(90deg,transparent,rgba(255,255,255,.75),transparent)}.route-line-dark{height:1px;background:linear-gradient(90deg,transparent,rgba(115,122,140,.45),transparent)}.success-pill{background:rgba(34,197,94,.12);color:#15803d;border:1px solid rgba(34,197,94,.28)}@keyframes successPulse{0%,100%{box-shadow:0 0 0 0 rgba(34,197,94,.25)}50%{box-shadow:0 0 0 14px rgba(34,197,94,0)}}@keyframes successPop{0%{transform:scale(.4);opacity:0}60%{transform:scale(1.15);opacity:1}100%{transform:scale(1);opacity:1}}@keyframes cDrop{0%{transform:translateY(-30px) rotate(0deg);opacity:1}100%{transform:translateY(110vh) rotate(720deg);opacity:0}}.success-check{animation:successPop .55s cubic-bezier(.22,1,.36,1),successPulse 2.2s ease-in-out infinite}.confetti-piece{position:fixed;top:-30px;z-index:9999;pointer-events:none;animation-name:cDrop;animation-timing-function:linear;animation-iteration-count:infinite}@media print{.no-print{display:none!important}body{background:white!important}.receipt-page{padding-top:20px!important}.receipt-card{box-shadow:none!important}}
CSS);
?>
<body class="text-on-background min-h-screen">
<?= navbar('riwayat.php') ?>
<div id="confettiLayer"></div>
<main class="receipt-page px-5 md:px-16 max-w-[1280px] mx-auto">
  <section class="text-center mb-8">
    <div class="success-check w-24 h-24 rounded-full bg-green-100 border-4 border-green-300 flex items-center justify-center mx-auto mb-4 shadow-xl relative"><span class="material-symbols-outlined icon-fill text-green-600 text-6xl">check_circle</span></div>
    <div class="inline-flex items-center gap-2 success-pill rounded-full px-4 py-2 mb-4 text-sm font-bold"><span class="material-symbols-outlined text-[18px] icon-fill">verified</span>Booking Confirmed</div>
    <h1 class="text-3xl md:text-5xl font-extrabold text-on-surface tracking-tight mb-2">Your Flight is Booked</h1>
    <p class="text-on-surface-variant">Ref: <span class="font-bold text-primary"><?= h($ref) ?></span></p>
  </section>
  <section class="max-w-4xl mx-auto receipt-card rounded-[2rem] overflow-hidden">
    <div class="ticket-header p-6 md:p-8 text-white relative overflow-hidden"><div class="absolute top-0 right-0 w-80 h-80 rounded-full bg-white/10 -translate-y-1/2 translate-x-1/3"></div><div class="relative z-10">
      <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-5 mb-8"><div class="flex items-center gap-4"><div class="w-16 h-16 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center text-3xl"><?= h($emoji) ?></div><div><p class="text-xl font-extrabold"><?= h($airline) ?></p><p class="text-white/65 text-sm"><?= h($airlineCode) ?> · <?= h($seatClass) ?> · <?= $pax ?> passenger<?= $pax>1?'s':'' ?></p></div></div><div class="text-left md:text-right"><p class="text-white/60 text-xs uppercase tracking-wider mb-1">Booking Ref</p><p class="font-mono font-extrabold text-lg"><?= h($ref) ?></p><p class="text-white/60 text-xs mt-1"><?= h(rd($b['created_at'] ?? date('Y-m-d'))) ?></p></div></div>
      <div class="grid grid-cols-[1fr_auto_1fr] gap-4 items-center mb-6"><div><p class="text-4xl md:text-5xl font-extrabold tracking-tight"><?= h($fromCode) ?></p><p class="text-white/70 text-sm mt-1"><?= h($fromCity) ?></p><p class="text-white font-bold mt-2"><?= h($depart) ?></p></div><div class="text-center min-w-[120px]"><div class="flex items-center gap-2"><div class="route-line w-16"></div><span class="material-symbols-outlined text-white text-2xl">flight_takeoff</span><div class="route-line w-16"></div></div><p class="text-white/60 text-xs mt-2"><?= h($duration) ?></p></div><div class="text-right"><p class="text-4xl md:text-5xl font-extrabold tracking-tight"><?= h($toCode) ?></p><p class="text-white/70 text-sm mt-1"><?= h($toCity) ?></p><p class="text-white font-bold mt-2"><?= h($arrive) ?></p></div></div>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-3"><div class="bg-white/12 border border-white/15 rounded-2xl p-3"><p class="text-white/55 text-xs mb-1">Departure Date</p><p class="font-bold text-sm"><?= h(rd($flightDate)) ?></p></div><div class="bg-white/12 border border-white/15 rounded-2xl p-3"><p class="text-white/55 text-xs mb-1">Terminal</p><p class="font-bold text-sm"><?= h($terminal) ?></p></div><div class="bg-white/12 border border-white/15 rounded-2xl p-3"><p class="text-white/55 text-xs mb-1">Gate</p><p class="font-bold text-sm"><?= h($gate) ?></p></div><div class="bg-white/12 border border-white/15 rounded-2xl p-3"><p class="text-white/55 text-xs mb-1">Status</p><p class="font-bold text-sm"><?= h($status) ?></p></div></div>
    </div></div>
    <div class="p-6 md:p-8">
      <?php if($isRound): ?><section class="info-card rounded-3xl p-5 mb-6"><div class="flex items-center gap-2 mb-5"><div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center"><span class="material-symbols-outlined text-primary">sync_alt</span></div><div><h2 class="font-extrabold text-on-surface">Return Flight</h2><p class="text-xs text-outline">Selected return schedule</p></div></div><div class="grid grid-cols-[1fr_auto_1fr] gap-4 items-center"><div><p class="text-2xl md:text-3xl font-extrabold text-on-surface"><?= h($retFromCity) ?></p><p class="text-outline text-sm"><?= h($retFromCode) ?> · <?= h($retDepart) ?></p></div><div class="text-center min-w-[90px]"><div class="flex items-center gap-2"><div class="route-line-dark w-10"></div><span class="material-symbols-outlined text-primary">flight_land</span><div class="route-line-dark w-10"></div></div><p class="text-outline text-xs mt-1"><?= h($duration) ?></p></div><div class="text-right"><p class="text-2xl md:text-3xl font-extrabold text-on-surface"><?= h($retToCity) ?></p><p class="text-outline text-sm"><?= h($retToCode) ?> · <?= h($retArrive) ?></p></div></div><div class="mt-4 pt-4 border-t border-outline-variant/30 flex items-center gap-2 text-sm text-on-surface-variant"><span class="material-symbols-outlined text-[18px] text-primary">calendar_month</span>Return Date: <span class="font-bold text-on-surface"><?= h(rd($returnDate)) ?></span></div></section><?php endif; ?>
      <section class="mb-6"><div class="flex items-center justify-between mb-4"><h2 class="font-extrabold text-on-surface text-lg">Passenger Details</h2><span class="text-xs font-bold text-primary bg-primary-fixed px-3 py-1 rounded-full"><?= count($passengers) ?> passenger<?= count($passengers)>1?'s':'' ?></span></div><div class="grid grid-cols-1 md:grid-cols-2 gap-3"><?php foreach($passengers as $i=>$p): $name=is_array($p)?rv($p,'name','Passenger '.($i+1)):'Passenger '.($i+1); $email=is_array($p)?rv($p,'email','-'):'-'; $phone=is_array($p)?rv($p,'phone','-'):'-'; $seat=chr(65+($i%6)).(10+$i); ?><div class="bg-white/75 border border-outline-variant/40 rounded-2xl p-4"><div class="flex items-start justify-between gap-3"><div class="flex items-start gap-3 min-w-0"><div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-primary text-[20px]">person</span></div><div class="min-w-0"><p class="font-bold text-on-surface truncate"><?= h($name) ?></p><p class="text-xs text-outline truncate"><?= h($email) ?></p><p class="text-xs text-outline truncate"><?= h($phone) ?></p></div></div><div class="text-right shrink-0"><p class="text-[10px] text-outline uppercase tracking-wider">Seat</p><p class="font-extrabold text-primary"><?= h($seat) ?></p></div></div></div><?php endforeach; ?></div></section>
      <section class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6"><div class="info-card rounded-2xl p-4 flex items-center gap-3"><span class="material-symbols-outlined text-primary">luggage</span><div><p class="text-xs text-outline">Baggage</p><p class="font-bold text-on-surface">20 kg</p></div></div><div class="info-card rounded-2xl p-4 flex items-center gap-3"><span class="material-symbols-outlined text-primary">schedule</span><div><p class="text-xs text-outline">Boarding Time</p><p class="font-bold text-on-surface"><?= h(addMin($depart,-45)) ?></p></div></div><div class="info-card rounded-2xl p-4 flex items-center gap-3"><span class="material-symbols-outlined text-primary">payments</span><div><p class="text-xs text-outline">Payment</p><p class="font-bold text-on-surface"><?= h($payment) ?></p></div></div></section>
      <section class="info-card rounded-3xl p-5 mb-6"><h2 class="font-extrabold text-on-surface mb-4">Payment Summary</h2><div class="space-y-3 text-sm"><div class="flex justify-between text-on-surface-variant"><span>Passenger</span><span><?= $pax ?> pax</span></div><div class="flex justify-between text-on-surface-variant"><span>Class</span><span><?= h($seatClass) ?></span></div><div class="pt-3 border-t border-outline-variant/30 flex justify-between items-center"><span class="font-extrabold text-on-surface text-lg">Total</span><span class="font-extrabold text-primary text-2xl"><?= formatRupiah($total) ?></span></div></div></section>
      <section class="text-center border-t border-outline-variant/30 pt-6"><div class="flex flex-col sm:flex-row gap-3 justify-center no-print"><button onclick="window.print()" class="px-6 py-3 rounded-full bg-primary text-white font-bold text-sm shadow-lg flex items-center justify-center gap-2"><span class="material-symbols-outlined text-[18px]">print</span>Print Ticket</button><a href="riwayat.php" class="px-6 py-3 rounded-full bg-primary-fixed text-primary font-bold text-sm flex items-center justify-center gap-2"><span class="material-symbols-outlined text-[18px]">history</span>My Bookings</a><a href="flight.php" class="px-6 py-3 rounded-full border border-primary text-primary font-bold text-sm flex items-center justify-center gap-2"><span class="material-symbols-outlined text-[18px]">flight_takeoff</span>Book Another Flight</a></div></section>
    </div>
  </section>
</main>
<script>
if('scrollRestoration' in history){history.scrollRestoration='manual'}window.scrollTo(0,0);function createConfetti(){const layer=document.getElementById('confettiLayer');if(!layer)return;const icons=['✅','✨','🎉','✈️'];for(let i=0;i<34;i++){const piece=document.createElement('div');piece.className='confetti-piece';piece.textContent=icons[Math.floor(Math.random()*icons.length)];piece.style.left=Math.random()*100+'vw';piece.style.fontSize=(14+Math.random()*18)+'px';piece.style.animationDuration=(3+Math.random()*3)+'s';piece.style.animationDelay=(Math.random()*1.6)+'s';layer.appendChild(piece);setTimeout(()=>piece.remove(),6500)}}document.addEventListener('DOMContentLoaded',function(){window.scrollTo(0,0);const main=document.querySelector('main');if(main){main.style.display='block';main.style.visibility='visible';main.style.opacity='1'}createConfetti()});window.addEventListener('pageshow',function(){window.scrollTo(0,0)});
</script>
</body></html>
