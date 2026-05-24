<?php require_once 'config.php'; checkLogin();
$id       = (int)($_GET['id'] ?? 0);
$checkin  = $_GET['checkin']  ?? date('Y-m-d', strtotime('+3 days'));
$checkout = $_GET['checkout'] ?? date('Y-m-d', strtotime('+6 days'));
$rooms    = max(1,(int)($_GET['rooms'] ?? 1));
$guests   = max(1,(int)($_GET['guests'] ?? 2));
$nights   = max(1,(int)((strtotime($checkout)-strtotime($checkin))/86400));

$hotel = null;
foreach ($hotels as $h) { if ($h['id'] == $id) { $hotel = $h; break; } }
if (!$hotel) { header('Location: hotel_search.php'); exit; }

$wishlistIds = array_column($_SESSION['wishlist'], 'id');
$inWish = in_array($hotel['id'], $wishlistIds);

// Dummy room types
$roomTypes = [
    ['name'=>'Deluxe King',    'desc'=>'1 King Bed · 1 Sofa · 2 Kamar Mandi Suite', 'price'=>$hotel['price'],      'img'=>'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400&q=80'],
    ['name'=>'Deluxe Twin',    'desc'=>'2 Twin Bed · 1 Sofa · 1 Kamar Mandi Suite', 'price'=>round($hotel['price']*.9), 'img'=>'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?w=400&q=80'],
    ['name'=>'Suite Premium',  'desc'=>'1 King Bed · Ruang Tamu · Jacuzzi',          'price'=>round($hotel['price']*1.6),'img'=>'https://images.unsplash.com/photo-1591088398332-8a7791972843?w=400&q=80'],
];

$amenityIcons = ['Pool'=>'🏊','Spa'=>'💆','WiFi'=>'📶','Breakfast'=>'🍳','Gym'=>'🏋️','Parking'=>'🅿️','Beach'=>'🏖️','Restaurant'=>'🍴','AC'=>'❄️'];

// Handle book room
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_room'])) {
    $roomName  = $_POST['room_name'];
    $roomPrice = (int)$_POST['room_price'];
    $totalPrice = $roomPrice * $rooms * $nights;
    $ticket = [
        'id'          => 'HTL'.rand(10000,99999),
        'booking_code'=> 'SVH'.strtoupper(substr(uniqid(),7)),
        'type'        => 'hotel',
        'hotel'       => $hotel,
        'room_name'   => $roomName,
        'checkin'     => $checkin,
        'checkout'    => $checkout,
        'rooms'       => $rooms,
        'guests'      => $guests,
        'nights'      => $nights,
        'price_per_night'=> $roomPrice,
        'total'       => $totalPrice,
        'payment'     => $_POST['payment_method'] ?? 'bank_bca',
        'booked_at'   => date('d M Y, H:i'),
    ];
    $_SESSION['tickets'][] = $ticket;
    $_SESSION['last_hotel_ticket'] = $ticket;
    header('Location: hotel_booking_success.php'); exit;
}
?>
<?php headHtml('Detail Hotel','
.hotel-hero{position:relative;height:240px;}
.hotel-hero img{width:100%;height:100%;object-fit:cover;}
.hotel-hero .back-fab{position:absolute;top:16px;left:16px;width:36px;height:36px;background:rgba(255,255,255,.85);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;text-decoration:none;}
.hotel-hero .heart-fab{position:absolute;top:16px;right:16px;width:36px;height:36px;background:rgba(255,255,255,.85);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;border:none;cursor:pointer;}
.hotel-info{padding:16px 16px 0;}
.rating-row{display:flex;align-items:center;gap:8px;margin:6px 0;}
.photo-scroll{display:flex;gap:8px;overflow-x:auto;scrollbar-width:none;padding:0 16px;}
.photo-thumb{flex-shrink:0;width:80px;height:60px;border-radius:10px;overflow:hidden;}
.amenity-grid{display:flex;flex-wrap:wrap;gap:8px;padding:0 16px;margin-bottom:16px;}
.amenity-item{display:flex;align-items:center;gap:4px;font-size:12px;background:#F3F4F6;padding:5px 10px;border-radius:40px;}
.room-card{margin:0 16px 12px;border:1px solid var(--border);border-radius:16px;overflow:hidden;}
.room-card img{height:120px;object-fit:cover;width:100%;}
.room-info{padding:12px;}
.room-info h4{font-size:14px;font-weight:700;}
.room-info p{font-size:12px;color:var(--gray);margin-top:2px;}
.room-footer{display:flex;align-items:center;justify-content:space-between;margin-top:10px;}
.sticky-footer{position:fixed;bottom:0;left:0;right:0;background:#fff;border-top:1px solid var(--border);padding:12px 16px;max-width:500px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;z-index:50;}
/* Modal */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:200;justify-content:center;align-items:flex-end;}
.modal-overlay.open{display:flex;}
.modal-box{background:#fff;border-radius:28px 28px 0 0;padding:24px 16px 36px;width:100%;max-width:500px;max-height:85vh;overflow-y:auto;}
.pay-method{display:flex;align-items:center;gap:10px;padding:11px 14px;border:1.5px solid var(--border);border-radius:12px;margin-bottom:8px;cursor:pointer;}
.pay-method.selected{border-color:var(--primary);background:#EEF2FF;}
') ?>
</head>
<body style="padding-bottom:70px;">

<!-- Hero Image (no page-header, use FAB) -->
<div class="hotel-hero">
  <img src="<?= $hotel['img'] ?>" alt="<?= $hotel['name'] ?>">
  <a href="hotel_results.php?city=<?= urlencode($hotel['city']) ?>&checkin=<?= urlencode($checkin) ?>&checkout=<?= urlencode($checkout) ?>&rooms=<?= $rooms ?>&guests=<?= $guests ?>" class="back-fab">←</a>
  <form method="POST" action="wishlist.php" style="margin:0;">
    <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">
    <input type="hidden" name="redirect" value="hotel_detail.php?id=<?= $hotel['id'] ?>&checkin=<?= urlencode($checkin) ?>&checkout=<?= urlencode($checkout) ?>&rooms=<?= $rooms ?>&guests=<?= $guests ?>">
    <button type="submit" name="toggle_wishlist" class="heart-fab"><?= $inWish?'❤️':'🤍' ?></button>
  </form>
</div>

<div class="hotel-info">
  <h2 style="font-size:20px;font-weight:800;"><?= $hotel['name'] ?></h2>
  <div class="rating-row">
    <span style="color:#F59E0B;font-size:13px;"><?= str_repeat('★',$hotel['stars']) ?><span style="color:#D1D5DB;"><?= str_repeat('★',5-$hotel['stars']) ?></span></span>
    <span class="badge badge-primary"><?= $hotel['rating'] ?></span>
    <span style="font-size:12px;color:var(--gray);"><?= number_format($hotel['reviews'],0,',','.') ?> ulasan</span>
  </div>
  <div style="font-size:13px;color:var(--gray);margin-bottom:12px;">📍 <?= $hotel['address'] ?></div>

  <div style="font-size:14px;color:#374151;line-height:1.6;margin-bottom:16px;">
    Hotel berbintang <?= $hotel['stars'] ?> ini menawarkan pengalaman menginap premium di <?= $hotel['city'] ?>. Tersedia berbagai fasilitas kelas dunia untuk kenyamanan tamu.
  </div>
</div>

<!-- Guest photos -->
<div style="padding:0 16px;margin-bottom:8px;"><h3 style="font-size:15px;font-weight:700;">📸 Foto Tamu</h3></div>
<div class="photo-scroll">
  <div class="photo-thumb"><img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=200&q=70" alt="Room"></div>
  <div class="photo-thumb"><img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=200&q=70" alt="Lobby"></div>
  <div class="photo-thumb"><img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=200&q=70" alt="Pool"></div>
  <div class="photo-thumb"><img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?w=200&q=70" alt="View"></div>
  <div class="photo-thumb"><img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=200&q=70" alt="Bed"></div>
</div>

<!-- Amenities -->
<div style="padding:14px 16px 6px;"><h3 style="font-size:15px;font-weight:700;">🏷️ Fasilitas</h3></div>
<div class="amenity-grid">
  <?php foreach ($hotel['amenities'] as $am): ?>
  <div class="amenity-item"><?= $amenityIcons[$am] ?? '✓' ?> <?= $am ?></div>
  <?php endforeach; ?>
</div>

<!-- Room Types -->
<div style="padding:0 16px 10px;"><h3 style="font-size:15px;font-weight:700;">🛏️ Pilih Kamar</h3></div>
<?php foreach ($roomTypes as $rt): ?>
<div class="room-card">
  <img src="<?= $rt['img'] ?>" alt="<?= $rt['name'] ?>">
  <div class="room-info">
    <h4><?= $rt['name'] ?></h4>
    <p><?= $rt['desc'] ?></p>
    <div class="room-footer">
      <div>
        <div style="font-size:18px;font-weight:800;color:var(--primary);">$<?= $rt['price'] ?><span style="font-size:11px;font-weight:400;">/mlm/kamar</span></div>
        <div style="font-size:11px;color:var(--gray);"><?= $rooms ?> kamar × <?= $nights ?> mlm = $<?= $rt['price']*$rooms*$nights ?></div>
      </div>
      <button class="btn-sm btn-primary" onclick="openBookModal('<?= addslashes($rt['name']) ?>',<?= $rt['price'] ?>)">Pesan</button>
    </div>
  </div>
</div>
<?php endforeach; ?>

<div style="height:20px;"></div>

<!-- Sticky Footer -->
<div class="sticky-footer">
  <div>
    <div style="font-size:11px;color:var(--gray);"><?= date('d M',strtotime($checkin)) ?> – <?= date('d M',strtotime($checkout)) ?> · <?= $rooms ?> kamar</div>
    <div style="font-size:18px;font-weight:800;color:var(--primary);">$<?= $hotel['price'] ?>/mlm</div>
  </div>
  <button class="btn btn-primary" style="width:auto;padding:12px 24px;" onclick="openBookModal('Deluxe King',<?= $hotel['price'] ?>)">Pesan Sekarang</button>
</div>

<!-- Booking Modal -->
<div class="modal-overlay" id="bookModal">
  <div class="modal-box">
    <h3 style="font-size:18px;font-weight:800;margin-bottom:4px;">Konfirmasi Pemesanan</h3>
    <p id="modalRoomName" style="color:var(--gray);font-size:13px;margin-bottom:16px;"></p>
    <div style="background:#F9FAFB;border-radius:14px;padding:14px;margin-bottom:16px;">
      <div style="display:flex;justify-content:space-between;font-size:13px;padding:4px 0;"><span style="color:var(--gray);">Check-in</span><span><?= date('D, d M Y',strtotime($checkin)) ?></span></div>
      <div style="display:flex;justify-content:space-between;font-size:13px;padding:4px 0;"><span style="color:var(--gray);">Check-out</span><span><?= date('D, d M Y',strtotime($checkout)) ?></span></div>
      <div style="display:flex;justify-content:space-between;font-size:13px;padding:4px 0;"><span style="color:var(--gray);">Kamar</span><span><?= $rooms ?> kamar · <?= $guests ?> tamu · <?= $nights ?> mlm</span></div>
      <hr style="margin:8px 0;border-color:var(--border);">
      <div style="display:flex;justify-content:space-between;font-size:16px;font-weight:800;color:var(--primary);"><span>Total</span><span id="modalTotal">$0</span></div>
    </div>
    <form method="POST">
      <input type="hidden" name="book_room" value="1">
      <input type="hidden" name="room_name" id="modalRoomInput">
      <input type="hidden" name="room_price" id="modalPriceInput">
      <p style="font-size:13px;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:.04em;margin-bottom:8px;">Pembayaran</p>
      <?php foreach (['bank_bca','gopay','ovo','cc_visa','paylater'] as $k): ?>
      <label class="pay-method" onclick="selectPay(this)">
        <input type="radio" name="payment_method" value="<?= $k ?>" <?= $k==='bank_bca'?'checked':'' ?>>
        <div style="font-size:20px;width:28px;"><?= $paymentMethods[$k]['icon'] ?></div>
        <div style="font-size:14px;"><?= $paymentMethods[$k]['label'] ?></div>
      </label>
      <?php endforeach; ?>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:16px;">
        <button type="button" class="btn btn-outline" onclick="closeBookModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Bayar →</button>
      </div>
    </form>
  </div>
</div>

<script>
let currentRooms=<?= $rooms ?>, currentNights=<?= $nights ?>;
function openBookModal(name, price){
  document.getElementById('bookModal').classList.add('open');
  document.getElementById('modalRoomName').textContent=name+' – $'+price+'/mlm';
  document.getElementById('modalRoomInput').value=name;
  document.getElementById('modalPriceInput').value=price;
  document.getElementById('modalTotal').textContent='$'+(price*currentRooms*currentNights);
}
function closeBookModal(){document.getElementById('bookModal').classList.remove('open');}
function selectPay(el){
  document.querySelectorAll('.pay-method').forEach(e=>e.classList.remove('selected'));
  el.classList.add('selected'); el.querySelector('input').checked=true;
}
document.querySelectorAll('.pay-method')[0]?.classList.add('selected');
document.getElementById('bookModal').addEventListener('click',function(e){if(e.target===this)closeBookModal();});
</script>
</body>
</html>