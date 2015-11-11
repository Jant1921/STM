
<?php
//Creado por Daniel Estrada; 11-11-2015
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      if(isset($_GET['ide'])){
      $idgroup=$_GET['ide'];
      }else{
          $idgroup='-1';
      };
      if(isset($_GET['idev'])){
      $idevento=$_GET['idev'];
      }else{
          $idevento='-1';
      };;
      //guarda un una variable local el catalogo seleccionado
      echo'<table style="width: 100%"  BORDER=1 RULES=ALL	FRAME=VOID>
			<tr bgcolor="#BBBBBB" >
                            <td>Nombre del Equipo</td>
                            <td></td>
                            <td>PJ</td>
                            <td></td>
                            <td>PG</td>
                            <td></td>
                            <td>PE</td>
                            <td></td>
                            <td>PP</td>
                            <td></td>
                            <td>GF</td>
                            <td></td>
                            <td>GC</td>
                            <td></td>
                            <td>DG</td>
                            <td></td>
                            <td>PFP</td>
                            <td></td>
                            <td>Pts</td>
                        </tr>
			<tr><td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr> ';
      $consult= " (SELECT Partido_Local FROM partido WHERE Partido_Evento=".$idevento." and Partido_Grupo=".$idgroup.")
UNION
(SELECT Partido_Visitante FROM partido WHERE Partido_Evento=".$idevento." and Partido_Grupo=".$idgroup.")";
      
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
                $difgoles=$golesfavor-$golescontra;
                $puntos=($ganes*3)+($empates*1);
        
        
        
        
        
      
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
                            <td>'.$difgoles.'</td>
                            <td></td>
                            <td>PFP</td>
                            <td></td>
                            <td>'.$puntos.'</td>
                        </tr>
                        

';
        
        

        }


       }
  
    ?>