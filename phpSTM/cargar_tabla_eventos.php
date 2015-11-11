<?php
//Creado por Jose Ruiz; 9-11-2015
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      
      //guarda un una variable local el catalogo seleccionado
      $consulta= "SELECT evento_Id,Evento_Cantidad_Equipos,Evento_Nombre,Evento_Sede,evento_Genero from evento;" ;
      
      $resultad= mysqli_query($conn,$consulta);
      while ($fila = mysqli_fetch_array($resultad)) {
        $cantidad=$fila['Evento_Cantidad_Equipos'];
        $idEvento=$fila['evento_Id'];
        $eventoNombre=$fila['Evento_Nombre'];
      	$eventoSede=$fila['Evento_Sede'];
      	$generoEvento=$fila['evento_Genero'];
      	
      	//Se carga la cantidad de equipos
      	$consulta = "select select_cantidadEquipos(?)";
      	if ($stmt = $conn->prepare ($consulta)) {
      		$stmt->bind_param ('s',$cantidad);  //define los parametros que recibe la funcion
      		$stmt->execute ();
      		$stmt->bind_result ($cantidad);	/* bind variables to prepared statement */
      		$stmt->fetch ();
      		$stmt->close ();/* close statement */
      	};

      	//Se carga el nombre del evento
      	$consulta = "select select_nombreTorneo(?)";
      	if ($stmt = $conn->prepare ($consulta)) {
      		$stmt->bind_param ('s',$eventoNombre);  //define los parametros que recibe la funcion
      		$stmt->execute ();
      		$stmt->bind_result ($eventoNombre);	/* bind variables to prepared statement */
      		$stmt->fetch ();
      		$stmt->close ();/* close statement */
      	};
      	//Se carga la sede del evento
      	$consulta = "select select_nacion(?)";
      	if ($stmt = $conn->prepare ($consulta)) {
      		$stmt->bind_param ('i',$eventoSede);  //define los parametros que recibe la funcion
      		$stmt->execute ();
      		$stmt->bind_result ($eventoSede);	/* bind variables to prepared statement */
      		$stmt->fetch ();
      		$stmt->close ();/* close statement */
      	};
      	//Se carga el genero de los equipos participantes
      	$consulta = "select select_genero(?)";
      	if ($stmt = $conn->prepare ($consulta)) {
      		$stmt->bind_param ('s',$generoEvento);  //define los parametros que recibe la funcion
      		$stmt->execute ();
      		$stmt->bind_result ($generoEvento);	/* bind variables to prepared statement */
      		$stmt->fetch ();
      		$stmt->close ();/* close statement */
      	};
      	
      	echo '<tr bgcolor="#FFFFFF"><td>'.$cantidad.'</td>
            	  <td></td>
            	  <td><a href="estadisticatorneo.html?evento='.$idEvento.'">'.$eventoNombre.'</a></td>
            	  <td></td>
            	  <td>'.$eventoSede.'</td><td></td><td>'.$generoEvento.'</td></tr>';

        }


       }
  
    ?>