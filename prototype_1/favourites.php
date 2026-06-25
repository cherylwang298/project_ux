<?php
require 'config.php';
requireAuth();
$user   = auth();
$favs   = getUserFavourites();
$filter = $_GET['type'] ?? 'all';
$shown  = ($filter==='all') ? $favs : array_filter($favs, fn($p)=>$p['type']===$filter);

echo htmlHead("Favourites", <<<CSS
.prop-card{background:rgba(255,255,255,.78);backdrop-filter:blur(24px);border:1.5px solid rgba(255,255,255,.5);box-shadow:0 8px 28px rgba(0,76,226,.06);transition:all .35s cubic-bezier(.22,1,.36,1)}
.prop-card:hover{transform:translateY(-5px);box-shadow:0 24px 56px rgba(0,76,226,.12);border-color:rgba(0,76,226,.15)}
.tab-f{transition:all .25s ease}
.tab-f.active{background:#004ce2;color:white;box-shadow:0 4px 12px rgba(0,76,226,.25)}
CSS
);
?>
<body class="bg-background text-on-background min-h-screen">
<?= navbar('favourites.php') ?><?= renderFlash() ?>

<div class="bg-gradient-to-br from-[#004ce2] to-[#00677f] pt-28 pb-12 px-5 md:px-16">
  <div class="max-w-[1280px] mx-auto">
    <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">My Favourites</h1>
    <p class="text-white/75"><?= count($favs) ?> saved properties</p>
  </div>
</div>

<main class="max-w-[1280px] mx-auto px-5 md:px-16 py-12">
  <!-- Filter Tabs -->
  <div class="flex gap-2 mb-8 anim-fade-up">
    <?php foreach(['all'=>'All','hotel'=>'Hotel','villa'=>'Villa'] as $val=>$lbl): ?>
    <a href="?type=<?= $val ?>"
      class="tab-f px-5 py-2.5 rounded-full text-sm font-bold border border-outline-variant/40 <?= $filter===$val?'active':'text-on-surface-variant' ?>">
      <?= $lbl ?>
      <span class="ml-1 opacity-60 font-normal">
        (<?= $val==='all'?count($favs):count(array_filter($favs,fn($p)=>$p['type']===$val)) ?>)
      </span>
    </a>
    <?php endforeach; ?>
  </div>

  <?php if (empty($shown)): ?>
  <!-- Empty state -->
  <div class="text-center py-24 anim-fade-up">
    <div class="w-24 h-24 rounded-3xl bg-surface-container flex items-center justify-center mx-auto mb-5 anim-float">
      <span class="material-symbols-outlined text-outline text-5xl">favorite_border</span>
    </div>
    <h2 class="text-2xl font-bold text-on-surface mb-2">No Favourites Yet<?= $filter!=='all'?' ('.$filter.')':'' ?></h2>
    <p class="text-on-surface-variant mb-8 max-w-sm mx-auto">Tekan ikon ❤️ pada properti yang kamu suka untuk menyimpannya di sini.</p>
    <div class="flex justify-center gap-4 flex-wrap">
      <a href="detail_hotel.php" class="px-6 py-3 bg-primary text-white rounded-full font-bold text-sm hover:opacity-90 transition-all shadow-md">Jelajahi Hotel</a>
      <a href="detail_villa.php" class="px-6 py-3 border border-primary text-primary rounded-full font-bold text-sm hover:bg-primary hover:text-white transition-all">Jelajahi Villa</a>
    </div>
  </div>
  <?php else: ?>
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    <?php foreach (array_values($shown) as $i => $p):
      $detailUrl = "detail_{$p['type']}.php?id={$p['id']}";
    ?>
    <div class="prop-card rounded-2xl overflow-hidden anim-fade-up delay-<?= min(400,($i+1)*80) ?>" id="card_<?= $p['id'] ?>">
      <div class="relative h-48 overflow-hidden">
        <img src="<?= h($p['image_url']) ?>" alt="<?= h($p['name']) ?>" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
        <div class="absolute top-3 left-3">
          <span class="px-2.5 py-1 bg-<?= $p['type']==='villa'?'secondary':'primary' ?>/90 text-white rounded-full text-xs font-bold"><?= ucfirst($p['type']) ?></span>
        </div>
        <!-- Remove favourite button -->
        <button onclick="removeFav(<?= $p['id'] ?>, this)"
          class="absolute top-3 right-3 w-10 h-10 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-error hover:scale-110 transition-all shadow-md">
          <span class="material-symbols-outlined text-[20px] icon-fill">favorite</span>
        </button>
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
            <p class="text-xl font-extrabold text-<?= $p['type']==='villa'?'secondary':'primary' ?>"><?= formatRupiah($p['price_per_night']) ?></p>
            <p class="text-xs text-outline">/ nights</p>
          </div>
          <a href="<?= $detailUrl ?>" class="px-5 py-2.5 bg-<?= $p['type']==='villa'?'secondary':'primary' ?> text-white rounded-full text-xs font-bold hover:opacity-90 hover:scale-105 transition-all shadow-md">Lihat</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</main>

<?= footer() ?>
<script>
async function removeFav(id, btn) {
  const fd = new FormData(); fd.append('property_id', id);
  const r = await fetch('toggle_fav.php', {method:'POST',body:fd});
  const d = await r.json();
  if (!d.active) {
    const card = document.getElementById('card_'+id);
    card.style.transition='all .4s ease';
    card.style.opacity='0'; card.style.transform='scale(.9)';
    setTimeout(()=>card.remove(),400);
  }
}
</script>
</body></html>
