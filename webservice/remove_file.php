<?php
    header("Content-Type: text/html;charset=utf-8");
    ini_set("display_errors", "On");
    error_reporting(E_ALL);

/*    $fp=fopen("yyy.txt","w");
    fputs($fp,"yyyyy");
    fclose($fp);*/

    $carpeta=$_POST["carpeta"];
    $archivo=$_POST["archivo"];
    $destino=$carpeta.'/'.$archivo;
    unlink($destino);
?>
