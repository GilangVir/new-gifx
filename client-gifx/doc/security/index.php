<?php
$mbrId = $user['ID_MBR'];

$query = $db->prepare("SELECT * FROM tb_member WHERE ID_MBR = ?");
$query->bind_param("i", $mbrId);
$query->execute();
$value = $query->get_result()->fetch_assoc();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<div class="container mt-1">
    <div class="col-md-12">
        <div class="card mb-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary">Security</h5>
            </div>
        </div>

        <div class="row">
            <!-- form Password -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-primary">Password</h6>
                    </div>
                    <div class="card-body">
                        <form id="form">
                            <input type="hidden" id="id" value="<?= $value['ID_MBR'] ?>">

                            <div class="mb-3 position-relative">
                                <label for="password_lama" class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_lama" placeholder="Enter your current password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordLama">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-3 position-relative">
                                <label for="password_baru" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_baru" placeholder="Enter your new password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordBaru">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3 position-relative">
                                <label for="konfirm_password" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="konfirm_password" placeholder="Enter your confirm password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">Update Password</button>
                                <button type="reset" class="btn btn-outline-secondary w-100">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- form 2FA Auth (Coming Soon) -->
            <div class="col-md-6">
                <!-- form 2FA Auth (Coming Soon) -->
                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-primary">2FA Auth (Coming Soon)</h6>
                    </div>
                    <div class="card-body">
                        <div class="forn">
                            <div class="mb-3">
                                <label for="" class="form-label">Key</label>
                                <input type="text" class="form-control" id="" name="" placeholder="">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Code</label>
                                <input type="text" class="form-control" id="" name="" placeholder="">
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">Update Password</button>
                                <button type="reset" class="btn btn-outline-secondary w-100">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Delete Account -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-primary">Delete Account</h6>
                    </div>

                    <div class="card-body">
                        <div class="forn">
                            <div class="mb-3">
                                <label for="" class="form-label">Delete Account</label>
                                <input type="text" class="form-control" id="" name="" placeholder="">
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(buttonId, inputId) {
    const btn = document.getElementById(buttonId);
    const input = document.getElementById(inputId);

    btn.addEventListener('click', function () {
        const icon = this.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
}
    // panggil fungsi toggle untuk semua input
    togglePassword('togglePasswordLama', 'password_lama');
    togglePassword('togglePasswordBaru', 'password_baru');
    togglePassword('togglePasswordConfirm', 'konfirm_password');

    $(document).ready(function(){
        $('#form').on('submit', function(e){
            e.preventDefault();

            let button = $(this).find('button[type="submit"]');
            button.addClass('loading')

            const data = {
                id: $('#id').val(),
                password_lama: $('#password_lama').val().trim(),
                password_baru: $('#password_baru').val().trim(),
                konfirm_password: $('#konfirm_password').val().trim()
            }

            $.ajax({
                url: '/ajax/post/security/update',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    button.removeClass('loading')
                    Swal.fire({
                        icon: response.success ? 'success' : 'error',
                        title: response.message
                    }).then(() => {
                        if(response.success && response.data.redirect) {
                            window.location.href = response.data.redirect; // redirect ke login/logout
                        }
                    });
                    $('#form')[0].reset()
                }
            })

        })
    })
</script>

