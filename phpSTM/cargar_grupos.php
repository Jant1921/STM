<?php

$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      
      //guarda un una variable local el catalogo seleccionado
      $consulta= "Select grupo_Id ,Grupo_Nombre from grupo" ;
      
      $resultad= mysqli_query($conn,$consulta);
      
      echo '<option value="-1">Seleccione un grupo </option>'; // colocacion de los datos consultados en el droplist

      while ($fila = mysqli_fetch_array($resultad)) {
           if($fila['Grupo_Nombre'] != 'Fase Final'){
            echo "<option value=".$fila['grupo_Id'].">".$fila['Grupo_Nombre']."</option>"; // colocacion de los datos consultados en el droplist
        }
      }
       }
    ?>