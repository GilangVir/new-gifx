<?php
namespace App\Shared;

interface InterfaceSharedView {
    
    public static function render(string $filepath, array $data = []);
    public static function render_script(string $filepath, array $data = []);

}