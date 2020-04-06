function abrirModal(){
    document.getElementById("vModal").style.display="block";
    document.getElementById("msj").innerHTML="";

}

function cerrarModal(){
    document.getElementById("vModal").style.display="none";

}

function subirFoto(id){
    // ir a la página subirFotos.php con el id del producto como querystring
    window.location.assign("subirFotos.php?id="+id);
}



function validarFormulario(){
    var flag = false;
    for (var i=1; i<3; i++){
        if (document.getElementById("c"+i).value == "") flag = true;
    }

    if (flag){
        document.getElementById("msj").innerHTML="Debe llenar los campos nombre, descripción y precio";
    }else{
        document.getElementById("msj").innerHTML="";
        //hacemos el submit del formulario
        document.getElementById("f2").submit();
   }
}