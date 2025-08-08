<?php
header('Access-Control-Allow-Origin: *'); // ← どこからのアクセスも許可（CORS対応）
header('Access-Control-Allow-Headers: Content-Type');

// 1. GASウェブアプリのURLをセット
$gas_url = 'https://script.google.com/macros/s/AKfycbzkll4ltcudd6mXBdoeRa8T5gr5Ot-a-YdeCmPnWYS9gZOuoTXJ2xSoniVFjGlCVAp2/exec'; // ← ここを自分のGASのURLに変えてください

// 2. 受け取ったJSONデータをGASにそのままPOST転送
$ch = curl_init($gas_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('php://input'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // ★ここを追加

$response = curl_exec($ch);

// 3. レスポンスをそのままフロントに返す
// デバッグ用ログ（必ず追加！）
error_log("=== GASからのレスポンス ===\n" . print_r($response, true));

if($response === false){
    error_log("cURL ERROR: " . curl_error($ch)); // ← これも追加
    echo json_encode(['success' => false, 'error' => curl_error($ch)]);
} else {
    header('Content-Type: application/json');
    echo $response;
}
curl_close($ch);

?>
