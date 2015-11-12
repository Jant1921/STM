<?php
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm" ); // crea la conexion con la base de datos
if (mysqli_connect_errno ()) { // verifica si ha habido un error
	$error = mysqli_connect_error (); // guarda el mensaje de error para mostrarlo en la pagina
} else {
    if(isset($_GET['idp'])){
      $idpart=$_GET['idp'];
      }else{
          $idp='-1';
      };;
      //guarda un una variable local el catalogo seleccionado
      echo'<table style="width: 100%"  BORDER=1 RULES=ALL	FRAME=VOID>
			<tr bgcolor="#BBBBBB" >
                            <td>Dorsal</td>
                            <td></td>
                            <td>Nombre</td>
                            <td></td>
                          

                        </tr>
			<tr><td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            
                        </tr> ';
    
    
    
	$consulta = "SELECT Partido_Local FROM partido where partido_id=?";
	
	if ($stmt = $conn->prepare ($consulta)) {
		$stmt->bind_param ('s',$idpart);  //define los parametros que recibe la funcion
		$stmt->execute ();
		/* bind variables to prepared statement */
		$stmt->bind_result ($team_local);
		$stmt->fetch ();
		/* close statement */
		$stmt->close ();
		};
                
        $consulta = "select JugadorxEquipo_Dorsal,persona_id,concat_ws(' ',Persona_Nombre,persona_primer_apellido,persona_segundo_apellido) nombre_completo from persona inner join jugadorxequipo on  JugadorxEquipo_Jugador=persona_Id and JugadorxEquipo_Equipo=?";
	if ($stmt = $conn->prepare ($consulta)) {
		$stmt->bind_param ( 'i',$team_local);  //define los parametros que recibe la funcion
		$stmt->execute ();
		
		/* bind variables to prepared statement */
		$stmt->bind_result ($dorsal,$jugador_id,$jugador_nombre);
		
      	/* fetch values */
		while ( $stmt->fetch () ) {
			
			echo ' <tr><td>'.$dorsal.'<td></td>
          
                            <td>'.$jugador_nombre.'</td>
                            <td></td>
                            
                        </tr>  ';// colocacion de los datos consultados en el droplist
        }
		
		/* close statement */
		$stmt->close ();
	}
                
                
                
                
}

?>                