<?php

use App\Models\FileUpload;
use Config\Core\Database;
use App\Models\Helper;

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

// upload file
$file = FileUpload::upload_myfile($_FILES['buku_tabungan'], 'news');
if(!is_array($file)){
    JsonResponse([
        'success'   => false,
        'message'   => "Failed to upload file. Please try again!. ErrMessage: ".$file,
        'data'      => []
    ]);
}
$filename = $file["filename"];

$regol = 0;
$sts = 0;
$mbr = 1;
$otp = 1;
$account = 1;
$OtpExpired = date("Y-m-d H:i:s");

$datetime = date("Y-m-d H:i:s");

$insert = Database::insert('tb_member_bank', [
    'MBANK_MBR' => $input['nomer'],
    'MBANK_HOLDER' => $input['nama_nasabah'],
    'MBANK_NAME' => $input['nama_bank'],
    'MBANK_ACCOUNT' => $account,
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
