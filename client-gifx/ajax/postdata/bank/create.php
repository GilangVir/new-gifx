<?php

use App\Models\FileUpload;
use Config\Core\Database;
use App\Models\Helper;


// membatasi user hanya bisa menambahkan 2 bank
$userId = $user['MBR_ID'];
$query = $db->prepare("SELECT COUNT(*) AS TOTAL FROM tb_member_bank WHERE MBANK_MBR = ?");
$query->bind_param("i", $userId);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_assoc();
$totalBankUser = $data['TOTAL'];

if($totalBankUser >= 2){
    JsonResponse([
        'success' => false,
        'message' => 'Maaf, Anda telah mencapai batas maksimum bank yang dapat ditambahkan.',
        'data' => [],
    ]);
}

$input = Helper::getSafeInput([
    'nama_bank' => $_POST['nama_bank'] ?? '',
    'nama_nasabah' => $_POST['nama_nasabah'] ?? '',
    'nomer' => $_POST['nomer'] ?? '',
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

if(!preg_match('/^[0-9]{10}$/', $input['nomer'])) {
    JsonResponse([
        'success' => false,
        'message' => 'Nomer rekening hanya boleh berisi angka dan maksimal 10 digit',
        'data' => []
    ]);
}

    //Upload file
    // $PRCSF = FileUpload::upload_myfile($_FILES["buku_tabungan"], 'news');
    // if(!is_array($PRCSF)){
    //     JsonResponse([
    //         'success'   => false,
    //         'message'   => "Failed to upload file. Please try again!. ErrMessage: ".$PRCSF,
    //         'data'      => []
    //     ]);
    // }

    // $filename = $PRCSF["filename"];

$filename = "image";
$regol = 0;
$sts = 0;
$mbr = 1;
$otp = 1;
$account = 1;
$OtpExpired = date("Y-m-d H:i:s");

$datetime = date("Y-m-d H:i:s");

$insert = Database::insert('tb_member_bank', [
    'MBANK_MBR' => $user['MBR_ID'],
    'MBANK_HOLDER' => $input['nama_nasabah'],
    'MBANK_NAME' => $input['nama_bank'],
    'MBANK_ACCOUNT' => $input['nomer'],
    'MBANK_IMG' => $filename,
    'MBANK_OTP' => $otp,
    'MBANK_OTP_EXPIRED' => $OtpExpired,
    'MBANK_REGOL' => $regol,
    'MBANK_STS' => $sts,
    'MBANK_DATETIME' => $datetime
]);

JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil disimpan',
    'data' => []
]);
