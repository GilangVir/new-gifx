<?php
use App\Models\Country;
use App\Models\Helper;
// metode ini digunakan untuk mengambil nilai id yg kirim dari tampilan view
$countryId = (int) Helper::form_input($_GET['d'] ?? '');
// setelah itu, nilai id tersebut akan dibuat untuk mengambil nilai dari tabel contry berdasarkan id
// setelah $country menyimpan nilai tersebut, digunakan untuk ditampilkan ke halaman form inputan untuk diupdate
$country = Country::findById($countryId);
// jika nilai id tersebut kosong/ null maka admin akan diarahkan ke halaman view
if (!$country) {
    die('<script>alert("id not found"); location.href = "/master/negara/view"</script>');
}

?>

<div class="row">
        <div class="col mb-3 mt-5">
            <div class="card">
                <div class="card-header">
                    <h1>UPDATE NEGARA</h1>
                    <div class="card-body">
                        <form id="updateCountryForm">

                            <input type="hidden" name="countryId" id="countryId" value="<?= htmlspecialchars($country['ID_COUNTRY']) ?>">

                            <div class="mb-3">
                                <label for="countryName" class="form-control-label">NAMA NEGARA</label>
                                <input type="text" class="form-control" id="countryName" name="countryName"
                                value="<?= htmlspecialchars($country['COUNTRY_NAME']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="currency" class="form-control-label">MATA UANG</label>
                                <input type="text" class="form-control" id="currency" name="currency" 
                                value="<?= htmlspecialchars($country['COUNTRY_CURR']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="countryCode" class="form-control-label">KODE</label>
                                <input type="text" class="form-control" id="countryCode" name="countryCode"  
                                value="<?= htmlspecialchars($country['COUNTRY_CODE']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="phoneCode" class="form-control-label">KODE HP</label>
                                <input type="text" class="form-control" id="phoneCode" name="phoneCode"  
                                value="<?= htmlspecialchars($country['COUNTRY_PHONE_CODE']) ?>">
                            
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
        $('#updateCountryForm').on('submit', function(e) {
            e.preventDefault();
            // memberikan efek loading pd tombol submit pd saat diklik
            let button = $(this).find('button[type="submit"]');
            button.addClass('loading')

            // setelah tombol disubmit, maka nilai yg dikirimkan akan diambil dan disimpan oleh $formData
            const formData = {
                id: $('#countryId').val(),
                countryName: $('#countryName').val().trim(),
                currency: $('#currency').val().trim(),
                countryCode: $('#countryCode').val().trim(),
                phoneCode: $('#phoneCode').val().trim()
            };

            // setelah nilai tersebut ditrima oleh formData maka ajax akan request ke server untuk melakukan update
            $.ajax({
                url: '/ajax/post/master/negara/update',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    // menghapus efek loading setelah muncul alert sukses pd saat menambahkan nilai
                    button.removeClass('loading')
                    Swal.fire(response.alert)
                    setTimeout(function(){
                        location.href = "/master/negara/view";
                    }, 500);
                },
            });
        });
    });

</script>