<div class="page-header">
	<div>
		<h2 class="main-content-title tx-24 mg-b-5">Master Module</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="javascript:void(0);">Developer</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Module</a></li>
		</ol>
	</div>
</div>

<div class="row">
    <?php App\Shared\AdminPermission\SharedViews::render("permission-module/create", ['filePermission' => $filePermission]); ?>
    <div class="col mb-3">
        <?php App\Shared\AdminPermission\SharedViews::render("permission-module/tabledata", ['filePermission' => $filePermission]); ?>
    </div>
</div>

<?php App\Shared\AdminPermission\SharedViews::render("permission-module/update_button", ['filePermission' => $filePermission]); ?>
<?php App\Shared\AdminPermission\SharedViews::render("permission-module/delete", ['filePermission' => $filePermission]); ?>