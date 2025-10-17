<?php

if (isset($_GET['get']) && $_GET['get'] == 'kelurahan') {
    $kec = $_GET['kec'];
    $stmt = $db->prepare("SELECT DISTINCT KDP_KELURAHAN FROM tb_kodepos WHERE KDP_KECAMATAN = ?");
    $stmt->bind_param("s", $kec);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode($result);
    exit;
}