<?php

require_once('../conexion/conexion.php');


$mysql = new connection();
$conexion = $mysql->get_connection();

$referenciav = $_POST['referenciav'];
$fechaensamble = $_POST['fechaensamble'];
$modelo = $_POST['modelo'];

$fechaen = date("y/m/d", strtotime($fechaensamble));


$statement = $conexion->prepare("CALL SP_modificarVehiculo('$referenciav','$fechaen',$modelo)");
$statement->execute();


    if($statement){
        echo "<script> alert ('Vehiculo Modificado con exito');
        location.href = '../core/vehiculos.php'; </script> ";
    }else{
        echo "<script> alert ('Error al guardar Cliente');
        location.href = '../core/vehiculos.php'; </script> ";
    }