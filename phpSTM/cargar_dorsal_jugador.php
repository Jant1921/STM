<?php
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm" ); // crea la conexion con la base de datos
if (mysqli_connect_errno ()) { // verifica si ha habido un error
	$error = mysqli_connect_error (); // guarda el mensaje de error para mostrarlo en la pagina
} else {
      
      
        $reference=$_GET['var1'];
       
        $referencet=$_GET['var2'];
        //$referencet=$_POST['ids'];
        
     

	$consulta = "select select_camisa(?,?)";
        
	if ($stmt = $conn->prepare ($consulta)) {
		$stmt->bind_param ('ss',$reference,$referencet);  //define los parametros que recibe la funcion
		$stmt->execute ();
		/* bind variables to prepared statement */
		$stmt->bind_result ($dorsal);
		$stmt->fetch ();
                /* close statement */
		$stmt->close ();
        };

        echo '<p><span>'.$dorsal.'</span></p>';
 			
	
}

?>
