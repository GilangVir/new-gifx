<?php

$dt->query('
    SELECT
    BANKLST_NAME,
    ID_BANKLST
    FROM tb_banklist
    ORDER BY BANKLST_NAME
');

$dt->edit('ID_BANKLST', function ($data) {
    return "<div class='action d-flex justify-content-center gap-2'>
            <button class='btn btn-sm btn-primary update-btn'  data-id='".$data['ID_BANKLST']."'>Edit</button>
            <button class='btn btn-sm btn-danger delete-btn' data-id='".$data['ID_BANKLST']."'>Delete</button>
        </div>";
    });

echo $dt->generate()->toJson();


?>