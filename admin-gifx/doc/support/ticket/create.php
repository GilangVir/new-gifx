<?php
    $query = $db->prepare('SELECT * FROM tb_member ORDER BY MBR_NAME');
    $query->execute();
    $result = $query->get_result();
    $member = $result->fetch_all(MYSQLI_ASSOC);
?>
<div class="container mt-5" style="max-width:900px;margin-top:50px;">
    <!-- Header Card -->
    <div class="row mb-4" style="margin-bottom:1.5rem;">
        <div class="col-md-12">
            <div class="card shadow-sm border-0" style="box-shadow:0 4px 15px rgba(0,0,0,0.08);border:none;border-radius:15px;overflow:hidden;">
                <div class="card-header bg-primary text-white py-3" style="background:linear-gradient(135deg,#007bff,#0056b3);color:#fff;padding:20px 30px;">
                    <h3 class="mb-0 fw-bold" style="margin:0;font-weight:700;">🎫 Create Ticket</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-md-8 offset-md-2" style="margin:0 auto;">
            <div class="card shadow-sm border-0" style="box-shadow:0 4px 15px rgba(0,0,0,0.08);border:none;border-radius:15px;">
                <div class="card-body" style="padding:30px;">
                    <form id="form">
                        <div class="mb-3" style="margin-bottom:1rem;">
                            <label for="email" class="form-control-label" style="display:block;margin-bottom:8px;font-weight:600;color:#333;">Email</label>
                            <select class="form-select" id="email" name="email" style="width:100%;padding:10px 12px;border:1px solid #ced4da;border-radius:10px;font-size:15px;">
                                <option selected disabled>Pilih Email</option>
                                <?php foreach ($member as $nilai): ?>
                                    <option value="<?= $nilai['MBR_ID']?>"><?= $nilai['MBR_EMAIL']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3" style="margin-bottom:1rem;">
                            <label for="subjek" class="form-label fw-semibold" style="display:block;margin-bottom:8px;font-weight:600;color:#333;">Subjek</label>
                            <input type="text" class="form-control" id="subjek" name="subjek" placeholder="Masukkan subjek" style="width:100%;padding:10px 12px;border:1px solid #ced4da;border-radius:10px;font-size:15px;">
                        </div>
                        <div class="mb-3" style="margin-bottom:1rem;">
                            <label for="deskripsi" class="form-label fw-semibold" style="display:block;margin-bottom:8px;font-weight:600;color:#333;">Deskripsi (opsional)</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" placeholder="Tulis deskripsi jika perlu" style="width:100%;padding:10px 12px;border:1px solid #ced4da;border-radius:10px;font-size:15px;"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-warning w-100 fw-bold" style="width:100%;padding:12px;border:none;border-radius:10px;background:#ffc107;color:#000;font-weight:700;font-size:16px;cursor:pointer;">Submit</button>
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
                    setTimeout(function(){
                        location.href = "/support/ticket/view";
                    }, 500);
                }
            })

        })
    })
</script>
