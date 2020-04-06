<?php
//no te permite ingresar a la pagina a menos de haya una sesion iniciada
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script src="https://kit.fontawesome.com/5637dd924f.js" crossorigin="anonymous"></script>
    <script src="./scripts.js"></script> 
</head>
<body>
<div class="header">
<h1>Fotos productos</h1>
</div>

<?php
if (isset($_REQUEST["id"])){
    $id = $_REQUEST["id"];
    include "../conexion.php";
    $sql = "select producto from paulina_productos where idProducto = ".$id;
    $rs = ejecutar($sql);
    $dato = mysqli_fetch_array($rs);
    $producto = $dato["producto"];
?>
<div class="contenedorFormulario">
    <div class="formulario">
        Subir fotos para el producto <?php echo $producto; ?>:
        <br><br>

        <form id="f1" method="post" action="subirFotos_xt.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value = "<?php echo $id; ?>">
        <input type="file" name="foto" class="botonSubirFoto">
        <br><br>
        <button type="submit" class="botonSubirFoto">Subir Foto</button>
        </form>
        
    </div>
</div>


<?php
}else{
    echo "<script language='javascript'>";
    echo "window.location.assign('index.php');";
    echo "</script>";
}
?>
    
</body>
</html>