<?php
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm" ); // crea la conexion con la base de datos
if (mysqli_connect_errno ()) { // verifica si ha habido un error
	$error = mysqli_connect_error (); // guarda el mensaje de error para mostrarlo en la pagina
} else {
	$reference=$_GET['id'];
	$consulta = "SELECT partido_local FROM partido where partido_id=?";
	
	if ($stmt = $conn->prepare ($consulta)) {
		$stmt->bind_param ('s',$reference);  //define los parametros que recibe la funcion
		$stmt->execute ();
		/* bind variables to prepared statement */
		$stmt->bind_result ($team_local);
		$stmt->fetch ();
		/* close statement */
		$stmt->close ();
		};
	
	
	$consulta = "select persona_id,concat_ws(' ',Persona_Nombre,persona_primer_apellido,persona_segundo_apellido) nombre_completo from persona inner join jugadorxequipo on  JugadorxEquipo_Jugador=persona_Id and JugadorxEquipo_Equipo=?";
	if ($stmt = $conn->prepare ($consulta)) {
		$stmt->bind_param ( 'i',$team_local);  //define los parametros que recibe la funcion
		$stmt->execute ();
		
		/* bind variables to prepared statement */
		$stmt->bind_result ($jugador_id,$jugador_nombre);
		
      	/* fetch values */
		while ( $stmt->fetch () ) {
			
			echo '<li><label><input type="checkbox" name="locales[]" value="'.$jugador_id.'">'.$jugador_nombre.'</label></li>';// colocacion de los datos consultados en el droplist
        }
		
		/* close statement */
		$stmt->close ();
	}
}

?>