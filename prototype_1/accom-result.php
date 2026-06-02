<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Accommodation Results</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>

/* BASE */
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

/* PHONE */
.phone{
  width:375px;
  height:812px;
  border-radius:44px;
  border:9px solid #18181b;
  overflow:hidden;
  position:relative;
  background:linear-gradient(165deg,#1e57b8,#2563EB,#C5DEFF);
  box-shadow:0 40px 80px rgba(0,0,0,.35);
}

/* BLOBS */
.blob{
  position:absolute;
  border-radius:50%;
  pointer-events:none;
}

.blob-1{
  width:280px;
  height:280px;
  background:radial-gradient(circle,rgba(255,255,255,.15),transparent 70%);
  top:-100px;
  right:-80px;
}

.blob-2{
  width:200px;
  height:200px;
  background:radial-gradient(circle,rgba(255,255,255,.12),transparent 70%);
  bottom:80px;
  left:-60px;
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
  z-index:10;
}

/* SCROLL */
.scroll{
  height:100%;
  overflow-y:auto;
  padding-bottom:40px;
  position:relative;
  z-index:2;
}

.scroll::-webkit-scrollbar{ display:none; }

/* STATUS */
.statusbar{
  padding:42px 24px 0;
  display:flex;
  justify-content:space-between;
  color:white;
  font-size:11px;
}

/* TOP */
.topbar{
  padding:14px 20px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.page-title{
  color:white;
  font-weight:700;
  font-size:17px;
}

/* SEARCH INFO */
.search-info{
  margin:0 16px;
  padding:18px;
  border-radius:24px;
  background:rgba(255,255,255,.2);
  backdrop-filter:blur(18px);
  color:white;
}

.route{
  font-size:20px;
  font-weight:700;
  margin-bottom:6px;
}

.detail{
  font-size:12px;
  opacity:.9;
}

/* SECTION */
.section-title{
  padding:20px 16px 10px;
  color:#0c2461;
  font-size:16px;
  font-weight:700;
}

/* LIST */
.list{
  padding:0 16px;
  display:flex;
  flex-direction:column;
  gap:14px;
}

/* CARD */
.card{
  background:white;
  border-radius:24px;
  overflow:hidden;
  box-shadow:0 10px 25px rgba(0,0,0,.1);
  cursor:pointer;
}

.card img{
  width:100%;
  height:140px;
  object-fit:cover;
}

/* CONTENT */
.content{
  padding:14px;
}

.name{
  font-size:15px;
  font-weight:700;
  color:#0c2461;
  margin-bottom:4px;
}

.loc{
  font-size:12px;
  color:#64748b;
  margin-bottom:10px;
}

/* META */
.meta{
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.price{
  font-weight:700;
  color:#2563EB;
}

.rating{
  font-size:12px;
  color:#0c2461;
}

/* FACILITY */
.facilities{
  display:flex;
  gap:6px;
  flex-wrap:wrap;
  margin-top:10px;
}

.badge{
  font-size:10px;
  padding:4px 8px;
  background:#EFF6FF;
  color:#2563EB;
  border-radius:999px;
}

/* BUTTON */
.btn{
  margin-top:12px;
  width:100%;
  height:38px;
  border:none;
  border-radius:12px;
  background:#2563EB;
  color:white;
  font-weight:700;
  font-size:12px;
}
</style>
</head>

<body>

<div class="phone">

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="notch"></div>

<div class="scroll">

<!-- STATUS -->
<div class="statusbar">
  <span>9:41</span>
  <!-- <span>🏨</span> -->
</div>

<!-- TITLE -->
<div class="topbar">

  <a href="accom.php" class="back-btn">
    ←
  </a>

  <div class="page-title">
    Accommodation Results
  </div>

  <div style="width:38px;"></div>

</div>

<!-- SEARCH INFO -->
<div class="search-info">

<div class="route" id="routeText">
Search Result
</div>

<div class="detail" id="detailText">
Loading...
</div>

</div>

<div class="section-title text-white">
Available Stays
</div>

<div class="list" id="list"></div>

</div>
</div>

<script src="db.js"></script>

<script>

const data =
  JSON.parse(localStorage.getItem('accomSearch')) || {};

/* SEARCH INFO */
document.getElementById('routeText').innerText =
  data.destination || "All Destinations";

document.getElementById('detailText').innerText =
  `${data.checkin || '-'} → ${data.checkout || '-'} • ${data.guest || 0} Guest`;

/* DATA */
let results = villaDatabase;

/* FILTER */
if(data.destination){
  results = results.filter(v =>
    v.city.toLowerCase().includes(
      data.destination.toLowerCase()
    )
  );
}

/* RENDER */
const list = document.getElementById('list');

results.forEach(r => {

  const el = document.createElement('div');
  el.className = "card";

  el.innerHTML = `
    <img src="${r.imageUrl}">
    <div class="content">

      <div class="name">${r.name}</div>
      <div class="loc">📍 ${r.locationDetail}</div>

      <div class="meta">
        <div class="price">
          Rp ${r.pricePerNight.toLocaleString('id-ID')}
        </div>
        <div class="rating">
          ⭐ ${r.rating}
        </div>
      </div>

      <div class="facilities">
        ${r.facilities.map(f =>
          `<div class="badge">${f}</div>`
        ).join('')}
      </div>

      <button class="btn">
        View Details
      </button>

    </div>
  `;

  el.onclick = () => {

    localStorage.setItem(
      'selectedAccom',
      JSON.stringify(r)
    );

    window.location.href = `accom_detail.php?id=${r.id}`;

  };

  list.appendChild(el);

});

</script>

</body>
</html>