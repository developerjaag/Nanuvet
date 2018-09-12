<?php

/*
 * Controlador para mostrar la informacion de un examen que se busca
 */
 
 	if(!isset($_SESSION)){
		    session_start();
		}
	
  	$idMedicamento = $_POST['idMedicamento'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los medicamentos
	require_once("../../../Models/medicamentos_model.php");
	
	$objetoMedicamentos = new medicamentos(); 
	
	$listadoMedicamentos = $objetoMedicamentos->listarUnMedicamento($idMedicamento);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   = 	array();
				$lang_general[12]   = "Estado";
				$lang_medicamentos		= array();
				$lang_medicamentos[4]	= "Código";
				$lang_medicamentos[5]	= "Observación";
				$lang_medicamentos[8]	= "Activar medicamento";
				$lang_medicamentos[9]	= "Desactivar medicamento";
				$lang_medicamentos[10]	= "Medicamento";

    		break;
    		
    	case 'En':
				$lang_general   = 	array();
				$lang_general[12]   = "State";	
				$lang_medicamentos		= array();
				$lang_medicamentos[4]	= "Code";
				$lang_medicamentos[5]	= "Observation";
				$lang_medicamentos[8]	= "Activate medicine";
				$lang_medicamentos[9]	= "off medication";
				$lang_medicamentos[10]	= "Medicine";
    		break;
        
    }//fin swtich
 

?>


		<table class="bordered highlight centered responsive-table">
									
				<thead>
					<tr>
						<th><?php echo $lang_medicamentos[10]//Medicamento?></th>
						<th><?php echo $lang_medicamentos[4]//Código?></th>
						<th><?php echo $lang_medicamentos[5]//Observación?></th>
						<th><?php echo $lang_general[12]//Estado?></th>
					</tr>
				</thead>
				
				<tbody>
					
					<?php									
						foreach ($listadoMedicamentos as $listadoMedicamentos1) {
							
							if($listadoMedicamentos1['estado'] == 'A'){																																																			//Desactivar medicamento
								$btn = '<span id="spanB_'.$listadoMedicamentos1['idMedicamento'].'"> <a id="'.$listadoMedicamentos1['idMedicamento'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarMedicamento(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_medicamentos[9].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
							}else{																																																											//Activar medicamento
								$btn = '<span id="spanB_'.$listadoMedicamentos1['idMedicamento'].'"> <a id="'.$listadoMedicamentos1['idMedicamento'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarMedicamento(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_medicamentos[8].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
							}
							
							$parametros = "'".$listadoMedicamentos1['idMedicamento']."','".$listadoMedicamentos1['nombre']."','".$listadoMedicamentos1['codigo']."','".$listadoMedicamentos1['observacion']."'";
					?>
					
						<tr style="cursor: pointer;">
							<td <?php if(in_array("68", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarMedicamento(<?php echo $parametros?>)" <?php } ?>><?php echo $listadoMedicamentos1['nombre']?></td>
							<td <?php if(in_array("68", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarMedicamento(<?php echo $parametros?>)" <?php } ?>><?php echo $listadoMedicamentos1['codigo']?></td>
							<td <?php if(in_array("68", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarMedicamento(<?php echo $parametros?>)" <?php } ?>><?php echo $listadoMedicamentos1['observacion']?></td>
							<td>
								<?php echo $btn ?>											
							</td>
						</tr>											
							
					<?php		
						}//fin foreach								
					?>
					
					
					
				</tbody>
				
				
			</table>