<?php

/*
 * Controlador para mostrar la informacion de un tipo de cita que se busca
 */
	if(!isset($_SESSION)){
		    session_start();
		} 
 
  	$idTipoCita = $_POST['idTipoCita'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los tipos de cita
	require_once("../../../Models/tiposCita_model.php");
	
	$objetoTiposCita = new tiposCita(); 
	
	$listadoTiposCita = $objetoTiposCita->listarUnTipoCita($idTipoCita);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   = 	array();
				$lang_agenda	= array();
				$lang_citas			= array();
				$lang_general[12]   = "Estado";
				$lang_agenda[0]	= 'Tipo de cita';
				$lang_citas[5]	= "Activar tipo de cita";
				$lang_citas[6]	= "Desactivar tipo de cita";
    		break;
    		
    	case 'En':
				$lang_general   = 	array();
				$lang_agenda	= array();
				$lang_citas			= array();
				$lang_general[12]   = "State";	
				$lang_agenda[0]	= 'Types of Appointment';
				$lang_citas[5]	= "Enable appointment type";
				$lang_citas[6]	= "Turn off appointment type";
				
    		break;
        
    }//fin swtich
 

?>


<table class="bordered highlight centered responsive-table">
									
	<thead>
		<tr>
			<th><?php echo $lang_agenda[0]//Tipos de cita?></th>											
			<th><?php echo $lang_general[12]//Estado?></th>
		</tr>
	</thead>
	
	<tbody>
										
		<?php									
			foreach ($listadoTiposCita as $listadoTiposCita1) {
				
				if($listadoTiposCita1['estado'] == 'A'){																																																			//Desactivar tipo de cita
					$btn = '<span id="spanTC_'.$listadoTiposCita1['idTipoCita'].'"> <a id="'.$listadoTiposCita1['idTipoCita'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarTipoCita(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_citas[6].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
				}else{																																																											//Activar tipo de cita
					$btn = '<span id="spanTC_'.$listadoTiposCita1['idTipoCita'].'"> <a id="'.$listadoTiposCita1['idTipoCita'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarTipoCita(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_citas[5].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
				}
				
				$parametros = "'".$listadoTiposCita1['idTipoCita']."','".$listadoTiposCita1['nombre']."'";
		?>
		
			<tr style="cursor: pointer;">
				<td  <?php if(in_array("101", $_SESSION['permisos_usuario'] )){ ?> onclick="editarTipoCita(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoTiposCita1['nombre']?></td>												
				<td>
					<?php echo $btn ?>											
				</td>
			</tr>											
				
		<?php		
			}//fin foreach								
		?>							
		
		
		
		
	</tbody>
	
	
</table>
