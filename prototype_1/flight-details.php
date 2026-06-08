<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Flight Details</title>

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

/* CARD */

.detail-card{
  margin:0 16px;

  background:rgba(255,255,255,0.42);
  border:1px solid rgba(255,255,255,0.55);
  backdrop-filter:blur(24px);
  -webkit-backdrop-filter:blur(24px);

  border-radius:28px;

  overflow:hidden;

  box-shadow:
    0 18px 40px rgba(0,0,0,.14);
}

.banner{
  height:170px;

  background:
    linear-gradient(
      135deg,
      rgba(13,40,120,.92),
      rgba(37,99,235,.72)
    );

  display:flex;
  align-items:center;
  justify-content:center;

  color:white;

  font-size:60px;
}

.content{
  padding:22px;
}

.airline{
  display:flex;
  justify-content:space-between;
  align-items:center;

  margin-bottom:20px;
}

.airline-name{
  font-size:20px;
  font-weight:700;

  color:#0c2461;
}

.flight-type{
  font-size:12px;
  color:#64748b;

  margin-top:4px;
}

.price{
  font-size:18px;
  font-weight:700;

  color:#2563EB;
}

/* ROUTE */

.route-box{
  background:rgba(255,255,255,0.62);
  border:1px solid rgba(255,255,255,0.65);
  border-radius:20px;
  padding:18px;
  margin-bottom:20px;
}

.route{
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.time{
  font-size:22px;
  font-weight:700;

  color:#0c2461;
}

.city{
  font-size:13px;
  color:#64748b;

  margin-top:4px;
}

.airport{
  font-size:11px;
  color:#94a3b8;

  margin-top:2px;
}

.middle{
  flex:1;
  text-align:center;
}

.line{
  height:2px;

  background:#bfdbfe;

  position:relative;

  margin:0 14px;
}

.line::after{
  content:'✈️';

  position:absolute;

  left:50%;
  top:50%;

  transform:translate(-50%,-50%);

  background:#EFF6FF;
}

.duration{
  margin-top:8px;

  font-size:12px;
  color:#64748b;
}

/* DETAIL */

.detail-list{
  display:flex;
  flex-direction:column;
  gap:14px;

  margin-bottom:24px;
}

.detail-item{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:14px 0;
  border-bottom:1px solid rgba(37,99,235,0.08);
}

.label{
  font-size:13px;
  color:#64748b;
}

.value{
  font-size:14px;
  font-weight:700;

  color:#0c2461;
}

/* BUTTON */

.book-btn{
  width:100%;
  height:56px;

  border:none;
  border-radius:18px;

  background:#2563EB;
  color:white;

  font-size:15px;
  font-weight:700;

  cursor:pointer;

  box-shadow:
    0 10px 20px rgba(37,99,235,.3);
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

<a href="flight-result.php" class="back-btn">
←
</a>

<div class="page-title">
Flight Details
</div>

<div class="empty"></div>

</div>

<!-- CARD -->

<div class="detail-card">

<div class="banner">
✈️
</div>

<div class="content">

<div class="airline">

<div>

<div
  class="airline-name"
  id="airlineName"
></div>

<div
  class="flight-type"
  id="flightType"
></div>

</div>

<div
  class="price"
  id="flightPrice"
></div>

</div>

<!-- ROUTE -->

<div class="route-box">

<div class="route">

<div>

<div
  class="time"
  id="departTime"
></div>

<div
  class="city"
  id="fromCity"
></div>

<div
  class="airport"
  id="fromAirport"
></div>

</div>

<div class="middle">

<div class="line"></div>

<div
  class="duration"
  id="duration"
></div>

</div>

<div style="text-align:right;">

<div
  class="time"
  id="arriveTime"
></div>

<div
  class="city"
  id="toCity"
></div>

<div
  class="airport"
  id="toAirport"
></div>

</div>

</div>

</div>

<!-- DETAILS -->

<div class="detail-list">

<div class="detail-item">

<div class="label">
Flight Date
</div>

<div
  class="value"
  id="flightDate"
></div>

</div>

<div class="detail-item">

<div class="label">
Passengers
</div>

<div
  class="value"
  id="passengerCount"
></div>

</div>

<div class="detail-item">

<div class="label">
Price / Passenger
</div>

<div
  class="value"
  id="pricePerPassenger"
></div>

</div>

<div class="detail-item">

<div class="label">
Subtotal
</div>

<div
  class="value"
  id="subtotalPrice"
></div>

</div>

<div class="detail-item">

<div class="label">
Tax & Service
</div>

<div
  class="value"
  id="taxPrice"
></div>

</div>

<div class="detail-item">

<div class="label">
Total Price
</div>

<div
  class="value"
  id="totalPrice"
  style="
    color:#2563EB;
    font-size:16px;
  "
></div>

</div>

<!-- <div class="detail-item">


</div> -->

<div class="detail-item">

<div class="label">
Trip Type
</div>

<div
  class="value"
  id="tripType"
></div>

</div>

</div>

<!-- <button
  class="book-btn"
  onclick="confirmBooking()"
>
Confirm Booking
</button> -->

<button
  class="book-btn"
  onclick="goToPayment()"
>
Continue to Payment
</button>

</div>

</div>

</div>

</div>

<script src="db.js"></script>

<script>

/* GET DATA */

const selectedFlight =
  JSON.parse(
    localStorage.getItem('selectedFlight')
  );

const searchData =
  JSON.parse(
    localStorage.getItem('flightSearchData')
  );

/* VALIDATION */

if(!selectedFlight || !searchData){

  window.location.href =
    'flight.php';

}

/* PASSENGER */

const passengerCount =
  parseInt(searchData.guest);

/* PRICE */

const pricePerPassenger =
  selectedFlight.price;

const subtotal =
  pricePerPassenger * passengerCount;

const tax =
  Math.round(subtotal * 0.1);

const totalPrice =
  subtotal + tax;

/* SET DATA */

document.getElementById('airlineName')
.innerText =
selectedFlight.airline;

document.getElementById('flightType')
.innerText =
selectedFlight.type;

document.getElementById('flightPrice')
.innerText =
`Rp ${totalPrice.toLocaleString('id-ID')}`;

document.getElementById('departTime')
.innerText =
selectedFlight.departureTime;

document.getElementById('arriveTime')
.innerText =
selectedFlight.arrivalTime;

document.getElementById('fromCity')
.innerText =
selectedFlight.from;

document.getElementById('toCity')
.innerText =
selectedFlight.to;

/* AIRPORT */

document.getElementById('fromAirport')
.innerText =
selectedFlight.fromAirport || '';

document.getElementById('toAirport')
.innerText =
selectedFlight.toAirport || '';

document.getElementById('duration')
.innerText =
selectedFlight.duration;

document.getElementById('flightDate')
.innerText =
searchData.departureDate;

document.getElementById('passengerCount')
.innerText =
`${passengerCount} Passenger(s)`;

document.getElementById('pricePerPassenger')
.innerText =
`Rp ${pricePerPassenger.toLocaleString('id-ID')}`;

document.getElementById('subtotalPrice')
.innerText =
`Rp ${subtotal.toLocaleString('id-ID')}`;

document.getElementById('taxPrice')
.innerText =
`Rp ${tax.toLocaleString('id-ID')}`;

document.getElementById('totalPrice')
.innerText =
`Rp ${totalPrice.toLocaleString('id-ID')}`;

document.getElementById('tripType')
.innerText =
searchData.tripType === 'round-trip'
? 'Round Trip'
: 'One Way';

/* BOOK */

function goToPayment(){

  const bookingData = {

    id:
      selectedFlight.id,

    airline:
      selectedFlight.airline,

    type:
      selectedFlight.type,

    from:
      selectedFlight.from,

    to:
      selectedFlight.to,

    fromAirport:
      selectedFlight.fromAirport,

    toAirport:
      selectedFlight.toAirport,

    departTime:
      selectedFlight.departureTime,

    arriveTime:
      selectedFlight.arrivalTime,

    duration:
      selectedFlight.duration,

    departureDate:
      searchData.departureDate,

    passenger:
      passengerCount,

    pricePerPassenger,

    subtotal,

    tax,

    totalPrice,

    tripType:
      searchData.tripType,

    imageUrl:
      selectedFlight.imageUrl,

    bookedAt:
      new Date().toISOString()

  };

  localStorage.setItem(
    'pendingFlightBooking',
    JSON.stringify(bookingData)
  );

  window.location.href =
    'flight-payment.php';

}

</script>

</body>
</html>