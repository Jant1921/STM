<?php
//session_start();
$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      if (isset ( $_POST ['boton_agregar'] )) {
            $equipo = $_POST ['campo_equipo']; //guarda un una variable local el catalogo seleccionado
            $jugador = $_POST ['lista_jxp']; //guarda un una variable local el catalogo seleccionado
            $dorsal = $_POST ['campo_dorsal']; //guarda un una variable local el catalogo seleccionado 
            $scriptAgregar='call insert_jugadorxequipo(?,?,?)'; //guarda en una variable local la instruccion a ejecutar
            if ($stmt = $conn->prepare ( $scriptAgregar )) { //verifica que la sentencia haya sido preparada para su ejecucion
                $stmt->bind_param ( 'sss',$equipo,$jugador,$dorsal);  //define los parametros que recibe la funcion
                $stmt->execute ();                             //ejecuta el query     
            }else{
                echo "No se pudo insertar el jugador al equipo";
            }
            header("location: pagequipos_editarplantilla.html");          
      }

      
      if (isset ( $_POST ['boton_eliminar'] )) {
            $equipo = $_POST ['campo_equipo']; //guarda un una variable local el catalogo seleccionado
            $jugador = $_POST ['campo_jugadorEliminar']; //guarda un una variable local el catalogo seleccionado
            $scriptAgregar='call delete_jugadorxequipo(?,?)'; //guarda en una variable local la instruccion a ejecutar
            if ($stmt = $conn->prepare ( $scriptAgregar )) { //verifica que la sentencia haya sido preparada para su ejecucion
                $stmt->bind_param ( 'ss', $equipo, $jugador);  //define los parametros que recibe la funcion
                $stmt->execute ();                             //ejecuta el query     
            }else{
                echo "No se pudo eliminar el jugador del equipo";
            }
            header("location: pagequipos_editarplantilla.html");
      }
      
}
        
        









    /*$equipo = $_POST ['campo_equipo']; //guarda un una variable local el catalogo seleccionado
    $jugador = $_POST ['lista_jxp']; //guarda un una variable local el catalogo seleccionado
    $dorsal = $_POST ['campo_dorsal']; //guarda un una variable local el catalogo seleccionado 
    $scriptAgregar='call insert_jugadorxequipo(?,?,?)'; //guarda en una variable local la instruccion a ejecutar
    if ($stmt = $conn->prepare ( $scriptAgregar )) { //verifica que la sentencia haya sido preparada para su ejecucion
        $stmt->bind_param ( 'sss', $jugador,$equipo,$dorsal);  //define los parametros que recibe la funcion
        $stmt->execute ();                             //ejecuta el query     
    }else{
        echo "No se pudo insertar el jugador al equipo";
    }
    header("location: pagequipos_editarplantilla.html");*/