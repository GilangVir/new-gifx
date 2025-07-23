<?php
namespace App\Shared\AdminPermission;

use App\Shared\InterfaceSharedView;
use Throwable;

class SharedViews implements InterfaceSharedView {

    public static function render(string $filepath, array $data = []) {
        ob_start();
        extract($data, EXTR_SKIP);

        try {
            include __DIR__ . "/views/$filepath.php";

        } catch (Throwable $e) {
            ob_get_clean();
            throw $e;
        }
    } 
}