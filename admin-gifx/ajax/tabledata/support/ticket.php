<?php

$dt->query("
    SELECT 
        t.TICKET_DATETIME, 
        IFNULL(t.TICKET_DATETIME_CLOSE, '-') AS TICKET_DATETIME_CLOSE,
        t.TICKET_CODE,  
        m.MBR_EMAIL AS EMAIL, 
        t.TICKET_SUBJECT, 
        t.TICKET_STS,
        t.ID_TICKET
    FROM tb_ticket AS t
    JOIN tb_member AS m ON t.TICKET_MBR = m.MBR_ID ORDER BY TICKET_DATETIME
");

$dt->edit('ID_TICKET', function ($data) {
    return "
        <div class='action d-flex justify-content-center gap-2'>
            <button class='btn btn-sm btn-primary update-btn' data-id='".$data['ID_TICKET']."'>Detail</button>
        </div>
    ";
});


echo $dt->generate()->toJson();
