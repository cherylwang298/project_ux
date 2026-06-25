<?php
require 'config.php';
$promos = getPromos();
echo htmlHead("Promo & Deals", <<<CSS
.promo-card{background:rgba(255,255,255,.78);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.45);box-shadow:0 8px 32px rgba(0,76,226,.07);transition:all .35s cubic-bezier(.22,1,.36,1)}
.promo-card:hover{transform:translateY(-4px);box-shadow:0 24px 56px rgba(0,76,226,.13);border-color:rgba(0,76,226,.12)}
.timer-box{background:rgba(0,76,226,.08);border:1px solid rgba(0,76,226,.12);border-radius:10px;padding:6px 10px;text-align:center;min-width:52px}
CSS
);
?>
<body class="bg-background text-on-background min-h-screen">
<?= navbar('promo.php') ?><?= renderFlash() ?>

<!-- Hero -->
<div class="pt-28 pb-20 px-5 md:px-16 relative overflow-hidden" 
     style="background: linear-gradient(to bottom, #0545c6 0%, #07629f 55%, transparent 100%);">
  
  <div class="absolute inset-0 overflow-hidden opacity-10 flex flex-wrap gap-8 content-start pt-8 text-4xl">
    <?php for($i=0;$i<30;$i++) echo '🏷️ '; ?>
  </div>
  <div class="max-w-[1280px] mx-auto relative z-10 text-center">
    <div class="inline-flex items-center gap-2 bg-white/15 border border-white/30 rounded-full px-4 py-2 mb-4">
      <span class="material-symbols-outlined text-white text-[16px] icon-fill">local_offer</span>
      <span class="text-white/90 text-sm font-semibold"><?= count($promos) ?> Active Deals</span>
    </div>
    <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-4">
      Save More<br><span class="text-secondary-container">Today.</span>
    </h1>
    <p class="text-white/75 max-w-xl mx-auto text-lg">Exclusive promo codes for accommodations and flights. Limited offers!</p>
  </div>
</div>

<main class="max-w-[1280px] mx-auto px-5 md:px-16 py-16">
  <?php if (empty($promos)): ?>
  <div class="text-center py-20">
    <span class="material-symbols-outlined text-outline text-6xl mb-4">local_offer</span>
    <h2 class="text-xl font-bold text-on-surface mb-2">No Deals Yet</h2>
    <p class="text-on-surface-variant">Check back soon for new offers.</p>
  </div>
  <?php else: ?>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <?php
    $grads=[
      ['from-[#004ce2] to-[#00d2ff]','from-[#004ce2]/5 to-[#00d2ff]/5'],
      ['from-[#00677f] to-[#004ce2]','from-[#00677f]/5 to-[#004ce2]/5'],
      ['from-[#111c2d] to-[#004ce2]','from-[#111c2d]/5 to-[#004ce2]/5'],
      ['from-[#3267ff] to-[#00677f]','from-[#3267ff]/5 to-[#00677f]/5'],
    ];
    foreach ($promos as $i => $pr):
      $days = daysLeft($pr['valid_until']);
      [$hGrad, $bGrad] = $grads[$i % count($grads)];
      $usedPct = min(99, round($pr['used_count']/$pr['max_uses']*100));
      $remaining = $pr['max_uses']-$pr['used_count'];
    ?>
    <div class="promo-card rounded-2xl overflow-hidden anim-fade-up delay-<?= min(400,($i+1)*100) ?>">
      <!-- Gradient banner -->
      <div class="bg-gradient-to-r <?= $hGrad ?> p-5 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 rounded-full bg-white/10 -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-20 h-20 rounded-full bg-black/10 translate-y-1/2 -translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
          <div>
            <p class="text-white/60 text-xs uppercase tracking-wider mb-1"><?= $pr['discount_type']==='percent'?'Persen OFF':'Potongan Price' ?></p>
            <p class="text-5xl font-extrabold text-white leading-none">
              <?= $pr['discount_type']==='percent' ? $pr['discount_value'].'%' : 'Rp'.number_format($pr['discount_value']/1000,0).'K' ?>
            </p>
            <p class="text-white/80 font-semibold mt-1"><?= h($pr['title']) ?></p>
          </div>
          <div class="text-right">
            <p class="text-white/60 text-xs mb-1">Berakhir dalam</p>
            <!-- Countdown timer -->
            <div class="flex gap-1" id="countdown_<?= $pr['id'] ?>">
              <div class="timer-box bg-white/20 text-white"><p class="text-lg font-extrabold" id="d<?= $pr['id'] ?>">--</p><p class="text-[9px] text-white/60">HARI</p></div>
              <div class="timer-box bg-white/20 text-white"><p class="text-lg font-extrabold" id="h<?= $pr['id'] ?>">--</p><p class="text-[9px] text-white/60">JAM</p></div>
              <div class="timer-box bg-white/20 text-white"><p class="text-lg font-extrabold" id="m<?= $pr['id'] ?>">--</p><p class="text-[9px] text-white/60">MIN</p></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Body -->
      <div class="p-5 bg-gradient-to-b <?= $bGrad ?>">
        <p class="text-sm text-on-surface-variant leading-relaxed mb-4"><?= h($pr['description']) ?></p>

        <!-- Promo code -->
        <div class="flex items-center gap-3 mb-4">
          <div class="flex-1 flex items-center gap-2 bg-primary-fixed/20 border border-primary-fixed rounded-xl px-4 py-3">
            <span class="material-symbols-outlined text-primary text-[16px]">local_offer</span>
            <span class="font-mono font-bold text-primary tracking-widest text-sm"><?= h($pr['code']) ?></span>
          </div>
          <button onclick="copyCode('<?= h($pr['code']) ?>', this)"
            class="px-4 py-3 bg-primary text-white rounded-xl text-xs font-bold flex items-center gap-1.5 hover:opacity-90 active:scale-95 transition-all shadow-md shadow-primary/20">
            <span class="material-symbols-outlined text-[16px]" id="copyIcon_<?= $pr['id'] ?>">content_copy</span>
            Salin
          </button>
        </div>

        <!-- Progress bar -->
        <div class="mb-4">
          <div class="flex justify-between text-xs text-outline mb-1.5">
            <span class="font-semibold">Sisa <?= $remaining ?> dari <?= $pr['max_uses'] ?> kuota</span>
            <span><?= $usedPct ?>% terpakai</span>
          </div>
          <div class="h-2 bg-surface-container-high rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-primary to-secondary-container rounded-full transition-all duration-1000"
              style="width:0%" data-target="<?= $usedPct ?>"></div>
          </div>
        </div>

        <!-- Meta info -->
        <div class="flex flex-wrap gap-3 text-xs text-outline">
          <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[13px]">calendar_month</span>Berlaku s/d <?= date('d M Y',strtotime($pr['valid_until'])) ?></span>
          <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[13px]">shopping_cart</span>Min. <?= formatRupiah($pr['min_spend']) ?></span>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- How to use -->
  <div class="mt-16">
    <h2 class="text-2xl font-extrabold text-on-surface mb-8 text-center">Cara Pakai Promo</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <?php foreach([
        ['search','1. Pilih Produk','Cari hotel, villa, atau penerbangan yang ingin dipesan.'],
        ['content_copy','2. Salin Kode','Salin kode promo dari halaman ini.'],
        ['book_online','3. Fill Checkout','Paste kode di kolom promo saat checkout.'],
        ['savings','4. Hemat!','Diskon otomatis terpotong dari total tagihan.'],
      ] as [$icon,$title,$desc]): ?>
      <div class="text-center anim-fade-up">
        <div class="w-14 h-14 rounded-2xl bg-primary-fixed flex items-center justify-center mx-auto mb-3">
          <span class="material-symbols-outlined text-primary text-2xl icon-fill"><?= $icon ?></span>
        </div>
        <h3 class="font-bold text-on-surface mb-1 text-sm"><?= $title ?></h3>
        <p class="text-xs text-on-surface-variant leading-relaxed"><?= $desc ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
</main>

<?= footer() ?>
<script>
function copyCode(code, btn) {
  navigator.clipboard.writeText(code).then(()=>{
    const icon = btn.querySelector('.material-symbols-outlined');
    icon.textContent = 'check'; btn.style.background='#4caf50';
    setTimeout(()=>{icon.textContent='content_copy'; btn.style.background='';}, 2500);
  });
}

// Countdown timers
<?php foreach($promos as $pr): ?>
(function(){
  const end = new Date('<?= $pr['valid_until'] ?>T23:59:59').getTime();
  function tick(){
    const now=Date.now(), diff=end-now;
    if(diff<=0){clearInterval(iv);return;}
    const d=Math.floor(diff/86400000),h=Math.floor((diff%86400000)/3600000),m=Math.floor((diff%3600000)/60000);
    document.getElementById('d<?= $pr['id'] ?>').textContent=String(d).padStart(2,'0');
    document.getElementById('h<?= $pr['id'] ?>').textContent=String(h).padStart(2,'0');
    document.getElementById('m<?= $pr['id'] ?>').textContent=String(m).padStart(2,'0');
  }
  tick(); const iv=setInterval(tick,60000);
})();
<?php endforeach; ?>

// Animate progress bars
window.addEventListener('load',()=>{
  document.querySelectorAll('[data-target]').forEach(el=>{
    setTimeout(()=>{el.style.width=el.dataset.target+'%';},300);
  });
});
</script>
</body></html>
