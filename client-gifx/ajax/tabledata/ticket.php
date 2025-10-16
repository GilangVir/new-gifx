<?php
use App\Models\Ticket;

$dt->query('SELECT TICKET_DATETIME, TICKET_CODE, TICKET_SUBJECT, TICKET_STS
        FROM tb_ticket  ');

// mengubah nilai code menjadi link yg menuju doc/chat_box
$dt->edit('TICKET_CODE', function($data) {
    $code = htmlspecialchars($data['TICKET_CODE']);
    return '<a href="chat_box?code=' . urlencode($code) . '">' . $code . '</a>';
});

// ubah nilai TICKET_STS jadi HTML berwarna sebelum dikirim ke DataTables
$dt->edit('TICKET_STS', function($data) {
    return Ticket::status((int)$data['TICKET_STS']);
});


echo $dt->generate()->toJson();

