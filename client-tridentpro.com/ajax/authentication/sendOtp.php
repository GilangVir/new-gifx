<?php
use App\Models\Helper;
use App\Models\User;
use App\Models\Zenziva;
use App\Models\Database;
use App\Shared\Verihubs;

$data = Helper::getSafeInput($_POST);
$required = [
    'phone_code' => "Phone Code",
    'phone' => "Phone Number"
];

foreach($required as $req => $text) {
    if(empty($data[$req])) {
        JsonResponse([
            'success' => false,
            'message' => "{$text} is required",
            'data' => []
        ]);
    }
} 

// $type = Helper::form_input($_POST['type'] ?? "");
// $type = strtolower($type);
$type = "sms";
if(empty($type) || !in_array($type, ['whatsapp', 'sms'])) {
    JsonResponse([
        'success' => false,
        'message' => "Invalid Type",
        'data' => []
    ]);
}

/** check terakhir mengirim */
$timenow = time();
if(!empty($user['MBR_OTP_DATETIME']) && $timenow < strtotime($user['MBR_OTP_DATETIME'])) {
    $dateNow = new Datetime(date("Y-m-d H:i:s", $timenow));
    $dateOtp = new Datetime($user['MBR_OTP_DATETIME']);
    $secondDiff = $dateNow->diff($dateOtp)->s;
    JsonResponse([
        'success' => false,
        'message' => "You need to wait {$secondDiff} seconds to send again",
        'data' => []
    ]);
}

$otp = random_int(1000, 9999);
$sendOtp = false;
switch($type) {
    case "whatsapp":
        // $sendOtp = Zenziva::sendOtp_WaReguler($user['MBR_PHONE'], $otp);
        $sendOtp = false;
        break;

    case "sms":
        $phone = Verihubs::phoneValidation($data['phone_code'], $data['phone']);
        if(!$phone){
            JsonResponse([
                'success' => false,
                'message' => "Invalid Phone Number",
                'data' => []
            ]);
        }

        $sendOtp = Verihubs::sendOtp_sms(['phone' => $phone, 'otp' => $otp]);
        break;
}

if(!$sendOtp) {
    JsonResponse([
        'success' => false,
        'message' => "Invalid Status",
        'data' => []
    ]);
}

if(!$sendOtp['success']) {
    JsonResponse([
        'success' => false,
        'message' => $sendOtp['message'],
        'data' => []
    ]);
}

JsonResponse([
    'success' => true,
    'message' => "OTP code was successfully sent",
    'data' => [
        'delay' => 90
    ]
]);
