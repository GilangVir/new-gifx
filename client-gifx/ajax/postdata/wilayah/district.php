<?php

if (isset($_GET['get']) && $_GET['get'] == 'kecamatan') {
    $kab = $_GET['kab'];
    $stmt = $db->prepare("SELECT DISTINCT KDP_KECAMATAN FROM tb_kodepos WHERE KDP_KABKO = ?");
    $stmt->bind_param("s", $kab);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode($result);
    exit;
}