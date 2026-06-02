<!-- accom.php -->
<?php

// $type = $_GET['type'] ?? 'hotel';

// $title =
// $type === 'villa'
// ? 'Luxury Villas'
// : 'Best Hotels';

// $desc =
// $type === 'villa'
// ? 'Nikmati villa private dengan view terbaik.'
// : 'Temukan hotel nyaman untuk staycation.';
$type = $_GET['type'] ?? 'hotel';

switch($type){
    case 'villa':
        $title = 'Luxury Villas';
        $desc = 'Nikmati villa private dengan view terbaik.';
        break;

    case 'apartemen':
        $title = 'Modern Apartments';
        $desc = 'Temukan apartemen nyaman untuk perjalanan bisnis maupun liburan.';
        break;

    default:
        $title = 'Best Hotels';
        $desc = 'Temukan hotel nyaman untuk staycation.';
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= ucfirst($type) ?></title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<style>

/* PASTE STYLE DARI flight.php */
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}

body{
  background:#b8cfe8;
  min-height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  font-family:'DM Sans',sans-serif;
}

.phone{
  width:375px;
  height:812px;
  border-radius:44px;
  border:9px solid #18181b;
  overflow:hidden;
  position:relative;

  background:linear-gradient(
    165deg,
    #1e57b8 0%,
    #2563EB 18%,
    #4A90D9 36%,
    #82B8F0 54%,
    #C5DEFF 72%,
    #EBF4FF 88%,
    #F5F9FF 100%
  );
}

/* BACK BUTTON STYLE (SAMA FLIGHT) */
.back-btn{
  width:38px;
  height:38px;
  border-radius:14px;

  background:rgba(255,255,255,.18);
  border:1px solid rgba(255,255,255,.2);

  backdrop-filter:blur(18px);

  display:flex;
  align-items:center;
  justify-content:center;

  color:white;
  text-decoration:none;

  font-size:18px;
  font-weight:700;
}

/* KEEP YOUR ORIGINAL STYLE */
.scroll{
  height:100%;
  overflow-y:auto;
  padding-bottom:120px;
}

.scroll::-webkit-scrollbar{
  display:none;
}

.notch{
  position:absolute;
  top:8px;
  left:50%;
  transform:translateX(-50%);
  width:100px;
  height:26px;
  border-radius:14px;
  background:#111;
}

.statusbar{
  padding:42px 24px 0;
  display:flex;
  justify-content:space-between;
  color:white;
  font-size:11px;
}

.topbar{
  padding:12px 20px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.greeting{
  color:rgba(255,255,255,.8);
  font-size:12px;
}

.name{
  color:white;
  font-size:18px;
  font-weight:700;
  font-family:'Playfair Display',serif;
}

.avatar{
  width:40px;
  height:40px;
  border-radius:50%;
  background:white;
  color:#2563EB;
  display:flex;
  justify-content:center;
  align-items:center;
  font-weight:700;
}

.hero{
  margin:0 16px;
  border-radius:24px;
  padding:20px;
  background:linear-gradient(
    135deg,
    rgba(13,40,120,.9),
    rgba(30,87,185,.7)
  );
  color:white;
}

.hero-eyebrow{
  font-size:10px;
  opacity:.7;
  margin-bottom:8px;
}

.hero h2{
  font-size:24px;
  line-height:1.3;
  margin-bottom:8px;
  font-family:'Playfair Display',serif;
}

.hero p{
  font-size:11px;
  line-height:1.6;
  opacity:.8;
}

.search-box{
  margin:18px 16px 0;
  background:rgba(255,255,255,.35);
  backdrop-filter:blur(20px);
  border-radius:24px;
  padding:18px;
}

.input{
  width:100%;
  height:50px;
  border:none;
  outline:none;
  border-radius:16px;
  margin-bottom:12px;
  padding:0 16px;
  font-size:13px;
}

.row{
  display:flex;
  gap:10px;
}

.btn{
  width:100%;
  height:52px;
  border:none;
  border-radius:18px;
  background:#2563EB;
  color:white;
  font-weight:700;
}

.sec-head{
  padding:22px 16px 12px;
}

.title{
  font-size:16px;
  font-weight:700;
  color:#0c2461;
  font-family:'Playfair Display',serif;
}

.featured-scroll{
  display:flex;
  gap:14px;
  overflow-x:auto;
  padding:0 16px;
}

.featured-scroll::-webkit-scrollbar{
  display:none;
}

.feat-card{
  width:220px;
  min-width:220px;
  background:white;
  border-radius:22px;
  overflow:hidden;
}

.feat-card img{
  width:100%;
  height:130px;
  object-fit:cover;
}

.feat-info{
  padding:14px;
}

.feat-tag{
  display:inline-block;
  background:#EFF6FF;
  color:#2563EB;
  font-size:10px;
  padding:4px 10px;
  border-radius:999px;
  margin-bottom:8px;
}

.feat-info h5{
  font-size:14px;
  margin-bottom:6px;
}

.loc{
  font-size:11px;
  color:#64748b;
  margin-bottom:10px;
}

.feat-bottom{
  display:flex;
  justify-content:space-between;
}

.feat-price{
  font-size:14px;
  font-weight:700;
  color:#2563EB;
}

.navbar{
  position:absolute;
  left:14px;
  right:14px;
  bottom:16px;
  height:68px;
  border-radius:26px;
  background:rgba(255,255,255,.3);
  backdrop-filter:blur(20px);
  display:flex;
  justify-content:space-around;
  align-items:center;
}

.nav-item{
  font-size:10px;
}

.nav-item a{
  text-decoration:none;
  color:#0c2461;
}
.topbar{
  padding:16px 20px 8px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  position:relative;
}

.page-title{
  position:absolute;
  left:50%;
  transform:translateX(-50%);
  color:white;
  font-size:16px;
  font-weight:700;
  font-family:'Playfair Display',serif;
}

.empty{
  width:38px;
  height:38px;
}

</style>
</head>

<body>

<div class="phone">

<div class="notch"></div>

<div class="scroll">

<div class="statusbar">
<span>9:41</span>
<span>🏨</span>
</div>

<div class="topbar">

  <a href="home.php" class="back-btn">
    ←
  </a>

  <div class="page-title">
    Accomodation Booking
  </div>

  <div class="empty"></div>

</div>

<div class="hero">

<div class="hero-eyebrow">
<?= strtoupper($type) ?> STAY
</div>

<h2>
<?= $title ?>
</h2>

<div style="
  margin-top:6px;
  font-size:11px;
  opacity:.85;
">
  <?= ucfirst($type) ?> • Stay Collection
</div>

<p>
<?= $desc ?>
</p>

</div>

<!-- REST FULLY UNCHANGED -->
<div class="search-box">

<div style="
  font-size:11px;
  color:#0c2461;
  font-weight:600;
  margin-bottom:10px;
">
  Search <?= ucfirst($type) ?>
</div>

<input type="text" class="input" placeholder="Destination">

<div class="row">
<input type="date" class="input">
<input type="date" class="input">
</div>

<div class="row">
<input type="number" class="input" placeholder="Guest">
<input type="number" class="input" placeholder="Room">
</div>

<button class="btn" onclick="searchAccom()">
Search <?= ucfirst($type) ?>
</button>

</div>

<div class="sec-head">
<div class="title">
Recommended <?= ucfirst($type) ?>
</div>
</div>

<div class="featured-scroll">

<!-- SAME CONTENT -->
<div class="feat-card">
<img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80">
<div class="feat-info">
<div class="feat-tag"><?= ucfirst($type) ?></div>
<h5>Luxury <?= ucfirst($type) ?></h5>
<div class="loc">📍 Bali, Indonesia</div>
<div class="feat-bottom">
<div class="feat-price">Rp 2.500.000</div>
<div>⭐ 4.9</div>
</div>
</div>
</div>

<div class="feat-card">
<img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=600&q=80">
<div class="feat-info">
<div class="feat-tag"><?= ucfirst($type) ?></div>
<h5>Ocean View Stay</h5>
<div class="loc">📍 Lombok, Indonesia</div>
<div class="feat-bottom">
<div class="feat-price">Rp 1.850.000</div>
<div>⭐ 4.8</div>
</div>
</div>
</div>

</div>

</div>

<nav class="navbar">

<div class="nav-item"><a href="home.php">Home</a></div>
<div class="nav-item"><a href="explore.php">Explore</a></div>
<div class="nav-item"><a href="pesanan.php">Pesanan</a></div>
<div class="nav-item"><a href="profile.php">Profil</a></div>

</nav>

</div>

<script>
function searchAccom(){

  const destination =
    document.querySelectorAll('.input')[0].value;

  const checkin =
    document.querySelectorAll('.input')[1].value;

  const checkout =
    document.querySelectorAll('.input')[2].value;

  const guest =
    document.querySelectorAll('.input')[3].value;

  const room =
    document.querySelectorAll('.input')[4].value;

  if(!destination){
    alert("Please enter destination");
    return;
  }

  const searchData = {
    type: "<?= $type ?>",
    destination,
    checkin,
    checkout,
    guest,
    room
  };

  localStorage.setItem(
    'accomSearch',
    JSON.stringify(searchData)
  );

  window.location.href = 'accom-result.php';
}
</script>

</body>
</html>