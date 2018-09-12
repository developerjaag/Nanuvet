<?php

/*
 * Controlador para mostrar la informacion de un personalizado que se busca
 */
 
 
  	$idPersonalizado = $_POST['idPersonalizado'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los personalizados
	require_once("../../../Models/personalizados_model.php");
	
	$objetoPersonalizados = new personalizados(); 
	
	$listadoPersonalizados = $objetoPersonalizados->consultarUnPersonalizadoOCI($idPersonalizado);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   = 	array();
				$lang_general[12]   = "Estado";
				$lang_personalizados[15]	= "Editar personalizado";
    		break;
    		
    	case 'En':
				$lang_general   = 	array();
				$lang_desparasitantes		= array();
				$lang_general[12]   = "State";	
				$lang_personalizados[15]	= "Edit custom";
    		break;
        
    }//fin swtich
 

?>


		<ul class="collapsible" data-collapsible="accordion">
			
			<?php									
				foreach ($listadoPersonalizados as $listadoPersonalizados1) {
					
					if($listadoPersonalizados1['estado'] == 'A'){																																																			
						$btn = '<span id="spanOCI_'.$listadoPersonalizados1['idPersonalizadoObservacionCirugia'].'"> <a id="'.$listadoPersonalizados1['idPersonalizadoObservacionCirugia'].'" class="waves-effect waves-light btn secondary-content" onclick="desactivarPersonalizadoOCI(this.id)"   ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
					}else{																																																											
						$btn = '<span id="spanOCI_'.$listadoPersonalizados1['idPersonalizadoObservacionCirugia'].'"> <a id="'.$listadoPersonalizados1['idPersonalizadoObservacionCirugia'].'" class="waves-effect red darken-1 btn secondary-content" onclick="activarPersonalizadoOCI(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
					}
					
					$parametros = "'".$listadoPersonalizados1['idPersonalizadoObservacionCirugia']."'";
			?>
			
				<li style="cursor: pointer;">
					
					<div class="collapsible-header"><?php echo $listadoPersonalizados1['titulo']?><?php echo $btn ?> </div>
					<div class="collapsible-body" style="max-height: 300px; overflow-y: scroll;">
						<div>
							<a class="waves-effect black btn tooltipped" data-position="right" data-delay="50" data-tooltip="<?php echo $lang_personalizados[15]//Editar personalizado?>" onclick="editarPersonalizadoOCI(<?php echo $parametros?>)"><i class="fa fa-pencil" aria-hidden="true"></i></a> 
						</div>
						<?php echo $listadoPersonalizados1['texto']?>
					</div>
					
					
				</li>											
					
			<?php		
				}//fin foreach								
			?>
			
			
		</ul>	