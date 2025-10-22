<?php
use App\Models\MemberBank;

$mbrId = $user['MBR_ID'];

$query = $db->prepare('SELECT * FROM tb_member WHERE MBR_ID = ?');
$query->bind_param('i', $mbrId);
$query->execute();
$member = $query->get_result()->fetch_assoc();

$dt->query('
        SELECT MBANK_DATETIME, MBANK_ACCOUNT, MBANK_STS, ID_MBANK
        FROM tb_member_bank WHERE MBANK_MBR = ?
', [$member['MBR_ID']]);

$dt->edit('ID_MBANK', function ($data) {
    return "<div class='action d-flex justify-content-center gap-2'>
            <button class='btn btn-sm btn-primary update-btn'  data-id='".$data['ID_MBANK']."'>Edit</button>
        </div>";
    });

// ubah nilai MBANK_STS jadi HTML berwarna sebelum dikirim ke DataTables
$dt->edit('MBANK_STS', function($data) {
    return MemberBank::status((int)$data['MBANK_STS']);
});



echo $dt->generate()->toJson();
    