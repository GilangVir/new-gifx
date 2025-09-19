<?php
// File ini hanya untuk menampilkan form
// Ambil data dari parameter URL jika ada

use App\Models\Country;
use App\Models\Helper;

$countryId = (int) Helper::form_input($_GET['d'] ?? '');
$country = Country::findById($countryId);
// Debug hanya di development
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
                            <meta name="csrf-token" content="{{ csrf_token() }}">

                            <input type="hidden" name="countryId" id="countryId" value="<?= htmlspecialchars($country['ID_COUNTRY']) ?>">

                            <div class="mb-3">
                                <label for="countryName" class="form-control-label">COUNTRY NAME</label>
                                <input type="text" class="form-control" id="countryName" name="countryName"
                                value="<?= htmlspecialchars($country['COUNTRY_NAME']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="currency" class="form-control-label">CURRENCY</label>
                                <input type="text" class="form-control" id="currency" name="currency" 
                                value="<?= htmlspecialchars($country['COUNTRY_CURR']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="countryCode" class="form-control-label">CODE</label>
                                <input type="text" class="form-control" id="countryCode" name="countryCode"  
                                value="<?= htmlspecialchars($country['COUNTRY_CODE']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="phoneCode" class="form-control-label">PHONE CODE</label>
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

            const formData = {
                id: $('#countryId').val(),
                countryName: $('#countryName').val().trim(),
                currency: $('#currency').val().trim(),
                countryCode: $('#countryCode').val().trim(),
                phoneCode: $('#phoneCode').val().trim()
            };

            //validasi input
            if(!formData.countryName || !formData.currency || !formData.countryCode || !formData.phoneCode) {
                alert('Semua field harus diisi');
                return;
            }

            console.log('Data yang akan diupdate:', formData);

            $.ajax({
                processing: true,
                serverSide: true,
                url: '/ajax/post/master/negara/update',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    alert('Data berhasil diupdate!');
                    {
                        location.href = "/master/negara/view";
                    }
                    $('#countryForm')[0].reset();
                    table.ajax.reload();
                    
                },
            });
        });
    });

</script>