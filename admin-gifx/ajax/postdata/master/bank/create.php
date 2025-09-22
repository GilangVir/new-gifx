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

    // Prepare statement. jika ada duplikasi nilai pd tabel
    $stmt = $db->prepare("SELECT BANKLST_NAME FROM tb_banklist WHERE BANKLST_NAME = ?");
    $stmt->bind_param("s", $bankName); // "s" untuk string
    $stmt->execute();
    $result = $stmt->get_result();
    $existingData = $result->fetch_all(MYSQLI_ASSOC);

    if ($existingData && count($existingData) > 0) {
        JsonResponse([
            'success' => false,
            'message' => 'Data dengan nama bank "' . $bankName . '" sudah ada',
            'data' => []
        ]);
        exit;
    }



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