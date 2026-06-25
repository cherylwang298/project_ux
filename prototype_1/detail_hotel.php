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
  @keyframes bounceDown {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(6px); }
  }
  /* Force navbar to always sit above hero/map overlays */
  header, nav, [class*='navbar'], [class*='nav-bar'] { position:relative; z-index:9999 !important; }
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
    echo htmlHead("Accommodations", str_replace('{{IMAGE_URL}}', '', $customCSS) . '
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
      #accomMap .leaflet-attribution-flag { display:none !important; }
    </style>
    ');
  ?>
  <body class="bg-background text-on-background min-h-screen">
    <?= navbar('detail_hotel.php') ?>

    <!-- ── HERO + MAP seamlessly merged ─────────────────────────── -->
    <div class="relative" style="margin-top:0">

      <!-- Blue gradient overlay — z-index BELOW navbar (navbar is z-50 or similar) -->
      <div class="absolute top-0 left-0 right-0 pointer-events-none"
           style="height:300px;z-index:10;background:linear-gradient(to bottom,#0545c6 0%, #07629f 55%, transparent 100%);">
      </div>

      <!-- Hero text + search -->
      <div class="relative px-5 md:px-16 pb-0" style="z-index:20;padding-top:120px;">
        <div class="max-w-[1280px] mx-auto">
          <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight text-center drop-shadow-lg" style="margin-bottom:10px;margin-top:0;">Accommodations</h1>
          <p class="text-white/80 text-sm drop-shadow text-center" style="margin-bottom:28px;">Choose hotels or villas for your stay.</p>

          <!-- Search + Filter bar — glassmorphism: semi-transparent white -->
          <div style="background:rgba(255,255,255,0.55);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border:1.5px solid rgba(255,255,255,0.75);box-shadow:0 8px 32px rgba(0,20,80,0.18);"
               class="rounded-2xl p-2.5 flex flex-col md:flex-row md:items-center gap-2.5">

            <div class="flex-1 w-full relative">
              <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#1a3a6e] text-[20px]">search</span>
              <input id="accomSearch" oninput="applyFilters()"
                style="background:rgba(255,255,255,0.6);border:1.5px solid rgba(180,205,240,0.7);color:#111c2d;"
                class="w-full h-11 pl-11 pr-4 rounded-xl outline-none text-sm font-medium placeholder:text-[#3a5a8a]/70 focus:border-primary transition-colors"
                placeholder="Cari nama hotel atau villa...">
            </div>

            <div class="relative shrink-0" id="dropdownTypeWrap">
              <button onclick="toggleDropdown('dropdownType')"
                style="background:rgba(255,255,255,0.6);border:1.5px solid rgba(180,205,240,0.7);"
                class="flex items-center gap-2 h-11 px-4 rounded-xl hover:bg-white/80 transition-colors text-sm font-semibold text-[#1a3a6e] min-w-[140px] justify-between">
                <div class="flex items-center gap-2">
                  <span class="material-symbols-outlined text-primary text-[17px]">apartment</span>
                  <span id="typeLabel">Semua Tipe</span>
                </div>
                <span class="material-symbols-outlined text-[#3a5a8a] text-[17px]" id="typeChevron">expand_more</span>
              </button>
              <div id="dropdownType" class="hidden absolute top-full left-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-outline-variant/40 overflow-hidden z-[9999]">
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
              <button onclick="toggleDropdown('dropdownRating')"
                style="background:rgba(255,255,255,0.6);border:1.5px solid rgba(180,205,240,0.7);"
                class="flex items-center gap-2 h-11 px-4 rounded-xl hover:bg-white/80 transition-colors text-sm font-semibold text-[#1a3a6e] min-w-[148px] justify-between">
                <div class="flex items-center gap-2">
                  <span class="material-symbols-outlined icon-fill text-amber-400 text-[17px]">star</span>
                  <span id="ratingLabel">Urutkan</span>
                </div>
                <span class="material-symbols-outlined text-[#3a5a8a] text-[17px]" id="ratingChevron">expand_more</span>
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
      </div>

      <!-- ── MAP (starts from top, behind the gradient) ──────────── -->
      <div id="mapSection" class="relative bg-[#d8e8ec] overflow-hidden" style="height:720px;margin-top:-300px;z-index:5;">
        <div id="accomMap" class="absolute inset-0 w-full h-full z-0"></div>

        <!-- Map Controls overlay -->
        <div class="absolute top-4 left-4 z-[500] flex flex-col gap-2">
          <button onclick="accomMap.zoomIn()" class="w-9 h-9 bg-white rounded-lg shadow-md flex items-center justify-center text-on-surface hover:bg-surface-container-low font-bold text-xl leading-none">+</button>
          <button onclick="accomMap.zoomOut()" class="w-9 h-9 bg-white rounded-lg shadow-md flex items-center justify-center text-on-surface hover:bg-surface-container-low font-bold text-xl leading-none">−</button>
          <button onclick="recenterMap()" class="w-9 h-9 bg-white rounded-lg shadow-md flex items-center justify-center text-primary hover:bg-surface-container-low">
            <span class="material-symbols-outlined text-[20px]">my_location</span>
          </button>
        </div>

        <!-- Search as I move toggle -->
        <div class="absolute top-4 right-4 z-[500]">
          <label class="flex items-center gap-2 bg-white rounded-lg px-3 py-2 shadow-md cursor-pointer text-sm font-semibold text-on-surface select-none">
            <input type="checkbox" id="searchAsMove" checked class="accent-primary w-4 h-4">
            Search as I move the map
          </label>
        </div>

        <!-- Property Carousel at bottom of map -->
        <div class="absolute bottom-0 left-0 right-0 z-[400] pointer-events-none">
          <div class="relative pointer-events-auto" style="padding-left:max(20px, calc((100vw - 1280px)/2 + 20px));padding-right:max(20px, calc((100vw - 1280px)/2 + 20px));padding-bottom:14px;">
            <div class="flex items-end gap-3 overflow-x-auto snap-x snap-mandatory scroll-smooth hide-scrollbar" id="mapCarousel" style="padding-bottom:6px;overflow-y:visible;">
              <?php foreach ($hotels as $hi => $hp):
                $hUrl = $hp['type'] === 'villa' ? 'detail_villa.php?id=' . (int)$hp['id'] : 'detail_hotel.php?id=' . (int)$hp['id'];
                $isFav2 = auth() ? isFavourited($hp['id']) : false;
              ?>
              <div class="map-card snap-start shrink-0 w-56 bg-white overflow-hidden cursor-pointer transition-all hover:-translate-y-1"
                style="border-radius:12px;border:1px solid rgba(200,215,235,0.6);box-shadow:0 4px 16px rgba(0,30,80,0.12);pointer-events:auto;"
                onclick="window.location.href='<?= h($hUrl) ?>'"
                data-lat="<?= h($hp['lat'] ?? '') ?>"
                data-lng="<?= h($hp['lng'] ?? '') ?>"
                data-id="<?= $hp['id'] ?>"
                data-name="<?= strtolower(h($hp['name'] . ' ' . $hp['location'])) ?>"
                data-type="<?= h($hp['type']) ?>">
                <div class="relative h-28 overflow-hidden">
                  <img src="<?= h($hp['image_url']) ?>" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" alt="<?= h($hp['name']) ?>">
                  <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                  <div class="absolute top-2 left-2 px-2 py-0.5 bg-black/55 backdrop-blur-sm text-white rounded text-[9px] font-bold uppercase tracking-wide flex items-center gap-1">
                    <span class="material-symbols-outlined text-[11px]"><?= $hp['type'] === 'villa' ? 'villa' : 'hotel' ?></span>
                    <?= h(strtoupper($hp['type'])) ?>
                  </div>
                  <?php if (auth()): ?>
                  <div class="absolute top-2 right-2 z-10">
                    <button onclick="event.stopPropagation(); event.preventDefault(); animateAndToggleFav(this, <?= $hp['id'] ?>)"
                      class="fav-btn <?= $isFav2 ? 'active' : '' ?>" style="width:34px;height:34px;">
                      <span class="material-symbols-outlined text-white text-[18px] <?= $isFav2 ? 'icon-fill' : '' ?>">favorite</span>
                    </button>
                  </div>
                  <?php endif; ?>
                  <div class="absolute bottom-2 right-2 flex items-center gap-0.5 bg-black/45 backdrop-blur-sm px-1.5 py-0.5 rounded-full">
                    <span class="material-symbols-outlined icon-fill text-amber-400 text-[11px]">star</span>
                    <span class="text-white text-[10px] font-bold"><?= $hp['rating'] ?></span>
                  </div>
                </div>
                <div class="p-3">
                  <h3 class="font-extrabold text-on-surface text-xs leading-tight mb-0.5 truncate"><?= h($hp['name']) ?></h3>
                  <p class="text-on-surface-variant text-[10px] flex items-center gap-0.5 mb-2">
                    <span class="material-symbols-outlined text-[11px]">location_on</span><?= h($hp['location']) ?>
                  </p>
                  <div class="flex items-end justify-between pt-2 border-t border-outline-variant/30">
                    <div>
                      <p class="text-[9px] text-outline">Starts from</p>
                      <div class="flex items-baseline gap-0.5">
                        <span class="text-primary font-extrabold text-xs"><?= formatRupiah($hp['price_per_night']) ?></span>
                        <span class="text-outline text-[9px]">/ night</span>
                      </div>
                    </div>
                    <a href="<?= h($hUrl) ?>" onclick="event.stopPropagation()"
                      class="view-btn px-3 py-1.5 text-white rounded-full text-[9px] font-bold">
                      View
                    </a>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <!-- Carousel nav arrows -->
            <button onclick="scrollCarousel(1)" id="carouselNext"
              class="absolute right-5 top-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center text-on-surface hover:bg-primary hover:text-white transition-all z-10">
              <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </button>
            <button onclick="scrollCarousel(-1)" id="carouselPrev"
              class="absolute left-5 top-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center text-on-surface hover:bg-primary hover:text-white transition-all z-10 hidden">
              <span class="material-symbols-outlined text-[18px]">chevron_left</span>
            </button>
          </div>
          <!-- Scroll for more hint -->
          <div class="flex justify-center pb-2 pt-1 pointer-events-none">
          </div>
        </div>

        <!-- dead remnant -->
        <div class="hidden" id="toggleListBtn"></div>
      </div><!-- /#mapSection -->

      <!-- Glassmorphism scroll hint — floats between map and list -->
      <div class="flex justify-center" style="margin-top:-36px;position:relative;z-index:50;pointer-events:none;">
        <div class="flex flex-col items-center justify-center gap-0.5 pointer-events-auto cursor-pointer"
             style="width:72px;height:72px;border-radius:50%;background:rgba(30,90,200,0.55);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.4);box-shadow:0 4px 20px rgba(0,20,60,0.25);animation:bounceDown 2s ease-in-out infinite;"
             onclick="document.getElementById('hotelGrid').scrollIntoView({behavior:'smooth'})">
          <span class="text-white font-bold" style="font-size:7px;letter-spacing:0.1em;text-shadow:0 1px 3px rgba(0,0,0,0.6);line-height:1.3;text-align:center;">SCROLL<br>FOR MORE</span>
          <span class="material-symbols-outlined text-white" style="font-size:26px;text-shadow:0 1px 3px rgba(0,0,0,0.5);line-height:0.8;margin-top:-2px;">keyboard_arrow_down</span>
        </div>
      </div>
    </div><!-- /.relative wrapper -->

    <!-- List Section — always visible below map -->
    <main class="max-w-[1280px] mx-auto px-5 md:px-16 py-12">

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

    <!-- Leaflet CSS + JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
      .hide-scrollbar::-webkit-scrollbar { display:none; }
      .hide-scrollbar { -ms-overflow-style:none; scrollbar-width:none; }
      /* City pin marker */
      .city-pin { position:relative; display:flex; flex-direction:column; align-items:center; cursor:pointer; }
      .city-pin .pin-bubble {
        width:52px; height:52px; border-radius:50%; border:3px solid white;
        overflow:hidden; box-shadow:0 4px 16px rgba(0,76,226,.35);
        transition:transform .2s;
      }
      .city-pin:hover .pin-bubble { transform:scale(1.12); }
      .city-pin .pin-count {
        position:absolute; top:-6px; right:-6px;
        background:#004ce2; color:white; font-size:10px; font-weight:800;
        border-radius:999px; min-width:20px; height:20px;
        display:flex; align-items:center; justify-content:center;
        border:2px solid white; padding:0 4px;
      }
      .city-pin .pin-label {
        margin-top:4px; background:white; border-radius:8px;
        padding:2px 7px; font-size:11px; font-weight:700;
        color:#111c2d; box-shadow:0 2px 8px rgba(0,0,0,.18);
        white-space:nowrap;
      }
      /* Active carousel card */
      .map-card.active-card { box-shadow:0 0 0 3px #004ce2, 0 8px 32px rgba(0,76,226,.25); }
    </style>

    <script>
      // ── MAP SETUP ──────────────────────────────────────────────────
      const accomMap = L.map('accomMap', { zoomControl: false, attributionControl: false }).setView([-8.55, 115.2], 10);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18, attribution: '© OpenStreetMap contributors'
      }).addTo(accomMap);
      L.control.attribution({ prefix: false, position: 'bottomleft' }).addTo(accomMap);

      // Individual hotel markers from PHP data
      const hotelMarkers = {};
      <?php foreach ($hotels as $hm): if (empty($hm['lat']) || empty($hm['lng'])) continue; ?>
      (function(){
        const id   = <?= (int)$hm['id'] ?>;
        const name = <?= json_encode($hm['name']) ?>;
        const img  = <?= json_encode($hm['image_url']) ?>;
        const lat  = <?= (float)$hm['lat'] ?>;
        const lng  = <?= (float)$hm['lng'] ?>;
        const type = <?= json_encode($hm['type']) ?>;

        const icon = L.divIcon({
          className: '',
          html: `<div class="city-pin" title="${name}">
            <div class="pin-bubble"><img src="${img}" style="width:100%;height:100%;object-fit:cover" loading="lazy"></div>
            <div class="pin-label">${name.split(' ').slice(0,3).join(' ')}</div>
          </div>`,
          iconSize: [56, 76], iconAnchor: [28, 76]
        });

        const m = L.marker([lat, lng], { icon }).addTo(accomMap);
        m.on('click', () => {
          accomMap.flyTo([lat, lng], 14, { duration: 1 });
          // Highlight matching carousel card
          const carousel = document.getElementById('mapCarousel');
          const cards = Array.from(carousel.querySelectorAll('.map-card'));
          cards.forEach(c => c.classList.remove('active-card'));
          const target = cards.find(c => parseInt(c.dataset.id) === id);
          if (target) {
            target.classList.add('active-card');
            carousel.scrollTo({ left: target.offsetLeft - 20, behavior: 'smooth' });
          }
        });
        hotelMarkers[id] = { marker: m, lat, lng, name };
      })();
      <?php endforeach; ?>

      function recenterMap() {
        accomMap.setView([-8.55, 115.2], 10, { animate: true });
      }

      // Carousel scroll logic
      function scrollCarousel(dir) {
        const c = document.getElementById('mapCarousel');
        c.scrollBy({ left: dir * 300, behavior: 'smooth' });
        setTimeout(updateCarouselArrows, 350);
      }
      function updateCarouselArrows() {
        const c = document.getElementById('mapCarousel');
        document.getElementById('carouselPrev').classList.toggle('hidden', c.scrollLeft < 10);
        document.getElementById('carouselNext').classList.toggle('hidden', c.scrollLeft + c.clientWidth >= c.scrollWidth - 10);
      }
      document.getElementById('mapCarousel').addEventListener('scroll', updateCarouselArrows);
      updateCarouselArrows();

      // Fix map size after page load
      window.addEventListener('load', () => { accomMap.invalidateSize(); });

      // ── FILTER / SORT ──────────────────────────────────────────────
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

      // Search: Enter key flies map to first match
      document.getElementById('accomSearch').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
          const q = this.value.toLowerCase().trim();
          if (!q) return;
          const match = Object.values(hotelMarkers).find(h => h.name.toLowerCase().includes(q));
          if (match) accomMap.flyTo([match.lat, match.lng], 14, { duration: 1.2 });
        }
      });

      function applyFilters() {
        const q = document.getElementById('accomSearch').value.toLowerCase().trim();
        // Filter grid cards
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

        // Filter carousel cards + fly map to first match
        const carousel = document.getElementById('mapCarousel');
        const mapCards = Array.from(carousel.querySelectorAll('.map-card'));
        let firstMatch = null;
        mapCards.forEach(card => {
          const matchName = card.dataset.name.includes(q);
          const matchType = (currentType === 'all' || card.dataset.type === currentType);
          const show = matchName && matchType;
          card.style.display = show ? '' : 'none';
          if (show && !firstMatch) firstMatch = card;
        });

        if (q && firstMatch) {
          const id = parseInt(firstMatch.dataset.id);
          const hm = hotelMarkers[id];
          if (hm) accomMap.flyTo([hm.lat, hm.lng], 14, { duration: 1.2 });
          mapCards.forEach(c => c.classList.remove('active-card'));
          firstMatch.classList.add('active-card');
          carousel.scrollTo({ left: firstMatch.offsetLeft - 20, behavior: 'smooth' });
        } else if (!q) {
          mapCards.forEach(c => { c.style.display = ''; c.classList.remove('active-card'); });
          recenterMap();
        }
      }
    </script>
  </body>
  </html>
  <?php } ?>