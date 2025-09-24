<?php
use Config\Core\Database;
use App\Models\User;

$input = $_POST; //Menyimpan semua data yang dikirim dari form.
// validasi input(jika ada inputan nilainya kosong) maka akan menampilkan pesan kesalahan
if (empty(trim($input['fullname'] ?? '')) 
    || empty(trim($input['email'] ?? '')) 
    || empty(trim($input['password'] ?? ''))
) {
    JsonResponse([
        'success' => false,
        'message' => 'Inputan ada yang kosong',
        'data' => []
    ]);
    exit;
}
// Validasi pada kolom nama apakah nilai nya mengandung karakter
$fullname = trim($input['fullname']); 
if (preg_match("/[^a-zA-Z\s]/", $fullname)) {
        JsonResponse([
        'success' =>false,
        'message' => 'Nama mengandung karakter',
        'data' => []
    ]);
    exit;
}
// Validasi pd kolom email
$email = trim($_POST['email']);  //menangkap nilai email berdasarkan nama kolom
$email = strtolower($email); // mengubah nilai inputan email menjadi strtolower(hurufnya kecil semua)
$stmt = $db->prepare("SELECT ID_MBR FROM tb_member WHERE MBR_EMAIL = ?");
// menampilkan nilai ID_MBR pd tabel tb_member berdasrkan kolom MBR_EMAIL (nilai MBR_EMAIL di dptkan dari $email)
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
// jika nilai tersebut ada di database maka muncul respon seperti ini
if ($stmt->num_rows > 0) {
        JsonResponse([
        'success' =>false,
        'message' => 'Email sudah terdaftar',
        'data' => []
    ]);
    exit;
}
$stmt->close();

// validasi password
$password = trim($_POST['password']); //menangkap nilai password berdasarkan nama kolom
$check = User::validation_password($password);
// validation_password() memberikan aturan pd password
if ($check === true) {
     // jika nilai true(sesuai aturan password), mk password tersebut akan dikasih type PASSWORD_BCRYPT
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
}else{
    // jika tidak sesuai aturan mk muncul pesan kesalahan
    JsonResponse([
        'success' =>false,
        'message' => $check, 
        'data' => []
    ]);
    exit;
}
$refferal = trim($_POST['refferal'] ?? '');
// jika refferal pda inputan nilai nya kosong, mk akan diberikan nilai default
if (empty($refferal)) {
    $defaultDSPN = 1000000000;
} else {
// jika inputan pd refferal tidk kosng maka nilai tersebut akan di ambil pd database & disimpan pd $mbr_id
    $stmt = $db->prepare("SELECT MBR_ID FROM tb_member WHERE MBR_CODE = ?");
    $stmt->bind_param("s", $refferal);
    $stmt->execute();
    $stmt->bind_result($mbr_id);

    if ($stmt->fetch()) {
        // refferal ditemukan, gunakan MBR_ID dari database
        $defaultDSPN = $mbr_id;
    } else {
        // refferal tidak ditemukan → fallback ke default
        JsonResponse([
            'success' =>false,
            'message' => 'refferal tidak ditemukan',
            'data' => []
        ]);
        exit;
    }
    $stmt->close();
}
// memberikan nilai random pada kolom MBR_OTP
$otp = random_int(1000,9999);
// Memberikan nilai pd kolom MBR_CODE = uniqi()
$mbrCode = uniqid();
// Memberikan nilai pd kolom MBR_COUNTRY
$mbrCountry = 'indonesia';

// panggil function untuk generate MBR_ID
// createMbrId digunakan untuk membuatkan nilai otomatis pd kolom MBR_ID
$mbrId = User::createMbrId();
    if ($mbrId === 0) {
    // gagal generate ID → lakukan fallback
    JsonResponse([
        'success' => false,
        'message' => 'Gagal',
        'data' => []
    ]);
    exit;
}
//Memberikan nilai pd kolom MBR_OTP_EXPIRED
$OtpExpired = date('Y-m-d H:i:s', strtotime("+15 minute"));
//Memberikan nilai pd kolom MBR_DATETIME
$dateTime = date("Y-m-d H:i:s");

$insert = Database::insert("tb_member", [
    'MBR_NAME' => $fullname,
    'MBR_EMAIL' => $email,
    'MBR_PASS' => $hashedPassword,
    'MBR_CODE' => $mbrCode,
    'MBR_COUNTRY' => $mbrCountry,
    'MBR_OTP' => $otp,
    'MBR_OTP_EXPIRED' => $OtpExpired,
    'MBR_DATETIME' => $dateTime,
    'MBR_ID' => $mbrId,
    'MBR_IDSPN' => $defaultDSPN
]);
if (!$insert) {
    JsonResponse([
    'success' =>false,
    'message' => 'Data berhasil disimpan',
    'data' => []
]);
}



JsonResponse([
    'success' =>true,
    'message' => 'Data berhasil disimpan',
    'data' => ['redirect' => '/']
]);






?>