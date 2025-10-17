<?php
use Config\Core\Database;
use App\Models\Helper;

$input = json_decode(file_get_contents('php://input'), true);

$input = Helper::getSafeInput([
    'name' => $input['name'] ?? '',
    'email' => $input['email'] ?? '',
    'nomer' => $input['nomer'] ?? '',
    'provinsi' => $input['provinsi'] ?? '',
    'kabupaten' => $input['kabupaten'] ?? '',
    'kecamatan' => $input['kecamatan'] ?? '',
    'kelurahan' => $input['kelurahan'] ?? '',
    'kodepos' => $input['kodepos'] ?? '',
    'tmptlahir' => $input['tmptlahir'] ?? '',
    'date' => $input['date'] ?? '',
    'gender' => $input['gender'] ?? '',
    'address' => $input['address'] ?? '',
]);

// validasi
foreach($input as $key => $value){
    if(empty(trim($value))){
    JsonResponse([
        'success' => false,
        'message' => ucfirst($key).' harap diisi',
        'data' => []
        ]);
    }
}

$user['MBR_ID'];
$stmt = $db->prepare("SELECT * FROM tb_member WHERE MBR_ID = ?");
$stmt->bind_param("i", $user['MBR_ID']);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$type = 2;
$MBR_ZIP = 0;
$codeNomer = '+62';
$OtpExpired = date('Y-m-d H:i:s', strtotime("+15 minute"));
$dateTime = date("Y-m-d H:i:s");

$insert = Database::update('tb_member', [
    'MBR_NAME' => $input['name'],
    'MBR_EMAIL' => $input['email'],
    'MBR_JENIS_KELAMIN' => $input['gender'],
    'MBR_TMPTLAHIR' => $input['tmptlahir'],
    'MBR_TGLLAHIR' => $input['date'],
    'MBR_PROVINCE' => $input['provinsi'],
    'MBR_CITY' => $input['kabupaten'],
    'MBR_DISTRICT' => $input['kecamatan'],
    'MBR_VILLAGES' => $input['kelurahan'],
    'MBR_ADDRESS' => $input['address'],
    'MBR_PHONE_CODE' => $codeNomer,
    'MBR_PHONE' => $input['nomer'],
    'MBR_OTP_EXPIRED' => $OtpExpired,
    'MBR_DATETIME' => $dateTime,
    // 'MBR_CODE' => $data['MBR_CODE'],
], ['MBR_ID' => $user['MBR_ID']]);

JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil disimpan',
    'data' => []
]);




?>