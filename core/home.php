<?php
require_once('conexion/conexion.php');

date_default_timezone_set('America/Bogota');
$DateAndTime = date('y-m-d h:i:s');

$mysql = new connection();
$conexion = $mysql->get_connection();
?>


<!--tomar ( columnas) de la pantalla para el calendario-->
<div class="container">
    <div class="col-md-8 offset-md-2">
        <div id='calendar'></div>
    </div>
</div>

<!--Script de fullCalendar-->
<script>

    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');  
    var calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',
        //cambiar el idioma del calendario
        locale:"es",

        dateClick: function(info) {
          $("#fecha").val(date.format());
            //alert('Date: ' + info.dateStr);
            //alert('Resource ID: ' + info.resource.id);
            //Aca debe aparecer el modal con la tabla de los carros libres
            $('#modalVehiculosLibresDeReserva').modal();
        },

        events: 'http://localhost:8888/ReservaCarros/logica/eventscalendar.php'
    });
    calendar.render();
    });

</script>


<!-- Modal -->
<div class="modal fade" id="modalVehiculosLibresDeReserva" tabindex="-1" role="dialog" aria-labelledby="VehiculosLibresDeReserva" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="VehiculosDisponiblesTittle">Vehiculos Disponibles</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <form action="" method="post">
     <table width="330" height="135" border="0" class="text">
         <tr>
             <td><label>User Name</label></td>
             <td><input type="text" name="fecha" id="fecha"></td> 
         </tr>

         <tr>
             <td align="center">
                <button type="submit" id="boton" name="add"  <?php if ($cumple) { echo 'disabled="disabled"';}?>>Verificar</button>
             </td>
         </tr>
     </table>
  </form>
      

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
