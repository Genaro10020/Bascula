<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");
include("conexion.php");

$respuesta =[];
$consulta = "SELECT * FROM registros WHERE  neto=0 ORDER BY id DESC";
$query = mysqli_query($con,$consulta);
while ($row = mysqli_fetch_array($query)){
    $respuesta [] = $row;
}
echo json_encode( $respuesta);

?>  