<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
<?php
// revisamos si se ha enviado el formulario
if (isset($_POST["producto"])){
    //recuperamos los datos enviados por el formulario
    $producto = $_POST["producto"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $nombreFoto = $_FILES["foto"]["name"];
    $tipo = $_FILES["foto"]["type"];
    $tamano = round($_FILES["foto"]["size"]/1024);
    

    include "../conexion.php";

    if($nombreFoto = $_FILES["foto"]["name"] == ""){

    $sql = "insert into paulina_productos (producto, descripcion, precio) values('$producto', '$descripcion', '$precio')";

    $nada = ejecutar($sql);

    echo "<script language='javascript'>";
    echo "window.location.assign('index.php');";
    echo "window.alert('El producto se ingresó correctamente a la base de datos.');";
    echo "</script>";

    }else{
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
            $idProducto = "select max(idProducto) from paulina_productos";
            $nombreFinal = $producto."_".$nombreFoto;
            $archivoParaSubir = $ruta.$nombreFinal;
            $temp = $_FILES["foto"]["tmp_name"]; /*nombre temporal del archivo que lo usa internament PHP para subirlo al servidor*/

            
            if (move_uploaded_file($temp, $archivoParaSubir)){
                 //primero inserta el producto, descripcion y precio
                $sql = "insert into paulina_productos (producto, descripcion, precio) values('$producto', '$descripcion', '$precio')";
                $nada = ejecutar($sql);

                //el archivo si subió al servidor.  Insertamos su nombre en la BD*/

                $sql_mode = "insert into paulina_fotoProductos (idProducto, foto) values((select max(idProducto) from paulina_productos), '$nombreFinal')";
                $nada = ejecutar($sql_mode);
                

                echo "<script language='javascript'>";
                echo "window.location.assign('index.php?foto=yes');";
                echo "window.alert('El producto se ingresó correctamente a la base de datos.');";
                echo "</script>";

            }else{
                // el archivo no subió al servidor. Redireccionamos la página con  un error*/
                echo "<script language='javascript'>";
                echo "window.location.assign('index.php?error=3');";
                echo "</script>";
            }

        }

    }

}else{
    //no se ha enviado nada, redireccionamos a index
    echo "<script language='javascript'>";
    echo "window.location.assign('index.php');";
    echo "</script>";
}
?>
    
</body>
</html>