<?php
session_start();
$arreglo = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");
include("conexion.php");

$productor=$arreglo['nombre'];
$respuesta =[];
$consulta = "SELECT * FROM registros WHERE productor LIKE '%$productor%' AND neto=0";
$query = mysqli_query($con,$consulta);
while ($row = mysqli_fetch_array($query)){
    $respuesta [] = [
        'productor'=>$row['productor'],
        'id'=>$row['id']
    ];
}
echo json_encode( $respuesta);

?>  