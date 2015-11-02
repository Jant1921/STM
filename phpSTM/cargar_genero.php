<?php

$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      
      //guarda un una variable local el catalogo seleccionado
      $consulta= "Select genero_Id , Genero_Nombre from genero" ;
      
      $resultad= mysqli_query($conn,$consulta);

      while ($fila = mysqli_fetch_array($resultad)) {
            echo "<option value=".$fila['genero_Id'].">".$fila['Genero_Nombre']."</option>"; // colocacion de los datos consultados en el droplist

        }


       }
  
    ?>
