<?php

$conn = new mysqli ( "127.0.0.1:3306", "base1", "base", "stm"); //crea la conexion con la base de datos
 if (mysqli_connect_errno ()) { //verifica si ha habido un error
   $error = mysqli_connect_error (); //guarda el mensaje de error para mostrarlo en la pagina
  } else {
      
      //guarda un una variable local el catalogo seleccionado
      $consulta= "SELECT evento_Id,Evento_Cantidad_Equipos,Evento_Nombre,Evento_sede,evento_Genero from evento;" ;
      
      $resultad= mysqli_query($conn,$consulta);
      while ($fila = mysqli_fetch_array($resultad)) {
            echo '<tr><td>'.$fila['Evento_Cantidad_Equipos'].'</td>
            	  <td></td>
            	  <td><a href="estadisticatorneo.html?evento='.$fila['evento_Id'].'">'.$fila['Evento_Nombre'].'</a></td>
            	  <td></td>
            	  <td>'.$fila['Evento_sede'].'</td><td></td><td>'.$fila['evento_Genero'].'</td></tr>';

        }


       }
  
    ?>