    
<?php if($adminPermissionCore->isHavePermission($moduleId, "create")) : ?>

    <div class="col mb-3 mt-5">
        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    <form id="produkform">
                        <div class="mb-3">
                            <label for="nama" class="form-control-label">NAMA PRODUK</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="nama produk">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            // menambahkan data
            $('#produkform').on('submit', function(e) {
                e.preventDefault();
                // memberikan efek loading pd tombol submit pd saat diklik
                let button = $(this).find('button[type="submit"]');
                button.addClass('loading')

                // menangkap nilai pd form inputan
                const nama = $('#nama').val().trim();

                $.ajax({
                    url: '/ajax/post/master/produk_kategori/create',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({nama: nama}),
                    
                    // Menampilkan pesan sukses
                    success: function(response) {
                        // menghapus efek loading setelah muncul alert sukses pd saat menambahkan nilai
                        button.removeClass('loading')
                        Swal.fire(response.alert)
                        $('#produkform')[0].reset();
                        table.ajax.reload();
                    },
                });
            });
        })
    </script>
    <?php endif; ?>