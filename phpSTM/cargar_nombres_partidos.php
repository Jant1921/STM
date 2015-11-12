<?php
//Creado por Jose Ruiz; 11-11-2015
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm" ); // crea la conexion con la base de datos
if (mysqli_connect_errno ()) { // verifica si ha habido un error
	$error = mysqli_connect_error (); // guarda el mensaje de error para mostrarlo en la pagina
} else {
	$consulta = "select partido_id,Partido_Local,Partido_visitante from partido where Partido_Evento=? and Partido_Grupo=?";
	
	
	if ($fil = $conn->prepare ($consulta)) {
		$fil->bind_param ( 'ii',$_GET['evento'],$_GET['grupo']);  //define los parametros que recibe la funcion
		$fil->execute ();
		
		/* bind variables to prepared statement */
		$fil->bind_result ( $partido_id, $partido_local,$partido_visitante);
		
		
		/* fetch values */
		while ( $fil->fetch () ) {
			
			$consultaL = "select nombre_equipo(?)";
         	if ($stmtL = $conn->prepare ($consultaL)) {
          		$stmtL->bind_param ('i',$partido_local);  //define los parametros que recibe la funcion
         		$stmtL->execute ();
          		$stmtL->bind_result ($partido_local);	/* bind variables to prepared statement */
          		$stmtL->fetch ();
          		$stmtL->close ();/* close statement */
          	};
			
			$consultaV = "select nombre_equipo(?)";
         	if ($stmtV= $conn->prepare ($consultaV)) {
          		$stmtV->bind_param ('i',$partido_visitante);  //define los parametros que recibe la funcion
         		$stmtV->execute ();
          		$stmtV->bind_result ($partido_visitante);	/* bind variables to prepared statement */
          		$stmtV->fetch ();
          		$stmtV->close ();/* close statement */
          	};
			
			
			echo '<option value='.$partido_id.'>'.$partido_local.' vs '.$partido_visitante.'</option>'; // colocacion de los datos consultados en el droplist
        
		
		}
		
		/* close statement */
		$fil->close ();
	}
}

?>