<?php
namespace App\Shared\AdminPermission\Models;

use App\Models\DBHelper;
use Config\Core\SystemInfo;
use Exception;

class PermissionModule {

    public static function findModuleById(string $id) {
        try {
            $db = DBHelper::getConnection();
            $sqlGet = $db->query("
                SELECT 
                	am.*,
                    amg.`group`
                FROM admin_module am
                JOIN admin_module_group amg ON (amg.id = am.group_id)
                WHERE MD5(MD5(am.id)) = '{$id}' 
                LIMIT 1
            ");

            if($sqlGet->num_rows != 1) {
                return false;
            }

            return $sqlGet->fetch_assoc();

        } catch (Exception $e) {
            if(ini_get("display_errors") == "1") {
                throw $e;
            }

            return [];
        }
    }
}