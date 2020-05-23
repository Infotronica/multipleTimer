<?php
    ini_set("display_errors", "On");
    error_reporting(E_ALL);

    if (isset($_POST["str"]))
    {
        $str=$_POST["str"];
        $str=codigos_to_acentos($str);
        echo $str;
    }

    function codigos_to_acentos($entrada)
    {
        $salida=$entrada;
        $salida=str_replace("<@>","á",$salida);
        $salida=str_replace("<#>","é",$salida);
        $salida=str_replace("<$>","í",$salida);
        $salida=str_replace("<%>","ó",$salida);
        $salida=str_replace("<&>","ú",$salida);

        $salida=str_replace("|@|","ñ",$salida);
        $salida=str_replace("|#|","ü",$salida);

        $salida=str_replace("<@@>","Á",$salida);
        $salida=str_replace("<##>","É",$salida);
        $salida=str_replace("<$$>","Í",$salida);
        $salida=str_replace("<%%>","Ó",$salida);
        $salida=str_replace("<&&>","Ú",$salida);

        $salida=str_replace("|@@|","Ñ",$salida);
        $salida=str_replace("|##|","Ü",$salida);

        return $salida;
    }
?>
