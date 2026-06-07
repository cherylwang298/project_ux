<?php
require 'config.php';

$from    = scalarParam('from');
$to      = scalarParam('to');
$date    = scalarParam('date', date('Y-m-d', strtotime('+3 days')));
$rangeStart = scalarParam('range_start', $date);
if (!strtotime($rangeStart)) $rangeStart = $date;
$returnDate = scalarParam('return_date', date('Y-m-d', strtotime('+7 days')));
$tripParam = scalarParam('trip','round');
$trip    = in_array($tripParam, ['round','oneway'], true) ? $tripParam : 'round';
$pax     = max(1,min(9,(int)scalarParam('pax','1')));
$classParam = scalarParam('class','economy');
$class   = in_array($classParam, ['economy','business'], true) ? $classParam : 'economy';
$searched = isset($_GET['from']);

// Get all flights or filter
if ($searched && ($from || $to)) {
    $results = getFlights($from, $to);
} else {
    $results = [];
}

// Popular routes derived from hardcoded data
$popularRoutes = [
    ['from'=>'Jakarta','from_code'=>'CGK','to'=>'Bali','to_code'=>'DPS','from_icon'=>'location_city','to_icon'=>'beach_access'],
    ['from'=>'Surabaya','from_code'=>'SUB','to'=>'Bali','to_code'=>'DPS','from_icon'=>'factory','to_icon'=>'beach_access'],
    ['from'=>'Jakarta','from_code'=>'CGK','to'=>'Lombok','to_code'=>'LOP','from_icon'=>'location_city','to_icon'=>'landscape'],
    ['from'=>'Bali','from_code'=>'DPS','to'=>'Jakarta','to_code'=>'CGK','from_icon'=>'beach_access','to_icon'=>'location_city'],
];

// Airline logos/emoji
$airlineEmojis = ['Garuda Indonesia'=>'🦅','Lion Air'=>'🦁','Citilink'=>'🟢','Batik Air'=>'🎨','AirAsia'=>'🔴'];
$allAirlines = array_values(array_unique(array_map(fn($f)=>$f['airline'], getFlights())));
function findReturnFlight(array $outbound, string $to, string $from): ?array {
    $returns = getFlights($to, $from);
    if (!$returns) return null;
    foreach ($returns as $rf) { if ($rf['airline'] === $outbound['airline']) return $rf; }
    return $returns[0];
}

echo htmlHead("Find Flights", <<<CSS
.flight-hero{background:linear-gradient(135deg,#eef6ff,#f9fbff);padding-top:112px;padding-bottom:34px;position:relative;overflow:hidden}.flight-hero:before{content:"";position:absolute;inset:auto -10% -60% auto;width:55vw;height:55vw;border-radius:999px;background:rgba(0,196,232,.14);filter:blur(80px)}
.flight-search{background:rgba(255,255,255,.66);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.7);box-shadow:0 24px 70px -34px rgba(17,28,45,.32);border-radius:28px}.flight-field{background:rgba(255,255,255,.56);border:1px solid rgba(120,130,155,.18);border-radius:16px}.flight-field input{border:0!important;background:transparent!important;box-shadow:none!important;outline:0!important}.class-btn,.trip-btn{transition:all .25s ease}.class-btn.active,.trip-btn.active{background:#004ce2;color:white;box-shadow:0 10px 22px -12px rgba(0,76,226,.55)}
.date-strip{display:flex;align-items:center;gap:10px;margin-bottom:24px}.date-arrow{width:46px;height:46px;border-radius:999px;background:rgba(255,255,255,.72);border:1px solid rgba(195,197,216,.55);display:flex;align-items:center;justify-content:center;color:#004ce2;font-weight:800;box-shadow:0 14px 40px -28px rgba(17,28,45,.32)}.date-tabs{flex:1;display:flex;gap:10px;overflow-x:auto;background:rgba(255,255,255,.62);border:1px solid rgba(255,255,255,.7);border-radius:999px;padding:8px;box-shadow:0 14px 40px -28px rgba(17,28,45,.32)}.date-tab{min-width:112px;height:46px;border-radius:999px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;color:#434655}.date-tab.active{border:2px solid #004ce2;color:#004ce2;background:white}.sort-pill.active{background:white;color:#004ce2;box-shadow:0 8px 20px -14px rgba(0,76,226,.55)}.return-option{border:1px solid rgba(195,197,216,.55);background:rgba(255,255,255,.52);border-radius:14px;padding:10px 12px;transition:.2s}.return-option:hover{border-color:#004ce2;background:rgba(220,225,255,.4)}
.airline-filter{background:linear-gradient(145deg,rgba(255,255,255,.72),rgba(255,255,255,.48));backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.66);box-shadow:0 18px 45px -25px rgba(17,28,45,.32);border-radius:24px}.airline-check{width:17px;height:17px;border-radius:4px;color:#004ce2;border-color:rgba(17,28,45,.3)}
.glass-card,.flight-card{border-radius:24px!important;background:linear-gradient(145deg,rgba(255,255,255,.72),rgba(255,255,255,.48))!important;backdrop-filter:blur(28px)!important;-webkit-backdrop-filter:blur(28px)!important;border:1px solid rgba(255,255,255,.65)!important;box-shadow:0 18px 48px -26px rgba(17,28,45,.38)!important;transition:all .28s ease!important;cursor:pointer}.flight-card:hover,.glass-card:hover{transform:translateY(-4px)!important;box-shadow:0 26px 64px -30px rgba(0,76,226,.38)!important;border-color:rgba(255,255,255,.85)!important}.destination-title{font-size:clamp(22px,2vw,32px);font-weight:800;letter-spacing:-.04em;color:#111c2d}.route-code{font-size:14px;font-weight:800;color:rgba(17,28,45,.55)}
@keyframes planeFly{0%,100%{transform:translateX(0) rotate(0)}50%{transform:translateX(8px) rotate(2deg)}}.plane-fly{animation:planeFly 2s ease-in-out infinite}
CSS
);
?>
<body class="bg-background text-on-background min-h-screen">
<?= navbar('flight.php') ?>

<!-- Hero Search -->
<div class="flight-hero px-5 md:px-16">
  <div class="max-w-[1280px] mx-auto relative z-10">
    <div class="mb-8 text-center">
      <h1 class="text-4xl md:text-5xl font-extrabold text-on-surface tracking-tight mb-2">Find Flights</h1>
      <p class="text-on-surface-variant">Choose a popular route or search for a specific flight.</p>
    </div>

    <form method="GET" class="flight-search p-5 md:p-6 max-w-5xl mx-auto">
      <div class="flex flex-wrap gap-2 mb-5">
        <button type="button" onclick="setTrip('round',this)" class="trip-btn <?= $trip==='round'?'active':'' ?> px-5 py-2 rounded-full text-sm font-bold bg-white/70 text-on-surface">Round Trip</button>
        <button type="button" onclick="setTrip('oneway',this)" class="trip-btn <?= $trip==='oneway'?'active':'' ?> px-5 py-2 rounded-full text-sm font-bold bg-white/70 text-on-surface">One Way</button>
        <div class="ml-0 md:ml-auto flex gap-1.5 bg-white/55 p-1 rounded-full">
          <button type="button" onclick="setClass('economy',this)" id="btn_economy" class="class-btn px-5 py-2 rounded-full text-sm font-bold text-on-surface/70">Economy</button>
          <button type="button" onclick="setClass('business',this)" id="btn_business" class="class-btn px-5 py-2 rounded-full text-sm font-bold text-on-surface/70">Business</button>
        </div>
      </div>
      <input type="hidden" name="class" id="classInput" value="<?= h($class) ?>">
      <input type="hidden" name="trip" id="tripInput" value="<?= h($trip) ?>">

      <div class="grid grid-cols-1 md:grid-cols-6 gap-3 items-center">
        <div class="flight-field relative md:col-span-1">
          <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">flight_takeoff</span>
          <input list="cities" type="text" name="from" value="<?= h($from) ?>" class="w-full h-14 pl-12 pr-4 text-sm" placeholder="From: Jakarta">
        </div>
        <div class="flight-field relative md:col-span-1">
          <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">flight_land</span>
          <input list="cities" type="text" name="to" value="<?= h($to) ?>" class="w-full h-14 pl-12 pr-4 text-sm" placeholder="To: Bali">
        </div>
        <div class="flight-field relative md:col-span-1">
          <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">calendar_month</span>
          <input type="date" name="date" value="<?= h($date) ?>" min="<?= date('Y-m-d') ?>" class="w-full h-14 pl-12 pr-4 text-sm">
        </div>
        <div class="flight-field relative md:col-span-1" id="returnDateField">
          <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">event_repeat</span>
          <input type="date" name="return_date" value="<?= h($returnDate) ?>" min="<?= date('Y-m-d') ?>" class="w-full h-14 pl-12 pr-4 text-sm">
        </div>
        <div class="flight-field flex items-center justify-between h-14 px-4">
          <span class="material-symbols-outlined text-outline text-[20px]">person</span>
          <button type="button" onclick="changePax(-1)" class="w-8 h-8 rounded-full bg-white/70 font-bold text-lg">−</button>
          <input id="paxInput" name="pax" value="<?= $pax ?>" readonly class="w-10 text-center bg-transparent border-0 shadow-none outline-none text-sm font-bold">
          <button type="button" onclick="changePax(1)" class="w-8 h-8 rounded-full bg-white/70 font-bold text-lg">+</button>
        </div>
        <button type="submit" class="h-14 px-5 bg-primary text-white rounded-2xl font-bold hover:opacity-90 transition-all flex items-center justify-center gap-1.5 whitespace-nowrap shadow-lg shadow-primary/20">
          <span class="material-symbols-outlined text-[20px]">search</span>
          Search
        </button>
      </div>
    </form>
    <datalist id="cities">
      <?php $cities=['Jakarta','Bali','Surabaya','Lombok','Medan','Makassar','Yogyakarta']; foreach($cities as $c): ?><option value="<?= $c ?>"><?php endforeach; ?>
    </datalist>
  </div>
</div>

<main class="max-w-[1280px] mx-auto px-5 md:px-16 py-12">
  <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-7 items-start">
    <aside class="airline-filter p-6 lg:sticky lg:top-28">
      <div class="flex items-center justify-between mb-5">
        <h3 class="text-lg font-extrabold text-on-surface">Airlines</h3>
        <button type="button" onclick="resetAirlines()" class="text-sm font-bold text-primary">Reset all</button>
      </div>
      <div class="space-y-3">
        <?php foreach($allAirlines as $air): ?>
        <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant cursor-pointer">
          <input type="checkbox" class="airline-check" data-airline="<?= h($air) ?>" checked onchange="filterAirlines()">
          <span><?= h($air) ?></span>
        </label>
        <?php endforeach; ?>
      </div>
    </aside>
    <section class="min-w-0">
      <?php if ($searched): ?>
      <?php
        $prevRange = date('Y-m-d', strtotime($rangeStart.' -7 days'));
        $nextRange = date('Y-m-d', strtotime($rangeStart.' +7 days'));
        $baseParams = 'from='.urlencode($from).'&to='.urlencode($to).'&return_date='.urlencode($returnDate).'&pax='.$pax.'&class='.urlencode($class).'&trip='.urlencode($trip);
      ?>
      <div class="date-strip anim-fade-up">
        <a class="date-arrow" title="Previous 7 days" href="?<?= $baseParams ?>&date=<?= $prevRange ?>&range_start=<?= $prevRange ?>"><span class="material-symbols-outlined">chevron_left</span></a>
        <div class="date-tabs">
          <?php for($d=0;$d<7;$d++): $dd=date('Y-m-d', strtotime($rangeStart." +{$d} days")); ?>
          <a class="date-tab <?= $dd===$date?'active':'' ?>" href="?<?= $baseParams ?>&date=<?= $dd ?>&range_start=<?= h($rangeStart) ?>"><?= date('M j', strtotime($dd)) ?></a>
          <?php endfor; ?>
        </div>
        <a class="date-arrow" title="Next 7 days" href="?<?= $baseParams ?>&date=<?= $nextRange ?>&range_start=<?= $nextRange ?>"><span class="material-symbols-outlined">chevron_right</span></a>
      </div>
      <?php endif; ?>
  <?php if ($searched && empty($results)): ?>
  <!-- No Results -->
  <div class="text-center py-20 anim-fade-up">
    <div class="w-20 h-20 mx-auto rounded-full bg-surface-container flex items-center justify-center mb-5">
      <span class="material-symbols-outlined text-outline text-4xl plane-fly">flight_off</span>
    </div>
    <h3 class="text-xl font-bold text-on-surface mb-2">No Flights Found</h3>
    <p class="text-on-surface-variant mb-6">Try one of the popular routes below.</p>
  </div>

  <?php elseif ($searched && !empty($results)): ?>
  <!-- Results Header -->
  <div class="flex items-center justify-between mb-6 anim-fade-up">
    <div>
      <h2 class="text-xl font-bold text-on-surface">
        <?php if($from&&$to): ?><?= h($from) ?> → <?= h($to) ?><?php elseif($from): ?>From <?= h($from) ?><?php else: ?>To <?= h($to) ?><?php endif; ?>
      </h2>
      <p class="text-on-surface-variant text-sm"><?= count($results) ?> flights · <?= $pax ?> passenger · <?= ucfirst($class) ?></p>
    </div>
    <div class="flex items-center gap-1 bg-surface-container-low/70 border border-outline-variant/40 rounded-full p-1">
      <button type="button" onclick="sortFlights('price',this)" class="sort-pill active px-4 py-2 rounded-full text-sm font-bold text-on-surface-variant">Recommended</button>
      <button type="button" onclick="sortFlights('cheap',this)" class="sort-pill px-4 py-2 rounded-full text-sm font-bold text-on-surface-variant">Cheapest</button>
      <button type="button" onclick="sortFlights('depart',this)" class="sort-pill px-4 py-2 rounded-full text-sm font-bold text-on-surface-variant">Fastest</button>
    </div>
  </div>

  <!-- Flight Cards -->
  <div class="space-y-4" id="flightList">
    <?php foreach ($results as $i => $f):
      $price = ($class === 'business') ? $f['price_business'] : $f['price_economy'];
      $returnOptions = ($trip === 'round') ? getFlights($f['to_city'], $f['from_city']) : [];
      $returnFlight = $returnOptions[0] ?? null;
      $returnPrice = $returnFlight ? (($class === 'business') ? $returnFlight['price_business'] : $returnFlight['price_economy']) : 0;
      $totalPrice = ($price + $returnPrice) * $pax;
      $emoji = $airlineEmojis[$f['airline']] ?? '✈';
      $checkoutUrl = auth() ? 'checkout.php?type=flight&id='.$f['id'].'&class='.$class.'&pax='.$pax.'&date='.h($date).'&trip='.$trip.'&return_date='.h($returnDate).($returnFlight?'&return_id='.$returnFlight['id']:'').'&total='.round($totalPrice*1.11) : 'login.php';
    ?>
    <div onclick="window.location.href='<?= $checkoutUrl ?>'" class="flight-card rounded-2xl p-5 md:p-6 anim-fade-up delay-<?= min(500,($i+1)*80) ?>"
      data-airline="<?= h($f['airline']) ?>" data-price="<?= $price ?>" data-depart="<?= $f['departure_time'] ?>" data-dur="<?= $f['duration'] ?>">
      <div class="flex flex-col md:flex-row md:items-center gap-5">
        <!-- Airline -->
        <div class="flex items-center gap-3 md:w-40">
          <div class="w-12 h-12 rounded-2xl bg-primary-fixed flex items-center justify-center text-2xl"><?= $emoji ?></div>
          <div>
            <p class="font-bold text-sm text-on-surface"><?= h($f['airline']) ?></p>
            <p class="text-xs text-outline"><?= h($f['airline_code']) ?></p>
          </div>
        </div>

        <!-- Route -->
        <div class="flex-1 flex items-center gap-4">
          <div class="text-center min-w-[120px]">
            <p class="destination-title"><?= h($f['from_city']) ?></p>
            <p class="route-code"><?= h($f['from_code']) ?> · <?= $f['departure_time'] ?></p>
          </div>
          <div class="flex-1 flex flex-col items-center">
            <p class="text-xs text-outline mb-1"><?= h($f['duration']) ?></p>
            <div class="w-full flex items-center gap-1">
              <div class="w-2 h-2 rounded-full bg-primary"></div>
              <div class="flex-1 h-px bg-gradient-to-r from-primary to-secondary-container"></div>
              <span class="material-symbols-outlined text-primary text-[18px]">flight</span>
              <div class="flex-1 h-px bg-gradient-to-r from-secondary-container to-secondary"></div>
              <div class="w-2 h-2 rounded-full bg-secondary"></div>
            </div>
            <p class="text-xs text-on-surface-variant mt-1">Direct</p>
          </div>
          <div class="text-center min-w-[120px]">
            <p class="destination-title"><?= h($f['to_city']) ?></p>
            <p class="route-code"><?= h($f['to_code']) ?> · <?= $f['arrival_time'] ?></p>
          </div>
        </div>

        <!-- Price + Book -->
        <div class="flex flex-row md:flex-col items-end justify-between md:justify-center md:items-end md:min-w-[160px]">
          <div class="text-right">
            <p class="text-xs text-outline"><?= $pax ?> passenger</p>
            <p class="text-2xl font-extrabold text-primary"><?= formatRupiah($totalPrice) ?></p>
            <p class="text-xs text-outline"><?= formatRupiah($price) ?>/person</p>
          </div>
          <?php if (auth()): ?>
          <a onclick="event.stopPropagation()" href="<?= $checkoutUrl ?>"
            class="mt-2 px-5 py-2.5 bg-primary text-white rounded-full text-xs font-bold hover:opacity-90 hover:scale-105 transition-all shadow-md shadow-primary/20">
            Book
          </a>
          <?php else: ?>
          <a onclick="event.stopPropagation()" href="login.php" class="mt-2 px-5 py-2.5 bg-primary text-white rounded-full text-xs font-bold hover:opacity-90 transition-all shadow-md">Login</a>
          <?php endif; ?>
        </div>
      </div>
      <?php if ($trip === 'round' && $returnOptions): ?>
      <div class="mt-4 pt-4 border-t border-outline-variant/30">
        <div class="flex items-center gap-2 text-sm font-extrabold text-primary mb-3"><span class="material-symbols-outlined text-[18px]">sync_alt</span> Choose Return Flight</div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
          <?php foreach(array_slice($returnOptions,0,3) as $ri=>$rf): $rPrice=(($class==='business')?$rf['price_business']:$rf['price_economy']); $rTotal=($price+$rPrice)*$pax; $rUrl=auth() ? 'checkout.php?type=flight&id='.$f['id'].'&class='.$class.'&pax='.$pax.'&date='.h($date).'&trip=round&return_date='.h($returnDate).'&return_id='.$rf['id'].'&total='.round($rTotal*1.11) : 'login.php'; ?>
          <a onclick="event.stopPropagation()" href="<?= $rUrl ?>" class="return-option <?= $ri===0?'border-primary bg-primary-fixed/30':'' ?>">
            <p class="font-extrabold text-on-surface text-sm"><?= $rf['departure_time'] ?> - <?= $rf['arrival_time'] ?></p>
            <p class="text-xs text-outline"><?= h($rf['airline']) ?> · <?= h($rf['from_code']) ?> → <?= h($rf['to_code']) ?></p>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
      <!-- Seats warning -->
      <?php if ($f['seats_available'] <= 20): ?>
      <div class="mt-3 pt-3 border-t border-outline-variant/30 flex items-center gap-1.5">
        <span class="material-symbols-outlined text-error text-[14px] icon-fill">warning</span>
        <p class="text-xs text-error font-semibold">Only <?= $f['seats_available'] ?> seats left!</p>
      </div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>

  <?php else: ?>
  <!-- Popular Routes (idle state) -->
  <div class="anim-fade-up">
    <h2 class="text-2xl font-extrabold text-on-surface mb-6">Popular Routes</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
      <?php foreach ($popularRoutes as $route): ?>
      <a href="?from=<?= urlencode($route['from']) ?>&to=<?= urlencode($route['to']) ?>&date=<?= date('Y-m-d',strtotime('+3 days')) ?>&range_start=<?= date('Y-m-d',strtotime('+3 days')) ?>&pax=1&class=economy&trip=round&return_date=<?= date('Y-m-d',strtotime('+7 days')) ?>"
        class="glass-card rounded-2xl p-5 flex items-center justify-between hover:border-primary/30 hover:scale-[1.02] transition-all group">
        <div class="flex items-center gap-4">
          <div class="w-10 h-10 rounded-xl bg-primary-fixed flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-[18px]"><?= $route['from_icon'] ?></span>
          </div>
          <div>
            <p class="font-extrabold text-on-surface"><?= $route['from'] ?> → <?= $route['to'] ?></p>
            <p class="text-xs text-outline"><?= $route['from_code'] ?> · <?= $route['to_code'] ?></p>
          </div>
        </div>
        <span class="material-symbols-outlined text-outline group-hover:text-primary group-hover:translate-x-1 transition-all">arrow_forward</span>
      </a>
      <?php endforeach; ?>
    </div>

  </div>
  <?php endif; ?>
    </section>
  </div>
</main>

<?= footer() ?>

<script>
function setClass(cls, btn) {
  document.querySelectorAll('.class-btn').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('classInput').value = cls;
}
function setTrip(type, btn) {
  document.querySelectorAll('.trip-btn').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('tripInput').value = type;
  document.getElementById('returnDateField').style.display = type === 'round' ? '' : 'none';
}
function changePax(delta) {
  const input = document.getElementById('paxInput');
  let val = parseInt(input.value || '1', 10) + delta;
  input.value = Math.max(1, Math.min(9, val));
}
function filterAirlines() {
  const checked = [...document.querySelectorAll('.airline-check:checked')].map(i=>i.dataset.airline);
  document.querySelectorAll('[data-airline]').forEach(card => {
    card.style.display = checked.includes(card.dataset.airline) ? '' : 'none';
  });
}
function resetAirlines() {
  document.querySelectorAll('.airline-check').forEach(i=>i.checked = true);
  filterAirlines();
}
// Init active class button
document.getElementById('btn_<?= $class ?>').classList.add('active');
document.getElementById('returnDateField').style.display = document.getElementById('tripInput').value === 'round' ? '' : 'none';

function sortFlights(by, btn=null) {
  if(btn){document.querySelectorAll('.sort-pill').forEach(b=>b.classList.remove('active'));btn.classList.add('active');}
  const list = document.getElementById('flightList');
  if (!list) return;
  const cards = [...list.children];
  cards.sort((a,b)=>{
    if (by==='price'||by==='cheap') return parseFloat(a.dataset.price)-parseFloat(b.dataset.price);
    if (by==='depart') return a.dataset.depart.localeCompare(b.dataset.depart);
    if (by==='dur') return a.dataset.dur.localeCompare(b.dataset.dur);
    return 0;
  });
  cards.forEach(c=>list.appendChild(c));
}
</script>
</body>
</html>
