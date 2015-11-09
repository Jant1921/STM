<?php
session_start();  //inicia localmente el array $_SESSION
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
  	
      $nombre 	= 	$_POST ['in_torneo']; //guarda un una variable local el catalogo seleccionado
      $genero	=	$_POST ['in_genero']; //guarda un una variable local el catalogo seleccionado
      $tipoEvento	=	$_POST ['in_tipo_evento']; //guarda un una variable local el catalogo seleccionado
      $tipoEquipo	=	$_POST ['in_tipo_equipo']; //guarda un una variable local el catalogo seleccionado
      $cantidad = 	$_POST ['in_cantidad']; //guarda un una variable local el catalogo seleccionado; //guarda un una variable local el catalogo seleccionado
      $pais 	=	$_POST ['in_pais']; //guarda un una variable local el catalogo seleccionado
      $creador  = $_SESSION['signed_nombre']; //Se carga el nombre de la persona que crea el evento
      
      $scriptAgregar='call insert_evento(?,?,?,?,?,?,?)'; //guarda en una variable local la instruccion a ejecutar
          if ($stmt = $conn->prepare ( $scriptAgregar )) { //verifica que la sentencia haya sido preparada para su ejecucion
				$stmt->bind_param ( 'sssssss', $nombre,$genero,$tipoEvento,$tipoEquipo,$cantidad,$pais,$creador);  //define los parametros que recibe la funcion
				$stmt->execute ();                             //ejecuta el query     
				echo "evento creado";
          }else{
          	echo "no se pudo registrar el evento";
          }
      
      shuffle($_POST['teams']);
      $copa=array();
      $cantidad=count($_POST['teams']);
      for ($i=0; $i < $cantidad ; $i+=4) {
      	$copa[]=array_slice($_POST['teams'],$i,4);
      }
      
      foreach ($copa as $keyg => $grupo) {
      	echo 'grupo: '.($keyg+1).'</br>Participantes: </br>';
      	foreach ($grupo as $keyt => $team) {
      		echo $team.'</br>';
      	}
      	echo'</br>';
      }
      echo'</br></br></br>';
      
      
      $matchs = array();
      
      foreach ($copa as $grupo) {
      	$fechas=array();
      	foreach($grupo as $k){
      		foreach($grupo as $j){
      			if($k == $j){
      				continue;
      			}
      			$z = array($k,$j);
      			sort($z);
      			if(!in_array($z,$fechas)){
      				$fechas[] = $z;
      			}
      		}
      	}
      	$matchs[]=$fechas;
      }
      
      
      foreach($matchs as $keyg=>$grupo){
      	echo 'Partidos del Grupo '.($keyg+1).'</br>';
      	foreach ($grupo as $keyp =>$partido) {
      		shuffle($partido);
      		$scriptPartido='CALL insertar_partido(?,?,?)'; //guarda en una variable local la instruccion a ejecutar
      		if ($stmt = $conn->prepare ( $scriptPartido )) { //verifica que la sentencia haya sido preparada para su ejecucion
      			$local=$partido[0];
      			$visita=$partido[1];
      			$NumGrupo=($keyg+1);
      			$stmt->bind_param ('iii',$local,$visita,$NumGrupo);  //define los parametros que recibe la funcion
      			$stmt->execute ();                             //ejecuta el query
      			echo $partido[0].' vs '.$partido[1].'</br>';
      		}else{
      			echo "no se pudo registrar el partido";
      		}
      		
      		
      	}
      	echo'</br>';
      
      }
            
            header("location: pagtorneo_nuevo.html");
        }
 ?>