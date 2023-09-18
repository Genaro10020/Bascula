<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");
include("conexion.php");

$respuesta =[];
$consulta = "SELECT * FROM registros WHERE  neto!=0 ORDER BY id DESC";
$query = mysqli_query($con,$consulta);
while ($row = mysqli_fetch_array($query)){
    $fecha_normal=$row['fecha_pesaje'];
    $fecha_dma= date("d-m-Y H:i:s", strtotime($fecha_normal));
    $row['fecha_dma']=$fecha_dma;
    $respuesta [] = $row;
}
echo json_encode( $respuesta);

?>  