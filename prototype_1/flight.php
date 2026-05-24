<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flight Booking</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<style>

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
  overflow:hidden;
}

/* PHONE */

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

  box-shadow:
    0 40px 80px rgba(0,0,0,.35),
    inset 0 0 0 1px rgba(255,255,255,.12);
}

/* BG BLOBS */

.blob{
  position:absolute;
  border-radius:50%;
  pointer-events:none;
}

.blob-1{
  width:320px;
  height:320px;

  background:
    radial-gradient(circle,
    rgba(255,255,255,.18) 0%,
    transparent 70%);

  top:-100px;
  right:-90px;
}

.blob-2{
  width:220px;
  height:220px;

  background:
    radial-gradient(circle,
    rgba(255,255,255,.14) 0%,
    transparent 70%);

  left:-60px;
  top:120px;
}

/* NOTCH */

.notch{
  position:absolute;
  top:8px;
  left:50%;
  transform:translateX(-50%);
  width:100px;
  height:26px;
  border-radius:14px;
  background:#111;
  z-index:100;
}

/* SCROLL */

.scroll{
  height:100%;
  overflow-y:auto;
  padding-bottom:40px;
  position:relative;
  z-index:2;
}

.scroll::-webkit-scrollbar{
  display:none;
}

/* STATUSBAR */

.statusbar{
  padding:42px 24px 0;

  display:flex;
  justify-content:space-between;
  align-items:center;

  color:white;
  font-size:11px;
  font-weight:600;
}

/* TOPBAR */

.topbar{
  padding:16px 20px 8px;

  display:flex;
  align-items:center;
  justify-content:space-between;
}

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

.page-title{
  color:white;
  font-size:16px;
  font-weight:700;
  font-family:'Playfair Display',serif;
}

.empty{
  width:38px;
}

/* HERO */

.hero{
  margin:8px 16px 0;

  border-radius:28px;
  padding:22px;

  position:relative;
  overflow:hidden;

  background:
    linear-gradient(
      135deg,
      rgba(13,40,120,.92),
      rgba(30,87,185,.72)
    );

  box-shadow:
    0 10px 35px rgba(13,40,120,.25);

  color:white;
}

.hero::after{
  content:'';

  position:absolute;

  width:160px;
  height:160px;

  border-radius:50%;

  background:rgba(255,255,255,.08);

  right:-50px;
  top:-50px;
}

.hero-eyebrow{
  font-size:10px;
  letter-spacing:1.5px;
  margin-bottom:8px;
  opacity:.7;
}

.hero h2{
  font-size:24px;
  line-height:1.3;

  font-family:'Playfair Display',serif;

  margin-bottom:10px;
}

.hero p{
  font-size:11px;
  line-height:1.7;
  opacity:.82;
}

/* SEARCH */

.search-box{
  margin:18px 16px 0;

  background:rgba(255,255,255,.32);

  border:1px solid rgba(255,255,255,.35);

  backdrop-filter:blur(22px);

  border-radius:28px;

  padding:18px;

  box-shadow:
    0 8px 25px rgba(37,99,235,.12);
}

/* CHIPS */

.chips{
  display:flex;
  gap:10px;
  margin-bottom:16px;
}

.chip{
  padding:9px 16px;
  border-radius:999px;

  font-size:11px;
  font-weight:700;

  cursor:pointer;

  transition:.25s;
}

.chip.active{
  background:#2563EB;
  color:white;

  box-shadow:
    0 8px 18px rgba(37,99,235,.35);
}

.chip.idle{
  background:white;
  color:#2563EB;
}

/* INPUT */

.input{
  width:100%;
  height:52px;

  border:none;
  outline:none;

  border-radius:16px;

  margin-bottom:12px;

  padding:0 16px;

  font-size:13px;
  font-weight:500;

  background:white;

  color:#0c2461;
}

.input::placeholder{
  color:#94a3b8;
}

.row{
  display:flex;
  gap:10px;
}

.btn{
  width:100%;
  height:54px;

  border:none;
  border-radius:18px;

  background:#2563EB;
  color:white;

  font-size:14px;
  font-weight:700;

  margin-top:8px;

  cursor:pointer;

  box-shadow:
    0 10px 20px rgba(37,99,235,.35);

  transition:.25s;
}

.btn:hover{
  transform:translateY(-2px);
}

/* SECTION */

.sec-head{
  padding:24px 16px 14px;
}

.title{
  font-size:18px;
  font-weight:700;

  color:#0c2461;

  font-family:'Playfair Display',serif;
}

/* CARDS */

.featured-scroll{
  display:flex;
  overflow-x:auto;
  gap:14px;
  padding:0 16px 20px;
}

.featured-scroll::-webkit-scrollbar{
  display:none;
}

.feat-card{
  width:220px;
  min-width:220px;

  background:white;

  border-radius:24px;

  overflow:hidden;

  box-shadow:
    0 10px 25px rgba(0,0,0,.1);
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
  font-weight:700;

  padding:4px 10px;
  border-radius:999px;

  margin-bottom:8px;
}

.feat-info h5{
  font-size:15px;
  margin-bottom:6px;
  color:#0c2461;
}

.loc{
  font-size:11px;
  color:#64748b;
  margin-bottom:12px;
}

.feat-bottom{
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.feat-price{
  font-size:15px;
  font-weight:700;
  color:#2563EB;
}

.rating{
  font-size:11px;
  font-weight:600;
  color:#0c2461;
}

/* INPUT GROUP */

.input-group{
  width:100%;
}

/* LABEL */

.input-label{
  display:block;

  font-size:11px;
  font-weight:700;

  color:#0c2461;

  margin-bottom:8px;
  margin-left:4px;

  letter-spacing:.3px;
}

</style>
</head>

<body>

<div class="phone">

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="notch"></div>

<div class="scroll">

<!-- STATUSBAR -->

<div class="statusbar">

<span>9:41</span>

<span>
✈️
</span>

</div>

<!-- TOPBAR -->

<div class="topbar">

<a href="home.php" class="back-btn">
←
</a>

<div class="page-title">
Flight Booking
</div>

<div class="empty"></div>

</div>

<!-- HERO -->

<div class="hero">

<div class="hero-eyebrow">
TRAVEL SMARTER
</div>

<h2>
Find Your<br>
Next Journey
</h2>

<p>
Cari tiket pesawat murah untuk perjalanan
domestik maupun internasional dengan
pengalaman booking yang cepat dan mudah.
</p>

</div>

<!-- SEARCH -->

<div class="search-box">

  <div class="chips">

    <div class="chip active" id="oneWayBtn">
      One Way
    </div>

    <div class="chip idle" id="roundTripBtn">
      Round Trip
    </div>

  </div>

  <!-- FROM -->

<div class="input-group">

  <label class="input-label">
    Departure
  </label>

  <input
    type="text"
    class="input"
    id="fromInput"
    placeholder="✈️ Dari Mana?"
  >

</div>

<!-- TO -->

<div class="input-group">

  <label class="input-label">
    Destination
  </label>

  <input
    type="text"
    class="input"
    id="toInput"
    placeholder="📍 Ke Mana?"
  >

</div>

<!-- DATE + GUEST -->

<div class="row">

  <div class="input-group">

    <label class="input-label">
      Departure Date
    </label>

    <input
      type="date"
      class="input"
      id="departDate"
    >

  </div>

  <div class="input-group">

    <label class="input-label">
      Passengers
    </label>

    <input
      type="number"
      class="input"
      id="guestInput"
      placeholder="Guest"
    >

  </div>

</div>
  <!-- RETURN DATE -->

  <div
    id="returnContainer"
    style="display:none;"
  >

    <div class="input-group">

      <label class="input-label">
        Return Date
      </label>

      <input
        type="date"
        class="input"
        id="returnDate"
      >

    </div>

  </div>

<button class="btn" id="searchFlightBtn">
  Cari Flight
</button>

</div>

<!-- POPULAR -->

<div class="sec-head">
    <div class="title">
    Popular Flights
    </div>
</div>

<div class="featured-scroll">

<!-- CARD -->

<div class="feat-card">

<img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=600&q=80">

<div class="feat-info">

<div class="feat-tag">
Direct Flight
</div>

<h5>
Surabaya → Bali
</h5>

<div class="loc">
📅 25 May 2026
</div>

<div class="feat-bottom">

<div class="feat-price">
Rp 850.000
</div>

<div class="rating">
⭐ 4.9
</div>

</div>

</div>

</div>

<!-- CARD -->

<div class="feat-card">

<img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&q=80">

<div class="feat-info">

<div class="feat-tag">
Promo
</div>

<h5>
Jakarta → Lombok
</h5>

<div class="loc">
📅 28 May 2026
</div>

<div class="feat-bottom">

<div class="feat-price">
Rp 1.200.000
</div>

<div class="rating">
⭐ 4.8
</div>

</div>

</div>

</div>

<!-- CARD -->

<div class="feat-card">

<img src="https://images.unsplash.com/photo-1517479149777-5f3b1511d5ad?w=600&q=80">

<div class="feat-info">

<div class="feat-tag">
Best Seller
</div>

<h5>
Singapore → Tokyo
</h5>

<div class="loc">
📅 02 June 2026
</div>

<div class="feat-bottom">

<div class="feat-price">
Rp 4.850.000
</div>

<div class="rating">
⭐ 5.0
</div>

</div>

</div>

</div>

</div>

</div>

</div>

<!-- <script>

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

</script> -->

<script>

const oneWayBtn = document.getElementById('oneWayBtn');
const roundTripBtn = document.getElementById('roundTripBtn');

const returnContainer =
  document.getElementById('returnContainer');

function setActiveChip(activeBtn, inactiveBtn){

  activeBtn.classList.remove('idle');
  activeBtn.classList.add('active');

  inactiveBtn.classList.remove('active');
  inactiveBtn.classList.add('idle');

}

// ONE WAY
oneWayBtn.addEventListener('click', () => {

  setActiveChip(oneWayBtn, roundTripBtn);

  returnContainer.style.display = 'none';

});

// ROUND TRIP
roundTripBtn.addEventListener('click', () => {

  setActiveChip(roundTripBtn, oneWayBtn);

  returnContainer.style.display = 'block';

});

</script>

<script>

const searchFlightBtn =
  document.getElementById('searchFlightBtn');

searchFlightBtn.addEventListener('click', () => {

  // ambil value input

  const from =
    document.getElementById('fromInput')
    .value
    .trim();

  const to =
    document.getElementById('toInput')
    .value
    .trim();

  const departureDate =
    document.getElementById('departDate')
    .value;

  const guest =
    document.getElementById('guestInput')
    .value;

  // validasi sederhana

  if(!from || !to || !departureDate || !guest){

    alert('Lengkapi semua data flight dulu ya ✈️');

    return;
  }

  // cek trip type

  const isRoundTrip =
    roundTripBtn.classList.contains('active');

  let returnDate = '';

  if(isRoundTrip){

    returnDate =
      document.getElementById('returnDate').value;

    if(!returnDate){

      alert('Pilih tanggal pulang dulu ✈️');

      return;
    }

  }

  // simpan query search

  const searchData = {

    from,
    to,
    departureDate,
    guest,
    tripType: isRoundTrip
      ? 'round-trip'
      : 'one-way',

    returnDate
  };

  // simpan ke localStorage

  localStorage.setItem(
    'flightSearchData',
    JSON.stringify(searchData)
  );

  // redirect

  window.location.href =
    'flight-result.php';

});

</script>

</body>
</html>