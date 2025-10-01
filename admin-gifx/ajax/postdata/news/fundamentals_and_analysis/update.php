<?php

use Config\Core\Database;
use App\Models\Admin;
use App\Models\FileUpload;

    if(!$adminPermissionCore->hasPermission($authorizedPermission, "/news/fundamentals_and_analysis/update/1")) {
    JsonResponse([
        'code'      => 200,
        'success'   => false,
        'message'   => "Authorization Failed",
        'data'      => []
    ]);
    }

    $id = $_POST['ID_BLOG'];

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

    //file lama
    $getBlog = $db->query("SELECT BLOG_IMG FROM tb_blog WHERE ID_BLOG = '{$_POST['ID_BLOG']}'");
    $oldData = $getBlog->fetch_assoc();
    $filename = $oldData['BLOG_IMG'] ?? '';
     //Upload file
    if (!empty($_FILES["BLOG_IMG"]) && $_FILES["BLOG_IMG"]['error'] === 0){
        $PRCSF = FileUpload::upload_myfile($_FILES["BLOG_IMG"], 'news');
        if(!is_array($PRCSF)){
            JsonResponse([
                'success'   => false,
                'message'   => "Failed to upload file. Please try again!. ErrMessage: ".$PRCSF,
                'data'      => []
            ]);
        }
        $filename = $PRCSF["filename"];
    }

     // === Cek duplikasi NAMA===
    $stmt = $db->prepare("SELECT BLOG_TITLE FROM tb_blog WHERE BLOG_TITLE = ? AND ID_BLOG != ?");
    $stmt->bind_param("si", $input['title'], $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingName = $result->fetch_all(MYSQLI_ASSOC);
    if ($existingName && count($existingName) > 0) {
        JsonResponse([
            'success' => false,
            'message' => 'judul dengan nama"' . $input['title'] . '" sudah ada',
            'data'    => []
        ]);
        exit;
    }

    // generate slug dari title
    $slug = strtolower($input['title']);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/\s+/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');

    $type = 1;
    $dateTime = date("Y-m-d H:i:s");

    Database::update("tb_blog", [
        'BLOG_TITLE' => $input['title'],
        'BLOG_MESSAGE' => $input['message'],
        'BLOG_IMG' => $filename,
        'BLOG_DATETIME'=> $dateTime,
        'BLOG_SLUG'      => $slug
    ], [
        'ID_BLOG' => $id
    ]);

    JsonResponse([
        'success' =>true,
        'message' => 'Data berhasil diupdate',
        'data' => []
    ]);





?>