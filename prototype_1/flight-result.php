<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Flight Result</title>

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

/* BLOBS */

.blob{
  position:absolute;
  border-radius:50%;
  pointer-events:none;
}

.blob-1{
  width:300px;
  height:300px;

  background:
    radial-gradient(circle,
    rgba(255,255,255,.16) 0%,
    transparent 70%);

  top:-100px;
  right:-90px;
}

.blob-2{
  width:220px;
  height:220px;

  background:
    radial-gradient(circle,
    rgba(255,255,255,.12) 0%,
    transparent 70%);

  left:-80px;
  bottom:80px;
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

  color:white;

  font-size:11px;
  font-weight:600;
}

/* TOPBAR */

.topbar{
  padding:16px 20px;

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

  font-size:17px;
  font-weight:700;

  font-family:'Playfair Display',serif;
}

.empty{
  width:38px;
}

/* SEARCH INFO */

.search-info{
  margin:0 16px;

  padding:18px;

  border-radius:24px;

  background:rgba(255,255,255,.25);

  backdrop-filter:blur(22px);

  border:1px solid rgba(255,255,255,.25);

  color:white;
}

.route{
  font-size:22px;
  font-weight:700;

  margin-bottom:8px;

  font-family:'Playfair Display',serif;
}

.search-detail{
  font-size:12px;
  opacity:.9;

  line-height:1.8;
}

/* RESULT */

.result-head{
  padding:24px 18px 14px;
}

.result-title{
  color:#0c2461;

  font-size:18px;
  font-weight:700;

  font-family:'Playfair Display',serif;
}

/* FLIGHT LIST */

.flight-list{
  padding:0 16px;

  display:flex;
  flex-direction:column;
  gap:14px;
}

/* CARD */

.flight-card{
  background:white;

  border-radius:26px;

  padding:18px;

  box-shadow:
    0 10px 25px rgba(0,0,0,.08);
}

.airline-row{
  display:flex;
  justify-content:space-between;
  align-items:center;

  margin-bottom:18px;
}

.airline{
  display:flex;
  align-items:center;
  gap:10px;
}

.logo{
  width:42px;
  height:42px;

  border-radius:14px;

  background:#EFF6FF;

  display:flex;
  align-items:center;
  justify-content:center;

  font-size:18px;
}

.airline-name{
  font-size:14px;
  font-weight:700;

  color:#0c2461;
}

.flight-type{
  font-size:11px;
  color:#64748b;
}

.price{
  font-size:16px;
  font-weight:700;

  color:#2563EB;
}

/* ROUTE */

.flight-route{
  display:flex;
  justify-content:space-between;
  align-items:center;

  margin-bottom:18px;
}

.time{
  font-size:20px;
  font-weight:700;

  color:#0c2461;
}

.city{
  font-size:12px;
  color:#64748b;

  margin-top:4px;
}

.flight-middle{
  flex:1;

  text-align:center;
}

.line{
  height:2px;

  background:#dbeafe;

  position:relative;

  margin:0 14px;
}

.line::after{
  content:'✈️';

  position:absolute;

  left:50%;
  top:50%;

  transform:translate(-50%,-50%);

  background:white;

  font-size:14px;
}

.duration{
  font-size:11px;
  color:#64748b;

  margin-top:8px;
}

/* FOOTER */

.card-footer{
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.rating{
  font-size:12px;
  font-weight:600;

  color:#0c2461;
}

.book-btn{
  border:none;

  background:#2563EB;
  color:white;

  padding:10px 18px;

  border-radius:14px;

  font-size:12px;
  font-weight:700;

  cursor:pointer;
}

/* EMPTY */

.empty-state{
  margin:40px 20px;

  background:white;

  border-radius:24px;

  padding:30px 20px;

  text-align:center;
}

.empty-state h3{
  color:#0c2461;

  margin-bottom:10px;
}

.empty-state p{
  font-size:13px;
  color:#64748b;

  line-height:1.7;
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

<span>✈️</span>

</div>

<!-- TOPBAR -->

<div class="topbar">

<a href="flight.php" class="back-btn">
←
</a>

<div class="page-title">
Flight Results
</div>

<div class="empty"></div>

</div>

<!-- SEARCH INFO -->

<div class="search-info">

<div class="route" id="routeText">
Surabaya → Bali
</div>

<div class="search-detail" id="searchDetail">
25 May 2026 • 2 Passengers
</div>

</div>

<!-- TITLE -->

<div class="result-head">

<div class="result-title">
Available Flights
</div>

</div>

<!-- RESULT -->

<div
  class="flight-list"
  id="flightList"
>

</div>

</div>

</div>

<script src="db.js"></script>

<script>

const searchData =
  JSON.parse(
    localStorage.getItem('flightSearchData')
  );

if(!searchData){

  window.location.href = 'flight.php';

}

/* SEARCH INFO */

document.getElementById('routeText')
.innerText =
`${searchData.from} → ${searchData.to}`;

document.getElementById('searchDetail')
.innerText =
`${searchData.departureDate} • ${searchData.guest} Passenger(s)`;

/* FILTER DATA */

// const filteredFlights =
//   flightDatabase.filter(flight => {

//     return (

//       flight.origin
//         .toLowerCase()
//         .includes(searchData.from.toLowerCase())

//       &&

//       flight.destination
//         .toLowerCase()
//         .includes(searchData.to.toLowerCase())

//     );

//   });

const filteredFlights =
  flightDatabase.filter(flight => {

    return (

      flight.from
        .toLowerCase()
        .includes(searchData.from.toLowerCase())

      &&

      flight.to
        .toLowerCase()
        .includes(searchData.to.toLowerCase())

    );

  });

/* RENDER */

const flightList =
  document.getElementById('flightList');

if(filteredFlights.length === 0){

  flightList.innerHTML = `

    <div class="empty-state">

      <h3>
        Flight Not Found 😢
      </h3>

      <p>
        Coba ganti kota tujuan atau tanggal keberangkatan kamu.
      </p>

    </div>

  `;

}else{

  filteredFlights.forEach(flight => {

    flightList.innerHTML += `

      <div class="flight-card">

        <div class="airline-row">

          <div class="airline">

            <div class="logo">
              ✈️
            </div>

            <div>

              <div class="airline-name">
                ${flight.airline}
              </div>

              <div class="flight-type">
                ${flight.type}
              </div>

            </div>

          </div>

          <div class="price">
            Rp ${flight.price.toLocaleString('id-ID')}
          </div>

        </div>

        <div class="flight-route">

          <div>

            <div class="time">
              ${flight.departureTime}
            </div>

            <div class="city">
              ${flight.from}
            </div>

          </div>

          <div class="flight-middle">

            <div class="line"></div>

           

          </div>

          <div style="text-align:right;">

            <div class="time">
              ${flight.arrivalTime}
            </div>

            <div class="city">
              ${flight.to}
            </div>

          </div>

        </div>

        <div class="card-footer">

          <div class="rating">
           
          </div>

          <button
            class="book-btn"
            onclick="bookFlight('${flight.id}')"
          >
            Book Now
          </button>

        </div>

      </div>

    `;

  });

}

/* BOOK */

function bookFlight(id){

  const selectedFlight =
    filteredFlights.find(
      flight => flight.id === id
    );

  localStorage.setItem(
    'selectedFlight',
    JSON.stringify(selectedFlight)
  );

  window.location.href =
    'flight-details.php';

}

</script>

</body>
</html>