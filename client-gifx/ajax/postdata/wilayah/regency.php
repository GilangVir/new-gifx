<?php

if (isset($_GET['get']) && $_GET['get'] == 'kabupaten') {
    $prov = $_GET['prov'];
    $stmt = $db->prepare("SELECT DISTINCT KDP_KABKO FROM tb_kodepos WHERE KDP_PROV = ?");
    $stmt->bind_param("s", $prov);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode($result);
    exit;
}
