<?php
use App\Shared\AdminPermission\Core\AdminPermissionCore;
App\Shared\AdminPermission\SharedViews::render_script("permission-group/ajax/delete", [
    'isAllowed' => AdminPermissionCore::hasPermission($authorizedPermission, $url),
    'user' => $user
]);