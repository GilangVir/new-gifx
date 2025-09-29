<?php

use App\Factory\UserOtpFactory;
use App\Models\Helper;
use Config\Core\Database;

$input = Helper::getSafeInput($_POST);
$sqlGet = $db->query("SELECT * FROM tb_member WHERE MD5(MD5(CONCAT(MBR_ID, ID_MBR))) = '{$input['code']}'  AND MBR_STS = 0 LIMIT 1");

$user = $sqlGet->fetch_assoc();

$useOtp = UserOtpFactory::useOtp($input['otp'], $user['MBR_ID']);

if($useOtp !== true){
            JsonResponse([
            'success' =>false,
            'message' => $useOtp,
            'data' => []
        ]);
    }
    // Jika OTP valid -> update status menjadi 1 (aktif)
    Database::update("tb_member", [
        'MBR_STS' => -1
    ], [
        'ID_MBR' => $user['ID_MBR']
    ]);
    
JsonResponse([
    'success' =>true,
    'message' => 'OTP Verification Success',
    'data' => ['redirect' => '/dashboard']
]);
