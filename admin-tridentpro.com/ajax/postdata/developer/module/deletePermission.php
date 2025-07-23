<?php
use Allmedia\Shared\AdminPermission\Core\AdminPermissionCore;
App\Shared\AdminPermission\SharedViews::render_script("permission-module/ajax/permission_delete", [
    'isAllowed' => AdminPermissionCore::hasPermission($authorizedPermission, "/developer/module/update/*"),
    'user' => $user
]);