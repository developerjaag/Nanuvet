<?php

/*
 * Archivo para realizar la busqueda de citas
 */

   $idPropietario 	= $_POST['idPropietario'];
   $fechaInicial	= $_POST['fechaInicial'];
   $fechaFinal		= $_POST['fechaFinal'];  
 
   require_once("../../Config/config.php");
   
   require_once("../../Models/agenda_model.php");
   
   $objetoAgenda	= new agenda();
   
   $datosCitas = $objetoAgenda->buscarCitas($idPropietario, $fechaInicial, $fechaFinal);
   
?>   
  		
  	<table class="bordered highlight">	
  		
  		<thead>
  			<tr>
  				<th>Paciente</th>
  				<th>Fecha</th>
  				<th>Hora</th>
  				<th>Duración</th>
  				<th>Estado</th>
  				<th>Tipo cita</th>
  				<th></th>
  			</tr>
  		</thead>
  		
  		<tbody>
  		 
<?php   
   foreach ($datosCitas as $datosCitas1) {
?>       
	  
	  <tr>
	  	<td>
	  		<a href="http://www.nanuvet.com/historiaClinica/<?php echo $datosCitas1['idMascota']?>/consultas/"><?php echo $datosCitas1['nombrePaciente']?></a>
	  	</td>
	  	<td><?php echo $datosCitas1['fecha']?></td>
	  	<td><?php echo $datosCitas1['horaInicio']?></td>
	  	<td><?php echo $datosCitas1['duracionHoras'].":".$datosCitas1['duracionMinutos']?></td>
	  	<td><?php echo $datosCitas1['estado']?></td>
	  	<td><?php echo $datosCitas1['nombreTipoCita']?></td>
	  	<td>
	  		<a class="waves-effect waves-light btn" onclick="editarCitaUsuario('<?php echo $datosCitas1['idAgendaCita']?>')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
	  	</td>
	  </tr>
	   
	   
<?php	   
   }//fin foreaach
?>

	</tbody>

	</table>