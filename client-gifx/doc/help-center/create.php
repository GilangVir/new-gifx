        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Form Pembuatan Ticket
                </div>
                <div class="card-body">
                    <form id="form">
                        <div class="mb-2">
                            <label for="subjek" class="form-label">Subjek</label>
                            <input type="text" class="form-control" id="subjek">
                        </div>
                        <div class="mb-2">
                            <label for="deskripsi" class="form-label">Deskripsi(opsional)</label>
                            <textarea type="text" class="form-control" rows="5" id="deskripsi"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-warning w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function(){
        $('#form').on('submit', function(e){
            e.preventDefault();

            let button = $(this).find('button[type="submit"]');
            button.addClass('loading')

            const data = {
                subjek: $('#subjek').val().trim(),
                deskripsi: $('#deskripsi').val().trim()
            }

            $.ajax({
                url: '/ajax/post/ticket/create',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(data),

                success: function(response) {

                    button.removeClass('loading')
                    Swal.fire(response.alert)
                    $('#form')[0].reset();
                    table.ajax.reload();
                }
            })

        })
    })
</script>