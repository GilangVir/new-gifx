<div class="container">
    <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    TICKET
                </div>
            </div>
    </div>
    <div class="row">
        <?php require_once __DIR__ . "/create.php"; ?>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="tabel">
                            <thead>
                                <tr>
                                    <th>Tanggal Dibuat</th>
                                    <th>Kode</th>
                                    <th>Subjek</th>
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
                url: "/ajax/datatable/ticket",
                contentType: "application/json",
                type: "GET",
            },
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],
        });
    })
</script>