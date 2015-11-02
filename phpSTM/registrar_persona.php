<?php

$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      $nombre = $_POST ['in_nombre']; //guarda un una variable local el catalogo seleccionado
      $papellido = $_POST ['in_papellido']; //guarda un una variable local el catalogo seleccionado
      $sapellido = $_POST ['in_sapellido']; //guarda un una variable local el catalogo seleccionado
      $genero = $_POST ['in_genero']; //guarda un una variable local el catalogo seleccionado
      $ident = $_POST ['in_identificacion']; //guarda un una variable local el catalogo seleccionado
      $pais = $_POST ['in_pais']; //guarda un una variable local el catalogo seleccionado
      $tipo= 1;
      
    
        $scriptAgregar='call insert_persona(?,?,?,?,?,?,?)'; //guarda en una variable local la instruccion a ejecutar
          if ($stmt = $conn->prepare ( $scriptAgregar )) { //verifica que la sentencia haya sido preparada para su ejecucion
				$stmt->bind_param ( 'sssssss', $nombre,$papellido,$sapellido,$ident,$pais,$genero,$tipo);  //define los parametros que recibe la funcion
				$stmt->execute ();                             //ejecuta el query     
            }
        }