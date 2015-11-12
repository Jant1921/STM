
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
                            <td>Equipo Local</td>
                            <td></td>
                            <td>_______</td>
                            <td></td>
                            <td>Resultado</td>
                            <td></td>
                            <td>_______</td>
                            <td></td>
                            <td>Equipo Visitante</td>
                            <td></td>   
                            <td></td>
                            <td>_______</td>
                            <td></td>
                            <td>Estado</td>

                        </tr>
			<tr><td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr> ';
      $consult= "select partido_id,partido_Local,partido_Visitante,Partido_Marcador_Local,Partido_Marcador_Visitante,partido_Disputado,Partido_Posesion_Local,Partido_Posesion_Visitante From partido where Partido_Evento=".$idevento." and Partido_Grupo=".$idgroup." ";;
      
      $resultad= mysqli_query($conn,$consult);
      while ($fil= mysqli_fetch_array($resultad)) {
          $idequipol=$fil['partido_Local'];
          $idequipov=$fil['partido_Visitante'];
          $marcadorlocal=$fil['Partido_Marcador_Local'];
          $marcadorvisitante=$fil['Partido_Marcador_Visitante'];
          $disputado=$fil['partido_Disputado'];
          $id_partido=$fil['partido_id'];
          $posesionl=$fil['Partido_Posesion_Local'];
          $posesionv=$fil['Partido_Posesion_Visitante'];
                
                //$consulta = "select partido_Local,partido_Visitante,Partido_Marcador_Local,Partido_Marcador_Visitante From partido where Partido_Evento=".$idevento." and Partido_Grupo=".$idgroup."";
         	$consulta = "select nombre_equipo(?)";
         	if ($stmt = $conn->prepare ($consulta)) {
          		$stmt->bind_param ('s',$idequipol);  //define los parametros que recibe la funcion
         		$stmt->execute ();
          		$stmt->bind_result ($nombrel);	/* bind variables to prepared statement */
          		$stmt->fetch ();
          		$stmt->close ();/* close statement */
          	};
                
                
                $consulta = "select nombre_equipo(?)";
         	if ($stmt = $conn->prepare ($consulta)) {
          		$stmt->bind_param ('s',$idequipov);  //define los parametros que recibe la funcion
         		$stmt->execute ();
          		$stmt->bind_result ($nombrev);	/* bind variables to prepared statement */
          		$stmt->fetch ();
          		$stmt->close ();/* close statement */
          	};
                
                if($disputado==1){
                    $jugado="Jugado";
                }else{
                    $jugado="Pendiente";
                };
                
        
        
      
      	echo '
			<tr>
                            <td>'.$nombrel.'</td>
                            <td></td>
                            <td>_______</td>
                            <td></td>
                            <td><a href="estadisticapartido.html?partido='.$id_partido.'&plocal='.$posesionl.'&nlocal='.$nombrel.'&nvisita='.$nombrev.'&pvisita='.$posesionv.'">'.$marcadorlocal.'--'.$marcadorvisitante.'</a></td>
                            <td></td>
                            <td>_______</td>
                            <td></td>
                            <td>'.$nombrev.'</td>
                            <td></td>   
                            <td></td>
                            <td>_______</td>
                            <td></td>
                            <td>'.$jugado.'</td>
                        </tr>
                        

';
        
        

        }


       }
       echo'		</table>';
  
    ?>