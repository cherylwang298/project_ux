<?php
session_start();
require '_data.php';
require '_head.php';

$activity_id = (int)($_POST['activity_id'] ?? 0);
$visit_date  = $_POST['visit_date'] ?? date('Y-m-d', strtotime('+1 day'));
$persons     = (int)($_POST['persons'] ?? 1);
$guest_name  = $_POST['guest_name'] ?? '';
$guest_email = $_POST['guest_email'] ?? '';
$guest_phone = $_POST['guest_phone'] ?? '';
$payment     = $_POST['payment_method'] ?? 'ovo';

$aidx = array_search($activity_id, array_column($ACTIVITIES, 'id'));
if ($aidx === false) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>'Activity not found']);
  exit;
}
$act = $ACTIVITIES[$aidx];
$total = $act['price'] * $persons;

$booking_id = 'ACT-' . strtoupper(substr(md5(time() . $activity_id), 0, 8));

$booking = [
  'booking_id'     => $booking_id,
  'type'           => 'activity',
  'activity_id'    => $activity_id,
  'activity_name'  => $act['name'],
  'location'       => $act['location'],
  'visit_date'     => $visit_date,
  'persons'        => $persons,
  'price_per'      => $act['price'],
  'total'          => $total,
  'guest_name'     => $guest_name,
  'guest_email'    => $guest_email,
  'guest_phone'    => $guest_phone,
  'payment_method' => $payment,
  'status'         => 'confirmed',
  'created_at'     => date('Y-m-d H:i:s'),
  'img_emoji'      => $act['img_emoji'],
  'category'       => $act['category'],
];

$_SESSION['booking'] = $booking;
$_SESSION['saved_guest'] = ['name'=>$guest_name,'email'=>$guest_email,'phone'=>$guest_phone];
if (!isset($_SESSION['orders'])) $_SESSION['orders'] = [];
$_SESSION['orders'][] = $booking;

header('Content-Type: application/json');
echo json_encode(['success'=>true,'booking_id'=>$booking_id]);
