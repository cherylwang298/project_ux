<?php require_once 'config.php'; checkLogin(); ?>
<?php headHtml('Home', '
.home-header{background:var(--primary);color:#fff;padding:20px 16px 28px;}
.home-header .greet{font-size:14px;opacity:.8;margin-bottom:2px;}
.home-header h2{font-size:22px;font-weight:800;}
.home-header .loc{font-size:13px;opacity:.75;margin-top:2px;}
.search-box{background:#fff;border-radius:16px;display:flex;align-items:center;gap:10px;padding:12px 16px;margin:0 16px;margin-top:-20px;box-shadow:0 4px 20px rgba(0,0,40,.15);cursor:pointer;border:1px solid #E5E7EB;}
.search-box span{color:var(--gray);}
.search-box input{flex:1;border:none;outline:none;font-size:15px;color:#374151;}
.tabs-row{display:flex;gap:8px;padding:18px 16px 0;overflow-x:auto;scrollbar-width:none;}
.tab-pill{flex-shrink:0;padding:9px 20px;border-radius:40px;font-size:14px;font-weight:600;cursor:pointer;border:1.5px solid var(--border);background:#fff;color:#374151;transition:.15s;}
.tab-pill.active{background:var(--primary);color:#fff;border-color:var(--primary);}
.banner{margin:16px 16px 0;border-radius:20px;overflow:hidden;position:relative;height:160px;}
.banner img{width:100%;height:100%;object-fit:cover;}
.banner-overlay{position:absolute;inset:0;background:rgba(0,32,130,.55);}
.banner-text{position:absolute;bottom:16px;left:16px;color:#fff;}
.banner-text h3{font-size:18px;font-weight:800;}
.banner-text p{font-size:12px;opacity:.85;}
.banner .explore-btn{position:absolute;bottom:16px;right:16px;background:var(--accent);color:#fff;border:none;padding:8px 18px;border-radius:40px;font-weight:700;font-size:13px;cursor:pointer;}
.hotel-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.hotel-mini{background:#fff;border-radius:16px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow);cursor:pointer;}
.hotel-mini img{height:110px;object-fit:cover;width:100%;}
.hotel-mini-info{padding:10px;}
.hotel-mini-info h4{font-size:13px;font-weight:700;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.hotel-mini-info .city{font-size:11px;color:var(--gray);}
.hotel-mini-info .price{font-size:13px;font-weight:700;color:var(--primary);margin-top:4px;}
.hotel-mini .heart-btn{float:right;background:none;border:none;font-size:16px;cursor:pointer;}
.route-chip{display:flex;align-items:center;gap:8px;background:#fff;border-radius:14px;padding:12px 14px;border:1px solid var(--border);cursor:pointer;}
.route-chip .route-icon{width:36px;height:36px;background:#EEF2FF;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.route-chip .route-info h4{font-size:13px;font-weight:700;}
.route-chip .route-info p{font-size:11px;color:var(--gray);}
.route-chip .route-price{margin-left:auto;font-weight:700;font-size:14px;color:var(--accent);}
.spot-scroll{display:flex;gap:12px;overflow-x:auto;scrollbar-width:none;padding-bottom:4px;}
.spot-card{flex-shrink:0;width:150px;background:#fff;border-radius:16px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow);}
.spot-card img{height:100px;object-fit:cover;}
.spot-card-info{padding:8px 10px;}
.spot-card-info h4{font-size:12px;font-weight:700;}
.spot-card-info .city{font-size:10px;color:var(--gray);}
.spot-card-info .price{font-size:12px;font-weight:700;color:var(--primary);}
.deal-banner{background:var(--primary);color:#fff;border-radius:20px;padding:16px;display:flex;justify-content:space-between;align-items:center;}
.deal-banner h4{font-size:15px;font-weight:700;}
.deal-banner p{font-size:12px;opacity:.8;margin-top:2px;}
.deal-banner .deal-amount{font-size:28px;font-weight:800;color:#FCD34D;}
') ?>
</head>
<body>
<?php
$wishlistIds = array_column($_SESSION['wishlist'], 'id');
?>
<div class="home-header">
  <p class="greet">Selamat datang,</p>
  <h2><?= htmlspecialchars($_SESSION['username']) ?> ✈️</h2>
  <p class="loc">📍 Indonesia – <?= date('d M Y') ?></p>
</div>

<!-- Search Bar -->
<div class="search-box" onclick="window.location='flight_search.php'">
  <span>🔍</span>
  <input type="text" placeholder="Mau pergi ke mana?" readonly>
  <span>⚙️</span>
</div>

<!-- Tabs -->
<div class="tabs-row">
  <div class="tab-pill active" onclick="showTab('hotel')">🏨 Hotel</div>
  <div class="tab-pill" onclick="window.location='flight_search.php'">✈️ Penerbangan</div>
  <div class="tab-pill" onclick="window.location='tourism.php'">🗺️ Wisata</div>
</div>

<div class="container" style="padding-top:16px;">

  <!-- Banner -->
  <div class="banner">
    <img src="https://images.unsplash.com/photo-1488085061387-422e29b40080?w=800&q=80" alt="Promo">
    <div class="banner-overlay"></div>
    <div class="banner-text">
      <h3>No idea where to go?</h3>
      <p>Temukan destinasi terbaik bersama kami</p>
    </div>
    <button class="explore-btn" onclick="window.location='hotel_search.php'">Explore Now →</button>
  </div>

  <!-- Popular Routes -->
  <div class="section-title" style="margin-top:20px;">
    <h3>✈️ Rute Populer</h3>
    <a href="flight_search.php">Lihat Semua</a>
  </div>
  <?php foreach (array_slice($popular_routes, 0, 4) as $r): ?>
  <div class="route-chip" onclick="window.location='flight_results.php?origin=<?= urlencode($r['from']) ?>&destination=<?= urlencode($r['to']) ?>&date=<?= date('Y-m-d', strtotime('+3 days')) ?>&class=Economy&passengers=1'" style="margin-bottom:10px;">
    <div class="route-icon">✈️</div>
    <div class="route-info">
      <h4><?= $r['from'] ?> → <?= $r['to'] ?></h4>
      <p>Mulai dari</p>
    </div>
    <div class="route-price">$<?= $r['price'] ?></div>
  </div>
  <?php endforeach; ?>

  <!-- Hotels -->
  <div class="section-title">
    <h3>🏨 Explore Hotels</h3>
    <a href="hotel_search.php">Lihat Semua</a>
  </div>
  <div class="hotel-grid">
    <?php foreach (array_slice($hotels, 0, 4) as $h): ?>
    <?php $inWish = in_array($h['id'], $wishlistIds); ?>
    <div class="hotel-mini" onclick="window.location='hotel_detail.php?id=<?= $h['id'] ?>'">
      <div style="position:relative;">
        <img src="<?= $h['img'] ?>" alt="<?= $h['name'] ?>">
        <form method="POST" action="wishlist.php" style="position:absolute;top:8px;right:8px;margin:0;">
          <input type="hidden" name="hotel_id" value="<?= $h['id'] ?>">
          <button type="submit" name="toggle_wishlist" class="heart-btn" style="background:rgba(255,255,255,.85);width:30px;height:30px;border-radius:50%;border:none;cursor:pointer;font-size:15px;">
            <?= $inWish ? '❤️' : '🤍' ?>
          </button>
        </form>
      </div>
      <div class="hotel-mini-info">
        <h4><?= $h['name'] ?></h4>
        <p class="city"><?= $h['city'] ?></p>
        <div style="font-size:11px;color:#F59E0B;"><?= str_repeat('★',$h['stars']) ?></div>
        <p class="price">$<?= $h['price'] ?><span style="font-size:10px;font-weight:400;">/mlm</span></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Deal Banner -->
  <div class="deal-banner" style="margin:20px 0 12px;">
    <div>
      <h4>Cashback Penerbangan</h4>
      <p>Berlaku s/d 30 Jun 2026</p>
      <p style="margin-top:8px;font-size:11px;">Kode: <strong>HEMAT20</strong></p>
    </div>
    <div style="text-align:right;">
      <div class="deal-amount">20%</div>
      <button class="btn-sm" style="background:var(--accent);color:#fff;margin-top:6px;" onclick="window.location='flight_search.php'">Pakai Sekarang</button>
    </div>
  </div>

  <!-- Wisata -->
  <div class="section-title">
    <h3>🗺️ Explore Spots</h3>
    <a href="tourism.php">Lihat Semua</a>
  </div>
  <div class="spot-scroll">
    <?php foreach (array_slice($tourism, 0, 6) as $t): ?>
    <div class="spot-card" onclick="window.location='tourism.php'">
      <img src="<?= $t['img'] ?>" alt="<?= $t['name'] ?>">
      <div class="spot-card-info">
        <h4><?= $t['name'] ?></h4>
        <p class="city">📍 <?= $t['city'] ?></p>
        <p class="price">$<?= $t['price'] ?>/orang</p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

</div>

<?php renderNav('home'); ?>
<div id="toast"></div>
<script>
function showTab(t){ /* tabs already link directly */ }
function showToast(msg){const el=document.getElementById('toast');el.textContent=msg;el.style.opacity='1';setTimeout(()=>el.style.opacity='0',2500);}
</script>
</body>
</html>