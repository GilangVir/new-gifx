<?php

use Config\Core\Database;

if(!$adminPermissionCore->hasPermission($authorizedPermission, "/master/produk_kategori/create")) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Authorization Failed",
        'data'      => []
    ]);
}

// menangkap nilai yg dikirimkan melalui ajax
$input = json_decode(file_get_contents('php://input'), true);

if(!$input 
    || !isset($input['nama']) || empty(trim($input['nama']))
    ) {
        JsonResponse([
            'success' =>false,
            'message' => 'Data Gagal disimpan',
            'data' => []
        ]);
        exit;
    }

    //mengambil nilai dari inputan yg dikirim oleh ajax
    $nama = trim($input['nama']);

    // Generate CODE dari nama
    $code = strtolower($nama);
    $code = preg_replace('/[^a-z0-9]+/', '_', $code); // ganti non-alfanumerik jadi "_"
    $code = trim($code, '_');// hapus "_" di awal/akhir

    // Prepare statement. jika ada duplikasi nilai pd tabel
    $stmt = $db->prepare("SELECT ACCKAT_NAME FROM tb_racctype_kategori WHERE ACCKAT_NAME = ?");
    $stmt->bind_param("s", $nama); // "s" untuk string
    $stmt->execute();
    $result = $stmt->get_result();
    $existingData = $result->fetch_all(MYSQLI_ASSOC);

    if ($existingData && count($existingData) > 0) {
        JsonResponse([
            'success' => false,
            'message' => 'Data dengan nama produk"' . $nama . '" sudah ada',
            'data' => []
        ]);
        exit;
    }

    Database::insert("tb_racctype_kategori", [
        'ACCKAT_CODE' => $code,
        'ACCKAT_NAME' => $nama,
    ]);

    // Cek hasil dan return JSON response
    JsonResponse([
        'success' =>true,
        'message' => 'Data berhasil disimpan',
        'data' => []
    ]);
?>