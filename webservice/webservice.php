<?php
    header("Content-Type: text/html;charset=utf-8");
    ini_set("display_errors", "On");
    error_reporting(E_ALL);

    include_once("acentos_to_codigos.php");
    include_once("codigos_to_acentos.php");

    $server="localhost";
    $sql="select * from usuarios";
    $usr_bd="";
    $pwd_bd="";
    $bd="";
    $imax="";
    $table_max="";

    if (isset($_POST["sql"]))
    {
        $sql=$_POST["sql"];
    }
    else if (isset($_GET["sql"]))
    {
        $sql=$_POST["sql"];
    }
    if (isset($_POST["usr_bd"]))
    {
        $usr_bd=$_POST["usr_bd"];
    }
    else if (isset($_POST["usr_bd"]))
    {
        $usr_bd=$_POST["usr_bd"];
    }
    if (isset($_POST["pwd_bd"]))
    {
        $pwd_bd=$_POST["pwd_bd"];
    }
    else if (isset($_POST["pwd_bd"]))
    {
        $pwd_bd=$_POST["pwd_bd"];
    }
    if (isset($_POST["bd"]))
    {
        $bd=$_POST["bd"];
    }
    else if (isset($_POST["bd"]))
    {
        $bd=$_POST["bd"];
    }
    if (isset($_POST["server"]))
    {
        $server=$_POST["server"];
    }
    else if (isset($_POST["server"]))
    {
        $server=$_POST["server"];
    }
    if (isset($_POST["imax"]))
    {
        $imax=$_POST["imax"];
    }
    else if (isset($_POST["imax"]))
    {
        $imax=$_POST["imax"];
    }
    if (isset($_POST["table_max"]))
    {
        $table_max=$_POST["table_max"];
    }
    else if (isset($_POST["table_max"]))
    {
        $table_max=$_POST["table_max"];
    }

    $mysqli_main = mysqli_connect($server, $usr_bd, $pwd_bd, $bd);
    if (mysqli_connect_errno())
    {
        printf("Fallo al conectar: %s<br>", mysqli_connect_error());
        exit();
    }
    mysqli_query($mysqli_main, "set names 'utf8'");

    $sql=acentos_to_codigos($sql);
    $query_main = mysqli_query($mysqli_main, $sql);   
    if ($query_main==FALSE)
    {
        mysqli_close($mysqli_main);
        echo "error sql";
        return;
    }
    
    $i=strpos($sql,"insert into");
    if ($i!=false && $table_max=="" && $imax=="")
    {
        echo "Campos imax y table_max vacios<br>";
        return;
    }

    if ($table_max!="" && $imax!="")
    {
        $sql="select max(`".$imax."`) as `".$imax."` from `".$table_max."`";
        $query_main = mysqli_query($mysqli_main, $sql);
        $row=mysqli_fetch_assoc($query_main);

        $i=$row[$imax];
        mysqli_close($mysqli_main);
        echo $i;
        return;
    }

    $i=0;
    $arreglo=array();
    while ($row=mysqli_fetch_array($query_main, MYSQLI_ASSOC))
    {
        $arreglo[$i++]=$row;
    }
    mysqli_close($mysqli_main);

    if ($i==0)
    {
        echo "";
    }
    else
    {
        $json=json_encode($arreglo);
        $json=codigos_to_acentos($json);
        echo $json;
    }
?>
