<?php
define('BOT_TOKEN', '8532129559:AAGmynX2GrrxowH34J3DuIm3Vh2u_v593uU');
define('CHAT_ID', '7763665935');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = trim($_POST['message']);
    if (empty($message)) exit(json_encode(['success'=>false,'error'=>'فارغ']));
    
    $data = [
        'chat_id' => CHAT_ID,
        'text' => "📩 رسالة جديدة:\n\n" . $message,
    ];
    
    $url = "https://api.telegram.org/bot".BOT_TOKEN."/sendMessage";
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    if ($result === FALSE) {
        echo json_encode(['success'=>false,'error'=>'فشل الاتصال']);
    } else {
        $response = json_decode($result, true);
        echo json_encode(['success'=>$response['ok'] ?? false]);
    }
    exit;
}
echo "غير مسموح";
?>
