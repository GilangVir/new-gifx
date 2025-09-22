<?php

// PHP (Server-side Processing)
    $dt->query('
        SELECT
            COUNTRY_NAME,
            COUNTRY_CURR,
            COUNTRY_CODE,
            COUNTRY_PHONE_CODE,
            ID_COUNTRY
        FROM tb_country
        ORDER BY COUNTRY_NAME
    ');

    $dt->edit('ID_COUNTRY', function ($data) {
        return "<div class='action d-flex justify-content-center gap-2'>
                <button class='btn btn-sm btn-primary update-btn' data-id='".$data['ID_COUNTRY']."'>Edit</button>
                <button class='btn btn-sm btn-danger delete-btn' data-id='".$data['ID_COUNTRY']."' >Delete</button>
            </div>";
        
        });
        // Menggenerate data dalam format JSON untuk dikirim ke DataTables untuk ditampilkan
        echo $dt->generate()->toJson();
    
    // alur kerja:
    //1. Browser memuat halaman dan menjalankan JavaScript
    //2. DataTables mengirim request AJAX ke endpoint /ajax/datatable/master/negara/view
    //3. Server menerima request, menjalankan query database
    //4. PHP memproses data dan mengembalikan response JSON
    //5. DataTables menerima JSON dan merender tabel dengan data
    //6. Kolom ACTION di-render dengan tombol Edit dan Delete yang memiliki atribut data-id