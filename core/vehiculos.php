<?php include("header.php");

require_once('../conexion/conexion.php');

date_default_timezone_set('America/Bogota');
$DateAndTime = date('y-m-d h:i:s');

$mysql = new connection();
$conexion = $mysql->get_connection();

?>

<form class="col-md-8 offset-md-2" method="POST" action="../logica/registrar.php">
  <br>
      <h1>Registro vehiculo concesionario</h1>
  <br>
  <div class="form-group">
    <input class="form-control form-control-lg" type="text" name="referencia" placeholder="Referencia">
  </div>
  <div class="form-group">
    <input class="form-control form-control-lg" type="text" name="nomvehiculo" placeholder="Nombre Vehiculo">
  </div>
  <div class="form-group">
     <label>Seleccione Planta de Producción</label>
    <select class="form-control" name="idplanta">
      <?php
        $statement = $conexion->prepare("CALL SP_listartablaPlanta()");
        $statement->execute();
        foreach($statement as $row){
      ?>
      <option value="<?php echo $row['idplanta'] ?>"><?php echo $row['descplanta'] ?></option>
      <?php
       }
       ?>
    </select>
  </div>
  <div class="form-group">
     <label>Seleccione la marca del vehiculo</label>
     <select class="form-control" name="idmarca">
       <?php
         $statement = $conexion->prepare("CALL SP_listartablamarca()");
         $statement->execute();
         foreach($statement as $row){
       ?>
       <option value="<?php echo $row['idmarca'] ?>"><?php echo $row['descmarca'] ?></option>
       <?php
        }
        ?>
     </select>
  </div>
  <div class="form-group">
    <label >Seleccione fecha de ensamble</label>
    <input class="form-control form-control-lg" type="date" name="fechaensamble" placeholder="Descripción Almacen">
  </div>
  <div class="form-group">
    <input class="form-control form-control-lg" type="text" name="modelo" placeholder="Modelo Vehiculo" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)">
  </div>
  <div class="form-group">
     <label>Seleccione ciudad de almacenamiento</label>
     <select class="form-control" name="idalmacen">
       <?php
         $statement = $conexion->prepare("CALL SP_listartablaalmacen()");
         $statement->execute();
         foreach($statement as $row){
       ?>
       <option value="<?php echo $row['idalmacen'] ?>"><?php echo $row['descalmacen'] ?></option>
       <?php
        }
        ?>
     </select>
  </div>
  <div class="form-group">
    <label >Fecha de Registro</label>
    <input class="form-control form-control-lg" type="text"  name="fecharegistro" disabled value="<?php echo $DateAndTime;?>">
  </div>
  <br>
  <input type="submit" class="btn btn-primary" name="registrarVehiculo" value="Registrar">

  <br><br><br><br>
  <table class="table col-md-12">
    <h1 class="table col-md-12 offset-md-2" id="tablah1">Seleccione Vehiculo para modificar</h1>
    <br>
  <thead class="thead-dark">
    <tr>
      <th scope="col">Referencia</th>
      <th scope="col">Vehiculo</th>
      <th scope="col">Planta</th>
      <th scope="col">Marca</th>
      <th scope="col">Fecha Ensamble</th>
      <th scope="col">Modelo</th>
      <th scope="col">Ciudad almacenamiento</th>
      <th scope="col">Fecha Registro</th>
      <th scope="col">Accion</th>
    </tr>
  </thead>
  <tbody>
  <?php
      $statement = $conexion->prepare("CALL SP_listarVehiculos()");
      $statement->execute();
      foreach($statement as $row){
    ?>
    <tr>
    <th scope="row"><?php echo $row['referencia'] ?></th>
    <th scope="row"><?php echo $row['nombrevehiculo'] ?></th>
    <th scope="row"><?php echo $row['descplanta'] ?></th>
    <th scope="row"><?php echo $row['descmarca'] ?></th>
    <th scope="row"><?php echo $row['fechaensamble'] ?></th>
    <th scope="row"><?php echo $row['modelo'] ?></th>
    <th scope="row"><?php echo $row['descalmacen'] ?></th>
    <th scope="row"><?php echo $row['fecharegistro'] ?></th>
    <th scope="row"><a href="actualizarvehiculo.php?id=<?php echo $row['referencia'] ?>" class="btn btn-info">Editar</a></th>
    </tr>

  </tbody>
    <?php
     }
  ?>
</table>

</form>

<?php include("footer.php"); ?>
