<?php
use Allmedia\Shared\AdminPermission\Core\AdminPermissionCore;
App\Shared\AdminPermission\SharedViews::render_script("admins/ajax/updatePassword", [
    'isAllowed' => AdminPermissionCore::hasPermission($authorizedPermission, "/admin/update/*"),
    'user' => $user
]);