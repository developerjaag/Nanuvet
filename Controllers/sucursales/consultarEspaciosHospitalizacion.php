<?php

/*
 * Archivo para consultar los espacios de hospitalizacion que tenga una sucursal
 */

 	if(!isset($_SESSION)){
		    session_start();
		}
	
 	$idSucursal	= $_POST['idSucursal'];
 
 	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de las ciudades
	require_once("../../Models/sucursales_model.php");
	
	$objetoSucursales = new sucursales();
	
	
	$espaciosHospitalizacion = 	$objetoSucursales->consultarEspaciosHospitalizacionSucursal($idSucursal);
 
?>

	<table>
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Capacidad</th>
				<th>Ocupado</th>
				<th>Observación</th>
				<th>Estado</th>
			</tr>
		</thead>
		
		<tbody>
			


<?php

	foreach ($espaciosHospitalizacion as $espaciosHospitalizacion1) {
		
		if($espaciosHospitalizacion1['estado']  == 'A'){
			
			$btn	= '<span id="spanEH_'.$espaciosHospitalizacion1['idEspacioHospitalizacion'].'"> <a id="'.$espaciosHospitalizacion1['idEspacioHospitalizacion'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarEspacioH(this.id)"  data-position="bottom" data-delay="50" data-tooltip="Desactivar" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
			
		}else{
			
			$btn	= '<span id="spanEH_'.$espaciosHospitalizacion1['idEspacioHospitalizacion'].'"> <a id="'.$espaciosHospitalizacion1['idEspacioHospitalizacion'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarEspacioH(this.id)" data-position="bottom" data-delay="50" data-tooltip="Activar"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';			
		}
		
		$parametros = "'".$espaciosHospitalizacion1['idEspacioHospitalizacion']."','".$espaciosHospitalizacion1['nombre']."','".$espaciosHospitalizacion1['capacidad']."','".$espaciosHospitalizacion1['espaciosOcupados']."','".$espaciosHospitalizacion1['observacion']."'";
		
?>	
	
			<tr style="cursor: pointer;">
				<td <?php if(in_array("107", $_SESSION['permisos_usuario'] )){ ?> onclick="EditarEspacioH(<?php echo $parametros ?>)" <?php } ?>><?php echo $espaciosHospitalizacion1['nombre'] ?></td>
				<td <?php if(in_array("107", $_SESSION['permisos_usuario'] )){ ?> onclick="EditarEspacioH(<?php echo $parametros ?>)" <?php } ?>><?php echo $espaciosHospitalizacion1['capacidad'] ?></td>
				<td <?php if(in_array("107", $_SESSION['permisos_usuario'] )){ ?> onclick="EditarEspacioH(<?php echo $parametros ?>)" <?php } ?>><?php echo $espaciosHospitalizacion1['espaciosOcupados'] ?></td>
				<td <?php if(in_array("107", $_SESSION['permisos_usuario'] )){ ?> onclick="EditarEspacioH(<?php echo $parametros ?>)" <?php } ?>><?php echo $espaciosHospitalizacion1['observacion'] ?></td>
				<td><?php echo $btn ?></td>
			</tr>
	
	
		
<?php		
	}//fin foreach
?>

		</tbody>
		
	</table>