<?php
use App\Shared\AdminPermission\Core\AdminPermissionCore;
App\Shared\AdminPermission\SharedViews::render_script("permission-module/ajax/permission_update", [
    'isAllowed' => AdminPermissionCore::hasPermission($authorizedPermission, "/developer/module/update/*"),
    'user' => $user
]);