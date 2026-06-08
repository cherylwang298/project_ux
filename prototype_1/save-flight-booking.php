<?php

header('Content-Type: application/json');

// MATIKAN WARNING jadi JSON tetap bersih
error_reporting(0);

$rawInput = file_get_contents("php://input");
// Simpan log mentah untuk debugging ketika dipanggil dari browser
@file_put_contents('save-flight-debug.log', date('c') . " RAW_INPUT: " . $rawInput . PHP_EOL, FILE_APPEND);

$data = json_decode($rawInput, true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "No data received"
    ]);
    exit;
}

$file = 'bookings.json';

$bookings = [];

if (file_exists($file)) {
    $bookings = json_decode(file_get_contents($file), true);
    if (!is_array($bookings)) {
        $bookings = [];
    }
}

$newBooking = [
    "type" => "flight",
    "id" => $data["id"] ?? null,
    "airline" => $data["airline"] ?? null,
    "from" => $data["from"] ?? null,
    "to" => $data["to"] ?? null,
    "fromAirport" => $data["fromAirport"] ?? null,
    "toAirport" => $data["toAirport"] ?? null,
    "departureDate" => $data["departureDate"] ?? null,
    "departureTime" => $data["departTime"] ?? null,
    "arrivalTime" => $data["arriveTime"] ?? null,
    "passenger" => $data["passenger"] ?? null,
    "pricePerPassenger" => $data["pricePerPassenger"] ?? null,
    "subtotal" => $data["subtotal"] ?? null,
    "tax" => $data["tax"] ?? null,
    "totalPrice" => $data["totalPrice"] ?? null,
    "total" => $data["grandTotal"] ?? $data["totalPrice"] ?? null,
    "promoCode" => $data["promoCode"] ?? null,
    "promoTitle" => $data["promoTitle"] ?? null,
    "promoDiscount" => $data["promoDiscount"] ?? null,
    "discountAmount" => $data["discountAmount"] ?? null,
    "grandTotal" => $data["grandTotal"] ?? null,
    "paymentMethod" => $data["paymentMethod"] ?? null,
    "bookedAt" => $data["bookedAt"] ?? null
];

$bookings[] = $newBooking;

file_put_contents($file, json_encode($bookings, JSON_PRETTY_PRINT));

echo json_encode([
    "success" => true
]);
exit;