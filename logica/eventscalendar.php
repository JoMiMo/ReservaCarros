<?php

header('content-type: application/json');

require_once('../conexion/conexion.php');

date_default_timezone_set('America/Bogota');
$DateAndTime = date('y-m-d h:i:s');
$date = date('y-m-d');

$fecha_actual = date('y-m-d h:i:s');
//sumo 1 día
$fecha_fin = date("y-m-d h:i:s",strtotime($DateAndTime."+ 1 days")); 


$mysql = new connection();
$conexion = $mysql->get_connection();

$statement = $conexion->prepare("CALL SP_vehiculosReservadosPorDia()");
$statement->execute();

$resul = $statement->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($resul);

?>