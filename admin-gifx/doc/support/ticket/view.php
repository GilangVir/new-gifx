<div class="container mt-4">
    <!-- Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center py-3 px-4 gap-2">
                    <h5 class="mb-2 mb-md-0 fw-bold text-primary">🎫 TICKET</h5>
                    <button type="button" id="buttonCreate" class="btn btn-primary px-4">
                        <i class="bi bi-plus-circle me-1"></i> New Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-2 p-md-4">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="table">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>DATA REQ</th>
                                    <th>LAST CONVERSATION DATE</th>
                                    <th>CODE</th>
                                    <th>EMAIL</th>
                                    <th>SUBJECT</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    let table;
    $(document).ready(function() {
        table = $('table').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollx: false,
            order:[[0, 'desc']],
            ajax: {
                url: "/ajax/datatable/support/ticket/view",
                contentType: "application/json",
                type: "GET",
            },
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],
            columns: [
                { data: 'TICKET_DATETIME' },
                { data: 'TICKET_DATETIME_CLOSE' },
                { data: 'TICKET_CODE' },  // tetap menampilkan code
                { data: 'EMAIL' },
                { data: 'TICKET_SUBJECT' },
                { data: 'TICKET_STS' },
                { data: 'ACTION', orderable: false }  // tombol Detail muncul di kolom #
            ],
            order: [[0, 'desc']],
            
            drawCallback:function(settings) {
                $('#buttonCreate').on('click', function(e){
                    e.preventDefault();
                    window.location.href = `/support/ticket/create`
                });

                $('.update-btn').on('click', function(e){
                    e.preventDefault();

                    const tiketcode = $(this).data('tiketcode'); 
    
                    // setelah mendapatkan id, maka nilai tersebut akan diarahkan ke tampilan update.. untuk diupdate pd nilai tersebut
                        window.location.href = `/support/ticket/detail/${tiketcode}`;
                });

                $('.delete-btn').on('click', function() {
                    const tiketcode = $(this).data('tiketcode'); // Mengambil dari data-id="?" dari tombol delete
                    if(confirm('Apakah yakin untuk menghapus?')) {
                        // fungsi ajax utk mengirim request ke server untuk menghapus data
                        $.ajax({
                            url: `/ajax/post/support/ticket/delete`,
                            type: 'POST',
                            dataType: 'json', 
                            data: { tiketcode: tiketcode },
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
            }
        })
    })
</script>