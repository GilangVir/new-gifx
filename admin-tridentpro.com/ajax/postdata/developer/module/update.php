<?php
use Allmedia\Shared\AdminPermission\Core\AdminPermissionCore;
App\Shared\AdminPermission\SharedViews::render_script("permission-module/ajax/update", [
    'isAllowed' => AdminPermissionCore::hasPermission($authorizedPermission, "/developer/module/update/*"),
    'user' => $user
]);