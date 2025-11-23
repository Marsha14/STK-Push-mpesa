<?php
$callbackJSONData = file_get_contents('php://input');
$callbackData = json_decode($callbackJSONData, true);
$logFile = 'mpesa_callback_log.txt';
file_put_contents($logFile, date('Y-m-d H:i:s') . " - " . $callbackJSONData . "\n", FILE_APPEND);

header('Content-Type: application/json');
echo json_encode(['ResultCode' => 0, 'ResultDesc' => 'Callback received successfully']);
?>
