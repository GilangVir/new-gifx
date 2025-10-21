<?php
use App\Models\Ticket;

$dt->query("
    SELECT 
        t.TICKET_DATETIME, 
        IFNULL(t.TICKET_DATETIME_CLOSE, '-') AS TICKET_DATETIME_CLOSE,
        t.TICKET_CODE,  
        m.MBR_EMAIL AS EMAIL, 
        t.TICKET_SUBJECT, 
        t.TICKET_STS,
        t.TICKET_MBR
    FROM tb_ticket AS t
    JOIN tb_member AS m ON t.TICKET_MBR = m.MBR_ID ORDER BY TICKET_DATETIME
");

$dt->add('ACTION', function ($data) {
    return "
        <div class='action d-flex justify-content-center gap-2'>
            <button class='btn btn-sm btn-primary update-btn' data-tiketcode='".$data['TICKET_CODE']."'>Detail</button>
            <button class='btn btn-sm btn-danger delete-btn' data-tiketcode='".$data['TICKET_CODE']."'>Delete</button>
        </div>
    ";
});

// ubah nilai TICKET_STS jadi HTML berwarna sebelum dikirim ke DataTables
$dt->edit('TICKET_STS', function($data) {
    return Ticket::status((int)$data['TICKET_STS']);
});


echo $dt->generate()->toJson();
