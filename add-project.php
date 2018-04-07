<?php
session_start();
require_once('connect.php');
if(isset($_SESSION)){
    $email = $_SESSION['email'];
    $prjTitle = mysqli_real_escape_string($conn, $_GET['project-title']);
    $_SESSION['project-title'] = $prjTitle;
    $prjFolder = "users/$email/$prjTitle";
    $countFolders = count(glob("users/$email/*", GLOB_ONLYDIR));
    $_SESSION['count-dir'] = $countFolders;
    if(!file_exists($prjFolder) && $countFolders < 5) {
        mkdir($prjFolder);
        $myfile = fopen("$prjFolder/index.php", 'w');
        $text = require_once('settings.php');
        fwrite($myfile, $text);
        fclose($myfile);
        echo "project <b>$prjTitle</b> was created";
    } elseif($countFolders > 5) {
        echo 'Maximum 5 projects';
    } else {
        echo 'Projects with this name exists';
    }
} else {
    header('location: login.php');
}
?>
