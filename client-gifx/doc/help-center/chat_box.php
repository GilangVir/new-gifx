<?php

$code = $_GET['code'];

$query = $db->prepare("SELECT * FROM tb_ticket WHERE TICKET_CODE = ?");
$query->bind_param("s", $code);
$query->execute();
$ticket = $query->get_result()->fetch_assoc();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<div class="container">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-header py-2">
                Tiket <span class="text-warning">#<?=  $ticket['TICKET_CODE']?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body position-relative p-4">
                    <!-- Header Customer Service -->
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <img src="../assets/images/admin.png" alt="CS" width="40" height="40" class="me-2 rounded-circle">
                            <div>
                                <h6 class="mb-0 fw-bold">Customer Service</h6>
                                <small class="text-success">Online</small>
                            </div>
                        </div>
                        <!-- ketika nilai sama maka tombol menghilang -->
                        <?php if ($ticket['TICKET_STS'] == -1): ?>
                            <button type="button" class="btn btn-danger update-btn" data-code="<?= $ticket['TICKET_CODE'] ?>">
                                Tutup Tiket
                            </button>
                        <?php endif; ?>
                    </div>
                    <!-- Area konten hitam,menampilkan isi chat-box -->
                    <div class="bg-dark rounded-3 mb-2 p-3" id="chat-box" name="chat-box" style="height: 400px; overflow-y: auto; scrollbar-width: thin;">
                        <?php require_once __DIR__ . "/../../ajax/postdata/ticket/chat_box.php"; ?>
                    </div>
                    <!-- form input & upload -->
                    <?php if ($ticket['TICKET_STS'] == -1): ?>
                        <form id="form">
                            <div style="display: flex; align-items: center; gap: 10px; background: #f7f7f7; padding: 10px; border-radius: 6px;">
                                <input type="hidden" id="ticket_code" name="ticket_code" value="<?= $ticket['TICKET_CODE'] ?>">

                                <label for="image" style="cursor: pointer; display: flex; align-items: center; justify-content: center; background-color: #c0cf76; color: white; padding: 8px 12px; border-radius: 4px;">
                                    <i class="bi bi-image" style="font-size: 18px;"></i>
                                    <input type="file" id="image" name="image" style="display: none;">
                                </label>

                                <input type="text" id="message" name="message" placeholder="Type your message..." style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                                <button type="submit" style="background-color: #c0cf76; color: white; border: none; padding: 10px 20px; border-radius: 4px;">Send</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        function reloadChat(){
            let code = "<?= $ticket['TICKET_CODE'] ?>";
            $('#chat-box').load('/ajax/post/ticket/chat_box?code=' + code, function(){
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            });
        }
    
        $('#form').on('submit', function(e){
            e.preventDefault();

            let button = $(this).find('button[type="submit"]');
            button.addClass('loading');

            let formData = new FormData(this);

            $.ajax({
                url: '/ajax/post/ticket/create_chatbox',
                type: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    button.removeClass('loading');
                    // jika berhasil,tidak menampilkan alert
                    if(response.success){
                        $('#form')[0].reset();
                        reloadChat();
                    }else{
                        swal.fire(response.alert)
                        $('#form')[0].reset();
                        // reload otomatis
                        reloadChat();
                    }
                },
            });
        }),

        $('.update-btn').on('click', function(){
            let button = $(this);
            let code = button.data('code');

            if(confirm('Konfirmasi untuk melanjutkan tikect')) {
                $.ajax({
                    url: '/ajax/post/ticket/update_status',
                    type: 'POST',
                    dataType: 'json',
                    data: { code: code },
                    success: function(response) {
                        swal.fire(response.alert).then(() => {
                            button.fadeOut();
                            $('#form').fadeOut();
                        });
                    }
                })
            }
            
        })
    });
</script>
