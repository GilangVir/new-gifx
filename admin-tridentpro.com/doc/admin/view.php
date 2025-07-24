<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">List Admin</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">List</a></li>
        </ol>
    </div>
</div>

<?php 
Allmedia\Shared\AdminPermission\SharedViews::render("admins/view", [
    'isAllowToCreate' => $adminPermissionCore->isHavePermission($moduleId, "create"),
    'isAllowToUpdate' => $adminPermissionCore->isHavePermission($moduleId, "update"),
]); 
?>