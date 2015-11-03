<?php

include('sesion.php');

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
//session_start(); // Starting Session
//$error=''; // Variable To Store Error Message



  
    //Agarra la contraseña que esta en la base actualmente
    $conn = new mysqli ("127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
    if (mysqli_connect_errno ()) { //verifica si ha habido un error
        $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
    	echo $error;
    }else{
        $consulta = "select select_contrasena(?)";    //define la funcion loguear, que se va a ejecutar en la base de datos para verificar si nickname y password son correctos
        if ($stmt = $conn->prepare ( $consulta )) { //verifica que la sentencia haya sido preparada para su ejecucion
        $stmt->bind_param ( 's', $user);  //define los parametros que recibe la funcion
        $stmt->execute ();                             //ejecuta el query
        $stmt->bind_result ( $contrasenaEnBase );	//define a la variable $emailUser, donde se va a almacenar el resultado del correo
        $stmt->fetch ();								//guarda el resultado en la variable $resultado
        //$stmt->close (); //se cierra el query
        echo "contraseña cargada\n";
        echo $contrasenaEnBase.'\n';
        }
    }

if (isset ( $_POST ['boton_guardar'] )) {//verifica si el boton de crear cuenta fue presionado    
        //pregunta si la persona quiere ingresar una nueva contraseña
    if (empty ( $_POST ['campo_contrasenaNueva'])) {//revisa si contraseña nueva esta vacio
          //si esta vacio no hace nada
      echo "nueva vacia\n";
    }else{  //sino hace el update de contraseña 
        $contraNueva = $_POST ['campo_contrasenaNueva'];
        $contrasenaAnterior = $_POST ['campo_contrasenaAnterior']; //contrasenaAnterior = a lo del campo
        $contrasenaAnterior = encrypt_decrypt ( 'encrypt', $contrasenaAnterior ); //encripta la clave para compararla con la de la base de datos
        if ($contrasenaAnterior!=$contrasenaEnBase ){
            $error="Contrase�a anterior equivocada, intente de nuevo.";          
            echo $error;
        }else{
            $scriptUpdateUsuarioContrasena='call update_usuarioContrasena(?,?)'; //guarda en una variable local la instruccion a ejecutar
            if ($stmt = $conn->prepare ( $scriptUpdateUsuarioContrasena )) { //verifica que la sentencia haya sido preparada para su ejecucion
                $stmt->bind_param ( 'ss',$user,$contraNueva );  //define los parametros que recibe la funcion
                $stmt->execute ();                     //ejecuta el query    
            }       
        }
    }

    
    if (empty ( $_POST ['campo_correo'] )) {//se verifica que ningun campo este vacio
            $error = "Correo no puede estar vacio";  //guarda el mensaje de error para mostrarlo en la pagina
            echo $error;
    }else{//si todos los campos tienen texto,verifica en la base de datos que sean correctos
            $correo = $_POST ['campo_correo']; //guarda un una variable local el correo ingresado por el usuario
            $contrasenaBefore = $_POST ['campo_contrasenaAnterior']; //contrasenaAnterior = a lo del campo
            $contrasenaBeforeEncry = encrypt_decrypt ( 'encrypt', $contrasenaBefore ); //encripta la clave para compararla con la de la base de datos
            if ($contrasenaBeforeEncry!=$contrasenaEnBase ){
                $error="Contraseña anterior equivocada, intente de nuevo.";          
                echo $error;
            }else{
                $scriptUpdateCorreo="call update_correo(?,?)"; //guarda en una variable local la instruccion a ejecutar
                if ($stmt = $conn->prepare ( $scriptUpdateCorreo )) { //verifica que la sentencia haya sido preparada para su ejecucion
                    $stmt->bind_param ( 'ss',$user,$correo );  //define los parametros que recibe la funcion
                    $stmt->execute ();                     //ejecuta el query    
                    echo "se supone que cambia";
                }else{
                	echo "parece que no se cargo el script";
                }
                echo"\nultima salida";
            }
    }
}
 ?>

