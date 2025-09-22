<?php

use Config\Core\Database;

$input = json_decode(file_get_contents('php://input'), true);

if(!$input 
    || !isset($input['nama']) || empty(trim($input['nama']))
    || !isset($input['code']) || empty(trim($input['code']))
    ) {
        JsonResponse([
            'success' =>false,
            'message' => 'Data Gagal disimpan',
            'data' => []
        ]);
        exit;
    }
$id = trim($input['id']);
$nama = trim($input['nama']);
$code = trim($input['code']);

    Database::update("tb_racctype_kategori", [
        'ACCKAT_NAME' => $nama,
        'ACCKAT_CODE' => $code
    ], [
        'ID_ACCKAT' => $id
    ]);

    // Cek hasil dan return JSON response
JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil disimpan',
    'data' => []
]);




?>