<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staycation App</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

 <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<style>
*, *::before, *::after{
  box-sizing:border-box;
  margin:0;
  padding:0;
}

:root{
  --blue-900:#0c2461;
  --blue-700:#1e5799;
  --blue-500:#2563EB;
  --blue-400:#3B82F6;
  --blue-300:#60A5FA;
  --blue-100:#DBEAFE;
  --blue-50:#EFF6FF;

  --glass-bg:rgba(255,255,255,0.40);
  --glass-border:rgba(255,255,255,0.45);
  --glass-blur:blur(25px);

  --muted:#475569;
}

body{
  background:#b8cfe8;
  display:flex;
  justify-content:center;
  align-items:center;
  min-height:100vh;
  overflow:hidden;
  padding:24px 16px;
  font-family:'DM Sans',sans-serif;
}

/* PHONE */
.phone{
  width:375px;
  height:812px;
  border-radius:44px;
  border:9px solid #18181b;
  position:relative;
  overflow:hidden;

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

  box-shadow:
    0 40px 80px rgba(0,0,0,.35),
    inset 0 0 0 1px rgba(255,255,255,.12);

  display:flex;
  flex-direction:column;
}

/* BLOBS */
.blob{
  position:absolute;
  border-radius:50%;
  pointer-events:none;
}

.blob-1{
  width:320px;
  height:320px;
  background:radial-gradient(circle, rgba(255,255,255,.22) 0%, transparent 70%);
  top:-80px;
  right:-80px;
  animation:drift 12s ease-in-out infinite;
}

.blob-2{
  width:220px;
  height:220px;
  background:radial-gradient(circle, rgba(255,255,255,.14) 0%, transparent 70%);
  top:60px;
  left:-60px;
  animation:drift 16s ease-in-out infinite reverse;
}

@keyframes drift{
  0%,100%{
    transform:translate(0,0) scale(1);
  }
  50%{
    transform:translate(12px,-16px) scale(1.06);
  }
}

/* NOTCH */
.notch{
  position:absolute;
  top:8px;
  left:50%;
  transform:translateX(-50%);
  width:100px;
  height:26px;
  background:#18181b;
  border-radius:14px;
  z-index:500;
}

/* SCROLL */
.scroll{
  flex:1;
  overflow-y:auto;
  scrollbar-width:none;
  padding-bottom:110px;
  position:relative;
  z-index:10;
}

.scroll::-webkit-scrollbar{
  display:none;
}

/* STATUS BAR */
.statusbar{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:42px 24px 0;
  font-size:11px;
  font-weight:600;
  color:rgba(255,255,255,.9);
}

.statusbar .icons{
  display:flex;
  gap:5px;
  align-items:center;
}

.statusbar .icons svg{
  width:14px;
  height:14px;
  fill:rgba(255,255,255,.9);
}

/* TOPBAR */
.topbar{
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  padding:10px 20px 0;
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
  width:38px;
  height:38px;
  border-radius:50%;
  background:linear-gradient(135deg,#ffd89b,#19547b);
  border:2px solid rgba(255,255,255,.5);

  display:flex;
  align-items:center;
  justify-content:center;

  color:white;
  font-size:14px;
  font-weight:700;
}

/* HERO */
.hero{
  margin:16px 16px 0;
  border-radius:22px;
  padding:18px 20px;
  position:relative;
  overflow:hidden;

  background:linear-gradient(
    135deg,
    rgba(13,40,120,.85),
    rgba(30,87,185,.75)
  );

  border:1px solid rgba(255,255,255,.2);

  backdrop-filter:blur(12px);
  -webkit-backdrop-filter:blur(12px);

  box-shadow:
    0 8px 32px rgba(13,40,120,.3),
    inset 0 1px 0 rgba(255,255,255,.15);
}

.hero::after{
  content:'';
  position:absolute;
  top:-30px;
  right:-20px;
  width:120px;
  height:120px;

  background:radial-gradient(circle, rgba(255,255,255,.12) 0%, transparent 65%);
}

.hero-eyebrow{
  font-size:9px;
  font-weight:700;
  letter-spacing:1.2px;
  text-transform:uppercase;
  color:rgba(255,255,255,.6);
  margin-bottom:5px;
}

.hero h2{
  font-family:'Playfair Display',serif;
  font-size:17px;
  color:white;
  line-height:1.3;
  margin-bottom:5px;
}

.hero p{
  font-size:10px;
  color:rgba(255,255,255,.7);
  line-height:1.6;
  margin-bottom:14px;
}

.hero-btn{
  display:inline-flex;
  align-items:center;
  gap:6px;

  background:white;
  color:#1D4ED8;

  font-size:11px;
  font-weight:700;

  padding:8px 16px;
  border-radius:10px;

  cursor:pointer;

  box-shadow:0 4px 12px rgba(0,0,0,.15);
}

.hero-btn svg{
  width:12px;
  height:12px;
  fill:#1D4ED8;
}

/* SEARCH */
.search-wrap{
  padding:14px 16px 0;
}

.searchbar{
  display:flex;
  align-items:center;
  gap:10px;

  height:48px;
  padding:0 14px;

  border-radius:16px;

  background:rgba(255,255,255,.75);

  border:1px solid rgba(255,255,255,.9);

  backdrop-filter:blur(18px);
  -webkit-backdrop-filter:blur(18px);

  box-shadow:0 4px 18px rgba(37,99,235,.1);
}

.searchbar svg{
  width:16px;
  height:16px;
}

.searchbar input{
  flex:1;
  border:none;
  background:transparent;
  outline:none;

  font-size:12px;
  color:#1e3a5f;
}

.searchbar input::placeholder{
  color:rgba(30,58,95,.4);
}

.filter-pill{
  width:32px;
  height:32px;
  border-radius:10px;
  background:#2563EB;

  display:flex;
  justify-content:center;
  align-items:center;
}

.filter-pill svg{
  width:15px;
  height:15px;
  fill:white;
}

/* CHIPS */
.chips{
  display:flex;
  gap:8px;
  padding:12px 16px 0;
  overflow-x:auto;
  scrollbar-width:none;
}

.chips::-webkit-scrollbar{
  display:none;
}

.chip{
  white-space:nowrap;
  padding:7px 16px;
  border-radius:999px;
  font-size:11px;
  font-weight:600;
  cursor:pointer;
  flex-shrink:0;
}

.chip.active{
  background:#1D4ED8;
  color:white;
  box-shadow:0 4px 14px rgba(29,78,216,.4);
}

.chip.idle{
  background:rgba(255,255,255,.65);
  color:#1e3a5f;
  border:1px solid rgba(255,255,255,.85);

  backdrop-filter:blur(12px);
}

/* SECTION */
.sec-head{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:18px 16px 10px;
}

.sec-head .title{
  font-size:14px;
  font-weight:700;
  color:#0c2461;
  font-family:'Playfair Display',serif;
}

.see-all{
  font-size:10px;
  font-weight:600;
  color:#2563EB;
}

/* CATEGORY STACK */
.stack-row{
  display:flex;
  gap:12px;
  padding:0 16px;
  overflow-x:auto;
  scrollbar-width:none;
}

.stack-row::-webkit-scrollbar{
  display:none;
}

.stack-group{
  flex-shrink:0;
  display:flex;
  flex-direction:column;
  align-items:center;
}

.stack-cluster{
  position:relative;
  width:88px;
  height:80px;
  margin-bottom:8px;
}

.stack-cluster .sc{
  position:absolute;
  width:78px;
  height:68px;
  border-radius:14px;
  overflow:hidden;

  border:2px solid white;

  box-shadow:0 4px 12px rgba(0,0,0,.15);
}

.stack-cluster .sc img{
  width:100%;
  height:100%;
  object-fit:cover;
}

.stack-cluster .sc:nth-child(1){
  top:0;
  left:10px;
  transform:rotate(6deg);
  opacity:.6;
}

.stack-cluster .sc:nth-child(2){
  top:4px;
  left:5px;
  transform:rotate(3deg);
  opacity:.8;
}

.stack-cluster .sc:nth-child(3){
  top:8px;
  left:0;
}

.stack-cluster .sc:nth-child(3)::after{
  content:attr(data-count);

  position:absolute;
  bottom:5px;
  right:5px;

  background:rgba(0,0,0,.55);
  color:white;

  font-size:8px;
  font-weight:700;

  padding:2px 6px;
  border-radius:6px;
}

.stack-label{
  font-size:11px;
  font-weight:600;
  color:#1e3a5f;
}

.stack-sub{
  font-size:9px;
  color:rgba(30,58,95,.5);
}

/* FEATURED */
.featured-scroll{
  display:flex;
  gap:14px;
  padding:0 16px 4px;
  overflow-x:auto;
  scrollbar-width:none;
}

.featured-scroll::-webkit-scrollbar{
  display:none;
}

.feat-card{
  width:210px;
  min-width:210px;
  height:260px;

  border-radius:22px;
  overflow:hidden;
  background:white;

  box-shadow:0 10px 28px rgba(0,0,0,.1);

  flex-shrink:0;
  cursor:pointer;

  display:flex;
  flex-direction:column;
}

.feat-card img{
  width:100%;
  height:125px;
  object-fit:cover;
  flex-shrink:0;
}

.feat-info{
  padding:12px;
  flex:1;

  display:flex;
  flex-direction:column;
  justify-content:space-between;
}

.feat-tag{
  display:inline-block;
  padding:3px 9px;
  border-radius:999px;

  background:#EFF6FF;
  color:#2563EB;

  font-size:9px;
  font-weight:700;

  margin-bottom:6px;
}

.feat-info h5{
  font-size:13px;
  font-weight:700;
  color:#0c2461;
  margin-bottom:3px;
  font-family:'Playfair Display',serif;
}

.loc{
  display:flex;
  align-items:center;
  gap:3px;

  font-size:10px;
  color:rgba(12,36,97,.55);

  margin-bottom:8px;
}

.loc svg{
  width:9px;
  height:9px;
  fill:#2563EB;
}

.feat-bottom{
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.feat-price{
  font-size:14px;
  font-weight:700;
  color:#1D4ED8;
}

.feat-price span{
  font-size:9px;
  font-weight:400;
  color:rgba(12,36,97,.45);
}

.feat-stars{
  display:flex;
  align-items:center;
  gap:2px;

  font-size:10px;
  font-weight:600;
  color:#0c2461;
}

.feat-stars svg{
  width:11px;
  height:11px;
  fill:#F59E0B;
}

/* NAVBAR */
.navbar{
  position:absolute;
  bottom:16px;
  left:14px;
  right:14px;

  height:68px;
  border-radius:26px;

  background:rgba(255,255,255,0.22);

  border:1px solid rgba(255,255,255,0.45);

  backdrop-filter:blur(28px) saturate(160%);
  -webkit-backdrop-filter:blur(28px) saturate(160%);

  box-shadow:
    0 8px 32px rgba(30,87,185,.18),
    0 2px 8px rgba(0,0,0,.08),
    inset 0 1px 0 rgba(255,255,255,.6);

  display:flex;
  justify-content:space-around;
  align-items:center;

  z-index:200;
}

.nav-item{
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  gap:3px;

  flex:1;
  height:100%;
}

.nav-item a{
  width:100%;
  height:100%;
  text-decoration:none;

  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  gap:3px;
}

.nav-item svg{
  width:20px;
  height:20px;

  fill:none;
  stroke:rgba(12,36,97,.4);
  stroke-width:1.8;
  stroke-linecap:round;
  stroke-linejoin:round;
}

.nav-item span{
  font-size:9px;
  font-weight:600;
  color:rgba(12,36,97,.4);
}

.nav-item.active{
  background:rgba(255,255,255,.55);
  border-radius:16px;
}

.nav-item.active svg{
  stroke:#1D4ED8;
}

.nav-item.active span{
  color:#1D4ED8;
}

/* PROMO CARD */
.promo-wrap{
  padding:18px 16px 0;
}

.promo-card{
  position:relative;
  overflow:hidden;

  border-radius:24px;
  padding:18px;

  background:
    linear-gradient(
      135deg,
      rgba(37,99,235,.95),
      rgba(96,165,250,.85)
    );

  box-shadow:
    0 10px 30px rgba(37,99,235,.28);

  color:white;
}

.promo-card::before{
  content:'';
  position:absolute;
  width:140px;
  height:140px;
  border-radius:50%;

  background:rgba(255,255,255,.12);

  top:-50px;
  right:-40px;
}

.promo-badge{
  display:inline-flex;
  align-items:center;
  gap:6px;

  padding:6px 10px;
  border-radius:999px;

  background:rgba(255,255,255,.16);

  font-size:10px;
  font-weight:700;

  margin-bottom:12px;

  backdrop-filter:blur(10px);
}

.promo-title{
  font-size:20px;
  font-weight:700;
  line-height:1.2;
  margin-bottom:6px;

  font-family:'Playfair Display',serif;
}

.promo-desc{
  font-size:11px;
  line-height:1.6;
  color:rgba(255,255,255,.85);

  margin-bottom:16px;
}

.promo-bottom{
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.promo-code{
  background:white;
  color:#1D4ED8;

  font-size:11px;
  font-weight:700;

  padding:8px 14px;
  border-radius:12px;
}

.promo-btn{
  display:flex;
  align-items:center;
  gap:5px;

  font-size:11px;
  font-weight:700;
}

.no-underline{
  text-decoration:none;
}
</style>
</head>

<body>

<div class="phone">

  <div class="notch"></div>
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  <div class="scroll">

    <!-- STATUS -->
    <div class="statusbar">
      <span>9:41</span>

      <div class="icons">
        <svg viewBox="0 0 24 24">
          <rect x="2" y="14" width="3" height="6" rx="1"/>
          <rect x="7" y="10" width="3" height="10" rx="1"/>
          <rect x="12" y="6" width="3" height="14" rx="1"/>
          <rect x="17" y="2" width="3" height="18" rx="1" opacity=".35"/>
        </svg>

        <svg viewBox="0 0 24 24">
          <path d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0M8.53 16.11a6 6 0 016.95 0M12 20h.01" stroke="rgba(255,255,255,.9)" stroke-width="2" fill="none" stroke-linecap="round"/>
        </svg>

        <svg viewBox="0 0 24 24">
          <rect x="2" y="7" width="18" height="10" rx="2" stroke="rgba(255,255,255,.9)" stroke-width="1.5" fill="none"/>
          <rect x="3" y="8" width="13" height="8" rx="1" fill="rgba(255,255,255,.9)"/>
          <path d="M20 10v4" stroke="rgba(255,255,255,.9)" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </div>
    </div>

    <!-- TOPBAR -->
    <div class="topbar">
      <div>
        <div class="greeting">Selamat datang kembali 👋</div>
        <div class="name">Jessica Putri</div>
      </div>

      <div class="avatar">JP</div>
    </div>

   <div class="hero">
  <div class="hero-eyebrow">TRAVEL SMARTER ✈️</div>

  <h2>Book Flights,<br>Hotels & More</h2>

  <p>
    Cari tiket pesawat murah, hotel nyaman,
    dan paket liburan terbaik dalam satu aplikasi.
  </p>

  <div class="hero-btn">
    <svg viewBox="0 0 24 24">
      <path d="M2.5 19l19-7L2.5 5v5l13 2-13 2z"/>
    </svg>
    Start Exploring
  </div>
</div>

   
    <!-- CATEGORY -->
    <div class="sec-head">
      <div class="title">Jelajah Kategori</div>
      <!-- <div class="see-all">Lihat semua →</div> -->
    </div>

    <div class="stack-row">

<div class="stack-group">

  <div class="stack-cluster">

    <div class="sc">
      <img src="https://images.unsplash.com/photo-1521727857535-28d2047314ac?auto=format&fit=crop&w=400&q=80" alt="Flight">
    </div>

    <div class="sc">
      <img src="https://images.unsplash.com/photo-1502920917128-1aa500764ce7?auto=format&fit=crop&w=400&q=80" alt="Flight">
    </div>

    <!--  data-count="120+" -->
    <div class="sc">
      <img src="https://images.unsplash.com/photo-1517479149777-5f3b1511d5ad?auto=format&fit=crop&w=400&q=80" alt="Flight">
    </div>

  </div>

  <div class="stack-label"><a href="flight.php" class="stack-group no-underline text-black">Flight</a></div>
  <!-- <div class="stack-sub">120 rute</div> -->

</div>

      <div class="stack-group">
        <div class="stack-cluster">
          <div class="sc">
            <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=200&q=60">
          </div>

          <div class="sc">
            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=200&q=60">
          </div>

          <div class="sc" >
            <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=200&q=60">
          </div>
        </div>

          <div class="stack-label"><a href="accom.php?type=hotel" class="stack-group no-underline text-black">Hotel</a></div>
        <!-- <div class="stack-sub">24 properti</div> -->
      </div>

      <div class="stack-group">
        <div class="stack-cluster">
          <div class="sc">
            <img src="https://images.unsplash.com/photo-1601628828688-632f38a5a7d0?w=200&q=60">
          </div>

          <div class="sc">
            <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=200&q=60">
          </div>

          <div class="sc">
            <img src="https://images.unsplash.com/photo-1523217582562-09d0def993a6?w=200&q=60">
          </div>
        </div>

                  <div class="stack-label"><a href="accom.php?type=villa" class="stack-group no-underline text-black">Villa</a></div>
        <!-- <div class="stack-sub">18 properti</div> -->
      </div>

    </div>

      <!-- PROMO -->
<div class="promo-wrap">

  <div class="promo-card">

    <div class="promo-badge">
      🎉 LIMITED OFFER
    </div>

    <div class="promo-title">
      Diskon 50%<br>
      Untuk Flight Pertama
    </div>

    <div class="promo-desc">
      Gunakan voucher spesial untuk booking
      tiket pesawat dan nikmati perjalanan
      lebih hemat.
    </div>

    <div class="promo-bottom">

      <div class="promo-code">
        FLYNOW50
      </div>

      <div class="promo-btn">
        Claim →
      </div>

    </div>

  </div>

</div>


    <!-- RECOMMENDATION -->
    <!-- RECOMMENDATION -->
<div class="sec-head">
  <div class="title">Rekomendasi Untukmu</div>
  <!-- <div class="see-all">Lihat semua →</div> -->
</div>

<div class="featured-scroll" id="recommendationContainer">
</div>

</div>

    
  <!-- NAVBAR -->
  <nav class="navbar">

    <div class="nav-item active">
      <a href="home.php">

        <svg viewBox="0 0 24 24">
          <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1V9.5z"/>
          <path d="M9 21V12h6v9"/>
        </svg>

        <span>Home</span>

      </a>
    </div>

    <div class="nav-item">
      <a href="explore.php">

        <svg viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="8"/>
          <path d="m21 21-4.35-4.35"/>
        </svg>

        <span>Explore</span>

      </a>
    </div>

    <div class="nav-item">
      <a href="pesanan.php">

        <svg viewBox="0 0 24 24">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <path d="M16 2v4M8 2v4M3 10h18"/>
        </svg>

        <span>Pesanan</span>

      </a>
    </div>

    <div class="nav-item">
      <a href="profile.php">

        <svg viewBox="0 0 24 24">
          <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>

        <span>Profil</span>

      </a>
    </div>

  </nav>

</div>

<script src="db.js"></script>

<script>

// FORMAT HARGA
function formatPrice(price){
  return new Intl.NumberFormat('id-ID').format(price);
}

// SHUFFLE RANDOM
function shuffleArray(array){
  return [...array].sort(() => Math.random() - 0.5);
}

// RANDOM 5 DATA
const recommendedVilla =
  shuffleArray(villaDatabase).slice(0, 5);

// TARGET
const recommendationContainer =
  document.getElementById('recommendationContainer');

// RENDER
recommendedVilla.forEach(villa => {

  recommendationContainer.innerHTML += `
  
  <div class="feat-card">

    <img src="${villa.imageUrl}" alt="${villa.name}">

    <div class="feat-info">

      <div class="feat-tag">
        ${villa.type}
      </div>

      <h5>${villa.name}</h5>

      <div class="loc">
        📍 ${villa.locationDetail}
      </div>

      <div class="feat-bottom">

        <div class="feat-price">
          Rp ${formatPrice(villa.pricePerNight)}
          <span>/ malam</span>
        </div>

        <div class="feat-stars">
          ⭐ ${villa.rating}
        </div>

      </div>

    </div>

  </div>

  `;
});

</script>
<script>
document.querySelectorAll('.chip').forEach(chip => {

  chip.addEventListener('click', () => {

    document.querySelectorAll('.chip').forEach(item => {
      item.classList.remove('active');
      item.classList.add('idle');
    });

    chip.classList.remove('idle');
    chip.classList.add('active');

  });

});
</script>

</body>
</html>