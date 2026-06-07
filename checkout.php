<?php
require 'config.php';
requireAuth();

$user = auth();

function checkout_param(string $key, string $default = ''): string {
    $value = $_GET[$key] ?? $_POST[$key] ?? $default;
    if (is_array($value)) $value = reset($value);
    $value = trim((string)$value);
    return $value !== '' ? $value : $default;
}
function checkout_nights(string $start, string $end): int {
    $s = strtotime($start); $e = strtotime($end);
    if (!$s || !$e || $e <= $s) return 1;
    return max(1, (int)ceil(($e - $s) / 86400));
}
function checkout_money($value): float {
    if (is_array($value)) $value = reset($value);
    return max(0, (float)$value);
}
function checkout_profiles(int $userId): array {
    if (!isset($_SESSION['guest_profiles'])) $_SESSION['guest_profiles'] = [];
    if (!isset($_SESSION['guest_profiles'][$userId])) $_SESSION['guest_profiles'][$userId] = [];
    if (empty($_SESSION['guest_profiles'][$userId])) {
        $u = auth();
        $_SESSION['guest_profiles'][$userId][] = [
            'id' => 'PROFILE-MAIN',
            'label' => 'Main Profile',
            'name' => $u['name'] ?? '',
            'email' => $u['email'] ?? '',
            'phone' => $u['phone'] ?? '',
        ];
    }
    return $_SESSION['guest_profiles'][$userId];
}
function checkout_profile_by_id(int $userId, string $profileId): ?array {
    foreach (checkout_profiles($userId) as $p) {
        if (($p['id'] ?? '') === $profileId) return $p;
    }
    return null;
}
function checkout_selected_profile(int $userId, string $slot): ?array {
    $map = $_SESSION['selected_guest_profile'][$userId] ?? [];
    $profileId = $map[$slot] ?? '';
    return $profileId ? checkout_profile_by_id($userId, $profileId) : null;
}
function current_checkout_url(): string {
    return basename($_SERVER['PHP_SELF']) . '?' . ($_SERVER['QUERY_STRING'] ?? '');
}

$type = strtolower(checkout_param('type'));
$id = (int)checkout_param('id', '0');

$checkin = checkout_param('checkin', date('Y-m-d', strtotime('+2 days')));
$checkoutDate = checkout_param('checkout', date('Y-m-d', strtotime('+5 days')));
$guests = max(1, min(20, (int)checkout_param('guests', '1')));

$seatClass = strtolower(checkout_param('class', 'economy'));
if (!in_array($seatClass, ['economy', 'business'], true)) $seatClass = 'economy';
$pax = max(1, min(9, (int)checkout_param('pax', (string)$guests)));
$flightDate = checkout_param('date', date('Y-m-d', strtotime('+3 days')));
$tripType = strtolower(checkout_param('trip', checkout_param('trip_type', 'one_way')));
$isRoundTrip = in_array($tripType, ['round_trip', 'roundtrip', 'round-trip', 'round'], true);
$returnDate = checkout_param('return_date', date('Y-m-d', strtotime($flightDate . ' +3 days')));
$returnTime = checkout_param('return_time', '18:00');

$roomName = checkout_param('room_name', checkout_param('room', ''));
$roomPrice = checkout_money(checkout_param('room_price', '0'));
$roomBed = checkout_param('room_bed', '');
$roomSize = checkout_param('room_size', '');
$roomMaxGuests = (int)checkout_param('room_max_guests', (string)$guests);
$roomAmenities = $_GET['room_amenities'] ?? $_POST['room_amenities'] ?? [];
if (!is_array($roomAmenities)) $roomAmenities = [$roomAmenities];

$item = null;
$pricePerUnit = 0;
$nights = 0;

if ($type === 'flight') {
    $item = getFlight($id);
    if (!$item) { flashSet('error', 'Flight not found.'); header('Location: flight.php'); exit; }
    $pricePerUnit = $seatClass === 'business'
        ? (float)($item['price_business'] ?? $item['price_economy'] ?? 0)
        : (float)($item['price_economy'] ?? 0);
    $base = $pricePerUnit * $pax * ($isRoundTrip ? 2 : 1);
} else {
    $item = getProperty($id);
    if (!$item || !in_array($type, ['hotel', 'villa'], true) || ($item['type'] ?? '') !== $type) {
        flashSet('error', 'Accommodation not found.'); header('Location: home.php'); exit;
    }
    if (strtotime($checkoutDate) <= strtotime($checkin)) $checkoutDate = date('Y-m-d', strtotime($checkin . ' +1 day'));
    $nights = checkout_nights($checkin, $checkoutDate);
    $pricePerUnit = ($type === 'hotel' && $roomPrice > 0) ? $roomPrice : (float)($item['price_per_night'] ?? 0);
    $base = $pricePerUnit * $nights;
}

$tax = $base * 0.11;
$total = $base + $tax;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentMethod = $_POST['payment_method'] ?? 'bank_transfer';
    $specialRequests = trim((string)($_POST['special_requests'] ?? ''));
    $finalTotal = checkout_money($_POST['final_total'] ?? $total);

    $guestName = trim((string)($_POST['guest_name'] ?? ''));
    $guestEmail = trim((string)($_POST['guest_email'] ?? ''));
    $guestPhone = trim((string)($_POST['guest_phone'] ?? ''));
    $passengers = null;

    if ($type === 'flight') {
        $passengers = [];
        $names = $_POST['passenger_name'] ?? [];
        $emails = $_POST['passenger_email'] ?? [];
        $phones = $_POST['passenger_phone'] ?? [];
        if (!is_array($names)) $names = [];
        if (!is_array($emails)) $emails = [];
        if (!is_array($phones)) $phones = [];

        for ($i = 0; $i < $pax; $i++) {
            $pName = trim((string)($names[$i] ?? ''));
            $pEmail = trim((string)($emails[$i] ?? ''));
            $pPhone = trim((string)($phones[$i] ?? ''));
            if ($pName === '') $errors[] = 'Passenger ' . ($i + 1) . ' name is required.';
            if ($pEmail !== '' && !filter_var($pEmail, FILTER_VALIDATE_EMAIL)) $errors[] = 'Passenger ' . ($i + 1) . ' email is invalid.';
            $passengers[] = ['name' => $pName, 'email' => $pEmail, 'phone' => $pPhone];
        }
        $guestName = $passengers[0]['name'] ?? ($user['name'] ?? '');
        $guestEmail = $passengers[0]['email'] ?? ($user['email'] ?? '');
        $guestPhone = $passengers[0]['phone'] ?? ($user['phone'] ?? '');
    } else {
        if ($guestName === '') $errors[] = 'Guest name is required.';
        if (!filter_var($guestEmail, FILTER_VALIDATE_EMAIL)) $errors[] = 'Guest email is invalid.';
        if ($guestPhone === '') $errors[] = 'Guest phone is required.';
    }
    if ($finalTotal <= 0) $errors[] = 'Total is invalid.';

    if (!$errors) {
        $refPrefix = $type === 'flight' ? 'SGF' : ($type === 'hotel' ? 'SGH' : 'SGV');
        $ref = generateRef($refPrefix);
        $booking = [
            'id' => count(getAllBookings()) + 1,
            'user_id' => (int)$user['id'],
            'booking_type' => $type,
            'property_id' => $type !== 'flight' ? $id : null,
            'flight_id' => $type === 'flight' ? $id : null,
            'booking_ref' => $ref,
            'guest_name' => $guestName,
            'guest_email' => $guestEmail,
            'guest_phone' => $guestPhone,
            'check_in' => $type !== 'flight' ? $checkin : null,
            'check_out' => $type !== 'flight' ? $checkoutDate : null,
            'flight_date' => $type === 'flight' ? $flightDate : null,
            'trip_type' => $type === 'flight' ? ($isRoundTrip ? 'round_trip' : 'one_way') : null,
            'return_date' => $type === 'flight' && $isRoundTrip ? $returnDate : null,
            'return_departure_time' => $type === 'flight' && $isRoundTrip ? $returnTime : null,
            'return_arrival_time' => $type === 'flight' && $isRoundTrip ? date('H:i', strtotime($returnTime) + 125 * 60) : null,
            'seat_class' => $type === 'flight' ? $seatClass : null,
            'guests' => $type === 'flight' ? $pax : $guests,
            'pax' => $type === 'flight' ? $pax : null,
            'passengers' => $type === 'flight' ? $passengers : null,
            'room' => $type === 'hotel' && $roomName !== '' ? [
                'name' => $roomName,
                'price' => $roomPrice,
                'bed' => $roomBed,
                'size' => $roomSize,
                'max_guests' => $roomMaxGuests,
                'amenities' => array_values(array_filter($roomAmenities)),
            ] : null,
            'room_type' => $type === 'hotel' ? $roomName : null,
            'room_price' => $type === 'hotel' ? $roomPrice : null,
            'total_amount' => $finalTotal,
            'payment_method' => $paymentMethod,
            'status' => 'confirmed',
            'special_requests' => $specialRequests,
            'created_at' => date('Y-m-d H:i:s'),
            '_item' => $item,
        ];
        saveBooking($booking);
        flashSet('success', 'Booking confirmed! Ref: ' . $ref);
        $receipt = $type === 'flight' ? 'resi_penerbangan.php' : 'resi_villa.php';
        session_write_close();
        header('Location: ' . $receipt . '?ref=' . urlencode($ref) . '&done=1&t=' . time(), true, 303);
        exit;
    }
}

$profiles = checkout_profiles((int)$user['id']);
$returnUrl = current_checkout_url();

$itemName = $type === 'flight'
    ? (($item['airline'] ?? 'Flight') . ' · ' . ($item['from_code'] ?? '-') . ' → ' . ($item['to_code'] ?? '-'))
    : ($item['name'] ?? 'Accommodation');
$itemLocation = $type === 'flight' ? (($item['from_city'] ?? '-') . ' → ' . ($item['to_city'] ?? '-')) : ($item['location'] ?? '-');
$itemImage = $type === 'flight' ? 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1200&q=80' : ($item['image_url'] ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&q=80');
$typeLabel = match($type) { 'hotel' => 'Hotel', 'villa' => 'Villa', 'flight' => 'Flight', default => 'Booking' };
$unitLabel = $type === 'flight'
    ? formatRupiah($pricePerUnit) . ' × ' . $pax . ' passenger' . ($pax > 1 ? 's' : '') . ($isRoundTrip ? ' × round trip' : '')
    : formatRupiah($pricePerUnit) . ' × ' . $nights . ' night' . ($nights > 1 ? 's' : '');

echo htmlHead('Checkout', <<<CSS
.checkout-card{background:rgba(255,255,255,.86);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border:1px solid rgba(195,197,216,.42);box-shadow:0 22px 70px rgba(0,76,226,.10)}
.input-field{width:100%;height:48px;border-radius:14px;background:rgba(246,248,255,.82);border:1.5px solid rgba(195,197,216,.8);padding:0 14px;outline:none}.textarea-field{width:100%;min-height:90px;border-radius:16px;background:rgba(246,248,255,.82);border:1.5px solid rgba(195,197,216,.8);padding:14px;outline:none}.input-field:focus,.textarea-field:focus{border-color:#004ce2;box-shadow:0 0 0 3px rgba(0,76,226,.10)}
.summary-card{background:rgba(255,255,255,.9);backdrop-filter:blur(30px);-webkit-backdrop-filter:blur(30px);border:1px solid rgba(195,197,216,.42);box-shadow:0 20px 70px rgba(0,76,226,.12)}
.choose-btn{height:42px;border-radius:999px;background:#004ce2;color:#fff;font-size:12px;font-weight:800;display:inline-flex;align-items:center;gap:6px;padding:0 16px}.summary-book-btn{width:100%;height:56px;border-radius:999px;background:linear-gradient(90deg,#004ce2,#00c9ed);color:white;font-weight:900;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 14px 28px rgba(0,76,226,.22)}
CSS);
?>
<body class="bg-background text-on-background min-h-screen">
<?= navbar('checkout.php') ?><?= renderFlash() ?>
<main class="pt-28 pb-20 px-5 md:px-16 max-w-[1280px] mx-auto">
  <a href="javascript:history.back()" class="inline-flex items-center gap-2 text-primary font-bold mb-6"><span class="material-symbols-outlined text-[18px]">arrow_back</span>Back</a>
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    <section class="lg:col-span-2 checkout-card rounded-[2rem] p-6 md:p-8">
      <div class="flex items-center gap-3 mb-6"><div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center"><span class="material-symbols-outlined text-primary"><?= $type === 'flight' ? 'flight_takeoff' : 'person' ?></span></div><div><h1 class="text-2xl font-extrabold text-on-surface"><?= $type === 'flight' ? 'Passenger Details' : 'Guest Details' ?></h1><p class="text-sm text-on-surface-variant">Complete your booking information.</p></div></div>
      <?php if (!empty($errors)): ?><div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-4 text-red-700 text-sm font-semibold"><?php foreach($errors as $e): ?><p>• <?= h($e) ?></p><?php endforeach; ?></div><?php endif; ?>
      <form method="POST" id="checkoutForm" class="space-y-6">
        <input type="hidden" name="final_total" value="<?= h((string)$total) ?>">
        <?php if ($type === 'flight'): ?>
          <div class="space-y-5">
            <?php for($i=0;$i<$pax;$i++): $slot='passenger_'.$i; $sel=checkout_selected_profile((int)$user['id'],$slot); ?>
            <div class="rounded-3xl border border-outline-variant/40 bg-white/60 p-5">
              <div class="flex items-center justify-between gap-3 mb-4"><h2 class="font-extrabold text-on-surface">Passenger <?= $i+1 ?></h2><a class="choose-btn" href="guest_profiles.php?slot=<?= h($slot) ?>&return=<?= urlencode($returnUrl) ?>"><span class="material-symbols-outlined text-[16px]">badge</span><?= $sel ? 'Change saved data' : 'Choose saved data' ?></a></div>
              <?php if ($sel): ?><div class="mb-4 rounded-2xl bg-primary-fixed/60 p-3 text-sm"><p class="font-extrabold text-on-surface"><?= h($sel['name'] ?? '') ?></p><p class="text-outline text-xs"><?= h($sel['email'] ?? '') ?> · <?= h($sel['phone'] ?? '') ?></p></div><?php endif; ?>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div class="md:col-span-2"><label class="text-xs font-extrabold text-outline uppercase">Full Name *</label><input class="input-field mt-1" name="passenger_name[]" value="<?= h($sel['name'] ?? '') ?>" placeholder="Passenger full name" required></div><div><label class="text-xs font-extrabold text-outline uppercase">Email</label><input class="input-field mt-1" name="passenger_email[]" value="<?= h($sel['email'] ?? '') ?>" placeholder="email@example.com"></div><div><label class="text-xs font-extrabold text-outline uppercase">Phone</label><input class="input-field mt-1" name="passenger_phone[]" value="<?= h($sel['phone'] ?? '') ?>" placeholder="+62..."></div></div>
            </div>
            <?php endfor; ?>
          </div>
        <?php else: $sel=checkout_selected_profile((int)$user['id'],'guest') ?: ['name'=>$user['name']??'', 'email'=>$user['email']??'', 'phone'=>$user['phone']??'']; ?>
          <div class="rounded-3xl border border-outline-variant/40 bg-white/60 p-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4"><div><h2 class="font-extrabold text-on-surface">Guest Data</h2><p class="text-xs text-outline">Choose saved guest data like choosing an address.</p></div><a class="choose-btn" href="guest_profiles.php?slot=guest&return=<?= urlencode($returnUrl) ?>"><span class="material-symbols-outlined text-[16px]">badge</span>Choose saved data</a></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div class="md:col-span-2"><label class="text-xs font-extrabold text-outline uppercase">Full Name *</label><input class="input-field mt-1" name="guest_name" value="<?= h($sel['name'] ?? '') ?>" required></div><div><label class="text-xs font-extrabold text-outline uppercase">Email *</label><input class="input-field mt-1" name="guest_email" value="<?= h($sel['email'] ?? '') ?>" required></div><div><label class="text-xs font-extrabold text-outline uppercase">Phone *</label><input class="input-field mt-1" name="guest_phone" value="<?= h($sel['phone'] ?? '') ?>" required></div><div class="md:col-span-2"><label class="text-xs font-extrabold text-outline uppercase">Special Requests</label><textarea class="textarea-field mt-1" name="special_requests" placeholder="Late check-in, extra bed, etc."></textarea></div></div>
          </div>
        <?php endif; ?>
        <section><h2 class="text-lg font-extrabold text-on-surface mb-3">Payment Method</h2><div class="grid grid-cols-2 md:grid-cols-5 gap-3"><?php foreach(['bank_transfer'=>'Bank','qris'=>'QRIS','gopay'=>'GoPay','ovo'=>'OVO','credit_card'=>'Card'] as $value=>$label): ?><label class="cursor-pointer"><input type="radio" name="payment_method" value="<?= h($value) ?>" class="peer hidden" <?= $value==='bank_transfer'?'checked':'' ?>><div class="h-14 rounded-2xl border border-outline-variant/50 bg-white/70 flex items-center justify-center text-sm font-bold peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary transition-all"><?= h($label) ?></div></label><?php endforeach; ?></div></section>
      </form>
    </section>

    <aside class="summary-card rounded-[2rem] p-6 lg:sticky lg:top-24">
      <div class="rounded-3xl overflow-hidden mb-5"><img src="<?= h($itemImage) ?>" class="w-full h-48 object-cover" alt="<?= h($itemName) ?>"></div>
      <div class="mb-5"><span class="inline-flex px-3 py-1 rounded-full bg-primary-fixed text-primary text-xs font-bold mb-3"><?= h($typeLabel) ?></span><h2 class="text-xl font-extrabold text-on-surface leading-tight"><?= h($itemName) ?></h2><p class="text-sm text-on-surface-variant mt-1 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">location_on</span><?= h($itemLocation) ?></p><?php if($type==='hotel' && $roomName!==''): ?><div class="mt-3 rounded-2xl bg-primary-fixed/60 p-3"><p class="text-xs text-outline">Selected Room</p><p class="font-extrabold text-on-surface"><?= h($roomName) ?></p><p class="text-xs text-outline"><?= h($roomBed) ?> <?= $roomSize ? '· '.h($roomSize) : '' ?></p></div><?php endif; ?></div>
      <div class="space-y-3 text-sm border-t border-outline-variant/30 pt-5">
        <?php if($type==='flight'): ?><div class="flex justify-between text-on-surface-variant"><span>Flight Date</span><span><?= h(date('d M Y', strtotime($flightDate))) ?></span></div><div class="flex justify-between text-on-surface-variant"><span>Trip</span><span><?= $isRoundTrip?'Round Trip':'One Way' ?></span></div><?php if($isRoundTrip): ?><div class="flex justify-between text-on-surface-variant"><span>Return</span><span><?= h(date('d M Y', strtotime($returnDate))) ?> · <?= h($returnTime) ?></span></div><?php endif; ?><?php else: ?><div class="flex justify-between text-on-surface-variant"><span>Check-in</span><span><?= h(date('d M Y', strtotime($checkin))) ?></span></div><div class="flex justify-between text-on-surface-variant"><span>Check-out</span><span><?= h(date('d M Y', strtotime($checkoutDate))) ?></span></div><div class="flex justify-between text-on-surface-variant"><span>Guests</span><span><?= $guests ?></span></div><?php endif; ?>
        <div class="flex justify-between text-on-surface-variant"><span><?= h($unitLabel) ?></span><span><?= formatRupiah($base) ?></span></div><div class="flex justify-between text-on-surface-variant"><span>Tax 11%</span><span><?= formatRupiah($tax) ?></span></div><div class="pt-3 border-t border-outline-variant/30 flex justify-between items-center"><span class="text-lg font-extrabold text-on-surface">Total</span><span class="text-2xl font-extrabold text-primary"><?= formatRupiah($total) ?></span></div>
      </div>
      <button type="submit" form="checkoutForm" class="summary-book-btn mt-6"><span class="material-symbols-outlined text-[20px]">check_circle</span>Confirm Booking</button>
    </aside>
  </div>
</main>
</body></html>
