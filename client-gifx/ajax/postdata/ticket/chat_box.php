<?php
    $code = $_GET['code'];
    $query = $db->prepare("SELECT * FROM tb_ticket_detail WHERE TDETAIL_TCODE = ?");
    $query->bind_param("s", $code);
    $query->execute();
    $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
?>  

<?php foreach($result as $nilai): ?>
    <div class="d-flex flex-column align-items-end mb-3">
        <div style="
            display: block;
            border-right: 2px solid white;
            background-color: #302f2fff;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            max-width: 60%;
            font-size: 13px;
            text-align: right;
            word-wrap: break-word;">
            <div class="mb-2"><?= htmlspecialchars($nilai['TDETAIL_CONTENT']) ?> </div>
            <div><?= date('H:i', strtotime($nilai['TDETAIL_DATETIME'])) ?></div>
        </div>
    </div>
<?php endforeach; ?>