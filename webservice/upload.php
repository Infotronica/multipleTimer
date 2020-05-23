<?php
    header("Content-Type: text/html;charset=utf-8");
    ini_set("display_errors", "On");
    error_reporting(E_ALL);

    //$filename=$_REQUEST['fn'];
    //$makedir=$_REQUEST['md'];

    $filename=$_GET['fn'];
    $makedir=$_GET['md'];

    $destino=$makedir.'/'.$filename;

    if(!is_dir($makedir)) // if the folder does not exists create it
    {
        mkdir($makedir,0777);
    }
    move_uploaded_file($_FILES["attachment"]["tmp_name"], $destino);
?>
