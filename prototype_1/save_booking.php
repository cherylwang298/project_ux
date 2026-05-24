<?php

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid JSON"
    ]);
    exit;
}

$file = 'bookings.json';

$currentData = file_exists($file)
    ? json_decode(file_get_contents($file), true)
    : [];

// =========================
// 🔥 TAMBAHKAN DEFAULT TYPE
// =========================
if (!isset($data['type'])) {
    $data['type'] = 'villa';
}

$currentData[] = $data;

file_put_contents(
    $file,
    json_encode($currentData, JSON_PRETTY_PRINT)
);

echo json_encode([
    "status" => "success",
    "data" => $data
]);