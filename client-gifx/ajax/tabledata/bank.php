<?php
use App\Models\MemberBank;

$dt->query('
        SELECT MBANK_DATETIME, MBANK_MBR, MBANK_STS, MBANK_REGOL 
        FROM tb_member_bank
');

// ubah nilai MBANK_STS jadi HTML berwarna sebelum dikirim ke DataTables
$dt->edit('MBANK_STS', function($data) {
    return MemberBank::status((int)$data['MBANK_STS']);
});



echo $dt->generate()->toJson();
    