<?php
use Allmedia\Shared\AdminPermission\Core\AdminPermissionCore;
App\Shared\AdminPermission\SharedViews::render_script("permission-module/ajax/create", [
    'isAllowed' => AdminPermissionCore::hasPermission($authorizedPermission, $url),
    'user' => $user
]);