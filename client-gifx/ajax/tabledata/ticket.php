<?php
use App\Models\Ticket;

$mbrId = $user['MBR_ID'];

$query = $db->prepare('SELECT * FROM tb_member WHERE MBR_ID = ?');
$query->bind_param('i', $mbrId);
$query->execute();
$member = $query->get_result()->fetch_assoc();

$dt->query('
    SELECT TICKET_DATETIME, TICKET_CODE, TICKET_SUBJECT, TICKET_STS
    FROM tb_ticket
    WHERE TICKET_MBR = ?
', [$member['MBR_ID']]);


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

