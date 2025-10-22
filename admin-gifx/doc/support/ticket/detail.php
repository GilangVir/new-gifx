<?php
use App\Models\Admin;
// Ambil URL path
$request_uri = $_SERVER['REQUEST_URI'];
$tiketcode = $_GET['tiketcode'] ?? null;
// Jika tidak ada, ambil dari segmen URL terakhir (misal /support/ticket/detail/123)
if (!$tiketcode) {
    $segments = explode('/', trim($request_uri, '/'));
    $tiketcode = end($segments); // ambil nilai terakhir dari URL path
}
$sessionData = Admin::getSessionData();
$token = $sessionData['token'] ?? null;

$query = $db->prepare("SELECT * FROM tb_ticket WHERE TICKET_CODE = ?");
$query->bind_param("s", $tiketcode);
$query->execute();
$values = $query->get_result()->fetch_assoc();

$query = $db->prepare('SELECT * FROM tb_member WHERE MBR_ID = ?');
$query->bind_param('s', $values['TICKET_MBR']);
$query->execute();
$member = $query->get_result()->fetch_assoc();

$query = $db->prepare("SELECT * FROM tb_admin WHERE ADM_TOKEN = ?");
$query->bind_param("s", $token);
$query->execute();
$admin = $query->get_result()->fetch_assoc();



?>

<style>
    #message:focus {
    color: #111827 !important; /* paksa tetap warna normal */
    outline: none !important; /* hilangkan border biru/merah */
}
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<div class="container" style="max-width: 900px; margin-top: 2.5rem; margin-bottom: 3rem;">
    <div class="card mb-3" style="border-radius: 10px;">
        <div class="card-header" style="background-color: #fff; border-bottom: 1px solid #e5e7eb;">
            <!-- Header -->
            <div class="text-center py-3">
                <h5 class="fw-bold mb-1" style="color: #000;"><?= $member['MBR_EMAIL'] ?></h5>
                <div style="font-size: 13px; color: #9ca3af;"><?= $member['MBR_ID']?></div>
            </div>
        </div>
    </div>

    <!-- Chat Card -->
    <div class="card shadow-sm border-0" style="border-radius: 14px; overflow: hidden;">
        <div class="card-body p-4" style="background-color: #f9fafb; height: 350px; overflow-y: auto;">

            <!-- Tanggal Chat -->
            <div class="text-center mb-4">
                <span style="background-color: #e5e7eb; color: #6b7280; font-size: 11px; font-weight: 600; padding: 5px 14px; border-radius: 20px; text-transform: uppercase;">
                    TODAY
                </span>
            </div>
            <!-- Chat Bubble :alamatnya ada di bagian line 100 -->
            <div id="chat-box">
                <div class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-secondary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-2 mb-0" style="font-size: 13px;">Loading messages...</p>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <?php if($values['TICKET_STS'] == -1): ?>
            <form id="form" style="border-top: 1px solid #e5e7eb; background-color: #fff; padding: 14px 18px; display: flex; align-items: center; gap: 12px;">
                <!-- nilai adm_id yg login hari ini -->
                <input type="hidden" id="ADM_ID" name="ADM_ID" value="<?= $admin['ADM_ID'] ?>">
                <!-- tiketcode berasal dari get -->
                <input type="hidden" name="TICKET_CODE" value="<?= $tiketcode ?>">
                <label for="image" style="cursor: pointer; color: #9ca3af; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="bi bi-image"></i>
                    <input type="file" id="image" name="image" style="display: none;">
                </label>

                <input type="text" id="message" name="message" placeholder="Type your message here..." 
                    style="flex: 1; border: none; outline: none; font-size: 14px; padding: 10px; color: #6b7280;">

                <button type="submit" 
                    style="background: none; border: none; color: #6366f1; font-size: 22px; cursor: pointer; padding: 0;">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>
<script>
    $(document).ready(function(){
        function reloadChat(){
            let code = "<?= $tiketcode?>";
            $('#chat-box').load('/ajax/post/support/ticket/view_chats?code=' + code, function(){
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            });
        }

        // Muat chat pertama kali
        reloadChat();

        // Auto reload setiap 3 detik
        setInterval(reloadChat, 2000);


        $('#form').on('submit', function(e){
            e.preventDefault();
            // this : otomatis mengikat ke form yang sedang disubmit, sehingga semua input di dalamnya akan ikut terkirim ke server
            const formData = new FormData(this);

            $.ajax({
                url: '/ajax/post/support/ticket/send_chats',
                type: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                if (response.success) {
                    // Jika berhasil, kosongkan input text
                    $('#message').val('');
                    $('#image').val('');
                    // Tunggu 200ms sebelum reload agar data baru pasti masuk DB
                    setTimeout(() => {
                        reloadChat();
                    }, 200);
                }else{
                    swal.fire(response.alert)
                    $('#form')[0].reset();
                    // reload otomatis
                    reloadChat();
                    }
                },
            });
        });
    });
</script>
