<?php
session_start ();
if (! empty ( $_POST ['in_nombre'] ) || ! empty ( $_POST ['in_capacidad'] ) || ! empty ( $_POST ['in_cesped'] )) {
	$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm" ); // crea la conexion con la base de datos
	if (mysqli_connect_errno ()) { // verifica si ha habido un error
		$error = mysqli_connect_error (); // guarda el mensaje de error para mostrarlo en la pagina
	} else {
		$nombre = $_POST ['in_nombre']; // guarda un una variable local el nombre insertado
		$capacidad = $_POST ['in_capacidad'];
		$cesped= $_POST ['in_cesped'] ;
		$ciudad= $_POST ['in_ciudad'];
		if(isset($_SESSION['foto_user'])){  //verifica si se ha cargado una foto a la pesona nueva
			$foto=$_SESSION['foto_user']; //guarda la ruta en una variable local
			echo $foto;
			unset($_SESSION['foto_user']); //borra la ruta, de sesion, para que no aparezca cuando se crea otra persona
		}
		
		$scriptAgregar='call insert_estadio(?,?,?,?,?)'; //guarda en una variable local la instruccion a ejecutar
		if ($stmt = $conn->prepare ( $scriptAgregar )) { //verifica que la sentencia haya sido preparada para su ejecucion
			$stmt->bind_param ( 'sssss', $nombre,$ciudad,$capacidad,$cesped,$foto);  //define los parametros que recibe la funcion
			$stmt->execute ();                             //ejecuta el query
		}else{
			echo "no se pudo insertar el estadio";
		}
		
	}
}else{ 
	echo "todos lo campos deben estar llenos";
}
header("location: pagestadios_nuevo.html")
?>