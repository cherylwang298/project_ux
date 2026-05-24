<?php require_once 'config.php'; checkLogin();
$city     = $_GET['city'] ?? '';
$checkin  = $_GET['checkin']  ?? date('Y-m-d', strtotime('+3 days'));
$checkout = $_GET['checkout'] ?? date('Y-m-d', strtotime('+6 days'));
$rooms    = max(1, (int)($_GET['rooms'] ?? 1));
$guests   = max(1, (int)($_GET['guests'] ?? 2));
$nights   = max(1, (int)((strtotime($checkout) - strtotime($checkin)) / 86400));

$filtered = $city ? array_filter($hotels, fn($h) => $h['city'] === $city) : $hotels;
$filtered = array_values($filtered);

$wishlistIds = array_column($_SESSION['wishlist'], 'id');
?>
<?php headHtml('Hotel','
.hotel-card{background:#fff;border-radius:20px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow);margin-bottom:14px;}
.hotel-img{position:relative;height:180px;}
.hotel-img img{width:100%;height:100%;object-fit:cover;}
.heart-btn{position:absolute;top:10px;right:10px;width:34px;height:34px;background:rgba(255,255,255,.9);border-radius:50%;border:none;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;}
.hotel-body{padding:14px;}
.hotel-body h3{font-size:16px;font-weight:700;margin-bottom:2px;}
.hotel-meta{display:flex;align-items:center;gap:6px;margin:4px 0;font-size:12px;color:var(--gray);}
.rating-pill{background:#EEF2FF;color:var(--primary);padding:2px 8px;border-radius:40px;font-size:11px;font-weight:700;}
.hotel-footer{display:flex;align-items:center;justify-content:space-between;margin-top:12px;}
.price-info .price{font-size:20px;font-weight:800;color:var(--primary);}
.price-info .sub{font-size:11px;color:var(--gray);}
.btn-book{background:var(--primary);color:#fff;border:none;padding:10px 20px;border-radius:40px;font-weight:700;font-size:14px;cursor:pointer;}
.filter-row{display:flex;gap:8px;overflow-x:auto;scrollbar-width:none;padding-bottom:4px;margin-bottom:14px;}
.filter-chip{flex-shrink:0;padding:7px 14px;border-radius:40px;font-size:12px;font-weight:600;border:1.5px solid var(--border);background:#fff;cursor:pointer;}
.filter-chip.active{background:var(--primary);color:#fff;border-color:var(--primary);}
') ?>
</head>
<body>
<div class="page-header">
  <a href="hotel_search.php" class="back-btn">←</a>
  <div>
    <h2><?= $city ?: 'Semua Hotel' ?></h2>
    <p style="font-size:12px;color:var(--gray);"><?= date('d M', strtotime($checkin)) ?> – <?= date('d M Y', strtotime($checkout)) ?> · <?= $nights ?> mlm · <?= $rooms ?> kamar</p>
  </div>
</div>

<div class="container">
  <div class="filter-row">
    <div class="filter-chip active">Semua</div>
    <div class="filter-chip">⭐⭐⭐⭐⭐ 5 Bintang</div>
    <div class="filter-chip">⭐⭐⭐⭐ 4 Bintang</div>
    <div class="filter-chip">Harga Terendah</div>
    <div class="filter-chip">Rating Tertinggi</div>
  </div>

  <p style="color:var(--gray);font-size:13px;margin-bottom:12px;"><?= count($filtered) ?> hotel ditemukan</p>

  <?php if (empty($filtered)): ?>
  <div class="card" style="text-align:center;padding:40px;">
    <div style="font-size:48px;margin-bottom:12px;">🏨</div>
    <h3>Tidak ada hotel</h3>
    <p style="color:var(--gray);margin-top:6px;">Coba kota lain.</p>
    <a href="hotel_search.php" class="btn btn-primary" style="margin-top:16px;">Cari Lagi</a>
  </div>
  <?php else: ?>
  <?php foreach ($filtered as $h): ?>
  <?php $inWish = in_array($h['id'], $wishlistIds); ?>
  <div class="hotel-card">
    <div class="hotel-img">
      <img src="<?= $h['img'] ?>" alt="<?= $h['name'] ?>">
      <form method="POST" action="wishlist.php" style="margin:0;">
        <input type="hidden" name="hotel_id" value="<?= $h['id'] ?>">
        <input type="hidden" name="redirect" value="hotel_results.php?<?= htmlspecialchars(http_build_query($_GET)) ?>">
        <button type="submit" name="toggle_wishlist" class="heart-btn">
          <?= $inWish ? '❤️' : '🤍' ?>
        </button>
      </form>
    </div>
    <div class="hotel-body">
      <h3><?= $h['name'] ?></h3>
      <div class="hotel-meta">
        <span><?= str_repeat('★',$h['stars']) ?><span style="color:#D1D5DB;"><?= str_repeat('★',5-$h['stars']) ?></span></span>
        <span class="rating-pill"><?= $h['rating'] ?></span>
        <span><?= number_format($h['reviews'],0,',','.') ?> ulasan</span>
      </div>
      <div class="hotel-meta">📍 <?= $h['address'] ?></div>
      <div style="margin-top:6px;display:flex;flex-wrap:wrap;gap:4px;">
        <?php foreach (array_slice($h['amenities'],0,4) as $am): ?>
        <span class="badge badge-primary"><?= $am ?></span>
        <?php endforeach; ?>
      </div>
      <div class="hotel-footer">
        <div class="price-info">
          <div class="price">$<?= $h['price'] * $rooms ?><span style="font-size:12px;font-weight:400;">/mlm</span></div>
          <div class="sub"><?= $rooms ?> kamar · <?= $nights ?> mlm = $<?= $h['price'] * $rooms * $nights ?></div>
        </div>
        <a href="hotel_detail.php?id=<?= $h['id'] ?>&checkin=<?= urlencode($checkin) ?>&checkout=<?= urlencode($checkout) ?>&rooms=<?= $rooms ?>&guests=<?= $guests ?>" class="btn-book">Lihat →</a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php renderNav('home'); ?>
</body>
</html>