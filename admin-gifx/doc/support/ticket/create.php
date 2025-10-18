<?php
    $query = $db->prepare('SELECT * FROM tb_member ORDER BY MBR_NAME');
    $query->execute();
    $result = $query->get_result();
    $member = $result->fetch_all(MYSQLI_ASSOC);
?>
<div class="container mt-5">
    <!-- Header Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h3 class="mb-0 fw-bold">🎫 Create Ticket</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form id="form">
                        <div class="mb-3">
                            <label for="email" class="form-control-label">Email</label>
                            <select class="form-select" id="email" name="email">
                                <option selected disabled>Pilih Email</option>
                                <?php foreach ($member as $nilai): ?>
                                    <option value="<?= $nilai['MBR_ID']?>">
                                        <?= $nilai['MBR_EMAIL']?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="subjek" class="form-label fw-semibold">Subjek</label>
                            <input type="text" class="form-control" id="subjek" name="subjek" placeholder="Masukkan subjek">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi (opsional)</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" placeholder="Tulis deskripsi jika perlu"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-warning w-100 fw-bold">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#form').on('submit', function(e){
            e.preventDefault();

            let button = $(this).find('button[type="submit"]');
            button.addClass('loading')

            const data = {
                mbr_id: $('#email').val().trim(),
                subjek: $('#subjek').val().trim(),
                deskripsi: $('#deskripsi').val().trim()
            }

            $.ajax({
                url: '/ajax/post/support/ticket/create',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(data),

                success: function(response) {

                    button.removeClass('loading')
                    Swal.fire(response.alert)
                    $('#form')[0].reset();
                    table.ajax.reload();
                }
            })

        })
    })
</script>
