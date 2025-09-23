<?php

use Config\Core\Database;

    
    if(!$adminPermissionCore->hasPermission($authorizedPermission, "/master/bank/update/1")) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Authorization Failed",
        'data'      => []
    ]);
}


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

    // Prepare statement. jika ada duplikasi nilai pd tabel
    $stmt = $db->prepare("SELECT BANKLST_NAME FROM tb_banklist WHERE BANKLST_NAME = ?");
    $stmt->bind_param("s", $name); // "s" untuk string
    $stmt->execute();
    $result = $stmt->get_result();
    $existingData = $result->fetch_all(MYSQLI_ASSOC);

    if ($existingData && count($existingData) > 0) {
        JsonResponse([
            'success' => false,
            'message' => 'Data dengan nama bank "' . $name . '" sudah ada',
            'data' => []
        ]);
        exit;
    }

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