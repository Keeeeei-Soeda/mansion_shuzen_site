<?php
// 送信先は自分のGASウェブアプリURL
$gas_url = 'https://script.google.com/macros/s/AKfycbyYbbG0EiyX3Nu-JvtPFvgO8K4GI5zuOgK9FiBwvzlbpGLrGcDNRFvuye6XExo9YuAWQw/exec'; // ←書き換えOK

// ダミーデータ
$data = [
    'age' => 10,
    'units' => 20,
    'area' => 30
];

$ch = curl_init($gas_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $response;
?>
