    
<div class="row">
<!-- form menginputkan nilai pd tabel negara -->
<?php require_once __DIR__ . "/create.php"; ?>

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

            drawCallback: function(settings) {
                // fungsi ini diperlukan pd saat tombol delete diklik
                // setelah tombol delete diklik, ambil data-id dan datatable akan melakukan request ke ajax
                // delete
                $('.delete-btn').on('click', function() {
                    const countryId = $(this).data('id'); // Mengambil dari data-id="?" dari tombol delete
                    console.log('Attempting to delete country ID:', countryId)
                    if(confirm('Are you sure you want to delete this country?')) {
                        // fungsi ajax utk mengirim request ke server untuk menghapus data
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
                
                // update
                $('.update-btn').on('click', function(e){
                    e.preventDefault();
                    //ambil nilai id dari tombol update
                    // ketika tombol update diklik maka nilai id tersebut akan disimpan juga oleh const countryId
                    // tujuannya nilai tabel berdasarkan id tersebut akan di update
                    const countryId = $(this).data('id'); 
                    console.log('Mencoba memperbarui ID negara:', countryId);
    
                    // metode ini digunakan untuk mengecek nilai tabel berdasarkan id tersebut
                    const row = $(this). closest('tr');
                        const rowData = table.row(row).data();
                        console.log('Data baris yang diambil:', rowData);
    
                    // setelah mendapatkan id, maka nilai tersebut akan diarahkan ke tampilan update.. untuk diupdate pd nilai tersebut
                        window.location.href = `/master/negara/update/${countryId}`;
                })
            },
        });        
    });


</script>