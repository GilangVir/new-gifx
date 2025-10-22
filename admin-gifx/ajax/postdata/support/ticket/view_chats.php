<?php
// ambil kode tiket dari URL
$code = $_GET['code'] ?? null;

if (!$code) {
    exit('No ticket code provided');
}

// ambil semua chat berdasarkan kode tiket
$query = $db->prepare("SELECT * FROM tb_ticket_detail WHERE TDETAIL_TCODE = ? ORDER BY TDETAIL_DATETIME ASC");
$query->bind_param("s", $code);
$query->execute();
$values = $query->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<?php foreach ($values as $value): ?>
    <div style="display: flex; <?= $value['TDETAIL_TYPE'] === 'ADMIN' ? 'justify-content: flex-end;' : 'justify-content: flex-start;' ?>">
        <div style="background-color: <?= $value['TDETAIL_TYPE'] === 'ADMIN' ? '#6366f1' : '#e5e7eb' ?>;
                    color: <?= $value['TDETAIL_TYPE'] === 'ADMIN' ? '#fff' : '#111827' ?>;
                    padding: 8px 12px;
                    border-radius: 10px;
                    max-width: 70%;
                    word-wrap: break-word;">
            <?= htmlspecialchars($value['TDETAIL_CONTENT']) ?>
        </div>
    </div>
    <div style="font-size: 12px; color: #9ca3af; margin-top: 3px; text-align: <?= $value['TDETAIL_TYPE'] === 'ADMIN' ? 'right' : 'left' ?>">
        <?= date('H:i', strtotime($value['TDETAIL_DATETIME'])) ?>
    </div>
<?php endforeach; ?>