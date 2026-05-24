<?php require_once 'config.php'; checkLogin();

// Handle wishlist toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_wishlist'])) {
    $hid = (int)$_POST['hotel_id'];
    $hotel = null;
    foreach ($hotels as $h) { if ($h['id'] == $hid) { $hotel = $h; break; } }
    if ($hotel) {
        $ids = array_column($_SESSION['wishlist'], 'id');
        if (in_array($hid, $ids)) {
            $_SESSION['wishlist'] = array_values(array_filter($_SESSION['wishlist'], fn($w) => $w['id'] !== $hid));
        } else {
            $_SESSION['wishlist'][] = $hotel;
        }
    }
    $redirect = $_POST['redirect'] ?? 'wishlist.php';
    header('Location: ' . $redirect); exit;
}

$tab = $_GET['tab'] ?? 'hotels';
$wishlist = $_SESSION['wishlist'];
?>
<?php headHtml('Wishlist','
.tab-row{display:flex;gap:0;border-bottom:2px solid var(--border);margin-bottom:16px;}
.tab-link{flex:1;text-align:center;padding:12px;font-size:14px;font-weight:600;color:var(--gray);border-bottom:3px solid transparent;margin-bottom:-2px;cursor:pointer;text-decoration:none;}
.tab-link.active{color:var(--primary);border-bottom-color:var(--primary);}
.wish-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.wish-card{background:#fff;border-radius:16px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow);}
.wish-card img{height:120px;object-fit:cover;width:100%;}
.wish-card-body{padding:10px;}
.wish-card-body h4{font-size:13px;font-weight:700;margin-bottom:2px;}
.wish-card-body .city{font-size:11px;color:var(--gray);}
.wish-card-body .price{font-size:13px;font-weight:700;color:var(--primary);margin-top:4px;}
.remove-btn{background:var(--accent);color:#fff;border:none;font-size:10px;padding:5px 10px;border-radius:40px;cursor:pointer;margin-top:6px;font-weight:700;}
') ?>
</head>
<body>
<div class="page-header">
  <h2>❤️ Wishlist</h2>
</div>

<div class="container">
  <div class="tab-row">
    <a href="wishlist.php?tab=hotels" class="tab-link <?= $tab==='hotels'?'active':'' ?>">🏨 Hotel</a>
    <a href="wishlist.php?tab=spots" class="tab-link <?= $tab==='spots'?'active':'' ?>">🗺️ Wisata</a>
  </div>

  <?php if ($tab === 'hotels'): ?>
    <?php if (empty($wishlist)): ?>
    <div style="text-align:center;padding:60px 20px;">
      <div style="font-size:56px;margin-bottom:14px;">🤍</div>
      <h3>Wishlist kosong</h3>
      <p style="color:var(--gray);margin-top:6px;">Tekan ❤️ di hotel favoritmu untuk menyimpannya di sini.</p>
      <a href="hotel_search.php" class="btn btn-primary" style="margin-top:20px;">Jelajahi Hotel</a>
    </div>
    <?php else: ?>
    <div class="wish-grid">
      <?php foreach ($wishlist as $h): ?>
      <div class="wish-card">
        <a href="hotel_detail.php?id=<?= $h['id'] ?>">
          <img src="<?= $h['img'] ?>" alt="<?= $h['name'] ?>">
        </a>
        <div class="wish-card-body">
          <h4><?= $h['name'] ?></h4>
          <p class="city">📍 <?= $h['city'] ?></p>
          <div style="font-size:11px;color:#F59E0B;"><?= str_repeat('★',$h['stars']) ?></div>
          <p class="price">$<?= $h['price'] ?>/mlm</p>
          <form method="POST" style="margin:0;">
            <input type="hidden" name="hotel_id" value="<?= $h['id'] ?>">
            <input type="hidden" name="redirect" value="wishlist.php?tab=hotels">
            <button type="submit" name="toggle_wishlist" class="remove-btn">✕ Hapus</button>
          </form>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

  <?php else: ?>
    <div style="text-align:center;padding:60px 20px;">
      <div style="font-size:56px;margin-bottom:14px;">🗺️</div>
      <h3>Wisata Coming Soon</h3>
      <p style="color:var(--gray);margin-top:6px;">Segera tersedia di update berikutnya.</p>
      <a href="tourism.php" class="btn btn-primary" style="margin-top:20px;">Jelajahi Wisata</a>
    </div>
  <?php endif; ?>
</div>

<?php renderNav('wishlist'); ?>
</body>
</html>