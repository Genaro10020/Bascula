<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");
include("conexion.php");

$id=$arreglo['id'];
$nombre=$arreglo['nombre'];
$usuario=$arreglo['usuario'];
$password=$arreglo['password'];
$tipo=$arreglo['tipo'];
$respuesta="";

$consulta = "UPDATE usuarios SET  nombre='$nombre',usuario='$usuario',contrasena='$password',tipo='$tipo' WHERE id='$id'";
$query = mysqli_query($con,$consulta);
if($query){
    $respuesta = $query;
}

echo json_encode( $respuesta);
?>  