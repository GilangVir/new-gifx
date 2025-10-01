<?php

use App\Models\FileUpload;
use App\Models\FundamentalsAnalysis;
use App\Models\Helper;

$id = (int) Helper::form_input($_GET['d'] ?? '');

$nilai = FundamentalsAnalysis::findById($id);

if (!$nilai) {
    die('<script>alert("id not found"); location.href = "/news/news_corner/view"</script>');
}

?>
<!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<div class="row">
        <div class="col mb-3 mt-5">
            <div class="card">
                <div class="card-header">
                    <h1>News Corner</h1>
                    <div class="card-body">
                        <form id="fundamen">

                            <input type="hidden" name="ID_BLOG" id="ID_BLOG" value="<?= $nilai['ID_BLOG']?>">

                            <div class="mb-3">
                                <label for="BLOG_TITLE" class="form-control-label">JUDUL</label>
                                <input type="text" class="form-control" id="BLOG_TITLE" name="BLOG_TITLE"
                                value="<?= $nilai['BLOG_TITLE'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="BLOG_MESSAGE" class="form-control-label">PESAN</label>
                                <div id="editor"><?= $nilai['BLOG_MESSAGE'] ?></div>
                                <input type="hidden" name="BLOG_MESSAGE" id="BLOG_MESSAGE">

                            <div class="mb-3">
                                <label for="BLOG_IMG" class="form-control-label">GAMBAR</label>
                                <input type="file" class="form-control" id="BLOG_IMG" name="BLOG_IMG">
                                    <?php if (!empty($nilai['BLOG_IMG'])): ?>
                                        <div style="margin-top:10px;">
                                            <p>Gambar lama:</p>
                                            <img src="<?= FileUpload::awsFile($nilai['BLOG_IMG']) ?>" 
                                                alt="Preview" 
                                                style="max-width:150px; border:1px solid #ccc; padding:3px; object-fit:cover; border:1px solid #ccc; padding:3px; cursor:pointer;"
                                                onclick="showImageModal('<?= FileUpload::awsFile($nilai['BLOG_IMG']) ?>')">
                                                
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
<script class="text/javascript">
    // Inisialisasi Quill editor
        const quill = new Quill('#editor', {
            modules: {
                toolbar: [
                    [{ header: [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote'],
                    [{ 'align': [] }]
                    ],
                },
                placeholder: 'Tulis pesan blog di sini...',
                theme: 'snow',
            });
        
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
        $('#fundamen').on('submit', function(e){
            e.preventDefault();
            // simpan isi editor ke hidden input
            $('#BLOG_MESSAGE').val(quill.root.innerHTML);
            let button = $(this).find('button[type="submit"]');
            button.addClass('loading')

            let formData = new FormData(this); // ambil semua data form

            $.ajax({
                url: '/ajax/post/news/news_corner/update',
                type: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    button.removeClass('loading')
                    Swal.fire(response.alert)
                    setTimeout(function(){
                        location.href = "/news/news_corner/view";
                    }, 500);
                },
            });
        })
    })
</script>