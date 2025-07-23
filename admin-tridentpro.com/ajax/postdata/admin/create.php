<?php
use App\Shared\AdminPermission\Core\AdminPermissionCore;
App\Shared\AdminPermission\SharedViews::render_script("admins/ajax/create", [
    'isAllowed' => AdminPermissionCore::hasPermission($authorizedPermission, "/admin/create"),
    'user' => $user
]);