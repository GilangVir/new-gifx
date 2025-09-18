<?php

// Pastikan untuk include file yang diperlukan

use Config\Core\Database;



    $input = json_decode(file_get_contents('php://input'), true);

        // Debug: Tampilkan data yang diterima
    error_log("Parsed input: " . print_r($input, true));

    // validasi input
    if(!$input || !isset($input['countryName']) || !isset($input['currency']) ||
    !isset($input['countryCode']) || !isset($input['phoneCode'])) {
        throw new Exception('Data tidak lengkap');
    }

    // PENTING: Ambil data dari input
    $countryName = trim($input['countryName']);
    $currency = trim($input['currency']);
    $countryCode = trim($input['countryCode']);
    $phoneCode = trim($input['phoneCode']);

        // Debug: Tampilkan data yang akan disimpan
    error_log("Data to insert: $countryName, $currency, $countryCode, $phoneCode");

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