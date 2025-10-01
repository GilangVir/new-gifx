<?php

use Config\Core\Database;

if(!$adminPermissionCore->hasPermission($authorizedPermission, "/news/news_corner/delete")) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Authorization Failed",
        'data'      => []
]);
}

$id = isset($_POST['id']) ? $_POST['id'] : null;
if(!$id || empty($id)) {
    JsonResponse([
        'success' => false,
        'message' => 'Data Gagal dihapus',
        'data' => []
    ]);
    exit; //Stop eksekusi
}

Database::delete("tb_blog", [
    'ID_BLOG' => $id
]);
JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil dihapus',
    'data' => []
]);


?>