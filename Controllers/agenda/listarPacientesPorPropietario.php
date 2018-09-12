<?php

/*
 * Archivo para listar los pacientes de un propietario (Select)
 */
 
 	if(!isset($_SESSION)){
		    session_start();
	}
 
 $idPropietario = $_POST['idPropietario'];
 
 require_once ("../../Config/config.php");
 require_once ("../../Models/nuevoPacientePropietario_model.php");
 
 $objetoPacientePropietario = new nuevo();
 
 $listadoPacientes = $objetoPacientePropietario->listarPacientesPorPropietario($idPropietario);

 ?>
 
 <select class="icons" id="cita_pacientes" name="cita_pacientes">
  

 	<option value="" disabled selected>Elige un paciente</option>
<?php
 foreach ($listadoPacientes as $listadoPacientes1) {
 	
		$rutaFoto 				= $listadoPacientes1['urlFoto'];

		if($rutaFoto == ""){
			$rutaFoto =	"http://www.nanuvet.com/Public/img/porDefectoClientes/huella.png";
		}else{
			$rutaFoto =	"http://www.nanuvet.com/Public/uploads/".$_SESSION['BDC_carpeta']."/img_pacientes/".$rutaFoto;
		} 	
	
?>

	<option value="<?php echo $listadoPacientes1['idMascota']?>"  data-icon="<?php echo $rutaFoto?>" class="left circle" ><?php echo $listadoPacientes1['nombre']?></option>
	
<?php	 
 }
?>

</select>
<label>Pacientes del propietario</label>