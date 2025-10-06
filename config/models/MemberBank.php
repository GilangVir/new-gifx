<?php
namespace App\Models;
use App\Models\Helper;
use Config\Core\Database;

class MemberBank {
    
    public static int $statusPending = 0;
    public static int $statusSuccess = -1;
    public static int $statusRejected = 1;
   
    public static function status(int $status): String {
        switch ($status){
            case self::$statusPending:
                return 'Pending';
            case self::$statusSuccess:
                return 'Success';
            case self::$statusRejected:
                return 'Rejected';
            default:
                return 'Unknown';
        }
    }
}