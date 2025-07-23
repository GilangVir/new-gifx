<?php
use App\Models\Admin;
?>

<?php if(Admin::isHavePermission($filePermission['module_id'], "update")) : ?>
    <div class="modal fade" tabindex="-1" id="modal-edit-group">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
                </div>
                <form method="post" id="update-group">
                    <input type="hidden" name="edit_group_id" id="edit_group_id">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="edit_group_name" class="form-control-label">Nama</label>
                            <input type="text" name="edit_group_name" id="edit_group_name" class="form-control" placeholder="Group name, gunakan - jangan spasi">
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_group_icon" class="form-control-label">Icon</label>
                            <input type="text" name="edit_group_icon" id="edit_group_icon" class="form-control" placeholder="HTML Icon">
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_group_type" class="form-control-label">Tipe</label>
                            <select name="edit_group_type" id="edit_group_type" class="form-control">
                                <option value="dropdown">dropdown</option>
                                <option value="single">single</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary" name="update_group">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#update-group').on('submit', function(event) {
                event.preventDefault();
                
                let data = Object.fromEntries(new FormData(this).entries());
                $.post("/ajax/post/developer/group/update", data, function(resp) {
                    $('#modal-edit-group').modal('hide')
                    Swal.fire(resp.alert).then(() => {
                        if(resp.success) {
                            location.reload();
                        }
                    })
                }, 'json')
            })
        })
    </script>
<?php endif; ?>