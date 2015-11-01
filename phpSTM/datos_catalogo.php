<?php

$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      $catalogo = $_POST ['catalogoagregar']; //guarda un una variable local el catalogo seleccionado
      $dato=$_POST['dato_insert'];
      if($catalogo=='cesped'){
    
        $scriptAgregar='call Insert_cesped(?)'; //guarda en una variable local la instruccion a ejecutar
          if ($stmt = $conn->prepare ( $scriptAgregar )) { //verifica que la sentencia haya sido preparada para su ejecucion
				$stmt->bind_param ( 's', $dato );  //define los parametros que recibe la funcion
				$stmt->execute ();                             //ejecuta el query     
            }
        }
  
      }
  
          