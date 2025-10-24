<?php
use App\Models\Helper;
use App\Models\User;
use Config\Core\Database;

$input = json_decode(file_get_contents('php://input'), true);
$input = Helper::getSafeInput($input);

foreach($input as $key => $value){
    if(empty(trim($value))){
    JsonResponse([
        'success' => false,
        'message' => ucfirst($key).' harap diisi',
        'data' => []
        ]);
    }
}

// validasi password baru tidak boleh sama dengan password lama
if ($input['password_baru'] == $input['password_lama']) {
    JsonResponse([
        'success' => false,
        'message' => 'Password baru dan password lama tidak boleh sama',
        'data' => []
    ]);
}

// Pastikan password baru == konfirmasi
if ($input['password_baru'] !== $input['konfirm_password']) {
    JsonResponse([
        'success' => false,
        'message' => 'Password baru dan konfirmasi tidak sama',
        'data' => []
    ]);
}

// validasi password baru
$validate = User::validation_password($input['password_baru']);
if ($validate !== true) {
    JsonResponse([
        'success' => false,
        'message' => $validate, // tampilkan pesan dari function
        'data' => []
    ]);
}
// Verifikasi password lama
$query = $db->prepare("SELECT * FROM tb_member WHERE ID_MBR = ?");
$query->bind_param("i", $input['id']);
$query->execute();
$user = $query->get_result()->fetch_assoc();
if (!$user || !password_verify($input['password_lama'], $user['MBR_PASS'])) {
    JsonResponse([
         'success' => false,
         'message' => 'Password lama salah',
         'data' => []
     ]);
}

// Update password baru (hash dulu)
$newPass = password_hash($input['password_baru'], PASSWORD_DEFAULT);
$update = Database::update('tb_member', [
    'MBR_PASS' => $newPass
], ['ID_MBR' => $input['id']]);
    JsonResponse([
        'success' => true,
        'message' => 'Berhasil',
        'data' => ['redirect' => '/logout']
    ]);
?>