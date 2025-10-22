    <div class="row">
        <div class="col-md-12">
            <div class="card my-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="tabel">
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
<script type="text/javascript">
    let table;
    $(document).ready(function(){
        table = $('#tabel').DataTable({
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