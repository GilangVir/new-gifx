<?php
namespace Config\Core;

use Dotenv\Dotenv;
use Exception;
use mysqli;

class Database {
   
    private static ?mysqli $instance = null;
    public static $host;
    public static $username;
    public static $password;
    public static $database;
    public static $port;
    
    public static function getConnection(): mysqli {
        if(self::$instance === null) {
            self::$host = $_ENV["DB_HOST"];
            self::$username = $_ENV["DB_USER"];
            self::$password = $_ENV["DB_PASS"];
            self::$database = $_ENV["DB_NAME"];
            self::$port = $_ENV["DB_PORT"];
            self::$instance = new mysqli(self::$host, self::$username, self::$password, self::$database, self::$port);
            
            if(self::$instance->connect_error) {
                throw new Exception("Database connection failed: " . self::$instance->connect_error);
            }

            self::$instance->set_charset("utf8mb4");
        }

        return self::$instance;
    } 

    public static function close(): void {
        if(self::$instance != null) {
            self::$instance->close();
            self::$instance = null;
        }
    }
}