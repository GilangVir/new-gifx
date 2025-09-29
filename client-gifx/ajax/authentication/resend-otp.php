<?php
use App\Factory\UserOtpFactory;
use Config\Core\EmailSender;
use App\Models\Helper;

$input = Helper::getSafeInput($_POST); 

// Generate OTP baru
$otp = rand(1000, 9999);
$expired_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));
$sqlGet = $db->query("SELECT * FROM tb_member WHERE MD5(MD5(CONCAT(MBR_ID, ID_MBR))) = '{$input['code']}'  AND MBR_STS = 0 LIMIT 1");
$user = $sqlGet->fetch_assoc();

$delay = UserOtpFactory::isDelay($user['MBR_ID']);
if($delay !== true){
    JsonResponse([
        'success' =>false,
        'message' => $delay,
        'data' => []
    ]);
}

$setotp = UserOtpFactory::setotp($otp, $expired_at, $user['MBR_ID']);
$emailData = [
    'subject' => "OTP Verification",
    'otp'  => $otp,
];
$emailSender = EmailSender::init(['email' => $user['MBR_EMAIL'], 'name' => $user['MBR_NAME']]);
$emailSender->useFile("otp", $emailData);
$send = $emailSender->send();
    JsonResponse([
        'success' =>true,
        'message' => 'OTP Verification',
        'data' => []
    ]);
