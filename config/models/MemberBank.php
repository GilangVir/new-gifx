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
                return '<span style="color:red;">Pending</span>';
            case self::$statusSuccess:
                return '<span style="color:green;">Success</span>';
            case self::$statusRejected:
                return '<span style="color:orange;">Rejected</span>';
            default:
                return '<span style="color:gray;">Unknown</span>';
        }
    }
}