<?php

use Config\Core\Database;

$input = json_decode(file_get_contents('php://input'), true);

    // validasi input
    if(!$input || !isset($input['bankName']) || empty(trim($input['bankName']))) {
        JsonResponse([
            'success' =>false,
            'message' => 'Data Gagal disimpan',
            'data' => []
        ]);
        exit;
    }

// ambil data dari input
$bankName = trim($input['bankName']);



Database::insert('tb_banklist', [
    'BANKLST_NAME' => $bankName
]);

// Cek hasil dan return JSON response
JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil disimpan',
    'data' => []
]);


?>