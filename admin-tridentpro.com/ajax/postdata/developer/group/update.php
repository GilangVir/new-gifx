<?php
use App\Models\Helper;
use App\Models\Logger;
use App\Models\Admin;

$permission = Admin::hasPermission($authorizedPermission, $url);
if(!$permission) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Authorization Failed",
        'data'      => []
    ]);
}

$data = Helper::getSafeInput($_POST);
foreach(['edit_group_id', 'edit_group_name', 'edit_group_type', 'edit_group_icon'] as $req) {
    if(empty($data[ $req ])) {
        JsonResponse([
            'code'      => 200,
            'success'   => false,
            'message'   => "{$req} diperlukan",
            'data'      => []
        ]);
    }
}

/** Update */
$update = $db->prepare("UPDATE admin_module_group SET `group` = ?, `type` = ?, `icon` = ? WHERE MD5(MD5(id)) = ?");
$update->bind_param("ssss", $data['edit_group_name'], $data['edit_group_type'], $data['edit_group_icon'], $data['edit_group_id']);
if(!$update->execute()) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Gagal memperbarui data grup",
        'data'      => []
    ]);
}

Logger::admin_log([
    'admid' => $user['ADM_ID'],
    'module' => "group",
    'message' => "Memperbarui module group ".$data['edit_group_name'],
    'ip' => Helper::get_ip_address(),
    'data' => json_encode($data)
]);

JsonResponse([
    'code'      => 200,
    'success'   => true,
    'message'   => "Berhasil memperbarui data modul grup",
    'data'      => []
]);