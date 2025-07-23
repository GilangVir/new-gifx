<?php
namespace App\Models;

use Config\Core\SystemInfo;
use Exception;

class PermissionGroup {

    public static function getById(string $id): array|bool {
        try {
            $db = DBHelper::getConnection();
            $sqlGet = $db->query("SELECT * FROM admin_module_group WHERE MD5(MD5(id)) = '{$id}' LIMIT 1");
            return $sqlGet->fetch_assoc() ?? false;

        } catch (Exception $e) {
            if(SystemInfo::isDevelopment()) {
                throw $e;
            }

            return false;
        }
    }

}