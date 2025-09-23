<?php

$dt->query('
    SELECT
    ACCKAT_CODE,
    ACCKAT_NAME,
    ID_ACCKAT
    FROM tb_racctype_kategori
    ORDER BY ACCKAT_NAME
');

$dt->edit('ID_ACCKAT', function ($data) {
    return "<div class='action d-flex justify-content-center gap-2'>
            <button class='btn btn-sm btn-primary update-btn'  data-id='".$data['ID_ACCKAT']."'>Edit</button>
        </div>";
    });

echo $dt->generate()->toJson();


?>