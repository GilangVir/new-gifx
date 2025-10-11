<?php
use App\Models\Helper;
use App\Models\MemberBank;
use App\Models\FileUpload;

$id = (int) Helper::form_input($_GET['id'] ?? '');
$nilai = MemberBank::getById($id);



$query = $db->prepare('SELECT * FROM tb_banklist ORDER BY BANKLST_NAME');
$query->execute();
$result = $query->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);

if (!$nilai) {
    die('<script>alert("id not found"); location.href = "/bank/index"</script>');
}

?>

<div class="row">
        <div class="col mb-3 mt-5">
            <div class="card">
                <div class="card-header">
                    <h1>UPDATE BANK</h1>
                    <div class="card-body">
                        <form id="update" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<?= $nilai['ID_MBANK']?>">
                            <div class="mb-3">
                                <label for="nama_bank" class="form-control-label">Nama Bank</label>
                                <select class="form-select" id="nama_bank" name="nama_bank">
                                    <option disabled <?= empty($nilai['MBANK_NAME']) ? 'selected' : '' ?>>Pilih Bank</option>
                                    <?php foreach ($data as $bank): ?>
                                        <option value="<?= $bank['BANKLST_NAME']?>" <?= ($bank['BANKLST_NAME'] == $nilai['MBANK_NAME']) ? 'selected' : '' ?>>
                                            <?= $bank['BANKLST_NAME']?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nama_nasabah" class="form-control-label">Nama Pemilik Rekening</label>
                                <input type="text" class="form-control" id="nama_nasabah" name="nama_nasabah" 
                                value="<?= $nilai['MBANK_HOLDER']?>">
                            </div>
                            <div class="mb-3">
                                <label for="nomer" class="form-control-label">No. Rekening</label>
                                <input type="text" class="form-control" id="nomer" name="nomer"
                                value="<?= $nilai['MBANK_ACCOUNT']?>">
                            </div>
                            <div class="mb-3">
                                <label for="buku_tabungan" class="form-control-label">GAMBAR</label>
                                <input type="file" class="form-control" id="buku_tabungan" name="buku_tabungan">
                                    <?php if (!empty($nilai['MBANK_IMG'])): ?>
                                        <div style="margin-top:10px;">
                                            <p>Gambar lama:</p>
                                            <img src="<?= FileUpload::awsFile($nilai['MBANK_IMG']) ?>" 
                                                alt="Preview" 
                                                style="max-width:150px; border:1px solid #ccc; padding:3px; object-fit:cover; border:1px solid #ccc; padding:3px; cursor:pointer;"
                                                onclick="showImageModal('<?= FileUpload::awsFile($nilai['MBANK_IMG']) ?>')">
                                        </div>
                                    <?php endif; ?>
                            </div>
                            <!-- Modal untuk menampilkan gambar ukuran penuh -->
                            <div id="imageModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.8); padding:20px;">
                                <span onclick="closeImageModal()" style="position:absolute; top:20px; right:40px; color:#fff; font-size:40px; font-weight:bold; cursor:pointer;">&times;</span>
                                <img id="modalImage" style="margin:auto; display:block; max-width:90%; max-height:90%; object-fit:contain;">
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

<script>
        // Menampilkan gambar pd saat diklik
            function showImageModal(src) {
            document.getElementById('imageModal').style.display = 'block';
            document.getElementById('modalImage').src = src;
        }

        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        // Close modal ketika klik di luar gambar
        document.getElementById('imageModal').onclick = function(e) {
            if (e.target.id === 'imageModal') {
                closeImageModal();
            }
        }

        $(document).ready(function(){
            $('#update').on('submit', function(e){
                e.preventDefault();

                 let formData = new FormData(this); // ambil semua data form

                $.ajax({
                url: '/ajax/post/bank/update',
                type: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    // button.removeClass('loading')
                    Swal.fire(response.alert)
                    setTimeout(function(){
                        location.href = "/bank/index";
                    }, 500);
                },
                });
            })
        })
</script>