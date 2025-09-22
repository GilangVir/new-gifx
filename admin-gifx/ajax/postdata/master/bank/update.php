<?php

use Config\Core\Database;
    $input = json_decode(file_get_contents('php://input'), true);

     // validasi input
    if(!$input || !isset($input['name']) || empty(trim($input['name']))) {
        JsonResponse([
            'success' =>false,
            'message' => 'Data Gagal disimpan',
            'data' => []
        ]);
        exit;
    }

    // Ambil data dari input
    $id = trim($input['id']);
    $name = trim($input['name']);

    Database::update("tb_banklist", [
        'BANKLST_NAME' => $name], [
        'ID_BANKLST' => $id
    ]);

    JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil disimpan',
    'data' => []
]);


    
    


?>