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
	
	$listadoPersonalizados = $objetoPersonalizados->consultarUnPersonalizadoMCI($idPersonalizado);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   = 	array();
				$lang_general[12]   = "Estado";
    		break;
    		
    	case 'En':
				$lang_general   = 	array();
				$lang_desparasitantes		= array();
				$lang_general[12]   = "State";	
    		break;
        
    }//fin swtich
 

?>


		<ul class="collapsible" data-collapsible="accordion">
			
			<?php									
				foreach ($listadoPersonalizados as $listadoPersonalizados1) {
					
			?>
			
				<li style="cursor: pointer;">
					
					<div class="collapsible-header active"><?php echo $listadoPersonalizados1['titulo']?></div>
					<div class="collapsible-body" id="textoUtilizarPersonalizadoMotivoCirugia" >
											
							<?php echo $listadoPersonalizados1['texto']?>
											
					</div>
					
					
				</li>											
					
			<?php		
				}//fin foreach								
			?>
			
			
		</ul>	