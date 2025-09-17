    
    <!-- tables -->
<div class="row">
    <div class="col-12 d-flex justify-content-center">
        <div class="col mb-3 mt-5">
            <div class="card">
                <div class="card-header">
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-control-label">COUNTRY NAME</label>
                                <input type="" class="form-control" id="exampleFormControlInput1" placeholder="nama negara">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-control-label">CURRENCY</label>
                                <input type="" class="form-control" placeholder="mata uang">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-control-label">CODE</label>
                                <input type="" class="form-control" id="exampleFormControlInput1" placeholder="kode">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-control-label">PHONE CODE</label>
                                <input type="" class="form-control" id="exampleFormControlInput1" placeholder="kode telepon">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col mb-3 mt-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>List Negara</h5>
                    
                </div>
                 <div class="card-body">
                    <table class="table table-striped" id="countriesTable">
                        <thead>
                            <tr>
                            <th scope="col">COUNTRY NAME</th>
                            <th scope="col">CURRENCY</th>
                            <th scope="col">CODE</th>
                            <th scope="col">PHONE CODE</th>
                            <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

         
    <!-- tables -->

    
<script type="text/javascript">
    let table;
    $(document).ready(function() {
        table = $('#countriesTable').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollX: true,
            order: [[0, 'desc']],
            ajax: {
                url: "/ajax/datatable/master/negara/view",
                contentType: "application/json",
                type: "GET",
            },
            columns: [
                { data: 'COUNTRY_NAME' },
                { data: 'COUNTRY_CURR' },
                { data: 'COUNTRY_CODE' },
                { data: 'COUNTRY_PHONE_CODE' },
                { data: 'action', orderable: false, searchable: false } // Kolom action
            ],
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ]
        });
    });
</script>
</body>
</html>
