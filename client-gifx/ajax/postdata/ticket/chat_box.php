<?php
    $code = $_GET['code'];
    $query = $db->prepare("SELECT * FROM tb_ticket_detail WHERE TDETAIL_TCODE = ? ORDER BY TDETAIL_DATETIME ASC");
    $query->bind_param("s", $code);
    $query->execute();
    $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
?>  

<?php foreach($result as $nilai): ?>
    <?php 
    // Coba berbagai kemungkinan kondisi
    $isAdmin = false;
    
    if(isset($nilai['ADM_ID']) && $nilai['ADM_ID'] != '' && $nilai['ADM_ID'] != null) {
        $isAdmin = true;
    } elseif(isset($nilai['TDETAIL_TYPE']) && strtolower($nilai['TDETAIL_TYPE']) == 'admin') {
        $isAdmin = true;
    } elseif(isset($nilai['SENDER_TYPE']) && strtolower($nilai['SENDER_TYPE']) == 'admin') {
        $isAdmin = true;
    }
    ?>
    
    <?php if($isAdmin): ?>
        <!-- Pesan dari Admin (Kiri) -->
        <div class="d-flex flex-column align-items-start mb-3">
            <div style="
                display: block;
                border-left: 2px solid white;
                background-color: #302f2fff;
                color: #fff;
                padding: 10px 15px;
                border-radius: 4px;
                max-width: 60%;
                font-size: 13px;
                text-align: left;
                word-wrap: break-word;">
                <div class="mb-2"><?= htmlspecialchars($nilai['TDETAIL_CONTENT']) ?></div>
                <div><?= date('H:i', strtotime($nilai['TDETAIL_DATETIME'])) ?></div>
            </div>
        </div>
    <?php else: ?>
        <!-- Pesan dari User (Kanan) -->
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
                <div class="mb-2"><?= htmlspecialchars($nilai['TDETAIL_CONTENT']) ?></div>
                <div><?= date('H:i', strtotime($nilai['TDETAIL_DATETIME'])) ?></div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>