<?php

require_once('../conexion/conexion.php');

date_default_timezone_set('America/Bogota');
$DateAndTime = date('y-m-d h:i:s');

$mysql = new connection();
$conexion = $mysql->get_connection();

$botonCliente = "";
$botonAlmacen = "";
$botonMarca = "";
$botonPlanta = "";
$botonVehiculo = "";
$botonReserva = "";

if(isset($_POST['registrarCliente'])){
    $botonCliente=$_POST['registrarCliente'];
}
if(isset($_POST['registrarAlmacen'])){
    $botonAlmacen=$_POST['registrarAlmacen'];
}
if(isset($_POST['registrarPlanta'])){
    $botonPlanta=$_POST['registrarPlanta'];
}
if(isset($_POST['registrarMarca'])){
    $botonMarca=$_POST['registrarMarca'];
}
if(isset($_POST['registrarVehiculo'])){
      $botonVehiculo=$_POST['registrarVehiculo'];
}
if(isset($_POST['registrarReserva'])){
    $botonReserva=$_POST['registrarReserva'];
}

if($botonCliente){

    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];

    $cedula = intval($cedula);

    try {
        $statement = $conexion->prepare("CALL SP_insertarCliente($cedula,'$nombres','$apellidos')");
        $statement->execute();

        if($statement){
            echo "<script> alert ('Guardao con exito');
            location.href = '../core/clientes.php'; </script> ";
        }
      } catch (Exception $e) {
        echo "<script> alert ('Error al guardar Cliente');
        location.href = '../core/clientes.php'; </script> ".$e;
      }
    

}elseif($botonAlmacen){

    $descripAlmacen = $_POST['descripAlmacen'];
    try{
        $statement = $conexion->prepare("CALL SP_insertarAlmacen('$descripAlmacen')");
        $statement->execute();

        if($statement){
            echo "<script> alert ('Guardado con exito');
            location.href = '../core/almacen.php'; </script> ";
        }  
    } catch (Exception $e) {
        echo "<script> alert ('Error al guardar Almacen');
        location.href = '../core/almacen.php'; </script> ";
  }

}elseif($botonPlanta){

    $descPlanta = $_POST['descPlanta'];
    try{
        $statement = $conexion->prepare("CALL SP_insertarplanta('$descPlanta')");
        $statement->execute();

        if($statement){
            echo "<script> alert ('Guardado con exito');
            location.href = '../core/planta.php'; </script> ";
        }
    } catch (Exception $e) {
        echo "<script> alert ('Error al guardar planta');
        location.href = '../core/planta.php'; </script> ";
    }
}elseif($botonMarca){

    $descMarca = $_POST['descMarca'];
    try{
        $statement = $conexion->prepare("CALL SP_insertarMarca('$descMarca')");
        $statement->execute();

        if($statement){
            echo "<script> alert ('Guardado con exito');
            location.href = '../core/marca.php'; </script> ";
        }
    } catch (Exception $e) {
        echo "<script> alert ('Error al guardar la Marca ');
        location.href = '../core/marca.php'; </script> ";
    }

}elseif($botonVehiculo){

    $referencia = $_POST['referencia'];
    $nomvehiculo = $_POST['nomvehiculo'];
    $idplanta = $_POST['idplanta'];
    $idmarca = $_POST['idmarca'];
    $fechaensamble = $_POST['fechaensamble'];
    $modelo = $_POST['modelo'];
    $idalmacen = $_POST['idalmacen'];
    try{
        $statement = $conexion->prepare("CALL SP_insertarVehiculo('$referencia','$nomvehiculo',$idplanta,$idmarca,'$fechaensamble',$modelo,$idalmacen,'$DateAndTime')");
        $statement->execute();

        if($statement){
            echo "<script> alert ('Guardado con exito');
            location.href = '../core/vehiculos.php'; </script> ";
        }
    } catch (Exception $e) {
        echo "<script> alert ('Error al guardar El Vehiculo ');
        location.href = '../core/vehiculos.php'; </script> ";
    }

}elseif($botonReserva){

    $referencia = $_POST['referencia'];
    $cedula = $_POST['cedula'];
    //$fechareserva = $_POST['fechareserva'];
    //$fechafinregistro = $_POST['fechafinregistro'];

    $fechareserva = date('y-m-d h:i:s');
    //sumo 1 día
    $fechafinregistro = date("y-m-d h:i:s",strtotime($DateAndTime."+ 1 days"));

    try{

        $statement = $conexion->prepare("CALL SP_reservasActivasCliente($cedula)");
        $statement->execute();
        foreach($statement as $row){
            $cantidad = $row['CantidadReservas'];
        }
        

        if($cantidad > 2){
            echo "<script> alert ('Este Cliente no puede Reservar más vehiculos, Motivo :tiene 3 reservas activas');
            location.href = '../core/reserva.php'; </script> ";
        }else{
                $statement = $conexion->prepare("CALL SP_insertarreserva('$referencia',$cedula,'$fechareserva','$fechafinregistro')");
                $statement->execute();

                if($statement){
                    echo "<script> alert ('Guardao con exito');
                    location.href = '../core/reserva.php'; </script> ";
                }
        }
    } catch (Exception $e) {
        echo "<script> alert ('Error al guardar la Reserva ');
        location.href = '../core/reserva.php'; </script> ";
    }
}
