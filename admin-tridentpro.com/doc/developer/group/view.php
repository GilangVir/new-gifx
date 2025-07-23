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
    <?php require_once __DIR__ . "/create.php"; ?>

    <div class="col mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-priamry">Daftar Grup</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="table-group">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th width="10%">Icon</th>
                                <th width="10%">#</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/update.php"; ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table-group').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "/ajax/datatable/developer/group/view",
            },
            drawCallback: function() {
                $('.btn-edit').on('click', function(evt) {
                    if(evt.currentTarget) {
                        $('#modal-edit-group').find('#edit_group_id').val( $(evt.currentTarget).data('id') )
                        $('#modal-edit-group').find('#edit_group_name').val( $(evt.currentTarget).data('group') )
                        $('#modal-edit-group').find('#edit_group_type').val( $(evt.currentTarget).data('type') )
                        $('#modal-edit-group').find('#edit_group_icon').val( $(evt.currentTarget).data('icon') )
                        $('#modal-edit-group').modal('show');
                    }
                })

                $('.btn-delete').on('click', function(evt) {
                    if(evt.currentTarget) {
                        $.post("/ajax/post/developer/group/delete", {id: $(evt.currentTarget).data('id')}, (resp) => {
                            Swal.fire(resp.alert).then(() => {
                                if(resp.success) {
                                    location.reload();
                                }
                            })
                        }, 'json')
                    }
                })
            }
        })
    })
</script>