<?php

//Basado en codigo visto en: http://www.formget.com/login-form-in-php/ 
echo "esto debería servir :/";
session_start(); // Starting Session
$error=''; // Variable To Store Error Message

//////////
function encrypt_decrypt($action, $string) {
$output = false;

$encrypt_method = "AES-256-CBC";
$secret_key = '23187SJAE382EJQW!2DSA';
$secret_iv = '9IEJWQDJE3-123.DASW1';

// hash
$key = hash('sha256', $secret_key);

// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
$iv = substr(hash('sha256', $secret_iv), 0, 16);

if( $action == 'encrypt' ) {
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
}
else if( $action == 'decrypt' ){
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
}
return $output;
}
/////////



if (isset($_POST['boton_login'])) {
    echo "boton tocado";
    if (empty($_POST['campo_nombre']) || empty($_POST['campo_pass'])) {
    $error = "Campo de Nombre de usuario o Contraseña vacío";
    }
    else
    {
        echo "todo tiene algo";
    $usuario = $_POST['campo_nombre'];
    $clave   = $_POST['campo_pass'];
    
    echo $clave;
    
   $conn = mysqli_connect('127.0.0.1:3306', 'base1', 'base');
    if (!$conn) {
       $error='No se ha podido conectar con la base de datos.';
       echo "NO FUNCIONO :( </br>";
    } else{
        echo "hay conecion</br>";
        $clave = encrypt_decrypt('encrypt', $clave);
        print $clave;
        
        
        
  
        


    //header("location: pag_inicio.html"); // Redirecting To Other Page            
    mysqli_close($conn);
       }
        }     
    }
?>

