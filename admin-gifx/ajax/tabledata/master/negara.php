<?php

$dt->query('
    SELECT
        COUNTRY_NAME,
        COUNTRY_CURR,
        COUNTRY_CODE,
        COUNTRY_PHONE_CODE
    FROM tb_country
    ORDER BY COUNTRY_NAME
');



    $dt->query('
        SELECT
            COUNTRY_NAME,
            COUNTRY_CURR,
            COUNTRY_CODE,
            COUNTRY_PHONE_CODE
        FROM tb_country
        ORDER BY COUNTRY_NAME
    ');

    $dt->add('action', function ($data) {
        return "<div class='action d-flex justify-content-center gap-2'>
                <button class='btn btn-sm btn-primary'>Edit</button>
                <button class='btn btn-sm btn-danger'>Delete</button>
            </div>";
        });
            echo $dt->generate()->toJson();