<?php
namespace App\Models;

use Config\Core\AdminAuth;
use Exception;

class Admin extends AdminAuth {

    public static function createAdmId(): int {
        try {
            global $db;
            if(empty($db)) {
                $db = DBHelper::getConnection();
            }

            $select = $db->query("SELECT (SELECT (MAX(tb2.ADM_ID) + 1) FROM tb_admin as tb2) as ADM_ID");
            return $select->fetch_assoc()['ADM_ID'] ?? 0;

        } catch (Exception $e) {
            return 0;
        }
    }

    public static function findById(int $idAdm): array {
        try {
            global $db;
            if(empty($db)) {
                $db = DBHelper::getConnection();
            }

            /** Check Database */
            $dateNow = date("Y-m-d H:i:s");
            $sqlCheck = $db->query("SELECT * FROM tb_admin JOIN tb_admin_role tar ON (tar.ID_ADMROLE = ADM_LEVEL) WHERE ID_ADM = {$idAdm} LIMIT 1");
            $user = $sqlCheck->fetch_assoc(); 
            if($sqlCheck->num_rows != 1) {
                return [];
            }

            return $user;

        } catch (Exception $e) {
            if(ini_get("display_errors") == "1") {
                throw $e;
            }

            return [];
        }
    } 

    public static function adminRoles() {
        try {
            global $db;
            $user = Self::authentication() ?? [];
            if(empty($user)) {
                return [];
            }

            $currentLevel = $user['ADM_LEVEL'];
            $sqlGet = $db->query("SELECT * FROM tb_admin_role WHERE (ID_ADMROLE > {$currentLevel} OR {$currentLevel} = 1) AND {$currentLevel} <= 2");
            return $sqlGet->fetch_all(MYSQLI_ASSOC);

        } catch (Exception $e) {
            return [];
        }
    }

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

    public static function maxGroupId() {
        try {
            global $db;
            if(empty($db)) {
                $db = DBHelper::getConnection();
            }
            
            $sqlGet = $db->query("SELECT MAX(id) as id FROM admin_module_group LIMIT 1");
            
            return $sqlGet->fetch_assoc()['id'] ?? 0;

        } catch (Exception $e) {
            return 0;
        }
    }
}