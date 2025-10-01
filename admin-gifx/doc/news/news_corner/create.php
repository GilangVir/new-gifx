<?php 
use App\Models\Admin;    
if($adminPermissionCore->isHavePermission($moduleId, "create")) :

?>
    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <!-- form menginputkan nilai pd tabel country -->
    <div class="col mb-3 mt-5">
        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    <form id="tb_blog">
                        <div class="mb-3">
                            <label for="BLOG_TITLE" class="form-control-label">JUDUL</label>
                            <input type="text" class="form-control" id="BLOG_TITLE" name="BLOG_TITLE" placeholder="Masukkan Judul">
                        </div>
                        
                        <div class="mb-3">
                            <label for="BLOG_MESSAGE" class="form-control-label">PESAN</label>
                            <div id="editor"></div>
                            <input type="hidden" name="BLOG_MESSAGE" id="BLOG_MESSAGE">
                        </div>
                        <div class="mb-3">
                            <label for="BLOG_IMG" class="form-control-label">GAMBAR</label>
                            <input type="file" class="form-control" id="BLOG_IMG" name="BLOG_IMG" placeholder="Upload gambar">
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

        $(document).ready(function(){
            $('#tb_blog').on('submit', function(e) {
                e.preventDefault();
                let button = $(this).find('button[type="submit"]');
                button.addClass('loading')

                 // simpan isi Quill ke hidden input
                $('#BLOG_MESSAGE').val(quill.root.innerHTML);

                let formData = new FormData(this); // ambil semua data form

                $.ajax({
                    url: '/ajax/post/news/news_corner/create',
                    type: 'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    data: formData,

                    success:function(response)
                    {
                        button.removeClass('loading')
                        swal.fire(response.alert)
                        $('#tb_blog')[0].reset();
                        
                        quill.setContents([]);
                        $('#BLOG_MESSAGE').val('');
                        table.ajax.reload();
                    },
                });
            });
        })
    </script>
<?php endif; ?>