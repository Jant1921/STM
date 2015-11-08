<?php

$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      
      //guarda un una variable local el catalogo seleccionado
      $consulta= "Select cantidad_equipos_Id , cantidad_equipos_numero from cantidad_equipos" ;
      
      $resultad= mysqli_query($conn,$consulta);

      while ($fila = mysqli_fetch_array($resultad)) {
            echo "<option value=".$fila['cantidad_equipos_Id'].">".$fila['cantidad_equipos_numero']."</option>"; // colocacion de los datos consultados en el droplist

        }


       }
  
    ?>
