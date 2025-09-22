<?php

use App\Models\ProdukKategori;
use App\Models\Helper;

$idProduk = (int) Helper::form_input($_GET['d'] ?? '');

$produk = ProdukKategori::findById($idProduk);

if(!$produk) {
    die('<script>alert("id not found"); location.href = "/master/produk_kategori/view"</script>');
}
?>

<div class="row">
        <div class="col mb-3 mt-5">
        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    <form id="produkform">
                        <input type="hidden" name="id" id="id" value="<?= $produk['ID_ACCKAT'] ?>">
                        <div class="mb-3">
                            <label for="nama" class="form-control-label">NAMA PRODUK</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="nama produk"
                            value="<?= $produk['ACCKAT_NAME'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-control-label">CODE PRODUK</label>
                            <input type="text" class="form-control" id="code" name="code" readonly 
                            value="<?= $produk['ACCKAT_CODE'] ?>">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
            function generateCode(nama) {
                if (!nama) return '';
                
                // Mengubah teks menjadi lowercase
                let code = nama.toLowerCase();
                
                // Menghapus karakter khusus dan spasi
                code = code.replace(/[^a-z0-9\s]/g, '');
                
                // Mengganti spasi dengan underscore
                code = code.replace(/\s+/g, '_');
                
                return code;
            }

            $('#nama').on('input', function() {
                const nama = $(this).val().trim();
                const generatedCode = generateCode(nama);
                $('#code').val(generatedCode);
            });

            
            // menambahkan data
            $('#produkform').on('submit', function(e) {
                e.preventDefault();
                // memberikan efek loading pd tombol submit pd saat diklik
                let button = $(this).find('button[type="submit"]');
                button.addClass('loading')

                // menangkap nilai pd form inputan
                const id = $('#id').val();
                const nama = $('#nama').val().trim();
                const code = $('#code').val().trim();

                // semua inputan tersebut akan disimpan oleh $data
                // untuk di kirimkan je ajax
                // ajax akan request ke server untuk ditambahkan
                const data = {
                    id: id,
                    nama: nama,
                    code: code,
                };

                $.ajax({
                    url: '/ajax/post/master/produk_kategori/update',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    
                    // Menampilkan pesan sukses
                    success: function(response) {
                        // menghapus efek loading setelah muncul alert sukses pd saat menambahkan nilai
                        button.removeClass('loading')
                        Swal.fire(response.alert)
                        setTimeout(function(){
                        location.href = "/master/produk_kategori/view";
                    }, 500);
                    },
                });
            });
    })
</script>