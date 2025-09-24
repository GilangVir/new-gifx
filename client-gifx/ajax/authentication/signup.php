<?php
use Config\Core\Database;
use App\Models\User;
use App\Models\Helper;

$input = Helper::getSafeInput($_POST); 

$fields = ['fullname','email','password'];
foreach($fields as $field){
    if(empty(trim($input[$field] ?? ''))){
        JsonResponse([
        'success' => false,
        'message' => $field.' Kolom ada yang kosong ', 
        'data' => []
    ]);
    }
}

$fullname = Helper::form_input($input['fullname']);
if (preg_match("/[^a-zA-Z\s]/", $fullname)) {
    JsonResponse([
        'success' => false,
        'message' => 'Nama hanya boleh huruf dan spasi',
        'data' => []
    ]);
}


$email = strtolower($input['email']); 
$stmt = $db->prepare("SELECT ID_MBR FROM tb_member WHERE MBR_EMAIL = '$email'");
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
        JsonResponse([
        'success' =>false,
        'message' => 'Email sudah terdaftar',
        'data' => []
    ]);
}
$stmt->close();


$password = user::validation_password($input['password']);
if($password !== true){
    JsonResponse([
        'success' =>false,
        'message' => $password ?? "password tidak valid", 
        'data' => []
    ]);
}

$refferal = ($input['refferal'] ?? '');
$defaultDSPN = 1000000000;
if (!empty($refferal)) {
    $stmt = $db->prepare("SELECT MBR_ID FROM tb_member WHERE MBR_CODE = ? ");
    $stmt->bind_param("s", $refferal);
    $stmt->execute();
    $stmt->bind_result($mbr_id);
    if (!$stmt->fetch()) {
        JsonResponse([
            'success' =>false,
            'message' => 'refferal tidak ditemukan',
            'data' => []
        ]);
    }
    $defaultDSPN = $mbr_id;
    $stmt->close();
} 

$otp = random_int(1000,9999);
$mbrCode = uniqid();
$mbrCountry = 'indonesia';
$mbrId = User::createMbrId();
    if ($mbrId === 0) {
    JsonResponse([
        'success' => false,
        'message' => 'Gagal',
        'data' => []
    ]);
    exit;
}
$OtpExpired = date('Y-m-d H:i:s', strtotime("+15 minute"));
$dateTime = date("Y-m-d H:i:s");
$hashedPassword = password_hash($input['password'], PASSWORD_BCRYPT);
$insert = Database::insert("tb_member", [
    'MBR_NAME' => $fullname,
    'MBR_EMAIL' => $email,
    'MBR_PASS' => $hashedPassword,
    'MBR_CODE' => $mbrCode,
    'MBR_COUNTRY' => $mbrCountry,
    'MBR_OTP' => $otp,
    'MBR_OTP_EXPIRED' => $OtpExpired,
    'MBR_DATETIME' => $dateTime,
    'MBR_ID' => $mbrId,
    'MBR_IDSPN' => $defaultDSPN
]);
if (!$insert) {
    JsonResponse([
    'success' =>false,
    'message' => 'Data berhasil disimpan',
    'data' => []
]);
}

JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil disimpan',
    'data' => ['redirect' => '/']
]);
