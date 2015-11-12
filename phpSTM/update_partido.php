<?php
session_start();
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
  	  $partido_code = $_POST ['in_partido']; //guarda un una variable local el catalogo seleccionado
  	  $estadio = $_POST ['in_estadio']; //guarda un una variable local el catalogo seleccionado
      $posesionL = $_POST ['in_posesion_local']; //guarda un una variable local el catalogo seleccionado
      $posesionV = $_POST ['in_posesion_visita']; //guarda un una variable local el catalogo seleccionado
      $golL = $_POST ['in_gol_local']; //guarda un una variable local el catalogo seleccionado
      $golV = $_POST ['in_gol_visita']; //guarda un una variable local el catalogo seleccionado
      $fecha= $_POST ['in_fecha']; //guarda la variable del tipo de persona que se va a insertar
          
        $scriptAgregar='call update_partido(?,?,?,?,?,?,?)'; //guarda en una variable local la instruccion a ejecutar
          if ($stmt = $conn->prepare ( $scriptAgregar )) { //verifica que la sentencia haya sido preparada para su ejecucion
				$stmt->bind_param ( 'sssssss', $partido_code,$estadio,$posesionL,$posesionV,$golL,$golV,$fecha);  //define los parametros que recibe la funcion
				$stmt->execute ();                             //ejecuta el query     
          		echo "actualizado";
          }else{
          	echo "no se pudo actualizar el patido";
          }
            
            header("location: pagpartido_nuevo.html");
        }
?>