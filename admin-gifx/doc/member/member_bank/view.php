<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card my-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="tabel">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>DATETIME</th>
                                    <th>FULLNAME</th>
                                    <th>BANK_NAME</th>
                                    <th>ACCOUNT_NUMBER</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- tabel history -->
    <div class="row">
        <div class="col-md-12">
            <div class="card my-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="tabel_history">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Datetime</th>
                                    <th>Fullname</th>
                                    <th>Nama Bank</th>
                                    <th>Nomer rekening</th>
                                    <th>Status</th>
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
    let table, tableHistory;
    $(document).ready(function(){
        table = $('#tabel').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollX: false,
            order: [[0, 'desc']],
            ajax: {
                url: "/ajax/datatable/member/member_bank/view",
                contentType: "application/json",
                type: "GET",
            },
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],

            drawCallback:function(settings) {
                $('#tabel').on('click', '.accept-btn', function(e){
                    e.preventDefault();
                    const button = $(this);
                    const id = $(this).data('accept');
                    $.ajax({
                        url: '/ajax/post/member/member_bank/action',
                        type: 'POST',
                        dataType: 'json', 
                        contentType: 'application/json',
                        data: JSON.stringify({ action: 'accept', id: id }),

                        success: function(response) {
                            button.removeClass('loading');
                            Swal.fire(response.alert);
                            table.ajax.reload();        // reload tabel utama
                            tableHistory.ajax.reload(); // reload tabel history
                        }
                    })
                });
        
                $('#tabel').on('click', '.reject-btn', function(e){
                    e.preventDefault();
                    const button = $(this);
                    const id = $(this).data('reject');
                    $.ajax({
                        url: '/ajax/post/member/member_bank/action',
                        type: 'POST',
                        dataType: 'json', 
                        contentType: 'application/json',
                        data: JSON.stringify({ action: 'reject', id: id }),
                        success: function(response) {
                            button.removeClass('loading');
                            Swal.fire(response.alert);
                            table.ajax.reload();        // reload tabel utama
                            tableHistory.ajax.reload(); // reload tabel history
                        }
                    })
                });
            }
        });

        const tableHistory = $('#tabel_history').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollX: false,
            order: [[0, 'desc']],
            ajax: {
                url: "/ajax/datatable/member/member_bank/history",
                contentType: "application/json",
                type: "GET",
            },
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],
        });
    });
</script>