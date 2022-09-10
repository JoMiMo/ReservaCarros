<?php  include("header.php");

require_once('../conexion/conexion.php');

date_default_timezone_set('America/Bogota');
$DateAndTime = date('y-m-d h:i:s');

$mysql = new connection();
$conexion = $mysql->get_connection();

$referencia=$_GET['id'];

$statement = $conexion->prepare("CALL SP_listarUnVehiculo('$referencia')");
$statement->execute();

foreach($statement as $row){

?>

<form class="col-md-8 offset-md-2" method="POST" action="../logica/actualizar.php">
  <br>
      <h1>Modificar vehiculo concesionario</h1>
  <br>
  <div class="form-group">
    <label>Referencia</label>
    <input class="form-control form-control-lg" type="hidden" name="referenciav" value="<?php echo $row['referencia'] ?>">
    <input class="form-control form-control-lg" type="text" name="referencia" value="<?php echo $row['referencia'] ?>" disabled>
  </div>
  <div class="form-group">
    <label>Nombre Vehiculo</label>
    <input class="form-control form-control-lg" type="text" name="nomvehiculo" value="<?php echo $row['nombrevehiculo'] ?>" disabled>
  </div>
  <div class="form-group">
     <label>Planta de Producción</label>
     <input class="form-control form-control-lg" type="text" name="idplanta" value="<?php echo $row['descplanta'] ?>" disabled>
  </div>
  <div class="form-group">
     <label>marca del vehiculo</label>
     <input class="form-control form-control-lg" type="text" name="idmarca" value="<?php echo $row['descmarca'] ?>" disabled>
  </div>
  <div class="form-group">
    <label>Seleccione fecha de ensamble</label>
    <input class="form-control form-control-lg" type="date" name="fechaensamble" value="<?php echo $row['fechaensamble'] ?>">
  </div>
  <div class="form-group">
    <label>Modelo Vehiculo</label>
    <input class="form-control form-control-lg" type="text" name="modelo" value="<?php echo $row['modelo'] ?>" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)">
  </div>
  <div class="form-group">
     <label>ciudad de almacenamiento</label>
     <input class="form-control form-control-lg" type="text" name="idalmacen" value="<?php echo $row['descalmacen'] ?>" disabled>
  </div>
  <div class="form-group">
    <label>Fecha de Registro</label>
    <input class="form-control form-control-lg" type="text"  name="fecharegistro" disabled value="<?php echo $row['fecharegistro'] ?>">
  </div>
  <br>
  <input type="submit" class="btn btn-primary" name="modificarVehiculo" value="Modificar">
</form>

<?php
}
?>