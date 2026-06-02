<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Flight Payment</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
body{
  margin:0;
  background:#b8cfe8;
  min-height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  font-family:system-ui;
}

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

.scroll{
  height:100%;
  overflow-y:auto;
  padding:60px 18px 30px;
}

.scroll::-webkit-scrollbar{ display:none; }

/* CARD */
.card{
  background:white;
  border-radius:28px;
  padding:20px;
  box-shadow:0 10px 30px rgba(0,0,0,.12);
}

.label{
  font-size:12px;
  color:#64748b;
  margin-top:12px;
}

.value{
  font-weight:700;
  color:#0f172a;
}

.total{
  font-size:22px;
  color:#2563EB;
  margin-top:4px;
}

.select{
  width:100%;
  height:48px;
  border-radius:14px;
  border:1px solid #e2e8f0;
  padding:0 12px;
  margin-top:16px;
}

.button{
  width:100%;
  height:52px;
  border:none;
  border-radius:16px;
  background:#2563EB;
  color:white;
  font-weight:700;
  margin-top:16px;
}
</style>
</head>

<body>

<div class="phone">
<div class="notch"></div>

<div class="scroll">

<div class="card">

<h1 class="text-xl font-bold mb-4">
✈️ Flight Payment
</h1>

<div class="label">Airline</div>
<div id="airline" class="value"></div>

<div class="label">Route</div>
<div id="route" class="value"></div>

<div class="label">Passengers</div>
<div id="passenger" class="value"></div>

<div class="label">Total Payment</div>
<div id="total" class="total"></div>

<select id="paymentMethod" class="select">
<option value="">Select Payment</option>
<option>Credit Card</option>
<option>Bank Transfer</option>
<option>E-Wallet</option>
</select>

<button class="button" onclick="payNow()">
Pay Now
</button>

</div>

</div>
</div>

<script>
const booking =
  JSON.parse(localStorage.getItem('pendingFlightBooking'));

  console.log('BOOKING:', booking);

if(!booking){
  window.location.href = 'flight.php';
}

document.getElementById('airline').innerText =
  booking.airline;

document.getElementById('route').innerText =
  `${booking.from} → ${booking.to}`;

document.getElementById('passenger').innerText =
  `${booking.passenger} Passenger(s)`;

document.getElementById('total').innerText =
  `Rp ${booking.totalPrice.toLocaleString('id-ID')}`;

async function payNow(){

  const method =
    document.getElementById('paymentMethod').value;

  if(!method){
    alert('Select payment method');
    return;
  }

  const payload = {
    ...booking,
    paymentMethod: method
  };

  const res =
    await fetch('save-flight-booking.php',{
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify(payload)
    });

  const text = await res.text();

  console.log(text);


  const result = JSON.parse(text);

  if(result.success){
    localStorage.removeItem('pendingFlightBooking');
    alert('Payment Successful ✈️');
    window.location.href='flight.php';
  } else {
    alert(result.message || 'Failed');
  }
}
</script>

</body>
</html>