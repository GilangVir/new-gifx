<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../config/setting.php";
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\MySQL;
use App\Models\Helper;
use Config\Core\Database;
use App\Models\User;

try {
    global $_SESSION, $_COOKIE;
    global $db;
    $aws_folder = "https://allmediaindo-2.s3.ap-southeast-1.amazonaws.com/gfsprime/";
    $dt = new Datatables( new MySQL([ 
        'host'     => DBHelper::$host,
        'port'     => DBHelper::$port,
        'username' => DBHelper::$username,
        'password' => DBHelper::$password,
        'database' => DBHelper::$database 
    ]));
    

    /** validate token */
    $user = User::authentication();
    if(empty($user)) {
        JsonResponse([
            'code'      => 404,
            'success'   => false,
            'message'   => "Invalid User",
            'data'      => []
        ]);
    }

    if(empty($_SERVER['HTTP_REFERER'])) {
        JsonResponse([
            'code'      => 404,
            'success'   => false,
            'message'   => "Invalid Request",
            'data'      => []
        ]);
    }

    /** Validate filename */
    $filename   = $_GET['url'];
    $url = "/{$filename}";
    if(!file_exists(__DIR__ . "/tabledata/{$filename}.php")) {
        JsonResponse([
            'code'      => 404,
            'success'   => false,
            'message'   => "Invalid Url",
            'data'      => []
        ]);
    }

    require_once __DIR__ . "/tabledata/{$filename}.php";

} catch (Exception $e) {
    throw $e;
}