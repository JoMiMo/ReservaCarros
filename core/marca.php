<?php
  include("header.php");

  require_once('../conexion/conexion.php');

  $mysql = new connection();
  $conexion = $mysql->get_connection();

?>

<form class="col-md-8 offset-md-2" method="POST" action="../logica/registrar.php">
  <br>
      <h1>Registro de Marcas</h1>
  <br>
  <div class="form-group">
    <input class="form-control form-control-lg" type="text" placeholder="Descripción Marca" name="descMarca" onkeypress="return ((event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 65 && event.charCode <= 90) || event.charCode == 32)">
  </div>
  <input type="submit" class="btn btn-primary" name="registrarMarca" value="Registrar">

  <br><br><br><br>

  <table class="table col-md-6 offset-md-2">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Id Marca</th>
      <th scope="col">Descripción</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $statement = $conexion->prepare("CALL SP_listartablamarca()");
      $statement->execute();
      foreach($statement as $row){
    ?>
    <tr>
    <th scope="row"><?php echo $row['idmarca'] ?></th>
    <th scope="row"><?php echo $row['descmarca'] ?></th>
    </tr>

  </tbody>
    <?php
     }
  ?>
</table>

</form>
<footer>
<?php include("footer.php"); ?>
