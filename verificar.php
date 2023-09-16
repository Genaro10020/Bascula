<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");
include("conexion.php");

$usuario=$arreglo['username'];
$contrasena=$arreglo['password'];
$consulta = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contrasena='$contrasena'";
$query = mysqli_query($con,$consulta);
if($query){
    if(mysqli_num_rows($query)>0){
        $respuesta= "Correcto";
        $fila = mysqli_fetch_assoc($query); 
        $nombre = $fila['nombre'];
        $usuario = $fila['usuario'];
        $tipo = $fila['tipo'];
        $_SESSION['nombre'] = $nombre;
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tipo'] = $tipo;
        
    }else{
        $respuesta="Incorrecto";
    }
}else{
    $respuesta= "Error en la consulta:".mysqli_error($con);
}

echo json_encode( $respuesta);

?>  