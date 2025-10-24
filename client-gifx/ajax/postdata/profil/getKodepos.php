<?php
use Config\Core\Database;

$db = Database::connect();

$kec = $_GET['kec'] ?? '';
$query = $db->prepare("SELECT KDP_POS FROM tb_kodepos WHERE KDP_KECAMATAN LIKE CONCAT('%', ?, '%') LIMIT 1");
$query->bind_param("s", $kec);
$query->execute();
$data = $query->get_result()->fetch_assoc();

echo json_encode($data ?: []);
