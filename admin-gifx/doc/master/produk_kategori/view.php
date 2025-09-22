<div class="row">
<!-- form menginputkan nilai pd tabel negara -->
<?php require_once __DIR__ . "/create.php"; ?>

    <div class="col mb-5 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>LIST PRODUK KATEGORI</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="produklist">
                    <thead>
                        <tr>
                            <th scope="col">CODE</th>
                            <th scope="col">NAMA</th>
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
        table = $('#produklist').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollX: true,
            order: [[0, 'desc']],
            ajax: {
                url: "/ajax/datatable/master/produk_kategori/view",
                contentType: "application/json",
                type: "GET",
            },
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],

            drawCallback:function(settings)
            {
                // update
                $('.update-btn').on('click', function(e){
                    e.preventDefault();
                    //ambil nilai id dari tombol update
                    // ketika tombol update diklik maka nilai id tersebut akan disimpan juga oleh const countryId
                    const id = $(this).data('id'); 
                    // setelah mendapatkan id, maka nilai tersebut akan diarahkan ke tampilan update.. untuk diupdate pd nilai tersebut
                        window.location.href = `/master/produk_kategori/update/${id}`;
                })
            }
        })
    })
</script>