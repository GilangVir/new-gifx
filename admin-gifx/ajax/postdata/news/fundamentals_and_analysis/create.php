<?php

use Config\Core\Database;
use App\Models\Admin;   
use App\Models\FileUpload;

    if(!$adminPermissionCore->hasPermission($authorizedPermission, "/news/fundamentals_and_analysis/create")) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Authorization Failed",
        'data'      => []
    ]);
    }

    // ambil inputan form
    $input = [
        'title'   => $_POST['BLOG_TITLE'] ?? '',
        'message' => $_POST['BLOG_MESSAGE'] ?? '',
    ];

    // validasi
    foreach($input as $key => $value){
        if(empty(trim($value))){
            JsonResponse([
                'success' => false,
                'message' => ucfirst($key).' harap diisi',
                'data' => []
            ]);
        }
    }

    // === Cek duplikasi NAMA===
    $stmt = $db->prepare("SELECT BLOG_TITLE FROM tb_blog WHERE BLOG_TITLE = ?");
    $stmt->bind_param("s", $input['title']);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingName = $result->fetch_all(MYSQLI_ASSOC);

    if ($existingName && count($existingName) > 0) {
        JsonResponse([
            'success' => false,
            'message' => 'Judul dengan nama "' . $input['title'] . '" sudah ada',
            'data'    => []
        ]);
        exit;
    }
    
    //Upload file
    $PRCSF = FileUpload::upload_myfile($_FILES["BLOG_IMG"], 'news');
    if(!is_array($PRCSF)){
        JsonResponse([
            'success'   => false,
            'message'   => "Failed to upload file. Please try again!. ErrMessage: ".$PRCSF,
            'data'      => []
        ]);
    }
    $filename = $PRCSF["filename"];

    // generate slug dari title
    $slug = strtolower($input['title']);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/\s+/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $type = 1;
    $dateTime = date("Y-m-d H:i:s");
    $insert = Database::insert('tb_blog', [
        'BLOG_TYPE' => $type,
        'BLOG_TITLE' => $input['title'],
        'BLOG_MESSAGE' => $input['message'],
        'BLOG_AUTHOR' => $user['ADM_NAME'],
        'BLOG_IMG' => $filename,
        'BLOG_SLUG' => $slug,
        'BLOG_DATETIME' => $dateTime,
    ]);

    JsonResponse([
        'success' =>true,
        'message' => 'Data berhasil disimpan',
        'data' => []
    ]);

?>