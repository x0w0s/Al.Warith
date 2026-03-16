<?php
define('BOT_TOKEN', '8532129559:AAGmynX2GrrxowH34J3DuIm3Vh2u_v593uU');
define('CHAT_ID', '7763665935');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = trim($_POST['message']);
    if (empty($message)) {
        echo json_encode(['success' => false, 'error' => 'الرسالة فارغة']);
        exit;
    }

    $data = [
        'chat_id' => CHAT_ID,
        'text' => "📩 رسالة جديدة من أحد الشباب (مجهول):\n\n" . $message,
    ];

    // استخدام cURL بدلاً من file_get_contents
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // أضف هذا إذا كان الاتصال مشفر
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($result === false) {
        echo json_encode(['success' => false, 'error' => 'cURL error: ' . curl_error($ch)]);
    } else {
        $response = json_decode($result, true);
        if ($httpCode == 200 && isset($response['ok']) && $response['ok'] == true) {
            echo json_encode(['success' => true]);
        } else {
            $errorMsg = isset($response['description']) ? $response['description'] : 'خطأ غير معروف';
            echo json_encode(['success' => false, 'error' => $errorMsg]);
        }
    }
    exit;
}
echo "غير مسموح بالوصول المباشر.";
?>
