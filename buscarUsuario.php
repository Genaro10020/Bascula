<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");
include("conexion.php");

$id=$arreglo['id'];
$respuesta ="";
$consulta = "SELECT * FROM usuarios WHERE id='$id'";
$query = mysqli_query($con,$consulta);
while ($row = mysqli_fetch_array($query)){
    $respuesta = $row;
}
echo json_encode( $respuesta);

?>  