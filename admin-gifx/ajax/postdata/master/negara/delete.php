<?php

use Config\Core\Database;

// Ambil ID dari POST
$countryId = isset($_POST['id']) ? $_POST['id'] : null;

// VALIDASI: Jika ID TIDAK ada atau kosong, GAGAL
if(!$countryId || empty($countryId)) {
    JsonResponse([
        'success' => false,
        'message' => 'Data Gagal dihapus',
        'data' => []
    ]);
    exit; //Stop eksekusi
}

Database::delete("tb_country", [
    'ID_COUNTRY' => $countryId
]);

// Validasi ID
// Cek hasil dan return JSON response
JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil dihapus',
    'data' => []
]);
?>