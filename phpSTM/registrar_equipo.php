<?php
session_start();
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      $nombre = $_POST ['campo_nombreEquipo']; //guarda un una variable local el catalogo seleccionado
      $ubicacion = $_POST ['campo_localidad']; //guarda un una variable local el catalogo seleccionado
      $tipo = $_POST ['campo_tipoEquipo']; //guarda un una variable local el catalogo seleccionado
      
      
      if(isset($_SESSION['foto_user'])){  //verifica si se ha cargado una foto a la pesona nueva
      	$foto=$_SESSION['foto_user']; //guarda la ruta en una variable local
      	unset($_SESSION['foto_user']); //borra la ruta, de sesion, para que no aparezca cuando se crea otra persona
      	}    
      else{	
      	$foto="fotos/default.png";  //si no se ha cargado una imagen,se asigna una predeterminada
      }
    
        $scriptAgregar='call insert_equipo(?,?,?,?)'; //guarda en una variable local la instruccion a ejecutar
          if ($stmt = $conn->prepare ( $scriptAgregar )) { //verifica que la sentencia haya sido preparada para su ejecucion
				$stmt->bind_param ( 'ssss', $nombre,$ubicacion,$tipo,$foto);  //define los parametros que recibe la funcion
				$stmt->execute ();                             //ejecuta el query     
          }else{
          	echo "no se pudo insertar el equipo";
          }       
            header("location: pagequipos_nuevo.html");
    }

