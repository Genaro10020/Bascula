<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");
include("conexion.php");

$id=$arreglo['id'];
$respuesta ='';
$consulta = "SELECT * FROM registros WHERE id='$id' AND neto=0";
$query = mysqli_query($con,$consulta);
if($fila = mysqli_fetch_assoc($query)){
    $respuesta = $fila;
}

echo json_encode( $respuesta);
?>  