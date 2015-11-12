<?php
//Creado por Daniel Estrada; 9-11-2015
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      
        $nuno=1;
        $reference=$_GET['id'];
	$consulta = "select count(1),sum(Partido_Marcador_visitante+Partido_Marcador_Local) from partido where Partido_Evento=? and Partido_Disputado=1";

	if ($stmt = $conn->prepare ($consulta)) {
		$stmt->bind_param('s',$reference);  //define los parametros que recibe la funcion
		$stmt->execute ();
		/* bind variables to prepared statement */
		$stmt->bind_result ($partidos,$goles);
		$stmt->fetch ();
                /* close statement */
		$stmt->close ();
        };
        if($partidos>0){
        $resultadofinal=$goles/$partidos;
        }else{
            $resultadofinal="no hay partidos";
        };
        echo '<p><span>'.$resultadofinal.'</span></p>'; 
  }
?>