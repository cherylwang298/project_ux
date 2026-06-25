<?php
require 'config.php';
header('Content-Type: application/json');
if (!auth()) { echo json_encode(['active'=>false,'error'=>'Login required']); exit; }
$pid = (int)($_POST['property_id'] ?? 0);
if (!$pid) { echo json_encode(['active'=>false,'error'=>'Invalid']); exit; }
$active = toggleFav($pid);
echo json_encode(['active'=>$active]);
