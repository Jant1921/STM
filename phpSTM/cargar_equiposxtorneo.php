<?php
//Creado por Daniel Estrada; 11-11-2015
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      if(isset($_GET['id'])){
      $idgroup=$_GET['id'];
      }else{
          $idgroup='-1';
      };
      
      //guarda un una variable local el catalogo seleccionado
      echo'<table style="width: 100%"  BORDER=1 RULES=ALL	FRAME=VOID>
			<tr bgcolor="#BBBBBB" >
                            <td>Nombre del Equipo</td>
                            
                        </tr>
			<tr><td></td>
                            
                        </tr> ';
      $consult= " (SELECT Partido_Local FROM partido WHERE Partido_Evento=".$idgroup.")
UNION
(SELECT Partido_Visitante FROM partido WHERE Partido_Evento=".$idgroup." )";
      
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
                
                
        
        
        
      
      	echo '
			<tr>
                            <td>'.$nombre.'</td>
                           
                            
                        </tr>
                        

';
        
        
        

        }


       }
       
       echo'		</table>';
  
    ?>