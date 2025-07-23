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

<?php App\Shared\AdminPermission\SharedViews::render("admins/tabledata", ['filePermission' => $filePermission]); ?>
<?php App\Shared\AdminPermission\SharedViews::render("admins/update_button", ['filePermission' => $filePermission]); ?>
<?php App\Shared\AdminPermission\SharedViews::render("admins/permission_button", ['filePermission' => $filePermission]); ?>