<?php
$dt->query('
        SELECT MBANK_DATETIME, MBANK_MBR, MBANK_STS, MBANK_REGOL 
        FROM tb_member_bank
');


echo $dt->generate()->toJson();
    