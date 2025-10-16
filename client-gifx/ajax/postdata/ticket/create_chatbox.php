<?php
use Config\Core\Database;
use App\Models\Helper;
use App\Models\FileUpload;

$input = helper::getSafeInput($_POST);
$message = $input['message'] ?? '';

if (empty(trim($message))) {
    JsonResponse([
        'success' => false,
        'message' => 'Mohon isi pesan',
        'data' => []
    ]);
}

    //Upload file
    // $PRCSF = FileUpload::upload_myfile($_FILES["image"], 'ticket');
    // if(!is_array($PRCSF)){
    //     JsonResponse([
    //         'success'   => false,
    //         'message'   => "Failed to upload file. Please try again!. ErrMessage: ".$PRCSF,
    //         'data'      => []
    //     ]);
    // }
    // $filename = $PRCSF["filename"];

$dateTime = date("Y-m-d H:i:s");

$insert = Database::insert('tb_ticket_detail', [
    'TDETAIL_TCODE' => $input['ticket_code'],
    'TDETAIL_FROM' =>  $user['MBR_ID'],
    'TDETAIL_TYPE' => 'MEMBER',
    'TDETAIL_CONTENT_TYPE' => 'message',
    'TDETAIL_CONTENT' => $input['message'],
    'TDETAIL_DATETIME' => $dateTime,
]);

    JsonResponse([
        'success' => true,
        'message' => 'berhasil',
        'data' => []
    ]);
