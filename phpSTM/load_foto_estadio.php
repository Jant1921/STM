<?php   
include('sesion.php');
if ($_FILES['imagen']['error']) {
          switch ($_FILES['imagen']['error']){
                   case 1: // UPLOAD_ERR_INI_SIZE
                   echo"El archivo sobrepasa el limite autorizado por el servidor(archivo php.ini) !";
                   break;
                   case 2: // UPLOAD_ERR_FORM_SIZE
                   echo "El archivo sobrepasa el limite autorizado en el formulario HTML !";
                   break;
                   case 3: // UPLOAD_ERR_PARTIAL
                   echo "El envio del archivo ha sido suspendido durante la transferencia!";
                   break;
                   case 4: // UPLOAD_ERR_NO_FILE
                   echo "El archivo que ha enviado tiene un tama�o nulo !";
                   break;
          }
          header("location: pagestadios_nuevo.html");
}
else {
 // $_FILES['imagen']['error'] vale 0 es decir UPLOAD_ERR_OK
 // lo que significa que no ha habido ning�n error
    $content = file_get_contents($_FILES['imagen']['tmp_name']);
    $ruta="fotos/".$_FILES['imagen']['name'];
    $fp = fopen($ruta, "w");
    fwrite($fp, $content);
    fclose($fp);
    $_SESSION['foto_user']=$ruta;
    header("location: pagestadios_nuevo.html");
} 
?>