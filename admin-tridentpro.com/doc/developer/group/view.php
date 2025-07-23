<div class="page-header">
	<div>
		<h2 class="main-content-title tx-24 mg-b-5">Grup</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="javascript:void(0);">Developer</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Grup</a></li>
		</ol>
	</div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <?php App\Shared\AdminPermission\SharedViews::render("permission-group/create", ['filePermission' => $filePermission]); ?>
    </div>
    <div class="col mb-3">
        <?php App\Shared\AdminPermission\SharedViews::render("permission-group/tabledata", ['filePermission' => $filePermission]); ?>
    </div>
</div>

<?php App\Shared\AdminPermission\SharedViews::render("permission-group/update", ['filePermission' => $filePermission]); ?>
<?php App\Shared\AdminPermission\SharedViews::render("permission-group/delete", ['filePermission' => $filePermission]); ?>