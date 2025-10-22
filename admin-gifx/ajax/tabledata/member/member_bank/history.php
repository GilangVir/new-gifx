<?php
use App\Models\MemberBank;

$dt->query('
        SELECT MBANK_DATETIME, MBANK_HOLDER, MBANK_NAME, MBANK_ACCOUNT, 
        MBANK_STS,
        ID_MBANK
        FROM tb_member_bank WHERE MBANK_STS = 1 OR MBANK_STS = -1
');

// ubah nilai MBANK_STS jadi HTML berwarna sebelum dikirim ke DataTables
$dt->edit('MBANK_STS', function($data) {
    return MemberBank::status((int)$data['MBANK_STS']);
});

echo $dt->generate()->toJson();

?>