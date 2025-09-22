<!-- ini adalah permission, sistem create ini dapat digunakan ketika admin_Biasa dpt permisson dari super admin -->
<?php if($adminPermissionCore->isHavePermission($moduleId, "create")) : ?>
    <!-- form menginputkan nilai pd tabel country -->
    <div class="col mb-3 mt-5">
        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    <form id="countryForm">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="mb-3">
                            <label for="countryName" class="form-control-label">COUNTRY NAME</label>
                            <input type="text" class="form-control" id="countryName" name="countryName" placeholder="nama negara">
                        </div>
                        <div class="mb-3">
                            <label for="currency" class="form-control-label">CURRENCY</label>
                            <input type="text" class="form-control" id="currency" name="currency" placeholder="mata uang">
                        </div>
                        <div class="mb-3">
                            <label for="countryCode" class="form-control-label">CODE</label>
                            <input type="text" class="form-control" id="countryCode" name="countryCode" placeholder="kode">
                        </div>
                        <div class="mb-3">
                            <label for="phoneCode" class="form-control-label">PHONE CODE</label>
                            <input type="text" class="form-control" id="phoneCode" name="phoneCode" placeholder="kode telepon">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- form menginputkan nilai pd tabel country -->

<!-- script ini seperti controller yg mengarahkan request ke repository -->
<!-- cuman pd sintax ini, ketika tombol submit ditekan maka ajax akan memberikan request ke server guna untuk menambahkan nilai -->
    <script>
        $(document).ready(function(){
            // menambahkan data
            $('#countryForm').on('submit', function(e) {
                e.preventDefault();
                // memberikan efek loading pd tombol submit pd saat diklik
                let button = $(this).find('button[type="submit"]');
                button.addClass('loading')

                // menangkap nilai pd form inputan
                const countryName = $('#countryName').val().trim();
                const currency = $('#currency').val().trim();
                const countryCode = $('#countryCode').val().trim();
                const phoneCode = $('#phoneCode').val().trim();

                // semua inputan tersebut akan disimpan oleh $data
                // untuk di kirimkan je ajax
                // ajax akan request ke server untuk ditambahkan
                const data = {
                    countryName: countryName,
                    currency: currency,
                    countryCode: countryCode,
                    phoneCode: phoneCode
                };

                $.ajax({
                    url: '/ajax/post/master/negara/create',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    
                    // Menampilkan pesan sukses
                    success: function(response) {
                        // menghapus efek loading setelah muncul alert sukses pd saat menambahkan nilai
                        button.removeClass('loading')
                        Swal.fire(response.alert)
                        $('#countryForm')[0].reset();
                        table.ajax.reload();
                    },
                });
            });
        })
    </script>
<?php endif; ?>