<?php

use Config\Core\Database;

    if(!$adminPermissionCore->hasPermission($authorizedPermission, "/master/negara/update/1")) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Authorization Failed",
        'data'      => []
    ]);
    }

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

    //Ambil data dari input
    $id = trim($input['id']);
    $countryName = trim($input['countryName']);
    $currency = trim($input['currency']);
    $countryCode = trim($input['countryCode']);
    $phoneCode = trim($input['phoneCode']);

    // === Cek duplikasi NAMA===
    $stmt = $db->prepare("SELECT COUNTRY_NAME FROM tb_country WHERE COUNTRY_NAME = ?");
    $stmt->bind_param("s", $countryName);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingName = $result->fetch_all(MYSQLI_ASSOC);

    if ($existingName && count($existingName) > 0) {
        JsonResponse([
            'success' => false,
            'message' => 'Data dengan nama produk "' . $countryName . '" sudah ada',
            'data'    => []
        ]);
        exit;
    }
    

    Database::update("tb_country", [
        'COUNTRY_NAME' => $countryName,
        'COUNTRY_CURR' => $currency,
        'COUNTRY_CODE' => $countryCode,
        'COUNTRY_PHONE_CODE' => $phoneCode
    ], [
        'ID_COUNTRY' => $id
    ]);

    // Cek hasil dan return JSON response
    JsonResponse([
        'success' =>true,
        'message' => 'Data berhasil disimpan',
        'data' => []
    ]);
    


?>