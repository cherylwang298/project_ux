<?php
session_start();
require '_data.php';
require '_head.php';

$flight_id = (int)($_POST['flight_id'] ?? 0);
$dep_date  = $_POST['dep_date'] ?? date('Y-m-d', strtotime('+1 day'));
$pax_name  = $_POST['pax_name'] ?? '';
$pax_email = $_POST['pax_email'] ?? '';
$pax_phone = $_POST['pax_phone'] ?? '';
$payment   = $_POST['payment_method'] ?? 'ovo';

$fidx = array_search($flight_id, array_column($FLIGHTS, 'id'));
if ($fidx === false) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>'Flight not found']);
  exit;
}
$f = $FLIGHTS[$fidx];

$booking_id = 'FLT-' . strtoupper(substr(md5(time() . $flight_id), 0, 8));

$booking = [
  'booking_id'     => $booking_id,
  'type'           => 'flight',
  'flight_id'      => $flight_id,
  'airline'        => $f['airline'],
  'from'           => $f['from'],
  'from_city'      => $f['from_city'],
  'to'             => $f['to'],
  'to_city'        => $f['to_city'],
  'dep_time'       => $f['dep'],
  'arr_time'       => $f['arr'],
  'dep_date'       => $dep_date,
  'duration'       => $f['duration'],
  'price'          => $f['price'],
  'class'          => $f['class'],
  'pax_name'       => $pax_name,
  'pax_email'      => $pax_email,
  'pax_phone'      => $pax_phone,
  'payment_method' => $payment,
  'status'         => 'confirmed',
  'created_at'     => date('Y-m-d H:i:s'),
];

$_SESSION['booking'] = $booking;
$_SESSION['saved_guest'] = ['name'=>$pax_name,'email'=>$pax_email,'phone'=>$pax_phone];
if (!isset($_SESSION['orders'])) $_SESSION['orders'] = [];
$_SESSION['orders'][] = $booking;

// Check if AJAX
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) || isset($_POST['ajax'])) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>true,'booking_id'=>$booking_id]);
} else {
  // Also accept fetch (no X-Requested-With set)
  header('Content-Type: application/json');
  echo json_encode(['success'=>true,'booking_id'=>$booking_id]);
}
