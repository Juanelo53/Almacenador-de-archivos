<?php 
require_once 'conexion.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Styles -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Enviador de archivos</title>
</head>
<body>
    <header class="inicio">
        <div class="titulo"><h1 class="blanco">Envia tus archivos</h1></div>
    </header>
    <main class="main">
        <div class="archivo">
            <form action="index.php" method="POST" enctype="multipart/form-data">
                <label for="archvio" class="blanco">Envia tu archivo ahora:</label><br>
                <input type="file" class="blanco" id="archivo" name="archivo" required>
                <br>
                <input type="submit" class="btn btn-success" value="Enviar">
                <br>
                <?php 
            if (isset($_FILES['archivo'])) {
                $archivo = $_FILES['archivo'];
                
                $nombre = $archivo['name'];
                $ruta = $archivo['tmp_name'];
                $destino = "files/".$nombre.""; 

                $c1 = "SELECT * FROM `files` WHERE nombre='$nombre'";
                $consultarPro = mysqli_query($conn, $c1);
                $row = mysqli_num_rows($consultarPro);
                   
                if($row > 0){

                 echo "<p class='error'>El archivo ya existe en la DB </p>";
                }else{
                    $enviar_Archivo = "INSERT INTO `files`(`nombre`) VALUES ('$nombre')";
                    $enviar = mysqli_query($conn, $enviar_Archivo);
                }

                if (file_exists("files/$nombre")) { // Si el archivo ya existe o si en la database existe no lo dejara subir
                    echo "<p class='error'>El archivo ya existe en el Servidor</p>";

                 }elseif(move_uploaded_file($ruta, $destino)){ // mueve el archivo a su ruta y lo sube a la base de datos

                    echo"<p class='exito'>Enviado con exito</p>";
                 }
                }
            ?>
            </form>
            
            
        </div>

        <div class="inidice">
            <h2 class="blanco">Descarga los archivos enviados</h2>

            <div class="blanco">
                <?php 
                $buscar = "SELECT * FROM `files` WHERE 1";
                $consultar1 = mysqli_query($conn, $buscar);
                
                while ($mostrar = mysqli_fetch_array($consultar1)) { // Consulta la base de datos
                    $rutaDescarga = "files/".$mostrar['nombre'];
                    $nombreDescarga = $mostrar['nombre']; 
             
                    if(isset($_POST['delete'])){
                        $eliminar = $_POST['delete'];


                    }


                ?>
              <li>Archvio: <?php echo $mostrar['nombre']?></li> 
              <a href="<?= $rutaDescarga ?>" download="<?= $nombreDescarga ?>" class="btn btn-success btn-sm">Descargar</a> 
              <a href="eliminar.php?archivo=<?php echo $mostrar['nombre'] ?>" class="btn btn-danger btn-sm" id="delete" name="delete">Eliminar</a>
              <?php     }
               
            ?>
            </div>
        </div>
    </main>

    <footer> 
        <h4 class="blanco">Desarrollado por Juanelo53❤ </h4>
    </footer>

</body>
</html>