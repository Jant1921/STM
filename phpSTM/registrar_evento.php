<?php
session_start();  //inicia localmente el array $_SESSION
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      $nombre 	= 	$_POST ['in_torneo']; //guarda un una variable local el catalogo seleccionado
      $genero	=	$_POST ['in_genero']; //guarda un una variable local el catalogo seleccionado
      $tipoEvento	=	$_POST ['in_tipo_evento']; //guarda un una variable local el catalogo seleccionado
      $tipoEquipo	=	$_POST ['in_tipo_equipo']; //guarda un una variable local el catalogo seleccionado
      $cantidad = 	$_POST ['in_cantidad']; //guarda un una variable local el catalogo seleccionado; //guarda un una variable local el catalogo seleccionado
      $pais 	=	$_POST ['in_pais']; //guarda un una variable local el catalogo seleccionado
      $creador  = $_SESSION['signed_nombre']; //Se carga el nombre de la persona que crea el evento
      
      $scriptAgregar='call insert_evento(?,?,?,?,?,?,?)'; //guarda en una variable local la instruccion a ejecutar
          if ($stmt = $conn->prepare ( $scriptAgregar )) { //verifica que la sentencia haya sido preparada para su ejecucion
				$stmt->bind_param ( 'sssssss', $nombre,$genero,$tipoEvento,$tipoEquipo,$cantidad,$pais,$creador);  //define los parametros que recibe la funcion
				$stmt->execute ();                             //ejecuta el query     
				echo "evento creado";
          }else{
          	echo "no se pudo registrar el evento";
          }
            
            header("location: pagtorneo_nuevo.html");
        }
 ?>