<?php
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm" ); // crea la conexion con la base de datos
if (mysqli_connect_errno ()) { // verifica si ha habido un error
	$error = mysqli_connect_error (); // guarda el mensaje de error para mostrarlo en la pagina
} else {
        
	
	$consulta = "Select equipo_Id,Equipo_Nombre from equipo
                        where equipo_tipo=?";
	if ($stmt = $conn->prepare ($consulta)) {
		$stmt->bind_param ( 'i',$_GET['id']);  //define los parametros que recibe la funcion
		$stmt->execute ();
		
		/* bind variables to prepared statement */
		$stmt->bind_result ( $equipo_id, $equipo_nombre);
		
      	/* fetch values */
		while ( $stmt->fetch () ) {
			echo '<li><label><input type="checkbox" name="teams[]" value="'.$equipo_id.'">'.$equipo_nombre.'</label></li>';// colocacion de los datos consultados en el droplist
        }
		
		/* close statement */
		$stmt->close ();
	}
}

?>