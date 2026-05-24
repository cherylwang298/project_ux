<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Flight Payment</title>

<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen flex justify-center items-center">

<div class="w-[375px] bg-white rounded-3xl p-6 shadow-xl">

<h1 class="text-2xl font-bold mb-6">
Flight Payment
</h1>

<div class="mb-5">

<p class="text-gray-500 text-sm">
Airline
</p>

<h2
  id="airline"
  class="font-bold text-lg"
></h2>

</div>

<div class="mb-5">

<p class="text-gray-500 text-sm">
Route
</p>

<h2
  id="route"
  class="font-semibold"
></h2>

</div>

<div class="mb-5">

<p class="text-gray-500 text-sm">
Passengers
</p>

<h2
  id="passenger"
  class="font-semibold"
></h2>

</div>

<div class="mb-6">

<p class="text-gray-500 text-sm">
Total Payment
</p>

<h2
  id="total"
  class="text-2xl font-bold text-blue-600"
></h2>

</div>

<select
  id="paymentMethod"
  class="w-full h-12 border rounded-xl px-4 mb-6"
>

<option value="">
Select Payment
</option>

<option>
Credit Card
</option>

<option>
Bank Transfer
</option>

<option>
E-Wallet
</option>

</select>

<button
  onclick="payNow()"
  class="w-full h-12 bg-blue-600 rounded-xl text-white font-bold"
>
Pay Now
</button>

</div>

<script>
const booking = JSON.parse(localStorage.getItem('pendingFlightBooking'));

if (!booking) {
  window.location.href = 'flight.php';
}

document.getElementById('airline').innerText = booking.airline;
document.getElementById('route').innerText = `${booking.from} → ${booking.to}`;
document.getElementById('passenger').innerText = `${booking.passenger} Passenger(s)`;
document.getElementById('total').innerText = `Rp ${booking.totalPrice.toLocaleString('id-ID')}`;

// async function payNow() {

//   const paymentMethod = document.getElementById('paymentMethod').value;

//   if (!paymentMethod) {
//     alert('Select payment method');
//     return;
//   }

//   const payload = {
//     ...booking,
//     paymentMethod
//   };

//   try {
//     const res = await fetch('save-flight-booking.php', {
//       method: 'POST',
//       headers: { 'Content-Type': 'application/json' },
//       body: JSON.stringify(payload)
//     });

//     const text = await response.text();
//     console.log("RAW RESPONSE:", text);

//     const result = await res.json();

//     if (result.success) {
//       localStorage.removeItem('pendingFlightBooking');

//       alert('Payment Successful ✈️');

//       window.location.href = 'flight.php';
//     } else {
//       alert(result.message || 'Failed to save booking');
//     }

//   } catch (err) {
//     console.error(err);
//     alert('Server error');
//   }
// }

async function payNow() {

  const paymentMethod = document.getElementById('paymentMethod').value;

  if (!paymentMethod) {
    alert('Select payment method');
    return;
  }

  const payload = {
    ...booking,
    paymentMethod
  };

  const response = await fetch('save-flight-booking.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(payload)
  });

  const text = await response.text();
console.log("RAW RESPONSE:", text);

const result = JSON.parse(text);

  if (result.success) {
    localStorage.removeItem('pendingFlightBooking');

    alert('Payment Successful ✈️');

    window.location.href = 'flight.php';
  } else {
    alert(result.message || 'Failed to save booking');
  }
}


</script>

</body>
</html>