<?php require_once 'config.php'; checkLogin();
$categories = array_unique(array_column($tourism, 'category'));
sort($categories);
$filterCat = $_GET['cat'] ?? '';
$filtered = $filterCat ? array_filter($tourism, fn($t) => $t['category'] === $filterCat) : $tourism;
$filtered = array_values($filtered);
?>
<?php headHtml('Wisata','
.spot-card{background:#fff;border-radius:20px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow);margin-bottom:14px;}
.spot-img{position:relative;height:170px;}
.spot-img img{width:100%;height:100%;object-fit:cover;}
.cat-badge{position:absolute;top:10px;left:10px;background:var(--primary);color:#fff;padding:4px 12px;border-radius:40px;font-size:11px;font-weight:700;}
.spot-body{padding:14px;}
.spot-body h3{font-size:16px;font-weight:700;margin-bottom:4px;}
.spot-meta{display:flex;align-items:center;gap:8px;font-size:12px;color:var(--gray);margin-bottom:8px;}
.spot-footer{display:flex;align-items:center;justify-content:space-between;}
.spot-price{font-size:18px;font-weight:800;color:var(--primary);}
') ?>
</head>
<body>
<div class="page-header">
  <a href="home.php" class="back-btn">←</a>
  <h2>🗺️ Destinasi Wisata</h2>
</div>

<div class="container">
  <!-- Filter -->
  <div style="display:flex;gap:8px;overflow-x:auto;scrollbar-width:none;padding-bottom:4px;margin-bottom:14px;">
    <a href="tourism.php" class="filter-chip <?= !$filterCat?'active':'' ?>" style="flex-shrink:0;padding:7px 14px;border-radius:40px;font-size:12px;font-weight:600;border:1.5px solid <?= !$filterCat?'var(--primary)':'var(--border)' ?>;background:<?= !$filterCat?'var(--primary)':'#fff' ?>;color:<?= !$filterCat?'#fff':'#374151' ?>;">Semua</a>
    <?php foreach ($categories as $cat): ?>
    <a href="tourism.php?cat=<?= urlencode($cat) ?>" style="flex-shrink:0;padding:7px 14px;border-radius:40px;font-size:12px;font-weight:600;border:1.5px solid <?= $filterCat===$cat?'var(--primary)':'var(--border)' ?>;background:<?= $filterCat===$cat?'var(--primary)':'#fff' ?>;color:<?= $filterCat===$cat?'#fff':'#374151' ?>;"><?= $cat ?></a>
    <?php endforeach; ?>
  </div>

  <p style="color:var(--gray);font-size:13px;margin-bottom:12px;"><?= count($filtered) ?> destinasi ditemukan</p>

  <?php foreach ($filtered as $t): ?>
  <div class="spot-card">
    <div class="spot-img">
      <img src="<?= $t['img'] ?>" alt="<?= $t['name'] ?>">
      <div class="cat-badge"><?= $t['category'] ?></div>
    </div>
    <div class="spot-body">
      <h3><?= $t['name'] ?></h3>
      <div class="spot-meta">
        <span>📍 <?= $t['city'] ?></span>
        <span>⭐ <?= $t['rating'] ?>/5.0</span>
      </div>
      <p style="font-size:13px;color:#374151;line-height:1.5;margin-bottom:12px;"><?= $t['desc'] ?></p>
      <div class="spot-footer">
        <div>
          <div class="spot-price">$<?= $t['price'] ?><span style="font-size:12px;font-weight:400;">/orang</span></div>
          <div style="font-size:11px;color:var(--gray);">± <?= formatRupiah($t['price']) ?></div>
        </div>
        <a href="flight_search.php?dest=<?= urlencode($t['city']) ?>" class="btn btn-primary" style="width:auto;padding:10px 18px;font-size:13px;">Ke Sini ✈️</a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<?php renderNav('home'); ?>
</body>
</html>