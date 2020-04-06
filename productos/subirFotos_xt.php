<?php
//no te permite ingresar a la pagina a menos de haya una sesion iniciada
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    //checamos hemos enviado el formulario
    if (isset($_POST["id"])){
        include "../conexion.php";
        $id = $_POST["id"];
        $nombreFoto = $_FILES["foto"]["name"];
        $tipo = $_FILES["foto"]["type"];
        $tamano = round($_FILES["foto"]["size"]/1024);

        /*
        echo "<br><br>";
        echo "Nombre foto = ".$nombreFoto."<br>";
        echo "Tipo = ".$tipo."<br>";
        echo "Tamaño = ".$tamano."KB<br>";
        echo "id = ".$id;
        */

        
        $error = 0; /*no tenemos errores*/

        /* checamos que el archivo sea una imagen */
        if ($tipo != "image/jpeg" && $tipo != "image/jpg" && $tipo != "image/png"){
            $error = 1;

        /* checamos el tamaño del archivo (que sea menor a 500 MB) */
        }else if ($tamano > 500000){
            $error = 2;
        }

        /* checamos el valor del error */
        if ($error != 0) {
            /* Reenviamos la página a index, con el error como querystring */
            echo "<script language='javascript'>";
            echo "window.location.assign('index.php?error=".$error."');";
            echo "</script>";

        } else {
            /* no hay errores: subimos la página al servidor y el nombre del archivo a la BD */
            $nombreFinal = $id."_".$nombreFoto;
            $archivoParaSubir = $ruta.$nombreFinal;
            $temp = $_FILES["foto"]["tmp_name"]; /*nombre temporal del archivo que lo usa internament PHP para subirlo al servidor*/

            if (move_uploaded_file($temp, $archivoParaSubir)){
                //el archivo si subió al servidor.  Insertamos su nombre en la BD*/
                
                $sql = "insert into paulina_fotoProductos (idProducto, foto) values($id, '$nombreFinal')";
                $nada = ejecutar($sql);

                echo "<script language='javascript'>";
                echo "window.location.assign('index.php?foto=yes');";
                echo "</script>";

            }else{
                // el archivo no subió al servidor. Redireccionamos la página con  un error*/
                echo "<script language='javascript'>";
                echo "window.location.assign('index.php?error=3');";
                echo "</script>";
            }

        }

    }else{
        echo "<script language='javascript'>";
        echo "window.location.assign('index.php');";
        echo "</script>";

    }
    ?>

</body>
</html>