<?php
use Config\Core\Database;

$code = isset($_POST['tiketcode']) ? trim($_POST['tiketcode']) : null;

if(!$code || empty($code)) {
    JsonResponse([
        'success' => false,
        'message' => 'Data Gagal dihapus',
        'data' => []
    ]);
}


// Database::delete("tb_ticket", [
//     'TICKET_CODE' => $code
// ]);

if ($code) {
    // Hapus detail dulu
    $stmt1 = $db->prepare("DELETE FROM tb_ticket WHERE TICKET_CODE = ?");
    $stmt1->bind_param("s", $code);
    $stmt1->execute();

    // Hapus tiket
    $stmt2 = $db->prepare("DELETE FROM tb_ticket_detail WHERE TDETAIL_TCODE = ?");
    $stmt2->bind_param("s", $code);
    $stmt2->execute();
}

JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil dihapus',
    'data' => []
]);


?>