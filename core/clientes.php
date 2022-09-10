<?php
  include("header.php");

  require_once('../conexion/conexion.php');

  $mysql = new connection();
  $conexion = $mysql->get_connection();

?>


<form class="col-md-8 offset-md-2" method="POST" action="../logica/registrar.php" >
  <br>
      <h1>Registro de Clientes</h1>
  <br>
  <div class="form-group">
    <input class="form-control form-control-lg" type="text" placeholder="Cedula" name="cedula" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)">
  </div>
  <div class="form-group">
    <input class="form-control form-control-lg" type="text" placeholder="Nombres" name="nombres" onkeypress="return ((event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 65 && event.charCode <= 90) || event.charCode == 32)">
  </div>
  <div class="form-group">
    <input class="form-control form-control-lg" type="text" placeholder="Apellidos" name="apellidos" onkeypress="return ((event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 65 && event.charCode <= 90) || event.charCode == 32)">
  </div>
  <input type="submit" class="btn btn-primary" name="registrarCliente" value="Registrar">

  <br><br><br><br>

        <table class="table col-md-6 offset-md-2">
        <thead class="thead-dark">
        <tr>
        <th scope="col">Cedula</th>
        <th scope="col">Nombres</th>
        <th scope="col">Apellidos</th>
      </tr>
      </thead>
      <tbody>

    <?php
        $statement = $conexion->prepare("CALL SP_listartblcliente()");
        $statement->execute();
        foreach($statement as $row){
    ?>

        <tr>
        <th scope="row"><?php echo $row['cedula'] ?></th>
        <th scope="row"><?php echo $row['nombres'] ?></th>
        <th scope="row"><?php echo $row['apellidos'] ?></th>
        </tr>

      </tbody>


    <?php
     }
    ?>

</table>

</form>


<?php include("footer.php"); ?>
