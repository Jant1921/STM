<?php
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm" ); // crea la conexion con la base de datos
if (mysqli_connect_errno ()) { // verifica si ha habido un error
	$error = mysqli_connect_error (); // guarda el mensaje de error para mostrarlo en la pagina
} else {
	
	$consulta = "Select ciudad_Id , ciudad_Nombre from ciudad
				where ciudad_pais=?";
	if ($stmt = $conn->prepare ($consulta)) {
		$stmt->bind_param ( 'i',$_GET['id']);  //define los parametros que recibe la funcion
		$stmt->execute ();
		
		/* bind variables to prepared statement */
		$stmt->bind_result ( $ciudad_id, $ciudad_nombre);
		
		/* fetch values */
		while ( $stmt->fetch () ) {
			echo '<option value='.$ciudad_id.'>'.$ciudad_nombre.'</option>'; // colocacion de los datos consultados en el droplist
        }
		
		/* close statement */
		$stmt->close ();
	}
}

?>
