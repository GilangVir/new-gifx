<?php if($adminPermissionCore->isHavePermission($moduleId, "create")) : ?>
    <!-- form menginputkan nilai pd tabel country -->
    <div class="col mb-3 mt-5">
        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    <form id="bankForm">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="mb-3">
                            <label for="bankName" class="form-control-label">NAMA BANK</label>
                            <input type="text" class="form-control" id="bankName" name="bankName" placeholder="bank nama">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // menambahkan data
            $('#bankForm').on('submit', function(e){
                e.preventDefault();

                // menangkap nilai inputan
                const bankName = $('#bankName').val().trim();

                const data = {
                    bankName: bankName
                };

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: '/ajax/post/master/bank/create',
                    type: 'POST',
                    dataType: 'json', 
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },

                    // memberikan sebuah respon sukses atau gagal pd saat menginputkan
                    success: function(response) {
                        Swal.fire(response.alert)
                        $('#bankForm')[0].reset();
                        table.ajax.reload();
                    }
                });
            })
        })
    </script>
<?php endif; ?>