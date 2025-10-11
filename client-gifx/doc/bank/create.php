<div class="col">
        <div class="card">
            <div class="card-header">
                <div>Tambah Bank</div>
            </div>
            <div class="card-body">
                <form id="form">
                    <div class="mb-3">
                        <label for="nama_bank" class="form-control-label">Nama Bank</label>
                        <select class="form-select" id="nama_bank" name="nama_bank">
                            <option selected disabled>Pilih Bank</option>
                            <?php foreach ($banklist as $nilai): ?>
                                <option value="<?= $nilai['BANKLST_NAME']?>">
                                    <?= $nilai['BANKLST_NAME']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_nasabah" class="form-control-label">Nama Pemilik Rekening</label>
                        <input type="text" class="form-control" id="nama_nasabah" name="nama_nasabah" placeholder="Nama pemilik rekening">
                    </div>
                    <div class="mb-3">
                        <label for="nomer" class="form-control-label">No. Rekening</label>
                        <input type="text" class="form-control" id="nomer" name="nomer" placeholder="Nomer rekening">
                        <small id="warning" class="text-danger" style="display:none;"></small>
                    </div>
                    <div class="mb-3">
                        <label for="buku_tabungan" class="form-label">Cover Buku Tabungan <span class="text-danger">*</span></label>
                        <div class="border border-2 rounded d-flex flex-column align-items-center justify-content-center p-5" 
                            style="cursor: pointer; min-height: 180px; text-align:center;" 
                            onclick="document.getElementById('buku_tabungan').click()">
                            <i class="bi bi-cloud-arrow-up fs-1 mb-2"></i>
                            <p class="text-muted">Drag and drop a file here or click</p>
                            <span id="file-name" class="text-primary mt-2 fw-bold"></span> 
                        </div>
                        <input type="text" class="form-control d-none" id="buku_tabungan" name="buku_tabungan">
                    </div>
                    <!-- Tombol Submit -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-warning px-4" style="color:white;">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>

    //validasi no.rek
    const input = document.getElementById('nomer');
    const warning = document.getElementById('warning');

    input.addEventListener('input', function(){
        const value = this.value.trim();
        if(!/^\d+$/.test(value)) {
            warning.style.display = 'block';
            warning.textContent = 'Nomor rekening hanya boleh berisi angka!';
        }else{
            // Jika kembali valid (angka semua) -> sembunyikan pesan
            warning.style.display = 'none';
            warning.textContent = '';
        }
    });

    // menampilkan nama file img
     $(document).ready(function(){
        // document.getElementById('buku_tabungan').addEventListener('change', function() {
        //     const fileInput = this;
        //     const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : 'Belum ada file';
        //     document.getElementById('file-name').textContent = fileName;
        // });

        $('#form').on('submit', function(e){
            e.preventDefault();
            let button = $(this).find('button[type="submit"]');
            button.addClass('loading')

            let formData = new FormData(this); // ambil semua data form

            $.ajax({
                url: '/ajax/post/bank/create',
                type: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                data: formData,
                success:function(response)
                {
                    button.removeClass('loading')
                    swal.fire(response.alert)

                    if(response.success === true){
                        $('#form')[0].reset();
                        $('#file-name').text(''); // kosongkan teks nama file
                        table.ajax.reload();
                            }
                        },
            });
        });
    })
</script>