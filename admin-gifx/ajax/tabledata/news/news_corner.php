<?php

$dt->query(
    '
    SELECT 
    BLOG_TYPE,
    BLOG_TITLE,
    BLOG_MESSAGE,
    BLOG_AUTHOR,
    BLOG_IMG,
    BLOG_SLUG,
    ID_BLOG
    FROM tb_blog WHERE BLOG_TYPE = ?', [0]
);

    $dt->edit('ID_BLOG', function ($data) {
        return "<div class='action d-flex justify-content-center gap-2'>
                <button class='btn btn-sm btn-primary update-btn' data-id='".$data['ID_BLOG']."'>Edit</button>
                <button class='btn btn-sm btn-danger delete-btn' data-id='".$data['ID_BLOG']."' >Delete</button>
            </div>";
        
        });

echo $dt->generate(); 

?>