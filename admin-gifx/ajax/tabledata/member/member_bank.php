<?php
use App\Models\MemberBank;

$dt->query('
    SELECT 
        MBANK_DATETIME,
        MBANK_HOLDER,
        MBANK_NAME,
        MBANK_ACCOUNT,
        ID_MBANK,
        MBANK_STS
    FROM tb_member_bank
    WHERE MBANK_STS = 0
');

$dt->edit('ID_MBANK', function ($data) {
    return "
    <div class='action d-flex justify-content-center gap-2'>
        <button class='btn btn-sm btn-primary accept-btn' data-accept='{$data['ID_MBANK']}'>Accept</button>
        <button class='btn btn-sm btn-danger reject-btn' data-reject='{$data['ID_MBANK']}'>Reject</button>
    </div>";
});

echo $dt->generate()->toJson();

?>