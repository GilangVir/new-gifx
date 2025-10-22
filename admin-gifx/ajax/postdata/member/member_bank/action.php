<?php
use Config\Core\Database;
$input = json_decode(file_get_contents('php://input'), true);

$action = $input['action'] ?? null;
$id = $input['id'] ?? null;
$status = null;

if ($action === 'reject') {
    $status = 1;
} elseif ($action === 'accept') {
    $status = -1;
}

if ($status !== null && $id !== null) {
    $update = Database::update('tb_member_bank', [
        'MBANK_STS' => $status
    ], ['ID_MBANK' => $id]);

    JsonResponse([
        'success' => true,
        'message' => 'Data berhasil diupdate',
        'data' => []
    ]);
}

?>