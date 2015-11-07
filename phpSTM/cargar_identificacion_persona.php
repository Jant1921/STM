<?php
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm" ); // crea la conexion con la base de datos
if (mysqli_connect_errno ()) { // verifica si ha habido un error
	$error = mysqli_connect_error (); // guarda el mensaje de error para mostrarlo en la pagina
} else {
      
      
        $reference=$_GET['idz'];
	$consulta = "select select_identificacion(?)";

	if ($stmt = $conn->prepare ($consulta)) {
		$stmt->bind_param ('s',$reference);  //define los parametros que recibe la funcion
		$stmt->execute ();
		/* bind variables to prepared statement */
		$stmt->bind_result ($identificacion);
		$stmt->fetch ();
                /* close statement */
		$stmt->close ();
        };

        echo '<p><span>'.$identificacion.'</span></p>';
 			
	
}

?>
