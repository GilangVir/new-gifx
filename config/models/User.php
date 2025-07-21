<?php
namespace App\Models;

use Config\Core\Database;
use Config\Core\UserAuth;
use Exception;

class User extends UserAuth {

    public static function createMbrId(): int {
        try {
            global $db;
            if(empty($db)) {
                $db = Database::getConnection();
            }

            $select = $db->query("SELECT UNIX_TIMESTAMP(NOW())+(SELECT IFNULL(MAX(tb.ID_MBR),0) FROM tb_member tb) as ID");
            return $select->fetch_assoc()['ID'] ?? 0;

        } catch (Exception $e) {
            return 0;
        }
    }
    
    public static function user(): bool|array {
        try {
            /** Return array on success and bool on error */
            $userid = self::authentication();
            if(!$userid) {
                return false;
            }
    
            $db = Database::getConnection();
            $sqlGet = $db->query("SELECT * FROM tb_member WHERE MBR_ID = {$userid} LIMIT 1");
            if($sqlGet->num_rows != 1) {
                return false;
            }
    
            return $sqlGet->fetch_assoc() ?? false;

        } catch (Exception $e) {
            if(ini_get("display_errors") == "1") {
                throw $e;
            }

            return false;
        }
    } 

     public static function avatar(string $filename): string {
        if(empty($filename) || $filename == "-") {
            return "/assets/images/avatar-14.png";
        }

        return FileUpload::awsFile($filename);
    } 

    public static function validation_password($input) {
        $character  = "abcdefghijklmnopqrstuvwxyz";
        $numeric    = "1234567890";
        $min_length = 8;

        $return     = [
            'upper'     => 0,
            'lower'     => 0,
            'numeric'   => 0
        ];

        // Validate Length
        if(strlen($input) < $min_length) {
            return  "Password must be at least {$min_length} characters";
        }

        // Validate Character
        foreach(str_split($character) as $char) {
            //Uppercase 
            if($return['upper'] == 0) {
                if(strpos($input, strtoupper($char)) !== FALSE) {
                    $return['upper'] += 1;
                } 
            }

            //Lowercase
            if($return['lower'] == 0) {
                if(strpos($input, strtolower($char)) !== FALSE) {
                    $return['lower'] += 1;
                }
            }
        }

        // Validate Numeric
        foreach(str_split($numeric) as $num) {
            if($return['numeric'] == 0) {
                if(strpos($input, $num) !== FALSE) {
                    $return['numeric'] += 1;
                }
            }
        }

        if($return['upper'] == 0) {
            return  "Password must contain at least one upper case letter.";
        }

        if($return['lower'] == 0) {
            return  "Password must contain at least one lower case letter.";
        }

        if($return['numeric'] == 0) {
            return  "Password must contain at least one number.";
        }

        if(preg_match('/[^a-zA-Z0-9]/', $input) <= 0) {
            return  "Password must contain symbols.";
        }

        return true;
    }
}