<?php
$dt->query("
    SELECT 
        `group` as groupName,
        `type`,
        `icon`,
        md5(md5(`id`)) as id_hash
    FROM admin_module_group
");

$dt->hide("type");
$dt->edit("icon", function($col) {
    return '<i class="'.$col['icon'].'"></i>';
});

$dt->edit("id_hash", function($col) {
    $buttonEdit = '<a class="btn btn-success btn-sm text-white btn-edit" data-id="'.$col['id_hash'].'" data-group="'.$col['groupName'].'" data-type="'.$col['type'].'" data-icon="'.$col['icon'].'"><i class="fas fa-edit"></i></a>';
    $buttonDelete = '<a class="btn btn-danger btn-sm text-white btn-delete" data-id="'.$col['id_hash'].'"><i class="fas fa-trash"></i></a>';
    
    return '
        <div class="text-center">
            '.(checkPermission("/developer/group/update", $buttonEdit)).'
            '.(checkPermission("/developer/group/delete", $buttonDelete)).'
        </div>
    ';
});

echo $dt->generate()->toJson();