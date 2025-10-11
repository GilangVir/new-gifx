

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
                            <th scope="col">NAMA NEGARA</th>
                            <th scope="col">MATA UANG</th>
                            <th scope="col">KODE</th>
                            <th scope="col">KODE HP</th>
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
                $('.delete-btn').on('click', function() {
                    const countryId = $(this).data('id');
                    if(confirm('Apakah anda yakin untuk menghapus?')) {
                        // fungsi ajax utk mengirim request ke server untuk menghapus data
                        $.ajax({
                            processing: true,
                            serverSide: true,
                            url: `/ajax/post/master/negara/delete`,
                            type: 'POST',
                            dataType: 'json',
                            data: { id: countryId },
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
                    // tujuannya untuk mengambil nilai pd tabel tersebut berdasarkan nilai id
                    const countryId = $(this).data('id'); 
    
                    // setelah mendapatkan id, maka nilai tersebut akan diarahkan ke tampilan update.. untuk diupdate pd nilai tersebut
                        window.location.href = `/master/negara/update/${countryId}`;
                })
            },
        });        
    });


</script>