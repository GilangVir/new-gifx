<?php

use Config\Core\Database;
    $input = json_decode(file_get_contents('php://input'), true);

        // Debug: Tampilkan data yang diterima
    error_log("Parsed input: " . print_r($input, true));

    // validasi input
    if(!$input || !isset($input['id']) || !isset($input['countryName']) || !isset($input['currency']) ||
    !isset($input['countryCode']) || !isset($input['phoneCode'])) {
        throw new Exception('Data tidak lengkap');
    }

    // PENTING: Ambil data dari input
    $id = trim($input['id']);
    $countryName = trim($input['countryName']);
    $currency = trim($input['currency']);
    $countryCode = trim($input['countryCode']);
    $phoneCode = trim($input['phoneCode']);

        // Debug: Tampilkan data yang akan diupdate
    error_log("Data to update: ID=$id, $countryName, $currency, $countryCode, $phoneCode");

    Database::update("tb_country", [
        'COUNTRY_NAME' => $countryName,
        'COUNTRY_CURR' => $currency,
        'COUNTRY_CODE' => $countryCode,
        'COUNTRY_PHONE_CODE' => $phoneCode
    ], [
        'ID_COUNTRY' => $id
    ]);

    
    


?>