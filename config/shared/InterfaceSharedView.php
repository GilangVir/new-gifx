<?php
namespace App\Shared;

interface InterfaceSharedView {
    
    public static function render(string $filepath, array $data = []);

}