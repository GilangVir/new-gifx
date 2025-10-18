<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4">
                    <h5 class="mb-0 fw-bold text-primary">🎫 TICKET</h5>
                    <button type="button" id="buttonCreate" class="btn btn-primary px-4">
                        <i class="bi bi-plus-circle me-1"></i> New Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="table">
                            <thead class="table-light">
                                <tr>
                                    <th>DATA REQ</th>
                                    <th>LAST CONVERSATION DATE</th>
                                    <th>CODE</th>
                                    <th>EMAIL</th>
                                    <th>SUBJECT</th>
                                    <th>STATUS</th>
                                    <th>#</th>
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
            drawCallback:function(settings) {
                $('#buttonCreate').on('click', function(e){
                    e.preventDefault();
                    window.location.href = `/support/ticket/create`
                })
            }
        })
    })
</script>