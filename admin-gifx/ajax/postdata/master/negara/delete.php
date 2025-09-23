<?php

use Config\Core\Database;


if(!$adminPermissionCore->hasPermission($authorizedPermission, "/master/negara/delete")) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Authorization Failed",
        'data'      => []
]);
}

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