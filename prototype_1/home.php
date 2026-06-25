<?php
require 'config.php';

$user       = auth();
$featured   = getProperties(null, true);
$hotelsAll  = getProperties('hotel');
$villasAll  = getProperties('villa');
$promos     = array_slice(getPromos(), 0, 3);

echo htmlHead("Discover Bali", <<<CSS
.hero-clean{min-height:92vh;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;background:#eaf5ff}
.hero-clean video,.hero-clean .hero-fallback{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;filter:saturate(1.04) brightness(1.02)}
.hero-clean:after{content:"";position:absolute;inset:0;background:linear-gradient(to bottom,rgba(255,255,255,.28),rgba(255,255,255,.58) 48%,rgba(255,255,255,.72));z-index:1}
.hero-content{position:relative;z-index:2;width:100%;max-width:1280px;margin:0 auto;padding:120px 32px 80px;text-align:center}
.hero-title{font-size:clamp(38px,5vw,72px);line-height:.98;font-weight:800;letter-spacing:-.055em;color:#111c2d;text-wrap:balance}
.hero-subtitle{margin:22px auto 46px;max-width:720px;font-size:clamp(15px,1.35vw,20px);line-height:1.8;color:rgba(17,28,45,.72)}
.hero-search{width:min(1120px,calc(100vw - 40px));margin:0 auto;display:grid;grid-template-columns:1.1fr 1fr 1fr .85fr 82px;align-items:center;min-height:86px;border-radius:24px;background:rgba(255,255,255,.62);backdrop-filter:blur(30px);-webkit-backdrop-filter:blur(30px);border:1px solid rgba(255,255,255,.72);box-shadow:0 24px 80px -32px rgba(17,28,45,.32), inset 0 1px 0 rgba(255,255,255,.85);overflow:hidden;transition: all 0.3s ease;}
.search-cell{height:100%;display:flex;align-items:center;gap:14px;padding:18px 24px;border-right:1px solid rgba(120,130,155,.16);text-align:left}
.search-cell:last-of-type{border-right:none}.search-cell .material-symbols-outlined{color:rgba(17,28,45,.46);font-size:26px}.search-label{display:block;font-size:13px;font-weight:800;color:#111c2d;margin-bottom:4px}.search-cell input{width:100%;border:0!important;outline:0!important;box-shadow:none!important;background:transparent!important;padding:0!important;font-size:17px;color:rgba(17,28,45,.76)}.search-cell input::placeholder{color:rgba(100,110,130,.38)}.search-btn{width:62px;height:62px;border-radius:22px;background:linear-gradient(135deg,#0062ff,#00c8e8);color:#fff;display:flex;align-items:center;justify-content:center;justify-self:center;box-shadow:0 16px 28px -12px rgba(0,94,255,.6);transition:.25s}.search-btn:hover{transform:translateY(-2px) scale(1.03)}
.prop-card{border-radius:28px!important;overflow:hidden;background:linear-gradient(145deg,rgba(255,255,255,.72),rgba(255,255,255,.48))!important;backdrop-filter:blur(28px)!important;-webkit-backdrop-filter:blur(28px)!important;border:1px solid rgba(255,255,255,.62)!important;box-shadow:0 18px 48px -24px rgba(17,28,45,.34)!important;transition:all .35s cubic-bezier(.22,1,.36,1)}
.prop-card:hover{transform:translateY(-7px)!important;box-shadow:0 32px 70px -30px rgba(0,76,226,.38)!important}.prop-card img{border-radius:0}.chip-glass{background:rgba(0,103,127,.86);backdrop-filter:blur(16px);color:#fff;border-radius:999px;font-size:12px;font-weight:800;padding:6px 12px}
.tab-btn{transition:all .25s ease; width: 170px; justify-content: center;}
.tab-btn.active{background:#004ce2;color:#fff;box-shadow:0 4px 12px rgba(0,76,226,.3)}
@media(max-width:900px){.hero-search{grid-template-columns:1fr!important;gap:0;padding:10px}.search-cell{border-right:0;border-bottom:1px solid rgba(120,130,155,.12);min-height:72px}.search-btn{width:100%;border-radius:18px;margin-top:8px}.hero-content{padding-left:20px;padding-right:20px}}
CSS
);
?>
<body class="bg-background text-on-background min-h-screen">
<?= navbar('home.php') ?>
<?= renderFlash() ?>

<section class="hero-clean">
  <video autoplay muted loop playsinline poster="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1800&q=80">
    <source src="https://cdn.coverr.co/videos/coverr-turquoise-water-1566/1080p.mp4" type="video/mp4">
  </video>
  <img class="hero-fallback" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1800&q=80" alt="Beach background">

  <div class="hero-content">
    <?php if ($user): ?>
    <div class="inline-flex items-center gap-2 bg-white/55 backdrop-blur-xl border border-white/70 rounded-full px-4 py-2 mb-6 shadow-sm">
      <span class="material-symbols-outlined text-primary text-[16px] icon-fill">waving_hand</span>
      <span class="text-on-surface/80 text-sm font-bold">Halo, <?= h(explode(' ',$user['name'])[0]) ?>!</span>
    </div>
    <?php endif; ?>

    <h1 class="hero-title">Your Journey, Beautifully<br class="hidden md:block"> Simplified</h1>
    <p class="hero-subtitle">Discover curated stays, effortless flights, and unforgettable experiences — all in one seamless platform.</p>

    <div class="flex justify-center gap-1 mb-4 mx-auto w-fit bg-white/60 backdrop-blur-md p-1.5 rounded-full border border-white/40 shadow-sm relative z-20">
      <button type="button" onclick="switchSearchTab('hotel')" id="btn-tab-hotel" class="tab-btn active flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-bold text-on-surface-variant cursor-pointer">
        <span class="material-symbols-outlined text-[18px]">hotel</span> Accommodations
      </button>
      <button type="button" onclick="switchSearchTab('flight')" id="btn-tab-flight" class="tab-btn flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-bold text-on-surface-variant cursor-pointer">
        <span class="material-symbols-outlined text-[18px]">flight</span> Flights
      </button>
    </div>

    <form action="detail_hotel.php" method="GET" id="main-search-form" class="hero-search">
      <div class="search-cell">
        <span class="material-symbols-outlined" id="icon-dest">location_on</span>
        <div class="w-full">
          <label class="search-label" id="label-dest">Location</label>
          <input type="text" name="q" id="input-dest" placeholder="Where to?" autocomplete="off" required>
        </div>
      </div>
      <div class="search-cell">
        <span class="material-symbols-outlined">calendar_month</span>
        <div class="w-full">
          <label class="search-label" id="label-date1">Check-in</label>
          <input type="date" name="checkin" value="<?= date('Y-m-d', strtotime('+3 days')) ?>">
        </div>
      </div>
      <div class="search-cell" id="cell-checkout">
        <span class="material-symbols-outlined">calendar_month</span>
        <div class="w-full">
          <label class="search-label">Check-out</label>
          <input type="date" name="checkout" value="<?= date('Y-m-d', strtotime('+7 days')) ?>">
        </div>
      </div>
      <div class="search-cell">
        <span class="material-symbols-outlined" id="icon-count">group</span>
        <div class="w-full">
          <label class="search-label" id="label-count">Guests</label>
          <input type="number" name="guests" value="2" min="1" max="12">
        </div>
      </div>
      <button type="submit" class="search-btn" aria-label="Search">
        <span class="material-symbols-outlined text-[30px]">search</span>
      </button>
    </form>
  </div>
</section>

<section class="max-w-[1280px] mx-auto px-5 md:px-16 py-20 -mt-10 relative z-10">
  <div class="flex items-end justify-between mb-10 anim-fade-up">
    <div>
      <span class="text-primary text-sm font-bold uppercase tracking-wider">Pilihan Terbaik</span>
      <h2 class="text-3xl md:text-4xl font-extrabold text-on-surface mt-1 tracking-tight">Featured Stays</h2>
    </div>
    <div class="flex gap-2">
      <a href="detail_hotel.php" class="px-4 py-2 border border-outline-variant/50 rounded-full text-sm font-semibold text-on-surface-variant hover:border-primary hover:text-primary transition-all">Hotels</a>
      <a href="detail_villa.php" class="px-4 py-2 border border-outline-variant/50 rounded-full text-sm font-semibold text-on-surface-variant hover:border-primary hover:text-primary transition-all">Villas</a>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($featured as $i => $p):
      $favd = isFavourited($p['id']);
      $detailUrl = "detail_{$p['type']}.php?id={$p['id']}";
    ?>
    <div onclick="window.location.href='<?= $detailUrl ?>'" class="prop-card <?= $p['type'] === 'villa' ? 'card-villa' : 'card-hotel' ?> rounded-2xl overflow-hidden anim-fade-up delay-<?= min(500,($i+1)*100) ?> cursor-pointer">
      <div class="relative h-56 overflow-hidden">
        <img src="<?= h($p['image_url']) ?>" alt="<?= h($p['name']) ?>" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
        <div class="absolute top-3 left-3 flex gap-2">
          <span class="px-2.5 py-1 bg-primary/90 backdrop-blur-sm text-white rounded-full text-xs font-bold"><?= ucfirst($p['type']) ?></span>
          <?php if($p['featured']): ?><span class="px-2.5 py-1 bg-amber-500 text-white rounded-full text-xs font-bold">Featured</span><?php endif; ?>
        </div>
        <?php if ($user): ?>
        <button onclick="event.stopPropagation();toggleFavBtn(<?= $p['id'] ?>,this)"
          class="fav-btn absolute top-3 right-3 w-10 h-10 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center transition-all hover:scale-110 shadow-md <?= $favd?'text-error':'text-outline' ?>">
          <span class="material-symbols-outlined text-[20px] <?= $favd?'icon-fill':'' ?>">favorite</span>
        </button>
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
        <div class="flex flex-wrap gap-1.5 mb-4">
          <?php foreach(array_slice($p['amenities'],0,3) as $am): ?>
          <span class="px-2 py-0.5 bg-surface-container rounded-full text-xs text-on-surface-variant flex items-center gap-1">
            <span class="material-symbols-outlined text-[11px] text-primary">check</span><?= h($am) ?>
          </span>
          <?php endforeach; ?>
          <?php if(count($p['amenities'])>3): ?>
          <span class="px-2 py-0.5 bg-surface-container rounded-full text-xs text-outline">+<?= count($p['amenities'])-3 ?></span>
          <?php endif; ?>
        </div>
        <div class="flex items-end justify-between pt-3 border-t border-outline-variant/30">
          <div>
            <p class="text-xs text-outline">Mulai dari</p>
            <div class="price-row">
              <span class="price"><?= formatRupiah($p['price_per_night']) ?></span>
              <span class="unit">/ night</span>
            </div>
          </div>
          <a onclick="event.stopPropagation()" href="<?= $detailUrl ?>" class="view-btn px-5 py-2.5 text-white rounded-full text-xs font-bold hover:opacity-90 hover:scale-105 transition-all shadow-md shadow-primary/20">Lihat Detail</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<?php if (!empty($promos)): ?>
<section class="max-w-[1280px] mx-auto px-5 md:px-16 pb-20">
  <div class="flex items-center justify-between mb-8 anim-fade-up">
    <div>
      <span class="text-secondary text-sm font-bold uppercase tracking-wider">Penawaran</span>
      <h2 class="text-2xl font-extrabold text-on-surface mt-1">Promo Terbatas</h2>
    </div>
    <a href="promo.php" class="text-primary text-sm font-bold hover:opacity-75 transition-opacity">All Promo →</a>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <?php $grads=['from-[#004ce2] to-[#00d2ff]','from-[#00677f] to-[#004ce2]','from-[#263143] to-[#004ce2]'];
    foreach ($promos as $i=>$pr): ?>
    <div class="rounded-2xl overflow-hidden bg-gradient-to-r <?= $grads[$i%3] ?> p-5 text-white relative anim-fade-up delay-<?= ($i+1)*100 ?>">
      <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-white/10 -translate-y-1/3 translate-x-1/3"></div>
      <div class="relative z-10">
        <p class="text-white/70 text-xs mb-1">Promo · <?= date('d M',strtotime($pr['valid_until'])) ?></p>
        <p class="text-3xl font-extrabold"><?= $pr['discount_type']==='percent'?$pr['discount_value'].'%':'Rp '.number_format($pr['discount_value'],0,'.','.') ?> <span class="text-lg font-bold text-white/70">OFF</span></p>
        <p class="font-bold mt-1 mb-3"><?= h($pr['title']) ?></p>
        <button onclick="navigator.clipboard.writeText('<?= h($pr['code']) ?>').then(()=>{this.textContent='✓ Disalin!';setTimeout(()=>{this.textContent='<?= h($pr['code']) ?>'}, 2000)})"
          class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-xl px-3 py-1.5 text-xs font-mono font-bold tracking-widest hover:bg-white/30 transition-colors cursor-pointer">
          <?= h($pr['code']) ?>
        </button>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<section class="bg-surface-container-low/60 py-20">
  <div class="max-w-[1280px] mx-auto px-5 md:px-16 text-center mb-12 anim-fade-up">
    <h2 class="text-3xl font-extrabold text-on-surface">Kenapa Pilih StayGo?</h2>
  </div>
  <div class="max-w-[1280px] mx-auto px-5 md:px-16 grid grid-cols-1 md:grid-cols-3 gap-8">
    <?php foreach([
      ['verified','Properties Terverifikasi','Setiap properti dikurasi dan diverifikasi tim kami untuk kualitas terjamin.'],
      ['price_check','Price Terbaik','Kami memastikan Anda mendapatkan nilai terbaik untuk setiap Rupiah yang dikeluarkan.'],
      ['support_agent','Support 24/7','Tim kami siap membantu kapan pun Anda membutuhkan, sebelum atau selama perjalanan.'],
    ] as [$icon,$title,$desc]): ?>
    <div class="text-center anim-fade-up">
      <div class="w-16 h-16 rounded-2xl bg-primary-fixed flex items-center justify-center mx-auto mb-4">
        <span class="material-symbols-outlined text-primary text-3xl icon-fill"><?= $icon ?></span>
      </div>
      <h3 class="font-bold text-on-surface mb-2"><?= $title ?></h3>
      <p class="text-sm text-on-surface-variant leading-relaxed"><?= $desc ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<?php if (!$user): ?>
<section class="max-w-[1280px] mx-auto px-5 md:px-16 py-20 text-center anim-fade-up">
  <div class="hero-bg rounded-3xl p-12 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 text-6xl flex flex-wrap gap-8 overflow-hidden">✈ 🏨 🌴 ✈ 🏝 🏨 🌴</div>
    <div class="relative z-10">
      <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Siap Untuk Petualangan?</h2>
      <p class="text-white/75 mb-8 max-w-lg mx-auto">Bergabung dengan ribuan traveler yang telah mempercayai StayGo untuk perjalanan impian mereka.</p>
      <div class="flex justify-center gap-4 flex-wrap">
        <a href="daftar_akun.php" class="px-8 py-4 bg-white text-primary font-bold rounded-full hover:bg-white/90 transition-all hover:scale-105 shadow-xl">Sign Up Gratis</a>
        <a href="detail_hotel.php" class="px-8 py-4 bg-white/15 border border-white/30 text-white font-bold rounded-full hover:bg-white/25 transition-all">Jelajahi Hotel</a>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?= footer() ?>

<script>
function switchSearchTab(type) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  
  const form = document.getElementById('main-search-form');
  const btnHotel = document.getElementById('btn-tab-hotel');
  const btnFlight = document.getElementById('btn-tab-flight');
  
  const labelDest = document.getElementById('label-dest');
  const inputDest = document.getElementById('input-dest');
  const iconDest = document.getElementById('icon-dest');
  
  const labelDate1 = document.getElementById('label-date1');
  const cellCheckout = document.getElementById('cell-checkout');
  
  const labelCount = document.getElementById('label-count');
  const iconCount = document.getElementById('icon-count');

  if (type === 'flight') {
    btnFlight.classList.add('active');
    form.action = 'detail_flight.php'; 
    iconDest.textContent = 'flight_takeoff';
    labelDest.textContent = 'Destination / Airport';
    inputDest.placeholder = 'Where do you want to fly?';
    
    labelDate1.textContent = 'Departure Date';
    cellCheckout.style.display = 'none'; 
    
    labelCount.textContent = 'Passengers';
    iconCount.textContent = 'person';
    
    form.style.gridTemplateColumns = '1.3fr 1.1fr 0.9fr 82px';
  } else {
    btnHotel.classList.add('active');
    form.action = 'detail_hotel.php';
    iconDest.textContent = 'location_on';
    labelDest.textContent = 'Location';
    inputDest.placeholder = 'Where to?';
    
    labelDate1.textContent = 'Check-in';
    cellCheckout.style.display = 'flex';
    
    labelCount.textContent = 'Guests';
    iconCount.textContent = 'group';
    
    form.style.gridTemplateColumns = '1.1fr 1fr 1fr .85fr 82px';
  }
}

async function toggleFavBtn(id, btn) {
  const fd = new FormData(); fd.append('property_id', id);
  const res = await fetch('toggle_fav.php',{method:'POST',body:fd});
  const d = await res.json();
  const icon = btn.querySelector('.material-symbols-outlined');
  btn.classList.toggle('text-error', d.active);
  btn.classList.toggle('text-outline', !d.active);
  icon.classList.toggle('icon-fill', d.active);
}

const obs = new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting)e.target.style.opacity='1'}),{threshold:.1});
document.querySelectorAll('.anim-fade-up').forEach(el=>{el.style.opacity='0';obs.observe(el);});
</script>
</body>
</html>