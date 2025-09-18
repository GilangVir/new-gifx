    
<div class="row">
<!-- form create -->
        <div class="col mb-3 mt-5">
            <div class="card">
                <div class="card-header">
                    <div class="card-body">
                        <form id="countryForm">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="mb-3">
                                <label for="countryName" class="form-control-label">COUNTRY NAME</label>
                                <input type="text" class="form-control" id="countryName" name="countryName" placeholder="nama negara">
                            </div>
                            <div class="mb-3">
                                <label for="currency" class="form-control-label">CURRENCY</label>
                                <input type="text" class="form-control" id="currency" name="currency" placeholder="mata uang">
                            </div>
                            <div class="mb-3">
                                <label for="countryCode" class="form-control-label">CODE</label>
                                <input type="text" class="form-control" id="countryCode" name="countryCode" placeholder="kode">
                            </div>
                            <div class="mb-3">
                                <label for="phoneCode" class="form-control-label">PHONE CODE</label>
                                <input type="text" class="form-control" id="phoneCode" name="phoneCode" placeholder="kode telepon">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!-- form create -->

<!-- tables -->
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
<!-- tables -->
<script type="text/javascript">
    let table;
    $(document).ready(function() {
        // menampilkan data table
        // Datatable ini digunakan mengirikan request ke ajax(menampilkan data, menghapus data)
        table = $('#countriesTable').DataTable({ 
            processing: true,
            serverSide: true, //Data di-load dari server, bukan dari client (data diambil dari server)
            deferRender: true, //Optimasi performa untuk dataset besar
            scrollX: true,
            order: [[0, 'desc']],
            ajax: {
                url: "/ajax/datatable/master/negara/view",
                contentType: "application/json",
                type: "GET",
            }, 
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],
            // delete
            drawCallback: function(settings) {
                $('.delete-btn').on('click', function() {
                    const countryId = $(this).data('id');
                    console.log('Attempting to delete country ID:', countryId)
                    if(confirm('Are you sure you want to delete this country?')) {
                        $.ajax({
                            url: `/ajax/post/master/negara/delete`,
                            type: 'POST',
                            data: { id: countryId },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            success: function(response) {
                                alert('Country deleted successfully!');
                                table.ajax.reload();
                            },
                            error: function(xhr, status, error) {
                                alert('An error occurred while deleting the country.');
                            }
                        });
                    }
                });
            }
        });

        // menambahkan data
        $('#countryForm').on('submit', function(e) {
            e.preventDefault();

            // Debug: Cek apakah event handler berjalan
            console.log('Form submit triggered');

            const countryName = $('#countryName').val().trim();
            const currency = $('#currency').val().trim();
            const countryCode = $('#countryCode').val().trim();
            const phoneCode = $('#phoneCode').val().trim();

            // Validasi input
            if (!countryName || !currency || !countryCode || !phoneCode) {
                alert('Please fill in all fields.');
                return;
            }

            const data = {
                countryName: countryName,
                currency: currency,
                countryCode: countryCode,
                phoneCode: phoneCode
            };

            $.ajax({
                processing: true,
                serverSide: true,
                url: '/ajax/post/master/negara/create',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    alert('Data berhasil disimpan!');
                    $('#countryForm')[0].reset();
                    table.ajax.reload();
                },
            });
        });
    });


</script>


</body>
</html>
