<?php

/*
 * Controlador para mostrar la informacion de un servicio que se busca
 */
 
 
  	$idServicio = $_POST['idServicio'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los servicios
	require_once("../../../Models/servicios_model.php");
	
	$objetoServicios = new servicios(); 
	
	$listadoServicios = $objetoServicios->listarUnServicio($idServicio);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   			= array();
				$lang_diagnosticos			= array();
				$lang_servicios				= array();
				$lang_general[12]   		= "Estado";
				$lang_diagnosticos[15]		= "Código";
				$lang_diagnosticos[7]		= "Precio";
				$lang_servicios[9]			= "Activar servicio";
				$lang_servicios[10]			= "Desactivar servicio";
				$lang_servicios[11]			= "Servicio";
				$lang_servicios[12]			= "Código";
				$lang_servicios[6]			= "Descripción";				
    		break;
    		
    	case 'En':
				$lang_general   			= array();			
				$lang_diagnosticos			= array();
				$lang_servicios				= array();
				$lang_general[12]   		= "State";
				$lang_diagnosticos[15]		= "Code";
				$lang_diagnosticos[7]		= "Price";
				$lang_servicios[9]			= "Enable service";
				$lang_servicios[10]			= "Disable service";
				$lang_servicios[11]			= "Service";
				$lang_servicios[12]			= "Code";
				$lang_servicios[6]			= "Description";	
    		break;
        
    }//fin swtich
 

?>


<table class="bordered highlight centered responsive-table">
									
			<thead>
				<tr>
					<th><?php echo $lang_servicios[11]//Servicio?></th>
					<th><?php echo $lang_servicios[12]//Código?></th>
					<th><?php echo $lang_servicios[6]//Descripción?></th>
					<th><?php echo $lang_diagnosticos[7]//Precio?></th>
					<th><?php echo $lang_general[12]//Estado?></th>
				</tr>
			</thead>
			
			<tbody>
				
				<?php									
					foreach ($listadoServicios as $listadoServicios1) {
						
						if($listadoServicios1['estado'] == 'A'){																																																			//Desactivar servicio
							$btn = '<span id="spanB_'.$listadoServicios1['idServicio'].'"> <a id="'.$listadoServicios1['idServicio'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarServicio(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_servicios[10].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}else{																																																											//Activar servicio
							$btn = '<span id="spanB_'.$listadoServicios1['idServicio'].'"> <a id="'.$listadoServicios1['idServicio'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarServicio(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_servicios[9].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}
						
						$parametros = "'".$listadoServicios1['idServicio']."','".$listadoServicios1['nombre']."','".$listadoServicios1['codigo']."','".$listadoServicios1['descripcion']."','".$listadoServicios1['precio']."'";
				?>
				
					<tr style="cursor: pointer;">
						<td onclick="editarServicio(<?php echo $parametros?>)" ><?php echo $listadoServicios1['nombre']?></td>
						<td onclick="editarServicio(<?php echo $parametros?>)"><?php echo $listadoServicios1['codigo']?></td>
						<td onclick="editarServicio(<?php echo $parametros?>)"><?php echo $listadoServicios1['descripcion']?></td>
						<td onclick="editarServicio(<?php echo $parametros?>)"><?php echo $listadoServicios1['precio']?></td>
						<td>
							<?php echo $btn ?>											
						</td>
					</tr>											
						
				<?php		
					}//fin foreach								
				?>
				
				
				
			</tbody>
			
			
		</table>