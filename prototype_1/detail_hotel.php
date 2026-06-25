<?php
require 'config.php';

$id = (int)($_GET['id'] ?? 0);

// Fallback room types kalau $p['rooms'] tidak ada di data
function hotelRoomTypes(array $p): array {
    $base = $p['price_per_night'] ?? 0;
    return [
        ['name'=>'Deluxe Room','slug'=>'deluxe-room','price'=>$base,'size'=>'32 m2','bed'=>'1 King Bed','max_guests'=>2,'rooms'=>'1 room','bathroom'=>'1 bathroom','amenities'=>['Free WiFi','Breakfast','City View','Smart TV','Workspace','Rain Shower'],'image'=>'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=1000&q=80','desc'=>'A clean, comfortable room for solo travelers or couples. Best for short stays with essential facilities.'],
        ['name'=>'Ocean View Suite','slug'=>'ocean-view-suite','price'=>(int)round($base*1.45),'size'=>'48 m2','bed'=>'1 King Bed + Sofa','max_guests'=>3,'rooms'=>'1 suite','bathroom'=>'1 bathroom','amenities'=>['Ocean View','Bathtub','Lounge Area','Mini Bar','Premium Toiletries','Breakfast'],'image'=>'https://images.unsplash.com/photo-1591088398332-8a7791972843?w=1000&q=80','desc'=>'A larger suite with better view, lounge area, and upgraded amenities.'],
        ['name'=>'Family Connecting Room','slug'=>'family-connecting-room','price'=>(int)round($base*1.85),'size'=>'64 m2','bed'=>'2 Rooms - 3 Beds','max_guests'=>4,'rooms'=>'2 connected rooms','bathroom'=>'2 bathrooms','amenities'=>['Connecting Room','Breakfast','Extra Space','Kids Friendly','Two Bathrooms','Family Sofa'],'image'=>'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=1000&q=80','desc'=>'A bigger setup for families or groups.'],
    ];
}

// Custom CSS
$customCSS = "
@keyframes heart-wiggle {
  0%, 100% { transform: scale(1) rotate(0deg); }
  25% { transform: scale(1.4) rotate(-15deg); }
  50% { transform: scale(1.4) rotate(15deg); }
  75% { transform: scale(1.4) rotate(-15deg); }
}
.anim-wiggle { animation: heart-wiggle 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
.fav-btn{width:48px;height:48px;border-radius:999px;display:flex;align-items:center;justify-content:center;background:rgba(15,23,42,.45);backdrop-filter:blur(14px);transition:all .25s ease;border:none;cursor:pointer}
.fav-btn:hover{transform:scale(1.08)}
.fav-btn.active .material-symbols-outlined{color:#dc2626;font-variation-settings:'FILL' 1}
.fav-btn.active{background:rgba(255,255,255,.92);box-shadow:0 0 0 4px rgba(239,68,68,.12),0 8px 24px rgba(239,68,68,.25)}
.fav-pop{animation:favPop .45s cubic-bezier(.22,1,.36,1)}
@keyframes favPop{0%{transform:scale(1)}40%{transform:scale(1.45)}70%{transform:scale(.9)}100%{transform:scale(1)}}
.hero-parallax{background-image:url('{{IMAGE_URL}}');background-size:cover;background-position:center;background-attachment:fixed}
.glass-card{background:rgba(255,255,255,.78);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.55);box-shadow:0 18px 52px -30px rgba(17,28,45,.35)}
.room-card{background:rgba(255,255,255,.66);backdrop-filter:blur(24px);border:1px solid rgba(195,197,216,.45);box-shadow:0 12px 34px -24px rgba(17,28,45,.28);transition:.25s}
.room-card:hover{transform:translateY(-3px);border-color:rgba(0,76,226,.45);box-shadow:0 22px 52px -30px rgba(0,76,226,.38)}
.room-chip{background:rgba(228,232,255,.72);border:1px solid rgba(195,197,216,.36)}
.date-input{height:48px;border-radius:14px;background:rgba(240,243,255,.72);border:1.5px solid rgba(195,197,216,.8);padding:0 14px;outline:none}
.guest-stepper{height:48px;border-radius:999px;background:rgba(240,243,255,.72);border:1.5px solid rgba(195,197,216,.8);display:flex;align-items:center;justify-content:space-between;padding:0 10px}
.step-btn{width:34px;height:34px;border-radius:999px;background:white;font-weight:800;color:#111c2d;display:flex;align-items:center;justify-content:center;line-height:1;font-size:20px;padding:0;margin:0;border:none;cursor:pointer;flex-shrink:0}
.photo-thumb:hover img{transform:scale(1.08)}
.prop-card{background:rgba(255,255,255,.78);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.45);box-shadow:0 8px 28px rgba(0,76,226,.06);transition:all .35s cubic-bezier(.22,1,.36,1)}
.prop-card:hover{transform:translateY(-5px);box-shadow:0 20px 48px rgba(0,76,226,.12);border-color:rgba(0,76,226,.12)}
.dd-active{background:rgba(0,76,226,.06);color:#004ce2}
.dd-active-r{background:rgba(251,191,36,.1)}
.dd-item:hover,.dd-item-r:hover{background:rgba(0,76,226,.05)}
";

if ($id) {
  // ── DETAIL VIEW ──────────────────────────────────────────────
  $p = getProperty($id);
  if (!$p || $p['type'] !== 'hotel') {
    header('Location: detail_hotel.php');
    exit;
  }

  $favd = auth() ? isFavourited($id) : false;

  // Ambil room types: dari data.php jika ada, fallback ke fungsi lokal
  $roomTypes = [];
  if (!empty($p['rooms']) && is_array($p['rooms'])) {
    $roomTypes = $p['rooms'];
  } else {
    $roomTypes = hotelRoomTypes($p);
  }

  $roomIndex   = isset($_GET['room']) ? max(0, min(count($roomTypes) - 1, (int)$_GET['room'])) : null;
  $selectedRoom = $roomIndex !== null ? $roomTypes[$roomIndex] : null;
  $checkin     = scalarParam('checkin', date('Y-m-d', strtotime('+2 days')));
  $checkout    = scalarParam('checkout', date('Y-m-d', strtotime('+5 days')));
  $guests      = max(1, min(9, (int)scalarParam('guests', '1')));
  $nights      = max(1, (int)ceil((strtotime($checkout) - strtotime($checkin)) / 86400));
  $activeRoomPrice = $selectedRoom ? ($selectedRoom['price'] ?? 0) : ($p['price_per_night'] ?? 0);
  $base  = $activeRoomPrice * $nights;
  $tax   = $base * 0.11;
  $total = $base + $tax;

  $facilityPhotos = [
    ['src' => $p['image_url'], 'label' => 'Hotel Exterior'],
    ['src' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=900&q=80', 'label' => 'Pool Area'],
    ['src' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=900&q=80', 'label' => 'Lobby'],
    ['src' => 'https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?w=900&q=80', 'label' => 'Restaurant'],
    ['src' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=900&q=80', 'label' => 'Spa & Wellness'],
  ];

  echo htmlHead(h($p['name']), str_replace('{{IMAGE_URL}}', $p['image_url'], $customCSS));
?>
<body class="bg-background text-on-background min-h-screen">
  <?= navbar('detail_hotel.php') ?>
  <?php if ($selectedRoom !== null): ?>
    <?= backButton("detail_hotel.php?id={$p['id']}&checkin={$checkin}&checkout={$checkout}&guests={$guests}#rooms") ?>
  <?php else: ?>
    <?= backButton('detail_hotel.php') ?>
  <?php endif; ?>

  <div class="hero-parallax h-[50vh] relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-t from-black/82 via-black/35 to-black/10"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 max-w-[1280px] mx-auto">
      <div class="flex items-end justify-between flex-wrap gap-4">
        <div>
          <div class="flex gap-2 mb-3">
            <span class="px-3 py-1 bg-primary/90 backdrop-blur-sm text-white rounded-full text-xs font-bold">Hotel</span>
            <?php foreach (array_slice($p['amenities'] ?? [], 0, 2) as $am): ?>
              <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white rounded-full text-xs font-semibold"><?= h($am) ?></span>
            <?php endforeach; ?>
          </div>
          <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight"><?= h($p['name']) ?></h1>
          <p class="text-white/75 flex items-center gap-1.5 mt-2">
            <span class="material-symbols-outlined text-[18px]">location_on</span><?= h($p['location']) ?>
          </p>
        </div>
        <div class="flex items-center gap-3">
          <?php if (auth()): ?>
            <button id="favBtn" onclick="animateAndToggleFav(this, <?= $p['id'] ?>)"
              class="px-5 h-12 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center gap-2 <?= $favd ? 'text-red-500' : 'text-white' ?> hover:bg-white/30 hover:scale-105 transition-all">
              <span class="material-symbols-outlined text-[24px] <?= $favd ? 'icon-fill' : '' ?>" id="favIcon">favorite</span>
              <span class="text-sm font-bold hidden sm:block fav-label"><?= $favd ? 'Favourited' : 'Add to Favourite' ?></span>
            </button>
          <?php endif; ?>
          <div class="glass rounded-2xl px-4 py-3 text-center">
            <div class="flex items-center gap-1 justify-center">
              <span class="material-symbols-outlined icon-fill text-amber-400 text-[20px]">star</span>
              <span class="text-2xl font-extrabold text-on-surface"><?= $p['rating'] ?></span>
            </div>
            <p class="text-xs text-outline"><?= number_format($p['review_count']) ?> reviews</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <main class="max-w-[1280px] mx-auto px-5 md:px-16 py-12">

    <section class="glass-card rounded-3xl p-4 mb-8 anim-fade-up">
      <div class="flex items-center justify-between mb-4 px-2">
        <h2 class="text-xl font-extrabold text-on-surface">Hotel Photos & Facilities</h2>
        <span class="text-xs font-bold text-outline">Preview</span>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        <?php foreach ($facilityPhotos as $ph): ?>
          <div class="photo-thumb relative h-28 rounded-2xl overflow-hidden group">
            <img src="<?= h($ph['src']) ?>" class="w-full h-full object-cover transition-transform duration-500" alt="<?= h($ph['label']) ?>">
            <div class="absolute inset-0 bg-gradient-to-t from-black/55 to-transparent"></div>
            <p class="absolute bottom-2 left-3 right-3 text-white text-xs font-bold"><?= h($ph['label']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <?php if ($selectedRoom === null): ?>
      <!-- HOTEL OVERVIEW + ROOM LIST -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 space-y-8">

          <section class="glass-card rounded-2xl p-6 anim-fade-up">
            <h2 class="text-xl font-bold text-on-surface mb-4">Hotel Overview</h2>
            <p class="text-on-surface-variant leading-relaxed"><?= h($p['description']) ?></p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-6">
              <?php foreach (array_slice($p['amenities'] ?? [], 0, 8) as $am): ?>
                <div class="flex items-center gap-2 p-3 bg-surface-container-low rounded-xl">
                  <span class="material-symbols-outlined text-primary text-[18px] icon-fill">check_circle</span>
                  <span class="text-sm font-medium text-on-surface"><?= h($am) ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </section>

          <section class="glass-card rounded-2xl p-6 anim-fade-up delay-100" id="rooms">
            <div class="mb-5">
              <h2 class="text-xl font-bold text-on-surface mb-1">Available Rooms</h2>
              <p class="text-sm text-on-surface-variant">Pick dates first, then choose the room type.</p>
            </div>
            <form method="GET" action="detail_hotel.php" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6 p-4 rounded-2xl bg-surface-container-low/70">
              <input type="hidden" name="id" value="<?= $p['id'] ?>">
              <div>
                <label class="text-xs font-extrabold text-outline uppercase">Check-in</label>
                <input class="date-input w-full mt-1" type="date" id="checkin" name="checkin" value="<?= h($checkin) ?>" min="<?= date('Y-m-d') ?>">
              </div>
              <div>
                <label class="text-xs font-extrabold text-outline uppercase">Check-out</label>
                <input class="date-input w-full mt-1" type="date" id="checkout" name="checkout" value="<?= h($checkout) ?>" min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
              </div>
              <div>
                <label class="text-xs font-extrabold text-outline uppercase">Guests</label>
                <div class="guest-stepper mt-1">
                  <button class="step-btn" type="button" onclick="changeGuest(-1)"><span style="display:block;line-height:1;margin-top:-2px">−</span></button>
                  <input id="guestInput" name="guests" value="<?= $guests ?>" readonly class="w-10 text-center bg-transparent border-0 font-extrabold">
                  <button class="step-btn" type="button" onclick="changeGuest(1)"><span style="display:block;line-height:1;margin-top:-2px">+</span></button>
                </div>
              </div>
              <button class="h-12 mt-5 md:mt-6 rounded-2xl bg-primary text-white font-bold" type="submit">Check Rooms</button>
            </form>

            <div class="space-y-4">
              <?php foreach ($roomTypes as $idx => $room): $isEnough = $guests <= ($room['max_guests'] ?? 2); ?>
                <a href="detail_hotel.php?id=<?= $p['id'] ?>&room=<?= $idx ?>&checkin=<?= h($checkin) ?>&checkout=<?= h($checkout) ?>&guests=<?= min($guests, $room['max_guests'] ?? 2) ?>"
                  class="room-card block rounded-2xl p-4 <?= !$isEnough ? 'opacity-60 pointer-events-none' : '' ?>">
                  <div class="flex flex-col md:flex-row gap-4">
                    <img src="<?= h($room['image'] ?? $p['image_url']) ?>" class="w-full md:w-40 h-36 md:h-28 rounded-xl object-cover" alt="<?= h($room['name'] ?? 'Room') ?>">
                    <div class="flex-1 min-w-0">
                      <div class="flex items-start justify-between gap-3">
                        <div>
                          <h3 class="text-lg font-extrabold text-on-surface"><?= h($room['name'] ?? 'Room') ?></h3>
                          <p class="text-xs text-outline mt-1"><?= h($room['size'] ?? '') ?> . <?= h($room['bed'] ?? '') ?> . Max <?= $room['max_guests'] ?? 2 ?> guests</p>
                        </div>
                        <div class="text-right">
                          <p class="text-lg font-extrabold text-primary"><?= formatRupiah($room['price'] ?? 0) ?></p>
                          <p class="text-xs text-outline">/night</p>
                        </div>
                      </div>
                      <div class="flex flex-wrap gap-1.5 mt-3">
                        <?php foreach (array_slice($room['amenities'] ?? [], 0, 5) as $am): ?>
                          <span class="room-chip px-2 py-1 rounded-full text-xs font-semibold text-on-surface-variant"><?= h($am) ?></span>
                        <?php endforeach; ?>
                      </div>
                      <div class="mt-3 flex flex-wrap items-center justify-between gap-2 border-t border-outline-variant/30 pt-3">
                        <p class="text-xs <?= $isEnough ? 'text-green-600' : 'text-error' ?> font-bold">
                          <?= $isEnough ? 'Available for selected guests' : 'Not enough capacity for ' . $guests . ' guests' ?>
                        </p>
                        <div class="flex items-center gap-4">
                          <?php if (auth()): ?>
                            <button onclick="event.preventDefault(); animateAndToggleFav(this, <?= $p['id'] ?>)"
                              class="flex items-center gap-1.5 text-xs font-extrabold <?= $favd ? 'text-red-500' : 'text-outline hover:text-red-500' ?> transition-colors z-10 relative">
                              <span class="material-symbols-outlined text-[16px] <?= $favd ? 'icon-fill' : '' ?>">favorite</span>
                              <span class="fav-label"><?= $favd ? 'Favourited' : 'Add to Favourite' ?></span>
                            </button>
                          <?php endif; ?>
                          <span class="text-primary text-sm font-extrabold">View Room Detail</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              <?php endforeach; ?>
            </div>
          </section>

        </div>
      </div>

    <?php else: ?>
      <!-- ROOM DETAIL + CHECKOUT CARD -->
      <div class="mb-6">
        <a href="detail_hotel.php?id=<?= $p['id'] ?>&checkin=<?= h($checkin) ?>&checkout=<?= h($checkout) ?>&guests=<?= $guests ?>#rooms"
          class="inline-flex items-center gap-2 text-primary font-bold hover:underline">
          <span class="material-symbols-outlined text-[18px]">arrow_back</span> Back to available rooms
        </a>
      </div>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 space-y-8">
          <section class="glass-card rounded-2xl p-6 anim-fade-up">
            <img src="<?= h($selectedRoom['image'] ?? $p['image_url']) ?>" class="w-full h-64 md:h-96 object-cover rounded-xl mb-6" alt="<?= h($selectedRoom['name'] ?? '') ?>">
            <h2 class="text-3xl font-extrabold text-on-surface mb-2"><?= h($selectedRoom['name'] ?? 'Room') ?></h2>
            <p class="text-sm text-outline mb-6">
              <?= h($selectedRoom['size'] ?? '') ?> &middot; <?= h($selectedRoom['bed'] ?? '') ?> &middot; Max <?= $selectedRoom['max_guests'] ?? 2 ?> guests &middot; <?= h($selectedRoom['bathroom'] ?? '') ?>
            </p>
            <h3 class="text-xl font-bold text-on-surface mb-3">Room Description</h3>
            <p class="text-on-surface-variant leading-relaxed mb-6"><?= h($selectedRoom['desc'] ?? '') ?></p>
            <h3 class="text-xl font-bold text-on-surface mb-3">Room Amenities</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
              <?php foreach ($selectedRoom['amenities'] ?? [] as $am): ?>
                <div class="flex items-center gap-2 p-3 bg-surface-container-low rounded-xl">
                  <span class="material-symbols-outlined text-primary text-[18px] icon-fill">check_circle</span>
                  <span class="text-sm font-medium text-on-surface"><?= h($am) ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </section>
        </div>

        <div class="lg:col-span-1">
          <div class="sticky top-24">
            <div class="glass-card rounded-2xl p-6 anim-fade-up delay-100">
              <div class="mb-4">
                <span class="text-2xl font-extrabold text-primary"><?= formatRupiah($selectedRoom['price'] ?? 0) ?></span>
                <span class="text-outline text-sm"> / night</span>
              </div>
              <div class="space-y-4 mb-6 p-4 rounded-xl bg-surface-container-low/50 border border-outline-variant/30">
                <div>
                  <p class="text-xs font-extrabold text-outline uppercase">Check-in</p>
                  <p class="font-bold text-on-surface"><?= date('D, d M Y', strtotime($checkin)) ?></p>
                </div>
                <div>
                  <p class="text-xs font-extrabold text-outline uppercase">Check-out</p>
                  <p class="font-bold text-on-surface"><?= date('D, d M Y', strtotime($checkout)) ?></p>
                </div>
                <div>
                  <p class="text-xs font-extrabold text-outline uppercase">Guests</p>
                  <p class="font-bold text-on-surface"><?= $guests ?> Guest(s)</p>
                </div>
              </div>
              <div class="space-y-2 py-4 border-y border-outline-variant/30 mb-4 text-sm">
                <div class="flex justify-between text-on-surface-variant">
                  <span><?= formatRupiah($selectedRoom['price'] ?? 0) ?> x <?= $nights ?> nights</span>
                  <span><?= formatRupiah($base) ?></span>
                </div>
                <div class="flex justify-between text-on-surface-variant">
                  <span>Tax (11%)</span>
                  <span><?= formatRupiah($tax) ?></span>
                </div>
                <div class="flex justify-between font-bold text-on-surface pt-2 border-t border-outline-variant/30">
                  <span>Total</span>
                  <span class="text-primary text-lg font-extrabold"><?= formatRupiah($total) ?></span>
                </div>
              </div>
              <?php
                $checkoutUrl = 'checkout.php?type=hotel'
                  . '&id=' . $p['id']
                  . '&checkin=' . urlencode($checkin)
                  . '&checkout=' . urlencode($checkout)
                  . '&guests=' . $guests
                  . '&room_name=' . urlencode($selectedRoom['name'] ?? '')
                  . '&room_price=' . ($selectedRoom['price'] ?? 0)
                  . '&room_bed=' . urlencode($selectedRoom['bed'] ?? '')
                  . '&room_size=' . urlencode($selectedRoom['size'] ?? '')
                  . '&room_max_guests=' . ($selectedRoom['max_guests'] ?? 2)
                  . '&nights=' . $nights
                  . '&total=' . round($total);
              ?>
              <?php if (auth()): ?>
                <a href="<?= $checkoutUrl ?>"
                  class="w-full h-12 bg-primary text-white rounded-full font-bold text-sm flex items-center justify-center gap-2 shadow-lg hover:scale-[1.02] transition-all">
                  Continue to Book
                </a>
              <?php else: ?>
                <a href="login.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>"
                  class="w-full h-12 bg-primary text-white rounded-full font-bold text-sm flex items-center justify-center gap-2 shadow-md hover:opacity-90 transition-all">
                  Login to Book
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </main>
  <?= footer() ?>

  <script>
    // Date validation
    const ciInput = document.getElementById('checkin');
    const coInput = document.getElementById('checkout');
    if (ciInput && coInput) {
      let d = new Date(ciInput.value || new Date());
      d.setDate(d.getDate() + 1);
      let nd = d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
      coInput.min = nd;
      ciInput.addEventListener('change', function() {
        if (!this.value) return;
        let d2 = new Date(this.value);
        d2.setDate(d2.getDate() + 1);
        let next = d2.getFullYear() + '-' + String(d2.getMonth()+1).padStart(2,'0') + '-' + String(d2.getDate()).padStart(2,'0');
        coInput.min = next;
        if (coInput.value <= this.value) coInput.value = next;
      });
    }

    function changeGuest(delta) {
      const inp = document.getElementById('guestInput');
      inp.value = Math.max(1, Math.min(9, parseInt(inp.value || '1') + delta));
    }

    function animateAndToggleFav(btn, id) {
      const icon = btn.querySelector('.material-symbols-outlined');
      icon.classList.remove('anim-wiggle');
      void icon.offsetWidth;
      icon.classList.add('anim-wiggle');
      const isNowFav = icon.classList.toggle('icon-fill');
      if (isNowFav) {
        btn.classList.add('text-red-500');
        btn.classList.remove('text-white', 'text-outline', 'hover:text-red-500');
      } else {
        btn.classList.remove('text-red-500');
        const isHero = btn.id === 'favBtn';
        btn.classList.add(isHero ? 'text-white' : 'text-outline');
      }
      const label = btn.querySelector('.fav-label');
      if (label) label.textContent = isNowFav ? 'Favourited' : 'Add to Favourite';
      toggleFav(id);
    }

    async function toggleFav(id) {
      const fd = new FormData();
      fd.append('property_id', id);
      try {
        const r = await fetch('toggle_fav.php', { method: 'POST', body: fd });
        const d = await r.json();
        console.log('Fav status:', d.active);
      } catch(e) { console.error('Fav error', e); }
    }
  </script>
</body>
</html>

<?php
} else {
  // ── LISTING VIEW ─────────────────────────────────────────────
  $hotels = getProperties();
  echo htmlHead("Accommodations", str_replace('{{IMAGE_URL}}', '', $customCSS));
?>
<body class="bg-background text-on-background min-h-screen">
  <?= navbar('detail_hotel.php') ?>

  <div class="bg-gradient-to-r from-[#004ce2] to-[#00677f] pt-32 pb-16 px-5 md:px-16">
    <div class="max-w-[1280px] mx-auto">
      <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-2">Accommodations</h1>
      <p class="text-white/75">Choose hotels or villas for your stay.</p>
    </div>
  </div>

  <main class="max-w-[1280px] mx-auto px-5 md:px-16 py-12">

    <div class="glass-card rounded-2xl p-5 mb-8 anim-fade-up relative overflow-visible z-[100]">
      <div class="flex flex-col md:flex-row md:items-center gap-3">

        <div class="flex-1 w-full relative">
          <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
          <input id="accomSearch" oninput="applyFilters()" class="w-full h-12 pl-12 pr-4 rounded-xl bg-surface-container-low border border-outline-variant outline-none focus:border-primary transition-colors text-sm" placeholder="Cari nama hotel atau villa...">
        </div>

        <div class="relative shrink-0" id="dropdownTypeWrap">
          <button onclick="toggleDropdown('dropdownType')" class="flex items-center gap-2 h-12 px-4 rounded-xl bg-surface-container-low border border-outline-variant hover:border-primary transition-colors text-sm font-semibold text-on-surface min-w-[140px] justify-between">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-primary text-[18px]">apartment</span>
              <span id="typeLabel">Semua Tipe</span>
            </div>
            <span class="material-symbols-outlined text-outline text-[18px]" id="typeChevron">expand_more</span>
          </button>
          <div id="dropdownType" class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-outline-variant/40 overflow-hidden z-[9999]">
            <button onclick="setTypeFilter('all', 'Semua Tipe', this)" class="dd-item w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-on-surface hover:bg-primary/8 transition-colors dd-active">
              <span class="material-symbols-outlined text-[17px] text-primary">select_all</span> Semua Tipe
              <span class="material-symbols-outlined text-primary text-[16px] ml-auto dd-check">check</span>
            </button>
            <button onclick="setTypeFilter('hotel', 'Hotel', this)" class="dd-item w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-on-surface hover:bg-primary/8 transition-colors">
              <span class="material-symbols-outlined text-[17px] text-outline">hotel</span> Hotel
              <span class="material-symbols-outlined text-primary text-[16px] ml-auto dd-check hidden">check</span>
            </button>
            <button onclick="setTypeFilter('villa', 'Villa', this)" class="dd-item w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-on-surface hover:bg-primary/8 transition-colors">
              <span class="material-symbols-outlined text-[17px] text-outline">villa</span> Villa
              <span class="material-symbols-outlined text-primary text-[16px] ml-auto dd-check hidden">check</span>
            </button>
          </div>
        </div>

        <div class="relative shrink-0" id="dropdownRatingWrap">
          <button onclick="toggleDropdown('dropdownRating')" class="flex items-center gap-2 h-12 px-4 rounded-xl bg-surface-container-low border border-outline-variant hover:border-primary transition-colors text-sm font-semibold text-on-surface min-w-[150px] justify-between">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined icon-fill text-amber-400 text-[18px]">star</span>
              <span id="ratingLabel">Urutkan</span>
            </div>
            <span class="material-symbols-outlined text-outline text-[18px]" id="ratingChevron">expand_more</span>
          </button>
          <div id="dropdownRating" class="hidden absolute top-full right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-outline-variant/40 overflow-hidden z-[9999]">
            <button onclick="setSort('rating','Rating Tertinggi',this)" class="dd-item-r w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-on-surface dd-active-r">
              <span class="material-symbols-outlined text-amber-400">star</span> Rating Tertinggi
            </button>
            <button onclick="setSort('cheap','Harga Termurah',this)" class="dd-item-r w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-on-surface">
              <span class="material-symbols-outlined">payments</span> Harga Termurah
            </button>
            <button onclick="setSort('expensive','Harga Termahal',this)" class="dd-item-r w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-on-surface">
              <span class="material-symbols-outlined">diamond</span> Harga Termahal
            </button>
            <button onclick="setSort('az','A-Z',this)" class="dd-item-r w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-on-surface">
              <span class="material-symbols-outlined">sort_by_alpha</span> A-Z
            </button>
            <button onclick="setSort('za','Z-A',this)" class="dd-item-r w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-on-surface">
              <span class="material-symbols-outlined">sort_by_alpha</span> Z-A
            </button>
          </div>
        </div>

      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="hotelGrid">
      <?php foreach ($hotels as $i => $p):
        $detailUrl = $p['type'] === 'villa' ? 'detail_villa.php?id=' . (int)$p['id'] : 'detail_hotel.php?id=' . (int)$p['id'];
        $isFav = auth() ? isFavourited($p['id']) : false;
      ?>
        <div class="prop-card <?= $p['type'] === 'villa' ? 'card-villa' : 'card-hotel' ?> rounded-2xl overflow-hidden cursor-pointer"
          onclick="window.location.href='<?= h($detailUrl) ?>'"
          data-name="<?= strtolower(h($p['name'] . ' ' . $p['location'])) ?>"
          data-type="<?= $p['type'] ?>"
          data-rating="<?= $p['rating'] ?>"
          data-price="<?= $p['price_per_night'] ?>"
          data-id="<?= $p['id'] ?>">
          <div class="relative h-52 overflow-hidden">
            <img src="<?= h($p['image_url']) ?>" alt="<?= h($p['name']) ?>" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
            <div class="absolute top-3 left-3 px-2.5 py-1 bg-black/50 backdrop-blur-md text-white rounded text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
              <span class="material-symbols-outlined text-[13px]"><?= $p['type'] === 'villa' ? 'villa' : 'hotel' ?></span>
              <?= $p['type'] ?>
            </div>
            <?php if (auth()): ?>
              <div class="absolute top-3 right-3 z-20">
                <button class="fav-btn <?= $isFav ? 'active' : '' ?>"
                  onclick="event.stopPropagation(); event.preventDefault(); animateAndToggleFav(this, <?= $p['id'] ?>)">
                  <span class="material-symbols-outlined text-white text-[24px]">favorite</span>
                </button>
              </div>
            <?php endif; ?>
            <div class="absolute bottom-3 right-3 flex items-center gap-1 bg-black/40 backdrop-blur-sm px-2.5 py-1 rounded-full">
              <span class="material-symbols-outlined icon-fill text-amber-400 text-[14px]">star</span>
              <span class="text-white text-xs font-bold"><?= $p['rating'] ?></span>
            </div>
          </div>
          <div class="p-5">
            <h3 class="font-extrabold text-on-surface text-lg leading-tight mb-1"><?= h($p['name']) ?></h3>
            <p class="text-on-surface-variant text-sm flex items-center gap-1 mb-3">
              <span class="material-symbols-outlined text-[14px]">location_on</span><?= h($p['location']) ?>
            </p>
            <div class="flex items-end justify-between pt-3 border-t border-outline-variant/30">
              <div>
                <p class="text-xs text-outline">Starts from</p>
                <div class="price-row"><span class="price"><?= formatRupiah($p['price_per_night']) ?></span><span class="unit">/ night</span></div>
              </div>
              <a href="<?= h($detailUrl) ?>" onclick="event.stopPropagation()" class="view-btn px-5 py-2.5 text-white rounded-full text-xs font-bold">View <?= ucfirst(h($p['type'])) ?></a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>
  <?= footer() ?>

  <script>
    let currentType = 'all';
    let currentSort = 'rating';

    function animateAndToggleFav(btn, id) {
      const icon = btn.querySelector('.material-symbols-outlined');
      icon.classList.remove('anim-wiggle');
      void icon.offsetWidth;
      icon.classList.add('anim-wiggle');
      const isNowFav = icon.classList.toggle('icon-fill');
      // fav-btn pakai class active, non fav-btn pakai text color
      if (btn.classList.contains('fav-btn')) {
        btn.classList.toggle('active', isNowFav);
      } else {
        if (isNowFav) {
          btn.classList.add('text-red-500');
          btn.classList.remove('text-white', 'text-outline');
        } else {
          btn.classList.remove('text-red-500');
          btn.classList.add('text-outline');
        }
        const label = btn.querySelector('.fav-label');
        if (label) label.textContent = isNowFav ? 'Favourited' : 'Add to Favourite';
      }
      toggleFav(id);
    }

    async function toggleFav(id) {
      const fd = new FormData();
      fd.append('property_id', id);
      try {
        const r = await fetch('toggle_fav.php', { method: 'POST', body: fd });
        const d = await r.json();
        console.log('Fav status:', d.active);
      } catch(e) { console.error('Fav error', e); }
    }

    function toggleDropdown(id) {
      const all = ['dropdownType', 'dropdownRating'];
      all.forEach(d => { if (d !== id) document.getElementById(d).classList.add('hidden'); });
      const el = document.getElementById(id);
      el.classList.toggle('hidden');
      const chevronId = id === 'dropdownType' ? 'typeChevron' : 'ratingChevron';
      document.getElementById(chevronId).textContent = el.classList.contains('hidden') ? 'expand_more' : 'expand_less';
    }

    document.addEventListener('click', function(e) {
      ['dropdownTypeWrap','dropdownRatingWrap'].forEach(wrap => {
        const el = document.getElementById(wrap);
        if (el && !el.contains(e.target)) {
          const ddId = wrap === 'dropdownTypeWrap' ? 'dropdownType' : 'dropdownRating';
          document.getElementById(ddId).classList.add('hidden');
          const chevronId = wrap === 'dropdownTypeWrap' ? 'typeChevron' : 'ratingChevron';
          document.getElementById(chevronId).textContent = 'expand_more';
        }
      });
    });

    function setTypeFilter(type, label, btn) {
      currentType = type;
      document.getElementById('typeLabel').textContent = label;
      document.querySelectorAll('.dd-item').forEach(b => {
        b.classList.remove('dd-active');
        b.querySelector('.dd-check').classList.add('hidden');
        b.querySelector('.material-symbols-outlined:first-child').classList.replace('text-primary','text-outline');
      });
      btn.classList.add('dd-active');
      btn.querySelector('.dd-check').classList.remove('hidden');
      btn.querySelector('.material-symbols-outlined:first-child').classList.replace('text-outline','text-primary');
      document.getElementById('dropdownType').classList.add('hidden');
      document.getElementById('typeChevron').textContent = 'expand_more';
      applyFilters();
    }

    function setSort(sort, label, btn) {
      currentSort = sort;
      document.getElementById('ratingLabel').textContent = label;
      document.querySelectorAll('.dd-item-r').forEach(b => b.classList.remove('dd-active-r'));
      btn.classList.add('dd-active-r');
      document.getElementById('dropdownRating').classList.add('hidden');
      document.getElementById('ratingChevron').textContent = 'expand_more';
      applyFilters();
    }

    function applyFilters() {
      const q = document.getElementById('accomSearch').value.toLowerCase();
      const grid = document.getElementById('hotelGrid');
      let cards = Array.from(grid.querySelectorAll('.prop-card'));
      cards.forEach(card => {
        const matchName = card.dataset.name.includes(q);
        const matchType = (currentType === 'all' || card.dataset.type === currentType);
        card.style.display = (matchName && matchType) ? '' : 'none';
      });
      let visible = cards.filter(c => c.style.display !== 'none');
      visible.sort((a, b) => {
        if (currentSort === 'rating') return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
        if (currentSort === 'cheap') return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
        if (currentSort === 'expensive') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
        if (currentSort === 'az') return a.dataset.name.localeCompare(b.dataset.name);
        if (currentSort === 'za') return b.dataset.name.localeCompare(a.dataset.name);
        return 0;
      });
      visible.forEach(c => grid.appendChild(c));
    }
  </script>
</body>
</html>
<?php } ?>