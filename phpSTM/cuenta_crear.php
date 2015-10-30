<?php


function encrypt_decrypt($action, $string) {
	////Codigo tomado de https://naveensnayak.wordpress.com/2013/03/12/simple-php-encrypt-and-decrypt///////
	$output = false; //variable que guarda el resultado de la encriptacion

	$encrypt_method = "AES-256-CBC";  //se define el tipo de encriptacion a utilizar
	$secret_key = '23187SJAE382EJQW!2DSA';
	$secret_iv = '9IEJWQDJE3-123.DASW1';

	// hash
	$key = hash('sha256', $secret_key);

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	//se verifica que tipo de accion se va a realizar
	if( $action == 'encrypt' ) {
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv );
		$output = base64_encode ( $output );
	} else if ($action == 'decrypt') {
		$output = openssl_decrypt ( base64_decode ( $string ), $encrypt_method, $key, 0, $iv );
	}
	return $output;//devuelve el resultado de la operacion
}
// ///////


//Basado en codigo visto en: http://www.formget.com/login-form-in-php/ 
session_start(); // Starting Session
$error=''; // Variable To Store Error Message



/*if (isset ( $_POST ['boton_crear'] )) {//verifica si el boton de crear cuenta fue presionado
	if (empty ( $_POST ['campo_correo'] ) || empty ( $_POST ['campo_nickname']  ) || empty ( $_POST ['campo_contrasena']  ) || empty ( $_POST ['campo_contrasenaConfirmar']  )) {//se verifica que ningun campo este vacio
		$error = "Todos los campos deben estar llenos";  //guarda el mensaje de error para mostrarlo en la pagina
	} else {//si todos los campos tienen texto,verifica en la base de datos que sean correctos
		$correo = $_POST ['campo_correo']; //guarda un una variable local el orreo ingresado por el usuario
		$nickname = $_POST ['campo_nickname'];		//guarda un una variable local el nickname ingresado por el usuario
                $contrasena = $_POST ['campo_contrasena'];		//guarda un una variable local el password ingresado por el usuario
                $contrasenaConfirmar = $_POST ['campo_contrasenaConfirmar'];		//guarda un una variable local el passwordConfirmar ingresado por el usuario
		
		
		$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
                if (mysqli_connect_errno ()) { //verifica si ha habido un error
			$error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
		} else { //si no han habido errores
			
			$contrasena = encrypt_decrypt ( 'encrypt', $contrasena ); //encripta la clave para compararla con la de la base de datos
			$query = "select loguear(?,?)";    //define la funcion loguear, que se va a ejecutar en la base de datos para verificar si nickname y password son correctos
			if ($stmt = $conn->prepare ( $query )) { //verifica que la sentencia haya sido preparada para su ejecucion
				$stmt->bind_param ( 'ss', $usuario, $clave );  //define los parametros que recibe la funcion
				$stmt->execute ();                             //ejecuta el query
				$stmt->bind_result ( $resultado );				//define a la variable $resultado, donde se va a almacenar el resultado
				$stmt->fetch ();								//guarda el resultado en la variable $resultado
				$stmt->close (); //se cierra el query
				if ($resultado == $usuario) {                  //verifica que la funcion haya encontrado un usuario que cumpla con los datos ingresados para el login 
					$_SESSION['signed_nombre']=$usuario;       //guarda el nombre del usuario para mantenerlo durante toda la sesion
					$_SESSION['is_signed']=true;				//se establece que ya hay una sesion activa en el sistema
					header("location: index.html"); // Se redirige al index, con sesion iniciada
				} else {
					$error = "Por favor verifique su usuario y/o contrase�a"; //no se han introducido datos en los campos de texto
				}
				
				$conn->close ();//se cierra la conexion con la base de datos
			}
		}
 	}
}


*/
 ?>


