<?php

/*
 * Controlador para mostrar la informacion de un diagnóstico que se busca
 */
 
 
  	$idDiagnostico = $_POST['idDiagnostico'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los diagnosticos
	require_once("../../../Models/diagnosticosCirugias_model.php");
	
	$objetoDiagnosticosCirugias = new diagnosticosCirugias(); 
	
	$listadoDiagnosticos = $objetoDiagnosticosCirugias->listarUnDiagnostico($idDiagnostico);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   = 	array();
				$lang_diagnosticos			= array();
				$lang_general[12]   = "Estado";
				$lang_diagnosticos[14]		= "Diagnóstico";
				$lang_diagnosticos[15]		= "Código";
				$lang_diagnosticos[6]		= "Observación";
				$lang_diagnosticos[7]		= "Precio";
				$lang_diagnosticos[12]		= "Activar diagnóstico";
				$lang_diagnosticos[13]		= "Desactivar diagnóstico";
    		break;
    		
    	case 'En':
				$lang_general   = 	array();
				$lang_diagnosticos			= array();
				$lang_general[12]   = "State";
				$lang_diagnosticos[14]		= "Diagnosis";
				$lang_diagnosticos[15]		= "Code";
				$lang_diagnosticos[6]		= "Observation";
				$lang_diagnosticos[7]		= "Price";
				$lang_diagnosticos[12]		= "Activate diagnosis";
				$lang_diagnosticos[13]		= "Disable diagnosis";	
    		break;
        
    }//fin swtich
 

?>


	<table class="bordered highlight centered responsive-table">
									
		<thead>
			<tr>
				<th><?php echo $lang_diagnosticos[14]//Diagnóstico?></th>
				<th><?php echo $lang_diagnosticos[15]//Código?></th>
				<th><?php echo $lang_diagnosticos[6]//Observación?></th>
				<th><?php echo $lang_diagnosticos[7]//Precio?></th>
				<th><?php echo $lang_general[12]//Estado?></th>
			</tr>
		</thead>
		
		<tbody>
			
			<?php									
				foreach ($listadoDiagnosticos as $listadoDiagnoticos1) {
					
					if($listadoDiagnoticos1['estado'] == 'A'){																																																			//Desactivar diagnótico
						$btn = '<span id="spanB_'.$listadoDiagnoticos1['idPanelCirugiaDiagnostico'].'"> <a id="'.$listadoDiagnoticos1['idPanelCirugiaDiagnostico'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarDiagnosticoCirugia(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_diagnosticos[13].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
					}else{																																																											//Activar diagnótico
						$btn = '<span id="spanB_'.$listadoDiagnoticos1['idPanelCirugiaDiagnostico'].'"> <a id="'.$listadoDiagnoticos1['idPanelCirugiaDiagnostico'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarDiagnosticoCirugia(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_diagnosticos[12].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
					}
					
					$parametros = "'".$listadoDiagnoticos1['idPanelCirugiaDiagnostico']."','".$listadoDiagnoticos1['nombre']."','".$listadoDiagnoticos1['codigo']."','".$listadoDiagnoticos1['observacion']."','".$listadoDiagnoticos1['precio']."'";
			?>
			
				<tr style="cursor: pointer;">
					<td <?php if(in_array("22", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarDiagnosticoCirugia(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoDiagnoticos1['nombre']?></td>
					<td <?php if(in_array("22", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarDiagnosticoCirugia(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoDiagnoticos1['codigo']?></td>
					<td <?php if(in_array("22", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarDiagnosticoCirugia(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoDiagnoticos1['observacion']?></td>
					<td <?php if(in_array("22", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarDiagnosticoCirugia(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoDiagnoticos1['precio']?></td>
					<td>
						<?php echo $btn ?>											
					</td>
				</tr>											
					
			<?php		
				}//fin foreach								
			?>
			
			
			
		</tbody>
		
		
	</table>