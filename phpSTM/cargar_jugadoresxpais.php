<?php
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm" ); // crea la conexion con la base de datos
if (mysqli_connect_errno ()) { // verifica si ha habido un error
	$error = mysqli_connect_error (); // guarda el mensaje de error para mostrarlo en la pagina
} else {
        
	
	$consulta = "select persona_Id,Persona_Nombre from persona where Persona_Nacionalidad=? and Persona_Tipo=1";
	if ($stmt = $conn->prepare ($consulta)) {
            
		$stmt->bind_param ( 's',$_GET['id']);  //define los parametros que recibe la funcion
		$stmt->execute ();
		
		/* bind variables to prepared statement */
		$stmt->bind_result ( $persona_id, $Persona_Nombre);
		
		/* fetch values */
		while ( $stmt->fetch () ) {
			echo '<option value='.$persona_id.'>'.$Persona_Nombre.'</option>'; // colocacion de los datos consultados en el droplist
        }
		
		/* close statement */
		$stmt->close ();
	}
}
?>
