<?php

use Config\Core\Database;
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

    error_log("Data to update: ID=$id, $countryName, $currency, $countryCode, $phoneCode");

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