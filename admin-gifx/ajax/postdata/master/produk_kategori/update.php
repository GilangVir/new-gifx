<?php

use Config\Core\Database;

    if(!$adminPermissionCore->hasPermission($authorizedPermission, "/master/produk_kategori/update/1")) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Authorization Failed",
        'data'      => []
    ]);
}

$input = json_decode(file_get_contents('php://input'), true);

if(!$input 
    || !isset($input['nama']) || empty(trim($input['nama']))
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

    // Generate Code dari mana
    $code = strtolower($nama);
    $code = preg_replace('/[^a-z0-9]+/', '_', $code);
    $code = trim($code, '_');

    // === Cek duplikasi NAMA (kecuali id ini) ===
    $stmt = $db->prepare("SELECT ACCKAT_NAME FROM tb_racctype_kategori WHERE ACCKAT_NAME = ?");
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingName = $result->fetch_all(MYSQLI_ASSOC);

    if ($existingName && count($existingName) > 0) {
        JsonResponse([
            'success' => false,
            'message' => 'Data dengan nama produk "' . $nama . '" sudah ada',
            'data'    => []
        ]);
        exit;
    }

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