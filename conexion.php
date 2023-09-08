<?php 
$hostname = 'localhost';
$database = 'bascula';
$user = 'root';
$password = '';

$con = new mysqli($hostname, $user, $password, $database);
if($con->connect_errno){
    echo "No se logro conectar con la BD";
}
?>