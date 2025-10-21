<?php
use Config\Core\Database;
use App\Models\Helper;

$db = Database::connect();

$input = Helper::getSafeInput($_POST);
$message = $input['message'] ?? '';

$tiketcode = $input['TICKET_CODE']; 

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
    'TDETAIL_TCODE' => $tiketcode,
    'TDETAIL_FROM' =>  $input['ADM_ID'],
    'TDETAIL_TYPE' => 'ADMIN',
    'TDETAIL_CONTENT_TYPE' => 'message',
    'TDETAIL_CONTENT' => $input['message'],
    'TDETAIL_DATETIME' => $dateTime,
]);

    JsonResponse([
        'success' => true,
        'message' => 'berhasil',
        'data' => []
    ]);


?>