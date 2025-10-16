<?php
use Config\Core\Database;

$code = $_POST['code'] ?? null;

$nilai = 1;
Database::update("tb_ticket", [
    'TICKET_STS' => $nilai], [
    'TICKET_CODE' => $code
    ]);

// redirect setelah update
JsonResponse([
    'success' =>true,
    'message' => 'berhasil',
    'data' => []
]);