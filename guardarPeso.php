<?php
session_start();
$usuario=$_SESSION['usuario'];
$arreglo = json_decode(file_get_contents('php://input'), true);
header("Content-Type: application/json");
include("conexion.php");

$respuesta="";
$fecha_actual = date('Y-m-d H:i:s');

$id=$arreglo['id'];
$cajas=$arreglo['cajas'];
$productor=$arreglo['productor'];
$pesobruto=$arreglo['pesobruto'];
$pesotara=$arreglo['pesotara'];
$pesoneto=$arreglo['pesoneto'];
$bandera=$arreglo['bandera'];
$pagar=$arreglo['pagar'];

if($bandera==0){
            $insertar = "INSERT INTO  registros (cajas,peso_bruto,fecha_pesaje,usuario,productor) VALUES ('$cajas','$pesobruto','$fecha_actual','$usuario','$productor')";
            $query = mysqli_query($con,$insertar);
            if($query){
                    $respuesta=$query;
                }else{
                    $respuesta= "Error en la consulta:".mysqli_error($con);
                }
}else if($bandera==1){
        $actualizar = "UPDATE  registros SET tara='$pesotara', fecha_final='$fecha_actual', neto='$pesoneto', pagar='$pagar' WHERE id='$id'";
        $query = mysqli_query($con,$actualizar);
         if($query){
                $respuesta=$query;
            }else{
                $respuesta= "Error en la consulta:".mysqli_error($con);
            }
}



echo json_encode( $respuesta);

?>  