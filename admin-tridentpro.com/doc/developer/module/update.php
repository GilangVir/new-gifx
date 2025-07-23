<?php
use App\Models\Helper;
App\Shared\AdminPermission\SharedViews::render("permission-module/update_view", [
    'filePermission' => $filePermission,
    'moduleId' => Helper::form_input($_GET['d'] ?? "")
]);
