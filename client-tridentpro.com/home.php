<?php
require_once(__DIR__ . "/../config/setting.php");
use App\Models\User;

$pageFile = "404";
$pageTitle = "404";
if(!empty($_GET["a"])){
    $pageFile = htmlentities(str_replace('%', '', str_replace(' ', '_', stripslashes(($_GET['a'])))),ENT_QUOTES,'WINDOWS-1252');
    $pageTitle = ucwords(strtolower(str_replace('-', ' ', $pageFile)));
}

$user = User::user();
$userid = md5(md5($user['MBR_ID']));
if(!$user) {
    die("<script>alert('Session Expired, please re-login'); location.href ='/'</script>"); 
}

?>

<!DOCTYPE html>
<html lang="en" data-menu="vertical" data-nav-size="nav-default">
    <?php require_once __DIR__ . "/template/header.php"; ?>
    <?php require_once __DIR__ . "/template/body.php"; ?>
</html>