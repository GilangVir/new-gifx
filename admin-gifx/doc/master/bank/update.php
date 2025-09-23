<?php
use App\Models\Bank;
use App\Models\Helper;

// metode ini digunakan untuk mengambil nilai id yg kirim dari tampilan view
$idBanklst = (int) Helper::form_input($_GET['d'] ?? '');
// setelah itu, nilai id tersebut akan dibuat untuk mengambil nilai dari tabel bank berdasarkan id
// setelah $idBank menyimpan nilai tersebut, digunakan untuk ditampilkan ke halaman form inputan update untuk diupdate
$bank = Bank::findById($idBanklst);
// jika nilai id tersebut kosong/ null maka admin akan diarahkan ke halaman view
if (!$bank) {
    die('<script>alert("id not found"); location.href = "/master/bank/view"</script>');
}
?>

<div class="row">
        <div class="col mb-3 mt-5">
            <div class="card">
                <div class="card-header">
                    <h1>UPDATE NAMA BANK</h1>
                    <div class="card-body">
                        <form id="updateBank">

                            <input type="hidden" name="id" id="id" value="<?= htmlspecialchars($bank['ID_BANKLST']) ?>">

                            <div class="mb-3">
                                <label for="name" class="form-control-label">NAMA BANK</label>
                                <input type="text" class="form-control" id="name" name="name"
                                value="<?= htmlspecialchars($bank['BANKLST_NAME']) ?>">
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#updateBank').on('submit', function(e) {
            e.preventDefault();
            // memberikan efek loading pd tombol submit pd saat diklik
            let button = $(this).find('button[type="submit"]');
            button.addClass('loading')
            
            // setelah tombol disubmit, maka nilai yg dikirimkan akan diambil dan disimpan oleh $formData
            const formData = {
                id: $('#id').val(),
                name: $('#name').val().trim(),
            };
            
            // setelah nilai tersebut ditrima oleh formData maka ajax akan request ke server untuk melakukan update
            $.ajax({
                url: '/ajax/post/master/bank/update',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    // menghapus efek loading setelah muncul alert sukses pd saat menambahkan nilai
                    button.removeClass('loading')
                    Swal.fire(response.alert)
                    setTimeout(function() {
                        location.href = "/master/bank/view";
                    }, 500);
                },
            });
        });
    });

</script>




