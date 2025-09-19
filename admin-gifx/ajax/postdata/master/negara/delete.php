<?php

use Config\Core\Database;

// mencari nilai yg dikirim apakah ada nilainya
$countryId = isset($_POST['id']) ? $_POST['id'] : null;
// mencari nilai yg dikirim

// Debug: Log ID yang diterima
error_log("Country ID received: " . var_export($countryId, true));
// Debug: Log ID yang diterima

Database::delete("tb_country", [
    'ID_COUNTRY' => $countryId
]);

// Validasi ID
if(!$countryId && is_numeric($countryId)) {
    JsonResponse([
        'success' =>true,
        'message' => 'Data berhasil dihapus',
    ]);
}else {
        JsonResponse([
        'gagal' => false,
        'message' => 'Data gagal dihapus',
    ]);
    throw new Exception('ID tidak valid');
}
?>