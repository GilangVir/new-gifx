<?php
namespace App\Models;
use App\Models\Helper;
use Config\Core\Database;
use Config\Core\SystemInfo;
use Exception;

class MemberBank {
    
    public static int $statusPending = 0;
    public static int $statusSuccess = -1;
    public static int $statusRejected = 1;
   
    public static function status(int $status): String {
        switch ($status){
            case self::$statusPending:
                return '<span style="color:red;">Pending</span>';
            case self::$statusSuccess:
                return '<span style="color:green;">Success</span>';
            case self::$statusRejected:
                return '<span style="color:orange;">Rejected</span>';
            default:
                return '<span style="color:gray;">Unknown</span>';
        }
    }

    public static function getById(int $id)
    {
        try{
            $db = Database::connect();
            $query = $db->query("SELECT * FROM tb_member_bank WHERE ID_MBANK = {$id}");
            return $query->fetch_assoc() ?? false;

        } catch (Exception $e) {
            if(SystemInfo::isDevelopment()) {
                throw $e;
            }
            return false;
        }
        
    }
}