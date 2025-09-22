<div class="row">
    <!-- form menginputkan nilai pd tabel bank -->
    <?php require_once __DIR__ . "/create.php"; ?>

    <div class="col mb-5 mt-5">
        <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>LIST BANK</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="banklist">
                        <thead>
                            <tr>
                                <th scope="col">NAMA BANK</th>
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
        table = $('#banklist').DataTable({
            processing: true,
            serverSide: true, //Data di-load dari serve, bukan dari client(data diambil dari server)
            deferRender: true, //optimasi perfoma untuk dataset besar
            scrollX: true,
            order: [[0, 'desc']],
            ajax: {
                url: "/ajax/datatable/master/bank/view",
                contentType: "application/json",
                type: "GET",
            },
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],

            drawCallback: function(settings)
            {
                $('.delete-btn').on('click', function() {
                    const idBanklst = $(this).data('id'); // Mengambil dari data-id="?" dari tombol delete
                    if(confirm('Apakah yakin untuk menghapus?')) {
                        // fungsi ajax utk mengirim request ke server untuk menghapus data
                        $.ajax({
                            processing: true,
                            serverSide: true,
                            url: `/ajax/post/master/bank/delete`,
                            type: 'POST',
                            dataType: 'json', 
                            data: { id: idBanklst },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
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
                    //ambil nilai id dari tombol update
                    // ketika tombol update diklik maka nilai id tersebut akan disimpan juga oleh const countryId
                    const idBanklst = $(this).data('id'); 
                    // setelah mendapatkan id, maka nilai tersebut akan diarahkan ke tampilan update.. untuk diupdate pd nilai tersebut
                        window.location.href = `/master/bank/update/${idBanklst}`;
                })
            }
        })
    })
</script>