<?php

/*
 * Controlador para mostrar la informacion de una categoría que se busca
 */
 	if(!isset($_SESSION)){
		    session_start();
		} 
 
  	$idCategoria = $_POST['idCategoria'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las categorias
	require_once("../../../Models/categoriasProductos_model.php");
	
	$objetocategoriasProductos = new categoriasProductos(); 
	
	$listadoCategorias = $objetocategoriasProductos->listarUnaCategoria($idCategoria);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   = 	array();
				$lang_categoriasProductos 	= array();
				$lang_general[12]   = "Estado";
				$lang_categoriasProductos[6]	= "Activar categoría";
				$lang_categoriasProductos[7]	= "Desactivar categoría";
				$lang_categoriasProductos[8]	= "Categoría";
    		break;
    		
    	case 'En':
				$lang_general   = 	array();
				$lang_categoriasProductos 	= array();
				$lang_general[12]   = "State";
				$lang_categoriasProductos[6]	= "Activate category";
				$lang_categoriasProductos[7]	= "Disable category";
				$lang_categoriasProductos[8]	= "Category";
    		break;
        
    }//fin swtich
 

?>


	<table class="bordered highlight centered responsive-table">
			
			<thead>
				<tr>
					<th><?php echo $lang_categoriasProductos[8]//Categoría?></th>
					<th><?php echo $lang_general[12]//Estado?></th>
				</tr>
			</thead>
			
			<tbody>
				
				<?php									
					foreach ($listadoCategorias as $listadoCategorias1) {
						
						if($listadoCategorias1['estado'] == 'A'){																																																			//Desactivar categoria
							$btn = '<span id="spanB_'.$listadoCategorias1['idCategoria'].'"> <a id="'.$listadoCategorias1['idCategoria'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarCategoria(this.id)"  data-position="right" data-delay="50" data-tooltip="'.$lang_categoriasProductos[7].'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}else{																																																											//Activar categoria
							$btn = '<span id="spanB_'.$listadoCategorias1['idCategoria'].'"> <a id="'.$listadoCategorias1['idCategoria'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarCategoria(this.id)" data-position="right" data-delay="50" data-tooltip="'.$lang_categoriasProductos[6].'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}
						
						$parametros = "'".$listadoCategorias1['idCategoria']."','".$listadoCategorias1['nombre']."'";
				?>
				
					<tr style="cursor: pointer;">
						<td <?php if(in_array("103", $_SESSION['permisos_usuario'] )){ ?> onclick="editarCategoria(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoCategorias1['nombre']?></td>
						<td>
							<?php echo $btn ?>											
						</td>
					</tr>											
						
				<?php		
					}//fin foreach								
				?>
				
				
				
			</tbody>
			
			
		</table>