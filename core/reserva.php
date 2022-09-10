<?php include("header.php"); 

require_once('../conexion/conexion.php');

date_default_timezone_set('America/Bogota');
$DateAndTime = date('y-m-d h:i:s');
$date = date('y-m-d');

$fecha_actual = date('y-m-d h:i:s');
//sumo 1 día
$fecha_fin = date("y-m-d h:i:s",strtotime($DateAndTime."+ 1 days")); 


$mysql = new connection();
$conexion = $mysql->get_connection();

?>

<form class="col-md-8 offset-md-2" method="POST" action="../logica/registrar.php">
  <br>
      <h1>Registro Reserva </h1>
  <br>
  <div class="form-group">
  <label>Seleccione referencia del Vehiculo</label>
    <select class="form-control" name="referencia">
      <?php
        $statement = $conexion->prepare("CALL SP_listarVehiculosNoReservados()");
        $statement->execute();
        foreach($statement as $row){
      ?>
      <option value="<?php echo $row['referencia'] ?>"><?php echo $row['referencia'] ?></option>
      <?php
       }
       ?>
    </select>
  </div>
  <div class="form-group">
  <label>Seleccione Cedula del Cliente</label>
    <select class="form-control" name="cedula">
      <?php
        $statement = $conexion->prepare("CALL SP_listartblcliente()");
        $statement->execute();
        foreach($statement as $row){
      ?>
      <option value="<?php echo $row['cedula'] ?>"><?php echo $row['cedula'] ?></option>
      <?php
       }
       ?>
    </select>
  </div>
  <div class="form-group">
    <label >Fecha Reserva</label>
    <input class="form-control form-control-lg" type="text" name="fechareserva"  value="<?php echo $fecha_actual;?>" disabled >
  </div>
  <div class="form-group">
    <label >Fecha de Finalización Reserva</label>
    <input class="form-control form-control-lg" type="text"  name="fechafinregistro" value="<?php echo $fecha_fin;?>" disabled>
  </div>
  <br>
  <input type="submit" class="btn btn-primary" name="registrarReserva" value="Registrar">
</form>

<br><br><br>
<table class="table col-md-6 offset-md-2">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Id Reserva</th>
      <th scope="col">Referencia Vehiculo</th>
      <th scope="col">Nombre Vehiculo</th>
      <th scope="col">Cedula</th>
      <th scope="col">Nombre Completo</th>
      <th scope="col">fecha Reserva</th>
      <th scope="col">fecha Fin Reserva</th>
      <th scope="col">Reservado</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $statement = $conexion->prepare("CALL SP_listarreserva()");
      $statement->execute();
      foreach($statement as $row){
    ?>
    <tr>
    <th scope="row"><?php echo $row['idreserva'] ?></th>
    <th scope="row"><?php echo $row['referencia'] ?></th>
    <th scope="row"><?php echo $row['nombrevehiculo'] ?></th>
    <th scope="row"><?php echo $row['cedula'] ?></th>
    <th scope="row"><?php echo $row['nombres'] ?></th>
    <th scope="row"><?php echo $row['fechareserva'] ?></th>
    <th scope="row"><?php echo $row['fechafin'] ?></th>
    <th scope="row"><?php echo $row['reservado'] ?></th>
    </tr>

  </tbody>
    <?php
     }
  ?>
</table>


<?php include("footer.php"); ?>
