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


$error ="";
if (isset ( $_POST ['boton_guardar'] )) {//verifica si el boton de crear cuenta fue presionado
    $correoNuevo=$_POST ['campo_correo'];
    $passNueva=$_POST['campo_contrasenaNueva']; 
    $passNuevaEncrypt=encrypt_decrypt('encrypt', $passNueva);
    $passConfirmar=$_POST ['campo_contrasenaConfirmar'];  
    if (!empty ( $_POST ['campo_correo']  )){
        $mailNuevo='call update_correo(?,?)'; //guarda en una variable local la instruccion a ejecutar
        if ($stmt = $conn->prepare ( $mailNuevo )) { //verifica que la sentencia haya sido preparada para su ejecucion
            $stmt->bind_param ( 'ss', $user,$correoNuevo );  //define los parametros que recibe la funcion
            $stmt->execute ();                             //ejecuta el query  
            header("location: index.html"); // Redirecciona a la pagina principal con sesion iniciada
        }else{
            echo "No pudo correr el script de correo";
        }   
    }else{
        $error= "El correo no puede estar vacio";
        header("location: pagcuenta_editar.html"); // Redirecciona a la pagina principal con sesion iniciada
        echo $error;
    }
    
    
    if (!empty ( $_POST ['campo_contrasenaNueva'] ) || !empty ( $_POST ['campo_contrasenaConfirmar']  )){
        if($passNueva == $passConfirmar){
            $passNuevo='call update_usuarioContrasena(?,?)'; //guarda en una variable local la instruccion a ejecutar
            if ($stmt = $conn->prepare ( $passNuevo )) { //verifica que la sentencia haya sido preparada para su ejecucion
                $stmt->bind_param ( 'ss',$user,$passNuevaEncrypt);  //define los parametros que recibe la funcion
                $stmt->execute ();                             //ejecuta el query   
                header("location: index.html"); // Redirecciona a la pagina principal con sesion iniciada
            }else{
                echo "No pudo correr el script de contrasena";
            }   
        }else{
            $error= "Contraseñas diferentes, intentelo de nuevo.";
            header("location: pagcuenta_editar.html"); // Redirecciona a la pagina principal con sesion iniciada
            echo $error;
        }  
    }
    
}            
 ?>

