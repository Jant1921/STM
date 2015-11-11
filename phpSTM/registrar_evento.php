<?php

//Creado por Jose Ruiz ; 8-11-2015


session_start();  //inicia localmente el array $_SESSION
$mensaje="";
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $mensaje = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
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
				$mensaje = "evento creado";
          }else{
          	$mensaje = "no se pudo registrar el evento";
          }
      
      shuffle($_POST['teams']);  //se "revuelven" los equipos seleccionados para disputar el evento
      $copa=array();             //se crea el array que va a contener los grupos en forma de array
      $cantidad=count($_POST['teams']);    //se guarda la cantidad de equipos seleccionados
      for ($i=0; $i < $cantidad ; $i+=4) {  //se realiza la siguiente accion hasta llegar al final del array
      	$copa[]=array_slice($_POST['teams'],$i,4);  //se toma un subarray de 4 equipos y cada uno sera un grupo
      }
      
      $matchs = array();  //se crea el array que tendr� un array de encuentros,para cada grupo
      
      foreach ($copa as $grupo) { //se recorren todos los grupos en $copa
      	$fechas=array();     		//se crea el array que tendra las fechas de cada grupo
      	foreach($grupo as $k){		//se define un ciclo para recorrer los equipos de un grupo
      		foreach($grupo as $j){	//se vuelve a definir un ciclo igual, para crear un producto X
      			if($k == $j){		//Si el equipo es el mismo:
      				continue;		//ignora la combinaci�n y continua con otra
      			}
      			$z = array($k,$j);  //en un array guarda dos equipos
      			sort($z);			//ordena el array para que al comparar el array con otro que tenga los mismos equipos, sean iguales
      			if(!in_array($z,$fechas)){  //si no hay un partido entre ambos equipos
      				$fechas[] = $z;			//Guarda el partido en fechas,para que se almacene en la base de datos
      			}
      		}
      	}
      	$matchs[]=$fechas;				//al recorrer todos los equipos de un grupo, guarda los emparejamientos en $matchs
      }
      
      
      foreach($matchs as $keyg=>$grupo){  				//recorre todos los grupos de $matchs
      	foreach ($grupo as $keyp =>$partido) {        	//recorre todos los emparejamientos de $grupo
      		shuffle($partido);							//se "revuelven" los equipos para definir aleatoreamente al local y visitante, pues anteriormente el array fu� ordenado
      		$scriptPartido='CALL insertar_partido(?,?,?)'; //guarda en una variable local la instruccion a ejecutar
      		if ($stmt = $conn->prepare ( $scriptPartido )) { //verifica que la sentencia haya sido preparada para su ejecucion
      			$local=$partido[0];				//define al primer equipo del array como el local
      			$visita=$partido[1];			//define al segundo equipo del array como el visitante
      			$NumGrupo=($keyg+1);			//guarda el numero de grupo en una variable local
      			$stmt->bind_param ('iii',$local,$visita,$NumGrupo);  //define los parametros que recibe la funcion
      			$stmt->execute ();                             //ejecuta el query
      			
      		}else{
      			$mensaje = "no se pudo registrar el partido";
      		}	
      	}      
      }
            
            header("location: pagtorneo_nuevo.html");
        }
 ?>