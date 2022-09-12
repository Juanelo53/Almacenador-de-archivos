<?php 

require "conexion.php";


if (!isset($_GET['archivo'])){
    header('Location: index.php');
}else{
    $nombre = $_GET['archivo'];
    
    $sql = "DELETE FROM `files` WHERE nombre='$nombre'";
    $consultar = mysqli_query($conn, $sql);

    unlink("files/".$nombre);

    header("Location: index.php");
}