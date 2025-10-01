<?php

namespace App\Models;

use Config\Core\Database;
use Config\Core\SystemInfo;
use Exception;

class FundamentalsAnalysis {

    public static function findById(int $id): array|bool {
        try {
            $db = Database::connect();
            $sqlGet = $db->query("SELECT * FROM tb_blog WHERE (ID_BLOG) = {$id}");
            return $sqlGet->fetch_assoc() ?? false;

        } catch (Exception $e) {
            if(SystemInfo::isDevelopment()) {
                throw $e;
            }

            return false;
        }
    }
}





?>