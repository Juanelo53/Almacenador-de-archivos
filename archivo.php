<?php 

if (isset($_FILES['archivo'])) {
    $archivo = $_FILES['archivo'];
  
    $nombre = $archivo['name'];
    $ruta = $archivo['tmp_name'];
    $destino = "files/".$nombre."";

    if (file_exists("files/$nombre")) {
        echo "<p class='error'>El archivo ya existe</p>";
     }elseif(move_uploaded_file($ruta, $destino)){
        echo"Enviado con exito";
     }
}


 

 

  