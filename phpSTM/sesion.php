<?php
session_start();
$user=$_SESSION['signed_nombre'];  

$conn = new mysqli ("127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      $consulta = "select select_correo(?)";    //define la funcion loguear, que se va a ejecutar en la base de datos para verificar si nickname y password son correctos
      if ($stmt = $conn->prepare ( $consulta )) { //verifica que la sentencia haya sido preparada para su ejecucion
            $stmt->bind_param ( 's', $user);  //define los parametros que recibe la funcion
            $stmt->execute ();                             //ejecuta el query
            $stmt->bind_result ( $emailUser );	//define a la variable $emailUser, donde se va a almacenar el resultado del correo
            $stmt->fetch ();								//guarda el resultado en la variable $resultado
            //$stmt->close (); //se cierra el query
      }
  }
?>
