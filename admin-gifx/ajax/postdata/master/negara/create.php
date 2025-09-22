<?php

// Pastikan untuk include file yang diperlukan

use Config\Core\Database;


    // menangkap nilai yg dikirimkan melalui ajax
    $input = json_decode(file_get_contents('php://input'), true);

    if(!$input 
        || !isset($input['countryName']) || empty(trim($input['countryName'])) 
        || !isset($input['currency']) || empty(trim($input['currency'])) 
        || !isset($input['countryCode']) || empty(trim($input['countryCode']))
        || !isset($input['phoneCode']) || empty(trim($input['phoneCode'])))
    {
        JsonResponse([
            'success' =>false,
            'message' => 'Data Gagal disimpan',
            'data' => []
        ]);
        exit;
    }

    //mengambil nilai dari inputan yg dikirim oleh ajax
    $countryName = trim($input['countryName']);
    $currency = trim($input['currency']);
    $countryCode = trim($input['countryCode']);
    $phoneCode = trim($input['phoneCode']);



    // Prepare statement. jika ada duplikasi nilai pd tabel
    $stmt = $db->prepare("SELECT COUNTRY_NAME FROM tb_country WHERE COUNTRY_NAME = ?");
    $stmt->bind_param("s", $countryName); // "s" untuk string
    $stmt->execute();
    $result = $stmt->get_result();
    $existingData = $result->fetch_all(MYSQLI_ASSOC);

    if ($existingData && count($existingData) > 0) {
        JsonResponse([
            'success' => false,
            'message' => 'Data dengan nama negara "' . $countryName . '" sudah ada',
            'data' => []
        ]);
        exit;
    }

    Database::insert("tb_country", [
        'COUNTRY_NAME' => $countryName,
        'COUNTRY_CURR' => $currency,
        'COUNTRY_CODE' => $countryCode,
        'COUNTRY_PHONE_CODE' => $phoneCode
    ]);

    // Cek hasil dan return JSON response
    JsonResponse([
        'success' =>true,
        'message' => 'Data berhasil disimpan',
        'data' => []
    ]);


?>