<?php
use App\Models\Helper;
use Config\Core\Database;


$input = json_decode(file_get_contents('php://input'), true);
$input = Helper::getSafeInput($input);

if(!$input || !isset($input['subjek']) || empty(trim($input['subjek'])) )
{
            JsonResponse([
            'success' =>false,
            'message' => 'Data Gagal disimpan',
            'data' => []
        ]);
        exit;
}


$code = strtoupper(substr(bin2hex(random_bytes(7)), 0, 13));

$sts = 'open';
$datatime = date("Y-m-d H:i:s");

$insert = Database::insert('tb_ticket', [
    'TICKET_MBR' => $user['MBR_ID'],
    'TICKET_CODE' => $code,
    'TICKET_SUBJECT' => $input['subjek'],
    'TICKET_DESCRIPTION' => $input['deskripsi'] ?? '',
    'TICKET_STATUS' => $sts,
    'TICKET_CREATED_AT' => $datatime
]);


JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil disimpan',
    'data' => []
]);
