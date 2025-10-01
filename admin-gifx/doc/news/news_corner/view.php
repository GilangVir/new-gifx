<div class="row">
<!-- form menginputkan nilai pd tabel negara -->
<?php require_once __DIR__ . "/create.php"; ?>

    <div class="col mb-5 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>News Corner</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="news">
                    <thead>
                        <tr>
                            <th scope="col">TYPE</th>
                            <th scope="col">JUDUL</th>
                            <th scope="col">PESAN</th>
                            <th scope="col">PEMBUAT</th>
                            <th scope="col">GAMBAR</th>
                            <th scope="col">SLUG</th>
                            <th scope="col">ACTION</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    let table;
    $(document).ready(function(){
            table = $('#news').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                scrollX: true,
                order: [[0, 'desc']],
                ajax: {
                    url: "/ajax/datatable/news/news_corner/view",
                    contentType: "application/json",
                    type: "GET",
                },
                lengthMenu: [
                    [10, 50, 100, -1],
                    [10, 50, 100, "All"]
                ], 
                
                // menampilkan nilai message hanya sebagian
                columnDefs: [
                            {
                                targets: 2, // kolom PESAN
                                className: 'text-truncate',
                                width: '250px',
                                render: function(data, type, row) {
                                    // Strip HTML tags
                                    let text = data.replace(/<[^>]*>/g, '');
                                    return '<div style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' + text + '</div>';
                                }
                            }
                        ],

            drawCallback: function(settings) {
                $('.delete-btn').on('click', function(e) {
                    e.preventDefault();
                    let button = $(this).find('button[type="submit"]');
                    button.addClass('loading')
                    const id = $(this).data('id');
                    if(confirm('Apakah anda yakin untuk menghapus?')) {
                        $.ajax({
                            url: `/ajax/post/news/news_corner/delete`,
                            type: 'POST',
                            dataType: 'json',
                            data: { id: id },
                            success: function(response) {
                                Swal.fire(response.alert)
                                table.ajax.reload();
                            },
                        });
                    }
                });

                // update
                $('.update-btn').on('click', function(e){
                    e.preventDefault();
                    const id = $(this).data('id'); 
                    window.location.href = `/news/news_corner/update/${id}`;
                })
            },
        });
    });
</script>