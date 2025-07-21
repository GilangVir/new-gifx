<?php
namespace App\Models;

use Exception;

class Country {

    public static function countries(): array {
        try {
            global $db;
            $sqlGet = $db->query("SELECT * FROM tb_country ORDER BY COUNTRY_NAME");
            return $sqlGet->fetch_all(MYSQLI_ASSOC) ?? [];

        } catch (Exception $e) {
            return [];
        }
    }

}