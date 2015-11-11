
<?php
//Creado por Jose Ruiz; 9-11-2015
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      $yolo=1;
      //guarda un una variable local el catalogo seleccionado
      $consult= " (SELECT Partido_Local FROM partido WHERE Partido_Grupo=1)
UNION
(SELECT Partido_Visitante FROM partido WHERE Partido_Grupo=".$yolo.")";
      
      $resultad= mysqli_query($conn,$consult);
      while ($fil= mysqli_fetch_array($resultad)) {
          $idequipo=$fil['Partido_Local'];
          
                $consulta = "select nombre_equipo(?)";
         	if ($stmt = $conn->prepare ($consulta)) {
          		$stmt->bind_param ('s',$idequipo);  //define los parametros que recibe la funcion
         		$stmt->execute ();
          		$stmt->bind_result ($nombre);	/* bind variables to prepared statement */
          		$stmt->fetch ();
          		$stmt->close ();/* close statement */
          	};
                
                $consulta = "select select_partidos_ganados(?)";
         	if ($stmt = $conn->prepare ($consulta)) {
          		$stmt->bind_param ('s',$idequipo);  //define los parametros que recibe la funcion
         		$stmt->execute ();
          		$stmt->bind_result ($ganes);	/* bind variables to prepared statement */
          		$stmt->fetch ();
          		$stmt->close ();/* close statement */
          	};
                
                $consulta = "select select_partidos_perdidos(?)";
         	if ($stmt = $conn->prepare ($consulta)) {
          		$stmt->bind_param ('s',$idequipo);  //define los parametros que recibe la funcion
         		$stmt->execute ();
          		$stmt->bind_result ($derrotas);	/* bind variables to prepared statement */
          		$stmt->fetch ();
          		$stmt->close ();/* close statement */
          	};
                $consulta = "select select_partidos_empatados(?)";
         	if ($stmt = $conn->prepare ($consulta)) {
          		$stmt->bind_param ('s',$idequipo);  //define los parametros que recibe la funcion
         		$stmt->execute ();
          		$stmt->bind_result ($empates);	/* bind variables to prepared statement */
          		$stmt->fetch ();
          		$stmt->close ();/* close statement */
          	};
                $total=$derrotas+$empates+$ganes;
                
                $consulta = "select select_Goles_local(?)";
         	if ($stmt = $conn->prepare ($consulta)) {
          		$stmt->bind_param ('s',$idequipo);  //define los parametros que recibe la funcion
         		$stmt->execute ();
          		$stmt->bind_result ($gollocal);	/* bind variables to prepared statement */
          		$stmt->fetch ();
          		$stmt->close ();/* close statement */
          	};
                $consulta = "select select_Goles_visitante(?)";
         	if ($stmt = $conn->prepare ($consulta)) {
          		$stmt->bind_param ('s',$idequipo);  //define los parametros que recibe la funcion
         		$stmt->execute ();
          		$stmt->bind_result ($golvisita);	/* bind variables to prepared statement */
          		$stmt->fetch ();
          		$stmt->close ();/* close statement */
          	};
                $golesfavor=$golvisita+$gollocal;
                
                $consulta = "select select_Golescontra_local(?)";
         	if ($stmt = $conn->prepare ($consulta)) {
          		$stmt->bind_param ('s',$idequipo);  //define los parametros que recibe la funcion
         		$stmt->execute ();
          		$stmt->bind_result ($golclocal);	/* bind variables to prepared statement */
          		$stmt->fetch ();
          		$stmt->close ();/* close statement */
          	};
                $consulta = "select select_Golescontra_visitante(?)";
         	if ($stmt = $conn->prepare ($consulta)) {
          		$stmt->bind_param ('s',$idequipo);  //define los parametros que recibe la funcion
         		$stmt->execute ();
          		$stmt->bind_result ($golcvisita);	/* bind variables to prepared statement */
          		$stmt->fetch ();
          		$stmt->close ();/* close statement */
          	};
                $golescontra=$golcvisita+$golclocal;
        
        
        
        
        
      
      	echo '
			<tr>
                            <td>'.$nombre.'</td>
                            <td></td>
                            <td>'.$total.'</td>
                            <td></td>
                            <td>'.$ganes.'</td>
                            <td></td>
                            <td>'.$empates.'</td>
                            <td></td>
                            <td>'.$derrotas.'</td>
                            <td></td>
                            <td>'.$golesfavor.'</td>
                            <td></td>
                            <td>'.$golescontra.'</td>
                            <td></td>
                            <td>DG</td>
                            <td></td>
                            <td>PFP</td>
                            <td></td>
                            <td>Pts</td>
                        </tr>
                        

';
        
        

        }


       }
  
    ?>