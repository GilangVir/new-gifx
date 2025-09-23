<?php

use Config\Core\Database;



    if(!$adminPermissionCore->hasPermission($authorizedPermission, "/master/bank/delete")) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Authorization Failed",
        'data'      => []
    ]);
}

// Ambil ID dari POST
$idBanklst = isset($_POST['id']) ? trim($_POST['id']) : null;

// VALIDASI: Jika ID TIDAK ada atau kosong, GAGAL
if(!$idBanklst || empty($idBanklst)) {
    JsonResponse([
        'success' => false,
        'message' => 'Data Gagal dihapus',
        'data' => []
    ]);
    exit; //Stop eksekusi
}

Database::delete("tb_banklist", [
    'ID_BANKLST' => $idBanklst
]);

// Cek hasil dan return JSON response
JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil dihapus',
    'data' => []
]);
?>