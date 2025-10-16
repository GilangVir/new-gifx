<?php
namespace App\Models;

class Ticket {
    public static int $aktif = -1;
    public static int $nonaktif = 1;

    public static function status(int $status): String {
        switch ($status){
            case self::$aktif:
                return '<span style="color:green;">Aktif</span>';
            case self::$nonaktif:
                return '<span style="color:red;">Close</span>';
            default:
                return '<span style="color:gray;">Unknown</span>'; // nilai default
        }
    }
}