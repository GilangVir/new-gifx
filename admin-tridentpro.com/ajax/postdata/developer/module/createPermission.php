<?php
use App\Shared\AdminPermission\Core\AdminPermissionCore;
App\Shared\AdminPermission\SharedViews::render_script("permission-module/ajax/permission_create", [
    'isAllowed' => AdminPermissionCore::hasPermission($authorizedPermission, "/developer/module/update/*"),
    'user' => $user
]);