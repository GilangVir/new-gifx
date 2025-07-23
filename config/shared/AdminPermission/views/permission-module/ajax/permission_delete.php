<?php
use App\Models\Helper;
use App\Models\DBHelper;
use App\Models\Logger;
use App\Shared\AdminPermission\Core\AdminPermissionCore;
use App\Shared\AdminPermission\Models\PermissionModule;

$listGrup = AdminPermissionCore::availableGroup();
if(!$isAllowed) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Authorization Failed",
        'data'      => []
    ]);
}

$permissionId = Helper::form_input($_POST['id'] ?? 0);
if(empty($permissionId)) {
    JsonResponse([
        'success'   => false,
        'message'   => "Permisison ID diperlukan",
        'data'      => []
    ]);
}

/** Check ID */
$permission = PermissionModule::findPermissionById($permissionId);
if(!$permission) {
    JsonResponse([
        'success' => false,
        'message' => "Permission ID tidak ditemukan",
        'data' => []
    ]);
}

/** Delete */
$delete = DBHelper::delete("admin_permissions", ['id' => $permissionId]);
if(!$delete) {
    JsonResponse([
        'success' => false,
        'message' => "Gagal menghapus permission",
        'data' => []
    ]);
}

Logger::admin_log([
    'admid' => $user['ADM_ID'],
    'module' => "module",
    'message' => "Mengahapus permission ".$permission['desc'],
    'ip' => Helper::get_ip_address(),
    'data' => array_merge($_POST, $permission)
]);

JsonResponse([
    'success' => true,
    'message' => "Berhasil",
    'data' => []
]);