<?php

/*session_start();
 $msg = "";
define('SERVIDOR', 'localhost');
    define('USER', 'root');
    define('PASSWORD', '');
    define('DB', 'csvparser');


    try{
        $conexion = new PDO('mysql:host='.SERVIDOR.";dbname=".DB,USER,PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }catch(PDOException $e){
        exit("Detalles del error: ".$e->getMessage());
    }


if(isset($_POST["databtn"])){
    //$data = $_SESSION["data"];
    $data = session('data2');
    $inserts = "";
    for($i = 0; $i < count($data); $i++){
        $catid = ":" . $i . $data[$i]->idFile0;
        $catname = ":" . $i . $data[$i]->file0Field;
        $cangid = ":" . $i . $data[$i]->idFile1;
        $cangname = ":" . $i . $data[$i]->file1Field;

        $inserts = $inserts . "(" . $catid . "," . $catname . "," . $cangid . "," . $cangname . ")";

        /*$catid = ":" . $i . $data[$i]->idFile0;
        $catname = ":" . $i . $data[$i]->file0Field;
        $cangid = ":" . $i . $data[$i]->idFile1;
        $cangname = ":" . $i . $data[$i]->file1Field;
    }
    $consulta = "INSERT INTO csvtest (catid, catname, cangid, cangname)
     VALUES " . $inserts;
    $sql = $conexion -> prepare($consulta);
    for($i = 0; $i < count($data); $i++){
        $catid = $data[$i]->idFile0;
        $catname = $data[$i]->file0Field;
        $cangid = $data[$i]->idFile1;
        $cangname = $data[$i]->file1Field;

        $sql->bindParam(":" . $i . $catid, $catid);
        $sql->bindParam(":" . $i . $catname, $catname);
        $sql->bindParam(":" . $i . $cangid, $cangid);
        $sql->bindParam(":" . $i . $cangname, $cangname);

        /*$catid = ":" . $i . $data[$i]->idFile0;
        $catname = ":" . $i . $data[$i]->file0Field;
        $cangid = ":" . $i . $data[$i]->idFile1;
        $cangname = ":" . $i . $data[$i]->file1Field;
    }
    $sql->execute();
    $msg = "successful";
}
else{
    
    $msg = "error";
}
echo $msg;

session_destroy();*/
?>