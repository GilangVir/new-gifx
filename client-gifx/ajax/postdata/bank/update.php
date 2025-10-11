<?php

use App\Models\FileUpload;
use Config\Core\Database;

$id = $_POST['id'];

$input = [
    'nama_bank' => $_POST['nama_bank'] ?? '',
    'nama_nasabah' => $_POST['nama_nasabah'] ?? '',
    'nomer' => $_POST['nomer'] ?? '',
];


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

    //file lama
    $stmt = $db->prepare("SELECT MBANK_IMG FROM tb_member_bank WHERE ID_MBANK = ?");
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();

    $result = $stmt->get_result();
    $oldData = $result->fetch_assoc();
    $filename = $oldData['MBANK_IMG'] ?? '';
     //Upload file
    if (!empty($_FILES["buku_tabungan"]) && $_FILES["buku_tabungan"]['error'] === 0){
        $PRCSF = FileUpload::upload_myfile($_FILES["buku_tabungan"], 'bank');
        if(!is_array($PRCSF)){
            JsonResponse([
                'success'   => false,
                'message'   => "Failed to upload file. Please try again!. ErrMessage: ".$PRCSF,
                'data'      => []
            ]);
        }
        $filename = $PRCSF["filename"];


    }

    $regol = 0;
    $sts = 0;
    $mbr = 1;
    $otp = 1;
    $account = 1;
    $OtpExpired = date("Y-m-d H:i:s");

    $datetime = date("Y-m-d H:i:s");

    $insert = Database::update('tb_member_bank', [
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
], [
    'ID_MBANK' => $id
]);

    JsonResponse([
        'success' =>true,
        'message' => 'Data berhasil diupdate',
        'data' => []
    ]);
