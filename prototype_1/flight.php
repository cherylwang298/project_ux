<?php
require 'config.php';

$from    = scalarParam('from');
$to      = scalarParam('to');
$date    = scalarParam('date', date('Y-m-d', strtotime('+3 days')));
$rangeStart = scalarParam('range_start', $date);
if (!strtotime($rangeStart)) $rangeStart = $date;
$returnDate = scalarParam('return_date', date('Y-m-d', strtotime('+7 days')));
$tripParam = scalarParam('trip','oneway');
$trip    = in_array($tripParam, ['round','oneway'], true) ? $tripParam : 'oneway';
$pax     = max(1,min(9,(int)scalarParam('pax','1')));
$classParam = scalarParam('class','economy');
$class   = in_array($classParam, ['economy','business'], true) ? $classParam : 'economy';
$searched = isset($_GET['from']);

// Round trip state
$outboundId = (int)($_GET['outbound_id'] ?? 0);
$isReturnSelection = ($trip === 'round' && $outboundId > 0);

// Find selected outbound flight for return step
$selectedOutbound = null;
if ($isReturnSelection) {
    foreach (getFlights() as $flight) {
        if (($flight['id'] ?? 0) == $outboundId) {
            $selectedOutbound = $flight;
            break;
        }
    }
}

// Get flight results
if ($isReturnSelection && $selectedOutbound) {
    // Step 2: show return flights (reversed route)
    $results = getFlights($selectedOutbound['to_city'], $selectedOutbound['from_city']);
} elseif ($searched && ($from || $to)) {
    // Step 1 or one-way: show outbound flights
    $results = getFlights($from, $to);
} else {
    $results = [];
}

// Popular routes
$popularRoutes = [
    ['from'=>'Jakarta','from_code'=>'CGK','to'=>'Bali','to_code'=>'DPS','from_icon'=>'location_city','to_icon'=>'beach_access'],
    ['from'=>'Surabaya','from_code'=>'SUB','to'=>'Bali','to_code'=>'DPS','from_icon'=>'factory','to_icon'=>'beach_access'],
    ['from'=>'Jakarta','from_code'=>'CGK','to'=>'Lombok','to_code'=>'LOP','from_icon'=>'location_city','to_icon'=>'landscape'],
    ['from'=>'Bali','from_code'=>'DPS','to'=>'Jakarta','to_code'=>'CGK','from_icon'=>'beach_access','to_icon'=>'location_city'],
];

$airlineEmojis = ['Garuda Indonesia'=>'🦅','Lion Air'=>'🦁','Citilink'=>'🟢','Batik Air'=>'🎨','AirAsia'=>'🔴'];
$allAirlines = array_values(array_unique(array_map(fn($f)=>$f['airline'], getFlights())));

// Build base params for URL reuse
$baseParams = 'from='.urlencode($from).'&to='.urlencode($to).'&return_date='.urlencode($returnDate).'&pax='.$pax.'&class='.urlencode($class).'&trip='.urlencode($trip);

echo htmlHead("Find Flights", <<<CSS
.flight-hero{background:linear-gradient(135deg,#eef6ff,#f9fbff);padding-top:112px;padding-bottom:34px;position:relative;overflow:hidden}.flight-hero:before{content:"";position:absolute;inset:auto -10% -60% auto;width:55vw;height:55vw;border-radius:999px;background:rgba(0,196,232,.14);filter:blur(80px)}
.flight-search{background:rgba(255,255,255,.66);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.7);box-shadow:0 24px 70px -34px rgba(17,28,45,.32);border-radius:28px}.flight-field{background:rgba(255,255,255,.56);border:1px solid rgba(120,130,155,.18);border-radius:16px}.flight-field input{border:0!important;background:transparent!important;box-shadow:none!important;outline:0!important}.class-btn,.trip-btn{transition:all .25s ease}.class-btn.active,.trip-btn.active{background:#004ce2;color:white;box-shadow:0 10px 22px -12px rgba(0,76,226,.55)}
.date-strip{display:flex;align-items:center;gap:10px;margin-bottom:24px}.date-arrow{width:46px;height:46px;border-radius:999px;background:rgba(255,255,255,.72);border:1px solid rgba(195,197,216,.55);display:flex;align-items:center;justify-content:center;color:#004ce2;font-weight:800;box-shadow:0 14px 40px -28px rgba(17,28,45,.32)}.date-tabs{flex:1;display:flex;gap:10px;overflow-x:auto;background:rgba(255,255,255,.62);border:1px solid rgba(255,255,255,.7);border-radius:999px;padding:8px;box-shadow:0 14px 40px -28px rgba(17,28,45,.32)}.date-tab{min-width:112px;height:46px;border-radius:999px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;color:#434655}.date-tab.active{border:2px solid #004ce2;color:#004ce2;background:white}.sort-pill.active{background:white;color:#004ce2;box-shadow:0 8px 20px -14px rgba(0,76,226,.55)}
.airline-filter{background:linear-gradient(145deg,rgba(255,255,255,.72),rgba(255,255,255,.48));backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.66);box-shadow:0 18px 45px -25px rgba(17,28,45,.32);border-radius:24px}.airline-check{width:17px;height:17px;border-radius:4px;color:#004ce2;border-color:rgba(17,28,45,.3)}
.glass-card,.flight-card{border-radius:24px!important;background:linear-gradient(145deg,rgba(255,255,255,.72),rgba(255,255,255,.48))!important;backdrop-filter:blur(28px)!important;-webkit-backdrop-filter:blur(28px)!important;border:1px solid rgba(255,255,255,.65)!important;box-shadow:0 18px 48px -26px rgba(17,28,45,.38)!important;transition:all .28s ease!important}.flight-card:hover,.glass-card:hover{transform:translateY(-4px)!important;box-shadow:0 26px 64px -30px rgba(0,76,226,.38)!important;border-color:rgba(255,255,255,.85)!important}.destination-title{font-size:clamp(22px,2vw,32px);font-weight:800;letter-spacing:-.04em;color:#111c2d}.route-code{font-size:11px;font-weight:700;color:rgba(17,28,45,.55)}
/* Round Trip Progress Bar */
.rt-progress{background:rgba(255,255,255,.62);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.68);box-shadow:0 12px 36px -20px rgba(17,28,45,.22);border-radius:20px;padding:14px 24px;margin-top:16px}
.rt-steps{display:flex;align-items:center;justify-content:center;gap:0}.rt-step{display:flex;flex-direction:column;align-items:center;gap:5px;min-width:100px}.rt-step-num{width:30px;height:30px;border-radius:50%;background:rgba(17,28,45,.08);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:rgba(17,28,45,.35)}.rt-step.active .rt-step-num{background:#004ce2;color:white;box-shadow:0 8px 18px -10px rgba(0,76,226,.55)}.rt-step-label{font-size:11px;font-weight:700;color:rgba(17,28,45,.4)}.rt-step.active .rt-step-label{color:#004ce2}.rt-connector{flex:1;height:2px;min-width:48px;max-width:100px;background:rgba(17,28,45,.1);margin:0 8px;margin-bottom:16px;position:relative}.rt-connector-fill{height:100%;width:0;background:linear-gradient(90deg,#004ce2,#00b4d8)}.rt-step.done .rt-step-num{background:#00b4d8;color:white}.rt-step.done .rt-step-label{color:#00b4d8}.rt-connector.done .rt-connector-fill{width:100%}
/* Outbound summary banner for return selection */
.outbound-summary{background:linear-gradient(135deg,#004ce2,#3267ff);border-radius:18px;padding:14px 20px;margin-bottom:20px;color:white}
/* Clickable card cursor */
.flight-card.clickable{cursor:pointer}
/* One-way layout */
#searchFieldsRow.oneway-layout #returnDateField{display:none}
#searchFieldsRow.oneway-layout{grid-template-columns:repeat(12,1fr)}
#searchFieldsRow.oneway-layout #fromField{grid-column:span 3}
#searchFieldsRow.oneway-layout #toField{grid-column:span 3}
#searchFieldsRow.oneway-layout #departureDateField{grid-column:span 2}
#searchFieldsRow.oneway-layout #paxField{grid-column:span 2}
#searchFieldsRow.oneway-layout button[type="submit"]{grid-column:span 2}
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

    <form method="GET" class="flight-search p-5 md:p-6 w-full mx-auto">
      <div class="flex flex-wrap gap-2 mb-5">
        <button type="button" onclick="setTrip('oneway',this)" class="trip-btn <?= $trip==='oneway'?'active':'' ?> px-5 py-2 rounded-full text-sm font-bold bg-white/70 text-on-surface">One Way</button>
        <button type="button" onclick="setTrip('round',this)" class="trip-btn <?= $trip==='round'?'active':'' ?> px-5 py-2 rounded-full text-sm font-bold bg-white/70 text-on-surface">Round Trip</button>
        <div class="ml-0 md:ml-auto flex gap-1.5 bg-white/55 p-1 rounded-full">
          <button type="button" onclick="setClass('economy',this)" id="btn_economy" class="class-btn px-5 py-2 rounded-full text-sm font-bold text-on-surface/70">Economy</button>
          <button type="button" onclick="setClass('business',this)" id="btn_business" class="class-btn px-5 py-2 rounded-full text-sm font-bold text-on-surface/70">Business</button>
        </div>
      </div>
      <input type="hidden" name="class" id="classInput" value="<?= h($class) ?>">
      <input type="hidden" name="trip" id="tripInput" value="<?= h($trip) ?>">
      
      <div id="searchFieldsRow" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
        <div class="flight-field relative md:col-span-2" id="fromField">
          <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">flight_takeoff</span>
          <input list="cities" type="text" name="from" value="<?= h($from) ?>" class="w-full h-14 pl-12 pr-4 text-sm" placeholder="From: Jakarta">
        </div>
        <div class="flight-field relative md:col-span-2" id="toField">
          <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">flight_land</span>
          <input list="cities" type="text" name="to" value="<?= h($to) ?>" class="w-full h-14 pl-12 pr-4 text-sm" placeholder="To: Bali">
        </div>
        <div class="flight-field relative md:col-span-2" id="departureDateField">
          <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">calendar_month</span>
          <input type="date" name="date" value="<?= h($date) ?>" min="<?= date('Y-m-d') ?>" class="w-full h-14 pl-12 pr-4 text-sm">
        </div>
        <div class="flight-field relative md:col-span-2" id="returnDateField">
          <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">event_repeat</span>
          <input type="date" name="return_date" value="<?= h($returnDate) ?>" min="<?= date('Y-m-d') ?>" class="w-full h-14 pl-12 pr-4 text-sm">
        </div>
        <div class="flight-field flex items-center justify-between h-14 px-4 md:col-span-2" id="paxField">
          <span class="material-symbols-outlined text-outline text-[20px]">person</span>
          <button type="button" onclick="changePax(-1)" class="w-8 h-8 rounded-full bg-white/70 font-bold text-lg">−</button>
          <input id="paxInput" name="pax" value="<?= $pax ?>" readonly class="w-10 text-center bg-transparent border-0 shadow-none outline-none text-sm font-bold">
          <button type="button" onclick="changePax(1)" class="w-8 h-8 rounded-full bg-white/70 font-bold text-lg">+</button>
        </div>
        <button type="submit" class="md:col-span-2 h-14 px-5 bg-primary text-white rounded-2xl font-bold hover:opacity-90 transition-all flex items-center justify-center gap-1.5 whitespace-nowrap shadow-lg shadow-primary/20">
          <span class="material-symbols-outlined text-[20px]">search</span>
          Search
        </button>
      </div>
    </form>
    <datalist id="cities">
      <?php $cities=['Jakarta','Bali','Surabaya','Lombok','Medan','Makassar','Yogyakarta']; foreach($cities as $c): ?><option value="<?= $c ?>"><?php endforeach; ?>
    </datalist>

    <!-- Round Trip Progress Bar: only visible for round trip -->
    <?php if ($trip === 'round' && $searched): ?>
    <div class="rt-progress mt-4">
      <div class="rt-steps">
        <!-- Step 1: Outbound -->
        <div class="rt-step <?= !$isReturnSelection ? 'active' : 'done' ?>" id="rtStep1">
          <div class="rt-step-num"><?= !$isReturnSelection ? '1' : '✓' ?></div>
          <span class="rt-step-label">Outbound</span>
        </div>
        <div class="rt-connector <?= $isReturnSelection ? 'done' : '' ?>">
          <div class="rt-connector-fill" style="width:<?= $isReturnSelection ? '100%' : '0' ?>"></div>
        </div>
        <!-- Step 2: Return -->
        <div class="rt-step <?= $isReturnSelection ? 'active' : '' ?>" id="rtStep2">
          <div class="rt-step-num">2</div>
          <span class="rt-step-label">Return</span>
        </div>
        <div class="rt-connector">
          <div class="rt-connector-fill" style="width:0"></div>
        </div>
        <!-- Step 3: Review & Pay -->
        <div class="rt-step" id="rtStep3">
          <div class="rt-step-num">3</div>
          <span class="rt-step-label">Review &amp; Pay</span>
        </div>
      </div>
    </div>
    <?php endif; ?>
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
        // For date strip links, preserve outbound_id when in return selection
        $dateStripParams = $baseParams . ($isReturnSelection ? '&outbound_id='.$outboundId : '');
      ?>
      <div class="date-strip anim-fade-up">
        <a class="date-arrow" title="Previous 7 days" href="?<?= $dateStripParams ?>&date=<?= $prevRange ?>&range_start=<?= $prevRange ?>"><span class="material-symbols-outlined">chevron_left</span></a>
        <div class="date-tabs">
          <?php for($d=0;$d<7;$d++): $dd=date('Y-m-d', strtotime($rangeStart." +{$d} days")); ?>
          <a class="date-tab <?= $dd===$date?'active':'' ?>" href="?<?= $dateStripParams ?>&date=<?= $dd ?>&range_start=<?= h($rangeStart) ?>"><?= date('M j', strtotime($dd)) ?></a>
          <?php endfor; ?>
        </div>
        <a class="date-arrow" title="Next 7 days" href="?<?= $dateStripParams ?>&date=<?= $nextRange ?>&range_start=<?= $nextRange ?>"><span class="material-symbols-outlined">chevron_right</span></a>
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

      <!-- ─── OUTBOUND SUMMARY BANNER (only shown during return selection step) ─── -->
      <?php if ($isReturnSelection && $selectedOutbound): ?>
      <?php
        $obPrice = ($class === 'business') ? $selectedOutbound['price_business'] : $selectedOutbound['price_economy'];
        $obEmoji = $airlineEmojis[$selectedOutbound['airline']] ?? '✈';
      ?>
      <div class="outbound-summary anim-fade-up mb-4">
        <div class="flex items-center justify-between flex-wrap gap-3">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-xl"><?= $obEmoji ?></div>
            <div>
              <p class="text-xs font-bold text-white/70 uppercase tracking-wider">Outbound Selected</p>
              <p class="font-extrabold text-white"><?= h($selectedOutbound['from_city']) ?> → <?= h($selectedOutbound['to_city']) ?> · <?= h($selectedOutbound['airline']) ?> · <?= $selectedOutbound['dep_time'] ?>–<?= $selectedOutbound['arr_time'] ?></p>
            </div>
          </div>
          <div class="text-right">
            <p class="text-xs text-white/70">Outbound fare</p>
            <p class="text-lg font-extrabold text-white"><?= formatRupiah($obPrice * $pax) ?></p>
          </div>
        </div>
        <div class="mt-3 pt-3 border-t border-white/20 flex items-center gap-2">
          <span class="material-symbols-outlined text-white/80 text-[16px]">info</span>
          <p class="text-xs text-white/80">Now pick your return flight from <strong><?= h($selectedOutbound['to_city']) ?></strong> back to <strong><?= h($selectedOutbound['from_city']) ?></strong></p>
          <a href="?<?= $baseParams ?>&date=<?= h($date) ?>&range_start=<?= h($rangeStart) ?>" class="ml-auto text-xs font-bold text-white/90 underline hover:text-white">← Change outbound</a>
        </div>
      </div>
      <?php endif; ?>

      <!-- Results Header -->
      <div class="flex items-center justify-between mb-6 anim-fade-up">
        <div>
          <h2 class="text-xl font-bold text-on-surface">
            <?php if ($isReturnSelection && $selectedOutbound): ?>
              <?= h($selectedOutbound['to_city']) ?> → <?= h($selectedOutbound['from_city']) ?> <span class="text-primary text-sm font-bold">(Return)</span>
            <?php elseif($from&&$to): ?>
              <?= h($from) ?> → <?= h($to) ?>
            <?php elseif($from): ?>
              From <?= h($from) ?>
            <?php else: ?>
              To <?= h($to) ?>
            <?php endif; ?>
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
          $totalPrice = $price * $pax;
          $emoji = $airlineEmojis[$f['airline']] ?? '✈';

          // ── DETERMINE BOOK URL BASED ON TRIP TYPE & STEP ──
          if ($trip === 'oneway') {
            // ONE-WAY: Book button → straight to checkout
            $bookUrl = auth()
              ? 'checkout.php?type=flight&id='.$f['id'].'&class='.$class.'&pax='.$pax.'&date='.urlencode($date).'&trip=oneway&total='.round($totalPrice*1.11)
              : 'login.php';
            $bookLabel = 'Book Now';
            $isClickable = true;

          } elseif (!$isReturnSelection) {
            // ROUND TRIP STEP 1 (select outbound): Book button → reload page with outbound_id
            $bookUrl = '?'.$baseParams.'&date='.urlencode($date).'&return_date='.urlencode($returnDate).'&range_start='.urlencode($rangeStart).'&outbound_id='.$f['id'];
            $bookLabel = 'Select Outbound';
            $isClickable = true;

          } else {
            // ROUND TRIP STEP 2 (select return): Book button → checkout with both flight ids
            $obPrice = ($class === 'business') ? $selectedOutbound['price_business'] : $selectedOutbound['price_economy'];
            $totalRound = ($obPrice + $price) * $pax;
            $bookUrl = auth()
              ? 'checkout.php?type=flight&id='.$selectedOutbound['id'].'&class='.$class.'&pax='.$pax.'&date='.urlencode($date).'&trip=round&return_date='.urlencode($returnDate).'&return_id='.$f['id'].'&total='.round($totalRound*1.11)
              : 'login.php';
            $bookLabel = 'Select Return';
            $isClickable = true;
          }
        ?>
        <div onclick="window.location.href='<?= $bookUrl ?>'"
          class="flight-card clickable rounded-2xl p-5 md:p-6 anim-fade-up delay-<?= min(500,($i+1)*80) ?>"
          data-flight-airline="<?= h($f['airline']) ?>" data-price="<?= $price ?>" data-depart="<?= $f['dep_time'] ?? '' ?>" data-dur="<?= $f['duration'] ?>">
          <div class="flex flex-col md:flex-row md:items-center gap-5">
            <!-- Airline -->
            <div class="flex items-center gap-3 md:w-40">
              <div class="w-12 h-12 rounded-2xl bg-primary-fixed flex items-center justify-center text-2xl"><?= $emoji ?></div>
              <div>
                <p class="font-bold text-sm text-on-surface"><?= h($f['airline']) ?></p>
                <p class="text-xs text-outline"><?= h($f['airline_code'] ?? '') ?></p>
              </div>
            </div>

            <!-- Route -->
            <div class="flex-1 flex items-center gap-4">
              <div class="text-center min-w-[120px]">
                <p class="destination-title"><?= h($f['from_city']) ?></p>
                <p class="route-code"><?= h($f['from_code']) ?> · <?= $f['dep_time'] ?? '' ?></p>
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
                <p class="route-code"><?= h($f['to_code']) ?> · <?= $f['arr_time'] ?? '' ?></p>
              </div>
            </div>

            <!-- Price + Book -->
            <div class="flex flex-row md:flex-col items-end justify-between md:justify-center md:items-end md:min-w-[160px]">
              <div class="text-right">
                <p class="text-xs text-outline"><?= $pax ?> passenger<?= $pax > 1 ? 's' : '' ?></p>
                <?php if ($isReturnSelection): ?>
                  <?php
                    $obPriceDisplay = ($class === 'business') ? $selectedOutbound['price_business'] : $selectedOutbound['price_economy'];
                    $totalRoundDisplay = ($obPriceDisplay + $price) * $pax;
                  ?>
                  <p class="text-2xl font-extrabold text-primary"><?= formatRupiah($totalRoundDisplay) ?></p>
                  <p class="text-xs text-outline">Combined total · <?= formatRupiah($price) ?>/person return</p>
                <?php else: ?>
                  <p class="text-2xl font-extrabold text-primary"><?= formatRupiah($totalPrice) ?></p>
                  <p class="text-xs text-outline"><?= formatRupiah($price) ?>/person</p>
                <?php endif; ?>
              </div>
              <a onclick="event.stopPropagation()" href="<?= $bookUrl ?>"
                class="mt-2 px-5 py-2.5 bg-primary text-white rounded-full text-xs font-bold hover:opacity-90 hover:scale-105 transition-all shadow-md shadow-primary/20">
                <?= $bookLabel ?>
              </a>
            </div>
          </div>

          <!-- Seats warning -->
          <?php $seatsLeft = $f['seats_available'] ?? null; if ($seatsLeft !== null && $seatsLeft <= 20): ?>
          <div class="mt-3 pt-3 border-t border-outline-variant/30 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-error text-[14px] icon-fill">warning</span>
            <p class="text-xs text-error font-semibold">Only <?= $seatsLeft ?> seats left!</p>
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
            class="glass-card rounded-2xl p-5 flex items-center justify-between hover:border-primary/30 hover:scale-[1.02] transition-all group cursor-pointer">
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
    document.querySelectorAll('.trip-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tripInput').value = type;
    const returnField = document.getElementById('returnDateField');
    const searchRow = document.getElementById('searchFieldsRow');
    if (type === 'oneway') {
        searchRow.classList.add('oneway-layout');
        if (returnField) returnField.style.display = 'none';
    } else {
        searchRow.classList.remove('oneway-layout');
        if (returnField) returnField.style.display = '';
    }
}
// Init layout on page load — only fix the return date visibility, don't reset tripInput
(function(){
  var trip = document.getElementById('tripInput').value;
  var returnField = document.getElementById('returnDateField');
  var searchRow = document.getElementById('searchFieldsRow');
  if (trip === 'oneway') {
    searchRow.classList.add('oneway-layout');
    if (returnField) returnField.style.display = 'none';
  } else {
    searchRow.classList.remove('oneway-layout');
    if (returnField) returnField.style.display = '';
  }
})();

function changePax(delta) {
  const input = document.getElementById('paxInput');
  let val = parseInt(input.value || '1', 10) + delta;
  input.value = Math.max(1, Math.min(9, val));
}
function filterAirlines() {
  const checked = [...document.querySelectorAll('.airline-check:checked')].map(i => i.dataset.airline);
  document.querySelectorAll('.flight-card[data-flight-airline]').forEach(card => {
    card.style.display = checked.includes(card.dataset.flightAirline) ? '' : 'none';
  });
}
function resetAirlines() {
  document.querySelectorAll('.airline-check').forEach(i=>i.checked = true);
  filterAirlines();
}
// Init active class button
var classBtn = document.getElementById('btn_<?= $class ?>');
if (classBtn) classBtn.classList.add('active');

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