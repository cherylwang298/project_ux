<?php
require 'config.php';

$id = (int)($_GET['id'] ?? 0);

if ($id) {
    // ── DETAIL VIEW ─────────────────────────────────────────────
    $p = getProperty($id);
    if (!$p || $p['type'] !== 'villa') { header('Location: detail_villa.php'); exit; }
    
    // Cek status database
    $favd = auth() ? isFavourited($id) : false;

    // Tambahkan CSS Animasi Wiggle di sini
    echo htmlHead(h($p['name']), <<<CSS
@keyframes heart-wiggle {
  0%, 100% { transform: scale(1) rotate(0deg); }
  25% { transform: scale(1.4) rotate(-15deg); }
  50% { transform: scale(1.4) rotate(15deg); }
  75% { transform: scale(1.4) rotate(-15deg); }
}
.anim-wiggle { animation: heart-wiggle 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
.hero-parallax{background-image:url('{$p['image_url']}');background-size:cover;background-position:center;background-attachment:fixed}
.glass-card{background:rgba(255,255,255,.78);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.45);box-shadow:0 8px 32px rgba(0,103,127,.07)}
CSS
    );
    ?>
    <body class="bg-background text-on-background min-h-screen">
    <?= navbar('detail_villa.php') ?>
    <?= backButton('detail_villa.php') ?>

    <div class="hero-parallax h-[55vh] relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/10"></div>
      <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 max-w-[1280px] mx-auto">
        <div class="flex items-end justify-between flex-wrap gap-4">
          <div>
            <div class="flex gap-2 mb-3">
              <span class="px-3 py-1 bg-secondary/90 backdrop-blur-sm text-white rounded-full text-xs font-bold">Villa</span>
              <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs font-semibold"><?= $p['bedrooms'] ?> Bedrooms</span>
              <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs font-semibold">Max <?= $p['max_guests'] ?> guests</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight"><?= h($p['name']) ?></h1>
            <p class="text-white/75 flex items-center gap-1.5 mt-2">
              <span class="material-symbols-outlined text-[18px]">location_on</span><?= h($p['location']) ?>
            </p>
          </div>
          <div class="flex items-center gap-3">
            <?php if (auth()): ?>
            <!-- Ini Tombol yang kamu minta untuk Detail View -->
            <button id="favBtn" onclick="animateAndToggleFav(this, <?= $p['id'] ?>)" 
              class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center hover:scale-105 transition-all <?= $favd ? 'text-red-500' : 'text-white' ?>">
              <span class="material-symbols-outlined text-[24px] <?= $favd ? 'icon-fill' : '' ?>">favorite</span>
            </button>
            <?php endif; ?>
            
            <div class="glass rounded-2xl px-4 py-3 text-center">
              <div class="flex items-center gap-1 justify-center">
                <span class="material-symbols-outlined icon-fill text-amber-400 text-[20px]">star</span>
                <span class="text-2xl font-extrabold text-on-surface"><?= $p['rating'] ?></span>
              </div>
              <p class="text-xs text-outline"><?= number_format($p['review_count']) ?> ulasan</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <main class="max-w-[1280px] mx-auto px-5 md:px-16 py-12">
      <section class="glass-card rounded-3xl p-4 mb-8 anim-fade-up">
        <div class="flex items-center justify-between mb-4 px-2"><h2 class="text-xl font-extrabold text-on-surface">Villa Photos & Facilities</h2><span class="text-xs font-bold text-outline">Preview</span></div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
          <?php $photos=[['src'=>$p['image_url'],'label'=>'Main View'],['src'=>'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?w=800&q=80','label'=>'Private Pool'],['src'=>'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=800&q=80','label'=>'Kitchen'],['src'=>'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=800&q=80','label'=>'Living Area'],['src'=>'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80','label'=>'Bedroom']]; foreach($photos as $ph): ?>
          <div class="relative h-28 rounded-2xl overflow-hidden group"><img src="<?= h($ph['src']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="<?= h($ph['label']) ?>"><div class="absolute inset-0 bg-gradient-to-t from-black/55 to-transparent"></div><p class="absolute bottom-2 left-3 right-3 text-white text-xs font-bold"><?= h($ph['label']) ?></p></div>
          <?php endforeach; ?>
        </div>
      </section>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
          <section class="glass-card rounded-2xl p-6 anim-fade-up">
            <h2 class="text-xl font-bold text-on-surface mb-4">About Villa</h2>
            <p class="text-on-surface-variant leading-relaxed"><?= h($p['description']) ?></p>
            <div class="grid grid-cols-3 gap-4 mt-6">
              <div class="text-center p-4 bg-surface-container-low rounded-xl">
                <span class="material-symbols-outlined text-secondary text-2xl">group</span>
                <p class="font-bold text-on-surface mt-1"><?= $p['max_guests'] ?></p>
                <p class="text-xs text-outline">Max Guests</p>
              </div>
              <div class="text-center p-4 bg-surface-container-low rounded-xl">
                <span class="material-symbols-outlined text-secondary text-2xl">bed</span>
                <p class="font-bold text-on-surface mt-1"><?= $p['bedrooms'] ?></p>
                <p class="text-xs text-outline">Bedrooms</p>
              </div>
              <div class="text-center p-4 bg-surface-container-low rounded-xl">
                <span class="material-symbols-outlined text-secondary text-2xl">pool</span>
                <p class="font-bold text-on-surface mt-1">Private</p>
                <p class="text-xs text-outline">Pool</p>
              </div>
            </div>
          </section>
          <section class="glass-card rounded-2xl p-6 anim-fade-up delay-100">
            <h2 class="text-xl font-bold text-on-surface mb-4">Amenities</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
              <?php foreach($p['amenities'] as $am): ?>
              <div class="flex items-center gap-2 p-3 bg-surface-container-low rounded-xl">
                <span class="material-symbols-outlined text-secondary text-[18px] icon-fill">check_circle</span>
                <span class="text-sm font-medium text-on-surface"><?= h($am) ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </section>
          <section class="glass-card rounded-2xl p-6 anim-fade-up delay-200">
            <h2 class="text-xl font-bold text-on-surface mb-5">Reviews Guests</h2>
            <div class="space-y-4">
              <?php foreach($p['reviews'] as $r): ?>
              <div class="p-4 bg-surface-container-low rounded-xl">
                <div class="flex items-center justify-between mb-2">
                  <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-secondary to-primary flex items-center justify-center text-white font-bold text-sm"><?= strtoupper(substr($r['name'],0,1)) ?></div>
                    <div><p class="font-bold text-sm text-on-surface"><?= h($r['name']) ?></p><p class="text-xs text-outline"><?= $r['date'] ?></p></div>
                  </div>
                  <div><?= str_repeat('⭐',min(5,$r['rating'])) ?></div>
                </div>
                <p class="text-sm text-on-surface-variant"><?= h($r['text']) ?></p>
              </div>
              <?php endforeach; ?>
            </div>
          </section>
        </div>

        <!-- Booking Card -->
        <div class="lg:col-span-1">
          <div class="sticky top-24">
            <div class="glass-card rounded-2xl p-6 anim-fade-up delay-300">
              <div class="mb-4">
                <span class="text-2xl font-extrabold text-secondary"><?= formatRupiah($p['price_per_night']) ?></span>
                <span class="text-outline text-sm"> / night</span>
              </div>
              <div class="space-y-3 mb-5">
                <div>
                  <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Check-in</label>
                  <input type="date" id="checkin" class="w-full h-11 px-3 rounded-xl bg-surface-container-low border border-outline-variant text-sm outline-none focus:border-secondary transition-colors"
                    min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d',strtotime('+3 days')) ?>">
                </div>
                <div>
                  <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Check-out</label>
                  <input type="date" id="checkout" class="w-full h-11 px-3 rounded-xl bg-surface-container-low border border-outline-variant text-sm outline-none focus:border-secondary transition-colors"
                    min="<?= date('Y-m-d',strtotime('+4 days')) ?>" value="<?= date('Y-m-d',strtotime('+7 days')) ?>">
                </div>
                <div>
                  <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Guests</label>
                  <div class="h-11 px-3 rounded-xl bg-surface-container-low border border-outline-variant flex items-center justify-between">
                    <button type="button" onclick="changeGuests(-1)" class="w-8 h-8 rounded-full bg-white/80 border border-outline-variant/40 font-bold text-lg text-on-surface hover:bg-secondary hover:text-white transition-all">−</button>
                    <div class="text-center">
                      <input id="guests" value="1" readonly class="w-10 bg-transparent border-0 shadow-none outline-none text-center text-sm font-extrabold text-on-surface p-0">
                    </div>
                    <button type="button" onclick="changeGuests(1)" class="w-8 h-8 rounded-full bg-white/80 border border-outline-variant/40 font-bold text-lg text-on-surface hover:bg-secondary hover:text-white transition-all">+</button>
                  </div>
                  <p class="text-xs text-outline mt-1">Max <?= $p['max_guests'] ?> guests</p>
                </div>
              </div>
              <div class="space-y-2 py-4 border-y border-outline-variant/30 mb-4 text-sm">
                <div class="flex justify-between text-on-surface-variant">
                  <span id="nightsLabel"><?= formatRupiah($p['price_per_night']) ?> × 4 nights</span>
                  <span id="baseAmt"><?= formatRupiah($p['price_per_night']*4) ?></span>
                </div>
                <div class="flex justify-between text-on-surface-variant"><span>Tax (11%)</span><span id="taxAmt"><?= formatRupiah($p['price_per_night']*4*0.11) ?></span></div>
                <div class="flex justify-between font-bold text-on-surface pt-2 border-t border-outline-variant/30">
                  <span>Total</span><span id="totalAmt" class="text-secondary"><?= formatRupiah($p['price_per_night']*4*1.11) ?></span>
                </div>
              </div>
              <?php if (auth()): ?>
              <button onclick="gotoCheckout()" class="w-full h-12 bg-gradient-to-r from-secondary to-primary text-white rounded-full font-bold text-sm flex items-center justify-center gap-2 shadow-lg hover:scale-[1.02] transition-all">
                <span class="material-symbols-outlined text-[18px]">villa</span>
                Book Villa
              </button>
              <?php else: ?>
              <a href="login.php" class="w-full h-12 bg-secondary text-white rounded-full font-bold text-sm flex items-center justify-center gap-2 shadow-md hover:opacity-90 transition-all">Login to Book</a>
              <?php endif; ?>
              <p class="text-center text-xs text-outline mt-3">Free cancellation within 24 hours.</p>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?= footer() ?>
    <script>
    const PPN = <?= $p['price_per_night'] ?>;
    const propId = <?= $p['id'] ?>;
    
    function calcNights(){
        const i=new Date(document.getElementById('checkin').value);
        const o=new Date(document.getElementById('checkout').value);
        return Math.max(1,Math.round((o-i)/86400000));
    }
    
    function updatePrice(){
      const n=calcNights();const base=PPN*n;const tax=base*0.11;const total=base+tax;
      document.getElementById('nightsLabel').textContent='<?= formatRupiah($p['price_per_night']) ?> × '+n+' nights';
      document.getElementById('baseAmt').textContent='Rp '+base.toLocaleString('id-ID');
      document.getElementById('taxAmt').textContent='Rp '+Math.round(tax).toLocaleString('id-ID');
      document.getElementById('totalAmt').textContent='Rp '+Math.round(total).toLocaleString('id-ID');
    }
    
    function changeGuests(delta){
      const input=document.getElementById('guests');
      let val=parseInt(input.value||'1',10)+delta;
      input.value=Math.max(1,Math.min(<?= $p['max_guests'] ?>,val));
    }
    
    function gotoCheckout(){
      const ci=document.getElementById('checkin').value;const co=document.getElementById('checkout').value;
      const g=document.getElementById('guests').value;const n=calcNights();const total=Math.round(PPN*n*1.11);
      location.href=`checkout.php?type=villa&id=${propId}&checkin=${ci}&checkout=${co}&guests=${g}&total=${total}`;
    }

    // --- LOGIKA KALENDER PINTAR ---
    document.getElementById('checkin').addEventListener('change', function() {
        let ciVal = this.value;
        if (!ciVal) return;
        
        // Buat objek date dari Checkin, lalu tambah 1 hari
        let d = new Date(ciVal);
        d.setDate(d.getDate() + 1);
        
        // Format ulang ke YYYY-MM-DD
        let nextDay = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
        
        let coInput = document.getElementById('checkout');
        coInput.min = nextDay; // Mencegah user klik tanggal yang salah di UI kalender
        
        // Auto-koreksi jika checkout yang ada saat ini <= checkin yang baru
        if (coInput.value <= ciVal) {
            coInput.value = nextDay;
        }
        
        updatePrice();
    });

    document.getElementById('checkout').addEventListener('change', updatePrice);
    
    <?php if (auth()): ?>
    // Fungsi gabungan: Animasi + Panggil DB
    async function animateAndToggleFav(btn, id) {
      const icon = btn.querySelector('.material-symbols-outlined');
      
      // Trigger animasi wiggle
      icon.classList.remove('anim-wiggle');
      void icon.offsetWidth; 
      icon.classList.add('anim-wiggle');
      
      // Update DB
      const fd = new FormData(); 
      fd.append('property_id', id);
      const r = await fetch('toggle_fav.php', { method: 'POST', body: fd });
      const d = await r.json();
      
      // Ubah warna langsung
      if (d.active) {
          btn.classList.add('text-red-500');
          btn.classList.remove('text-white', 'text-outline');
          icon.classList.add('icon-fill');
      } else {
          btn.classList.remove('text-red-500');
          btn.classList.add(btn.classList.contains('bg-white/20') ? 'text-white' : 'text-outline');
          icon.classList.remove('icon-fill');
      }
    }
    <?php endif; ?>
    </script>
    </body></html>
    <?php

} else {
    // ── LISTING VIEW ─────────────────────────────────────────────
    $villas = getProperties('villa');
    
    // Tambahkan CSS Animasi Wiggle di List juga
    echo htmlHead("Villas Bali", <<<CSS
@keyframes heart-wiggle {
  0%, 100% { transform: scale(1) rotate(0deg); }
  25% { transform: scale(1.4) rotate(-15deg); }
  50% { transform: scale(1.4) rotate(15deg); }
  75% { transform: scale(1.4) rotate(-15deg); }
}
.anim-wiggle { animation: heart-wiggle 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
.prop-card{background:rgba(255,255,255,.78);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.45);box-shadow:0 8px 28px rgba(0,103,127,.06);transition:all .35s cubic-bezier(.22,1,.36,1)}
.prop-card:hover{transform:translateY(-5px);box-shadow:0 20px 48px rgba(0,103,127,.12);border-color:rgba(0,103,127,.15)}
.filter-btn.active{background:#00677f;color:white;box-shadow:0 4px 12px rgba(0,103,127,.3)}
CSS
    );
    ?>
    <body class="bg-background text-on-background min-h-screen">
    <?= navbar('detail_villa.php') ?>
    <div class="bg-gradient-to-r from-[#00677f] to-[#004ce2] pt-32 pb-16 px-5 md:px-16">
      <div class="max-w-[1280px] mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-2">Private Villas Bali</h1>
        <p class="text-white/75">Temukan <?= count($villas) ?> villa privat eksklusif dengan kolam renang sendiri.</p>
      </div>
    </div>
    <main class="max-w-[1280px] mx-auto px-5 md:px-16 py-12">
      <div class="glass-card rounded-2xl p-4 mb-6 anim-fade-up">
        <label class="text-xs font-bold text-outline uppercase tracking-wider">Search accommodation</label>
        <div class="relative mt-2"><span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span><input id="accomSearch" oninput="filterName()" class="w-full h-12 pl-12 pr-4 rounded-xl bg-surface-container-low border border-outline-variant outline-none focus:border-secondary" placeholder="Search villa name, e.g. Ubud Rainforest Villa"></div>
      </div>
      <div class="flex flex-wrap gap-2 mb-8 anim-fade-up">
        <button onclick="filterBed('all',this)" class="filter-btn active px-4 py-2 rounded-full text-xs font-bold border border-outline-variant/40">All</button>
        <button onclick="filterBed(1,this)" class="filter-btn px-4 py-2 rounded-full text-xs font-bold border border-outline-variant/40 text-on-surface-variant">1 Bedrooms</button>
        <button onclick="filterBed(2,this)" class="filter-btn px-4 py-2 rounded-full text-xs font-bold border border-outline-variant/40 text-on-surface-variant">2+ Bedrooms</button>
        <button onclick="filterBed(4,this)" class="filter-btn px-4 py-2 rounded-full text-xs font-bold border border-outline-variant/40 text-on-surface-variant">4+ Bedrooms</button>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="villaGrid">
        <?php foreach ($villas as $i => $p):
          $favd = auth() ? isFavourited($p['id']) : false;
        ?>
        <div class="prop-card card-villa rounded-2xl overflow-hidden anim-fade-up delay-<?= min(500,($i+1)*80) ?>"
          data-name="<?= strtolower(h($p['name'].' '.$p['location'])) ?>" data-beds="<?= $p['bedrooms'] ?>" data-price="<?= $p['price_per_night'] ?>">
          <div class="relative h-52 overflow-hidden">
            <img src="<?= h($p['image_url']) ?>" alt="<?= h($p['name']) ?>" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
            <div class="absolute top-3 left-3 flex gap-1.5">
              <span class="px-2.5 py-1 bg-secondary/90 text-white rounded-full text-xs font-bold">Villa</span>
              <span class="px-2.5 py-1 bg-white/25 text-white rounded-full text-xs font-semibold"><?= $p['bedrooms'] ?>BR</span>
            </div>
            <?php if (auth()): ?>
            <!-- Tombol Listing yang sudah diupdate ke versi merah bergoyang -->
            <button onclick="event.stopPropagation(); event.preventDefault(); animateAndToggleFav(this, <?= $p['id'] ?>)"
              class="absolute top-3 right-3 w-10 h-10 rounded-full bg-black/40 hover:bg-black/70 backdrop-blur-md flex items-center justify-center hover:scale-110 transition-all shadow-md <?= $favd ? 'text-red-500' : 'text-white' ?>">
              <span class="material-symbols-outlined text-[20px] <?= $favd ? 'icon-fill' : '' ?>">favorite</span>
            </button>
            <?php endif; ?>
            <div class="absolute bottom-3 right-3 flex items-center gap-1 bg-black/40 px-2.5 py-1 rounded-full">
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
              <span class="px-2 py-0.5 bg-surface-container rounded-full text-xs text-on-surface-variant"><?= h($am) ?></span>
              <?php endforeach; ?>
            </div>
            <div class="flex items-end justify-between pt-3 border-t border-outline-variant/30">
              <div>
                <p class="text-xs text-outline">Mulai dari</p>
                <div class="price-row"><span class="price"><?= formatRupiah($p['price_per_night']) ?></span><span class="unit">/ night</span></div>
              </div>
              <a href="detail_villa.php?id=<?= $p['id'] ?>" class="view-btn px-5 py-2.5 text-white rounded-full text-xs font-bold hover:opacity-90 hover:scale-105 transition-all shadow-md">Detail</a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </main>
    <?= footer() ?>
    <script>
    <?php if (auth()): ?>
    // Fungsi gabungan: Animasi + Panggil DB untuk halaman depan
    async function animateAndToggleFav(btn, id) {
      const icon = btn.querySelector('.material-symbols-outlined');
      icon.classList.remove('anim-wiggle');
      void icon.offsetWidth; 
      icon.classList.add('anim-wiggle');
      
      const fd = new FormData(); 
      fd.append('property_id', id);
      const r = await fetch('toggle_fav.php', { method: 'POST', body: fd });
      const d = await r.json();
      
      if (d.active) {
          btn.classList.add('text-red-500');
          btn.classList.remove('text-white', 'text-outline');
          icon.classList.add('icon-fill');
      } else {
          btn.classList.remove('text-red-500');
          btn.classList.add('text-white');
          icon.classList.remove('icon-fill');
      }
    }
    <?php endif; ?>

    function filterBed(min,btn){
      document.querySelectorAll('.filter-btn').forEach(b=>{b.classList.remove('active');b.classList.add('text-on-surface-variant');});
      btn.classList.add('active');btn.classList.remove('text-on-surface-variant');
      document.querySelectorAll('#villaGrid>div').forEach(c=>{c.style.display=(min==='all'||parseInt(c.dataset.beds)>=min)?'':'none';});
    }
    </script>
    </body></html>
    <?php
}