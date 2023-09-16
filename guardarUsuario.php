<?php
session_start();
$usuario=$_SESSION['usuario'];
$arreglo = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");
include("conexion.php");

$respuesta="";
$nombre=$arreglo['nombre'];
$usuario=$arreglo['usuario'];
$contrasena=$arreglo['contrasena'];
$tipo=$arreglo['tipo'];


    $insertar = "INSERT INTO  usuarios (nombre,usuario,contrasena,tipo) VALUES ('$nombre','$usuario','$contrasena','$tipo')";
    $query = mysqli_query($con,$insertar);
    if($query){
            $respuesta=$query;
        }else{
            $respuesta= "Error en la consulta:".mysqli_error($con);
        }



echo json_encode( $respuesta);

?>  