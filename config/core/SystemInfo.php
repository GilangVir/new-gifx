<?php
namespace Config\Core;

class SystemInfo {

    public static function isDevelopment(): bool {
        return (ini_get('display_errors') == "1")? true : false; 
    }
}