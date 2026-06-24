<?php
require 'config.php';

$id = (int)($_GET['id'] ?? 0);

function hotelRoomTypes(array $p): array {
    return [
        [
            'name'=>'Deluxe Room','slug'=>'deluxe-room','price'=>$p['price_per_night'],
            'size'=>'32 m²','bed'=>'1 King Bed','max_guests'=>2,'rooms'=>'1 room','bathroom'=>'1 bathroom',
            'amenities'=>['Free WiFi','Breakfast','City View','Smart TV','Workspace','Rain Shower'],
            'image'=>'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=1000&q=80',
            'gallery'=>[
                'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=1000&q=80',
                'https://images.unsplash.com/photo-1595576508898-0ad5c879a061?w=1000&q=80',
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1000&q=80',
            ],
            'desc'=>'A clean, comfortable room for solo travelers or couples. Best for short stays with essential facilities and easy access to hotel amenities.'
        ],
        [
            'name'=>'Ocean View Suite','slug'=>'ocean-view-suite','price'=>(int)round($p['price_per_night']*1.45),
            'size'=>'48 m²','bed'=>'1 King Bed + Sofa','max_guests'=>3,'rooms'=>'1 suite','bathroom'=>'1 bathroom',
            'amenities'=>['Ocean View','Bathtub','Lounge Area','Mini Bar','Premium Toiletries','Breakfast'],
            'image'=>'https://images.unsplash.com/photo-1591088398332-8a7791972843?w=1000&q=80',
            'gallery'=>[
                'https://images.unsplash.com/photo-1591088398332-8a7791972843?w=1000&q=80',
                'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=1000&q=80',
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&q=80',
            ],
            'desc'=>'A larger suite with better view, lounge area, and upgraded amenities. More suitable if the guest wants a premium hotel experience.'
        ],
        [
            'name'=>'Family Connecting Room','slug'=>'family-connecting-room','price'=>(int)round($p['price_per_night']*1.85),
            'size'=>'64 m²','bed'=>'2 Rooms · 3 Beds','max_guests'=>4,'rooms'=>'2 connected rooms','bathroom'=>'2 bathrooms',
            'amenities'=>['Connecting Room','Breakfast','Extra Space','Kids Friendly','Two Bathrooms','Family Sofa'],
            'image'=>'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=1000&q=80',
            'gallery'=>[
                'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=1000&q=80',
                'https://images.unsplash.com/photo-1598928636135-d146006ff4be?w=1000&q=80',
                'https://images.unsplash.com/photo-1560448075-bb485b067938?w=1000&q=80',
            ],
            'desc'=>'A bigger setup for families or groups. This room makes more sense when booking for more than two people.'
        ],
    ];
}

if ($id) {
    $p = getProperty($id);
    if (!$p || $p['type'] !== 'hotel') { header('Location: detail_hotel.php'); exit; }

    $favd = isFavourited($id);
    $roomTypes = hotelRoomTypes($p);
    $roomIndex = isset($_GET['room']) ? max(0, min(count($roomTypes)-1, (int)$_GET['room'])) : null;
    $selectedRoom = $roomIndex !== null ? $roomTypes[$roomIndex] : null;
    $checkin = scalarParam('checkin', date('Y-m-d', strtotime('+2 days')));
    $checkout = scalarParam('checkout', date('Y-m-d', strtotime('+5 days')));
    $guests = max(1, min(9, (int)scalarParam('guests', '1')));
    $nights = max(1, (int)ceil((strtotime($checkout) - strtotime($checkin)) / 86400));
    $activeRoomPrice = $selectedRoom ? $selectedRoom['price'] : $p['price_per_night'];
    $base = $activeRoomPrice * $nights;
    $tax = $base * 0.11;
    $total = $base + $tax;

    $facilityPhotos = [
        ['src'=>$p['image_url'], 'label'=>'Hotel Exterior'],
        ['src'=>'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=900&q=80', 'label'=>'Pool Area'],
        ['src'=>'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=900&q=80', 'label'=>'Lobby'],
        ['src'=>'https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?w=900&q=80', 'label'=>'Restaurant'],
        ['src'=>'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=900&q=80', 'label'=>'Spa & Wellness'],
    ];

    echo htmlHead(h($p['name']), <<<CSS
.hero-parallax{background-image:url('{$p['image_url']}');background-size:cover;background-position:center;background-attachment:fixed}.glass-card{background:rgba(255,255,255,.78);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.55);box-shadow:0 18px 52px -30px rgba(17,28,45,.35)}.room-card{background:rgba(255,255,255,.66);backdrop-filter:blur(24px);border:1px solid rgba(195,197,216,.45);box-shadow:0 12px 34px -24px rgba(17,28,45,.28);transition:.25s}.room-card:hover{transform:translateY(-3px);border-color:rgba(0,76,226,.45);box-shadow:0 22px 52px -30px rgba(0,76,226,.38)}.room-chip{background:rgba(228,232,255,.72);border:1px solid rgba(195,197,216,.36)}.date-input{height:48px;border-radius:14px;background:rgba(240,243,255,.72);border:1.5px solid rgba(195,197,216,.8);padding:0 14px;outline:none}.guest-stepper{height:48px;border-radius:999px;background:rgba(240,243,255,.72);border:1.5px solid rgba(195,197,216,.8);display:flex;align-items:center;justify-content:space-between;padding:0 10px}.step-btn{width:34px;height:34px;border-radius:999px;background:white;font-weight:800;color:#111c2d}.photo-thumb:hover img{transform:scale(1.08)}
CSS);
?>
<body class="bg-background text-on-background min-h-screen">
<?= navbar('detail_hotel.php') ?>
<?= backButton('detail_hotel.php') ?>

<div class="hero-parallax h-[50vh] relative overflow-hidden">
  <div class="absolute inset-0 bg-gradient-to-t from-black/82 via-black/35 to-black/10"></div>
  <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 max-w-[1280px] mx-auto">
    <div class="flex items-end justify-between flex-wrap gap-4">
      <div>
        <div class="flex gap-2 mb-3">
          <span class="px-3 py-1 bg-primary/90 backdrop-blur-sm text-white rounded-full text-xs font-bold">Hotel</span>
          <?php foreach(array_slice($p['amenities'],0,2) as $am): ?><span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white rounded-full text-xs font-semibold"><?= h($am) ?></span><?php endforeach; ?>
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight"><?= h($p['name']) ?></h1>
        <p class="text-white/75 flex items-center gap-1.5 mt-2"><span class="material-symbols-outlined text-[18px]">location_on</span><?= h($p['location']) ?></p>
      </div>
      <div class="flex items-center gap-3">
        <?php if (auth()): ?><button id="favBtn" onclick="toggleFav()" class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center <?= $favd?'text-error':'text-white' ?> hover:scale-110 transition-all"><span class="material-symbols-outlined text-[24px] <?= $favd?'icon-fill':'' ?>" id="favIcon">favorite</span></button><?php endif; ?>
        <div class="glass rounded-2xl px-4 py-3 text-center"><div class="flex items-center gap-1 justify-center"><span class="material-symbols-outlined icon-fill text-amber-400 text-[20px]">star</span><span class="text-2xl font-extrabold text-on-surface"><?= $p['rating'] ?></span></div><p class="text-xs text-outline"><?= number_format($p['review_count']) ?> reviews</p></div>
      </div>
    </div>
  </div>
</div>

<main class="max-w-[1280px] mx-auto px-5 md:px-16 py-12">

  <section class="glass-card rounded-3xl p-4 mb-8 anim-fade-up">
    <div class="flex items-center justify-between mb-4 px-2"><h2 class="text-xl font-extrabold text-on-surface">Hotel Photos & Facilities</h2><span class="text-xs font-bold text-outline">Preview</span></div>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
      <?php foreach($facilityPhotos as $ph): ?>
      <div class="photo-thumb relative h-28 rounded-2xl overflow-hidden group"><img src="<?= h($ph['src']) ?>" class="w-full h-full object-cover transition-transform duration-500" alt="<?= h($ph['label']) ?>"><div class="absolute inset-0 bg-gradient-to-t from-black/55 to-transparent"></div><p class="absolute bottom-2 left-3 right-3 text-white text-xs font-bold"><?= h($ph['label']) ?></p></div>
      <?php endforeach; ?>
    </div>
  </section>

  <?php if ($selectedRoom === null): ?>
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    <div class="lg:col-span-2 space-y-8">
      <section class="glass-card rounded-2xl p-6 anim-fade-up">
        <h2 class="text-xl font-bold text-on-surface mb-4">Hotel Overview</h2>
        <p class="text-on-surface-variant leading-relaxed"><?= h($p['description']) ?></p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-6">
          <?php foreach(array_slice($p['amenities'],0,8) as $am): ?><div class="flex items-center gap-2 p-3 bg-surface-container-low rounded-xl"><span class="material-symbols-outlined text-primary text-[18px] icon-fill">check_circle</span><span class="text-sm font-medium text-on-surface"><?= h($am) ?></span></div><?php endforeach; ?>
        </div>
      </section>

      <section class="glass-card rounded-2xl p-6 anim-fade-up delay-100" id="rooms">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-5">
          <div><h2 class="text-xl font-bold text-on-surface mb-1">Available Rooms</h2><p class="text-sm text-on-surface-variant">Pick dates first, then choose the room type. Hotel room capacity, beds, and facilities are different per room.</p></div>
        </div>
        <form method="GET" action="detail_hotel.php" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6 p-4 rounded-2xl bg-surface-container-low/70">
          <input type="hidden" name="id" value="<?= $p['id'] ?>">
          <div><label class="text-xs font-extrabold text-outline uppercase">Check-in</label><input class="date-input w-full mt-1" type="date" name="checkin" value="<?= h($checkin) ?>"></div>
          <div><label class="text-xs font-extrabold text-outline uppercase">Check-out</label><input class="date-input w-full mt-1" type="date" name="checkout" value="<?= h($checkout) ?>"></div>
          <div><label class="text-xs font-extrabold text-outline uppercase">Guests</label><div class="guest-stepper mt-1"><button class="step-btn" type="button" onclick="changeGuest(-1)">−</button><input id="guestInput" name="guests" value="<?= $guests ?>" readonly class="w-10 text-center bg-transparent border-0 font-extrabold"><button class="step-btn" type="button" onclick="changeGuest(1)">+</button></div></div>
          <button class="h-12 mt-5 md:mt-6 rounded-2xl bg-primary text-white font-bold" type="submit">Check Rooms</button>
        </form>

        <div class="space-y-4">
          <?php foreach($roomTypes as $idx=>$room): $isEnough = $guests <= $room['max_guests']; ?>
          <a href="detail_hotel.php?id=<?= $p['id'] ?>&room=<?= $idx ?>&checkin=<?= h($checkin) ?>&checkout=<?= h($checkout) ?>&guests=<?= min($guests,$room['max_guests']) ?>" class="room-card block rounded-2xl p-4 <?= !$isEnough?'opacity-60 pointer-events-none':'' ?>">
            <div class="flex flex-col md:flex-row gap-4">
              <img src="<?= h($room['image']) ?>" class="w-full md:w-40 h-36 md:h-28 rounded-xl object-cover" alt="<?= h($room['name']) ?>">
              <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3"><div><h3 class="text-lg font-extrabold text-on-surface"><?= h($room['name']) ?></h3><p class="text-xs text-outline mt-1"><?= h($room['size']) ?> · <?= h($room['bed']) ?> · Max <?= $room['max_guests'] ?> guests</p></div><div class="text-right"><p class="text-lg font-extrabold text-primary"><?= formatRupiah($room['price']) ?></p><p class="text-xs text-outline">/night</p></div></div>
                <div class="flex flex-wrap gap-1.5 mt-3"><?php foreach(array_slice($room['amenities'],0,5) as $am): ?><span class="room-chip px-2 py-1 rounded-full text-xs font-semibold text-on-surface-variant"><?= h($am) ?></span><?php endforeach; ?></div>
                <div class="mt-3 flex items-center justify-between"><p class="text-xs <?= $isEnough?'text-green-600':'text-error' ?> font-bold"><?= $isEnough?'Available for selected guests':'Not enough capacity for '.$guests.' guests' ?></p><span class="text-primary text-sm font-extrabold">View Room Detail →</span></div>
              </div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </section>
    </div>
  </div>

  <?php else: ?>
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    <div class="lg:col-span-2 space-y-8">
      <a href="detail_hotel.php?id=<?= $p['id'] ?>&checkin=<?= h($checkin) ?>&checkout=<?= h($checkout) ?>&guests=<?= $guests ?>#rooms" class="inline-flex items-center gap-2 text-primary font-bold text-sm"><span class="material-symbols-outlined text-[18px]">arrow_back</span>Back to rooms</a>
      <section class="glass-card rounded-2xl overflow-hidden anim-fade-up">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 p-3">
          <div class="md:col-span-2 h-72 rounded-2xl overflow-hidden"><img src="<?= h($selectedRoom['gallery'][0]) ?>" class="w-full h-full object-cover" alt="<?= h($selectedRoom['name']) ?>"></div>
          <div class="grid grid-cols-2 md:grid-cols-1 gap-2"><?php foreach(array_slice($selectedRoom['gallery'],1) as $img): ?><div class="h-[136px] rounded-2xl overflow-hidden"><img src="<?= h($img) ?>" class="w-full h-full object-cover" alt="Room photo"></div><?php endforeach; ?></div>
        </div>
        <div class="p-6"><h2 class="text-3xl font-extrabold text-on-surface mb-2"><?= h($selectedRoom['name']) ?></h2><p class="text-on-surface-variant leading-relaxed"><?= h($selectedRoom['desc']) ?></p>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-6">
            <div class="text-center p-4 bg-surface-container-low rounded-xl"><span class="material-symbols-outlined text-primary">group</span><p class="font-extrabold"><?= $selectedRoom['max_guests'] ?></p><p class="text-xs text-outline">Max Guests</p></div>
            <div class="text-center p-4 bg-surface-container-low rounded-xl"><span class="material-symbols-outlined text-primary">bed</span><p class="font-extrabold"><?= h($selectedRoom['bed']) ?></p><p class="text-xs text-outline">Bed Type</p></div>
            <div class="text-center p-4 bg-surface-container-low rounded-xl"><span class="material-symbols-outlined text-primary">meeting_room</span><p class="font-extrabold"><?= h($selectedRoom['rooms']) ?></p><p class="text-xs text-outline">Room Setup</p></div>
            <div class="text-center p-4 bg-surface-container-low rounded-xl"><span class="material-symbols-outlined text-primary">straighten</span><p class="font-extrabold"><?= h($selectedRoom['size']) ?></p><p class="text-xs text-outline">Room Size</p></div>
          </div>
        </div>
      </section>

      <section class="glass-card rounded-2xl p-6 anim-fade-up delay-100"><h2 class="text-xl font-bold text-on-surface mb-4">Room Amenities</h2><div class="grid grid-cols-2 md:grid-cols-3 gap-3"><?php foreach($selectedRoom['amenities'] as $am): ?><div class="flex items-center gap-2 p-3 bg-surface-container-low rounded-xl"><span class="material-symbols-outlined text-primary text-[18px] icon-fill">check_circle</span><span class="text-sm font-medium text-on-surface"><?= h($am) ?></span></div><?php endforeach; ?></div></section>
    </div>

    <aside class="glass-card rounded-2xl p-6 lg:sticky lg:top-24 anim-fade-up delay-200">
      <p class="text-2xl font-extrabold text-primary mb-1"><?= formatRupiah($selectedRoom['price']) ?><span class="text-xs text-outline font-semibold"> / night</span></p>
      <p class="text-sm text-on-surface-variant mb-5"><?= h($selectedRoom['name']) ?></p>
      <form method="GET" action="checkout.php" class="space-y-4">
        <input type="hidden" name="type" value="hotel"><input type="hidden" name="id" value="<?= $p['id'] ?>"><input type="hidden" name="room" value="<?= h($selectedRoom['name']) ?>"><input type="hidden" name="room_price" value="<?= $selectedRoom['price'] ?>">
        <div><label class="text-xs font-extrabold text-outline uppercase">Check-in</label><input class="date-input w-full mt-1" type="date" name="checkin" value="<?= h($checkin) ?>"></div>
        <div><label class="text-xs font-extrabold text-outline uppercase">Check-out</label><input class="date-input w-full mt-1" type="date" name="checkout" value="<?= h($checkout) ?>"></div>
        <div><label class="text-xs font-extrabold text-outline uppercase">Guests</label><div class="guest-stepper mt-1"><button class="step-btn" type="button" onclick="changeBookGuests(-1)">−</button><input id="bookGuests" name="guests" value="<?= min($guests,$selectedRoom['max_guests']) ?>" readonly class="w-10 text-center bg-transparent border-0 font-extrabold"><button class="step-btn" type="button" onclick="changeBookGuests(1)">+</button></div><p class="text-xs text-outline mt-1">Max <?= $selectedRoom['max_guests'] ?> guests for this room.</p></div>
        <div class="border-t border-outline-variant/30 pt-4 space-y-2 text-sm"><div class="flex justify-between text-on-surface-variant"><span><?= formatRupiah($selectedRoom['price']) ?> × <?= $nights ?> nights</span><span><?= formatRupiah($base) ?></span></div><div class="flex justify-between text-on-surface-variant"><span>Tax (11%)</span><span><?= formatRupiah($tax) ?></span></div><div class="flex justify-between font-extrabold text-on-surface pt-2"><span>Total</span><span class="text-primary"><?= formatRupiah($total) ?></span></div></div>
        <button type="submit" class="w-full h-14 rounded-full bg-gradient-to-r from-primary to-secondary-container text-white font-bold flex items-center justify-center gap-2 shadow-lg"><span class="material-symbols-outlined text-[20px]">hotel</span>Book This Room</button>
      </form>
    </aside>
  </div>
  <?php endif; ?>

</main>
<?= footer() ?>
<script>
function changeGuest(delta){const input=document.getElementById('guestInput'); if(!input) return; let v=parseInt(input.value||'1',10)+delta; input.value=Math.max(1,Math.min(9,v));}
function changeBookGuests(delta){const input=document.getElementById('bookGuests'); if(!input) return; let v=parseInt(input.value||'1',10)+delta; input.value=Math.max(1,Math.min(<?= $selectedRoom ? (int)$selectedRoom['max_guests'] : 9 ?>,v));}
<?php if (auth()): ?>
async function toggleFav(){const fd=new FormData();fd.append('property_id',<?= $p['id'] ?>);const r=await fetch('toggle_fav.php',{method:'POST',body:fd});const d=await r.json();const btn=document.getElementById('favBtn');const icon=document.getElementById('favIcon');btn.classList.toggle('text-error',d.active);btn.classList.toggle('text-white',!d.active);icon.classList.toggle('icon-fill',d.active);}
<?php endif; ?>
</script>
</body></html>
<?php
} else {
    $hotels = getProperties();
    echo htmlHead("Accommodations", <<<CSS
.prop-card{background:rgba(255,255,255,.78);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.45);box-shadow:0 8px 28px rgba(0,76,226,.06);transition:all .35s cubic-bezier(.22,1,.36,1)}.prop-card:hover{transform:translateY(-5px);box-shadow:0 20px 48px rgba(0,76,226,.12);border-color:rgba(0,76,226,.12)}
CSS);
?>
<body class="bg-background text-on-background min-h-screen">
<?= navbar('detail_hotel.php') ?>
<?= backButton('home.php') ?>
<div class="bg-gradient-to-r from-[#004ce2] to-[#00677f] pt-32 pb-16 px-5 md:px-16"><div class="max-w-[1280px] mx-auto"><h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-2">Accommodations</h1><p class="text-white/75">Choose hotels or villas for your stay.</p></div></div>
<main class="max-w-[1280px] mx-auto px-5 md:px-16 py-12">
  <div class="glass-card rounded-2xl p-4 mb-6"><label class="text-xs font-bold text-outline uppercase tracking-wider">Search accommodation</label><div class="relative mt-2"><span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span><input id="accomSearch" oninput="filterName()" class="w-full h-12 pl-12 pr-4 rounded-xl bg-surface-container-low border border-outline-variant outline-none focus:border-primary" placeholder="Search hotel or villa name"></div></div>
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="hotelGrid">
    <?php foreach($hotels as $i=>$p): $detailUrl = $p['type'] === 'villa' ? 'detail_villa.php?id='.(int)$p['id'] : 'detail_hotel.php?id='.(int)$p['id']; ?>
    <div class="prop-card <?= $p['type'] === 'villa' ? 'card-villa' : 'card-hotel' ?> rounded-2xl overflow-hidden cursor-pointer" onclick="window.location.href='<?= h($detailUrl) ?>'" data-name="<?= strtolower(h($p['name'].' '.$p['location'])) ?>">
      <div class="relative h-52 overflow-hidden"><img src="<?= h($p['image_url']) ?>" alt="<?= h($p['name']) ?>" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"><div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div><div class="absolute bottom-3 right-3 flex items-center gap-1 bg-black/40 backdrop-blur-sm px-2.5 py-1 rounded-full"><span class="material-symbols-outlined icon-fill text-amber-400 text-[14px]">star</span><span class="text-white text-xs font-bold"><?= $p['rating'] ?></span></div></div>
      <div class="p-5"><h3 class="font-extrabold text-on-surface text-lg leading-tight mb-1"><?= h($p['name']) ?></h3><p class="text-on-surface-variant text-sm flex items-center gap-1 mb-3"><span class="material-symbols-outlined text-[14px]">location_on</span><?= h($p['location']) ?></p><div class="flex items-end justify-between pt-3 border-t border-outline-variant/30"><div><p class="text-xs text-outline">Starts from</p><div class="price-row"><span class="price"><?= formatRupiah($p['price_per_night']) ?></span><span class="unit">/ night</span></div></div><a href="<?= h($detailUrl) ?>" onclick="event.stopPropagation()" class="view-btn px-5 py-2.5 text-white rounded-full text-xs font-bold">View <?= ucfirst(h($p['type'])) ?></a></div></div>
    </div>
    <?php endforeach; ?>
  </div>
</main>
<?= footer() ?>
<script>function filterName(){const q=document.getElementById('accomSearch').value.toLowerCase();document.querySelectorAll('#hotelGrid > div').forEach(card=>{card.style.display=card.dataset.name.includes(q)?'':'none';});}</script>
</body></html>
<?php } ?>
