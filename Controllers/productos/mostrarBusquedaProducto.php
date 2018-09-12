<?php

/*
 * Controlador para mostrar la informacion de un producto que se busca
 */
 
	if(!isset($_SESSION)){
		    session_start();
		}
	 
  	$idProducto = $_POST['idProducto'];
 
 
	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los productos
	require_once("../../Models/productos_model.php");
	
	$objetoProductos = new productos(); 
	
	$listadoProductos = $objetoProductos->listarUnProducto($idProducto);

    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				$lang_general   = 	array();
				$lang_general[12]   = "Estado";
				
    		break;
    		
    	case 'En':
				$lang_general   = 	array();
				$lang_general[12]   = "State";	
				
    		break;
        
    }//fin swtich
 

?>


	<table class="bordered highlight centered responsive-table">
									
			<thead>
				<tr>	
					<th>Código</th>																					
					<th>Nombre</th>
					<th>Precio</th>
					<th>Categoría</th>
					<th>Proveedores</th>
					<th>Stock</th>
					<th>Estado</th>
				</tr>
			</thead>
			
			<tbody>
				
				<?php
					foreach ($listadoProductos as $listadoProductos1) {
								
						if($listadoProductos1['estado'] == "A"){																																																						//Desactivar proveedor
							$btn = '<span id="spanP_'.$listadoProductos1['idProducto'].'"> <a id="'.$listadoProductos1['idProducto'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarProducto(this.id)"  data-position="bottom" data-delay="50" data-tooltip="Desactivar producto" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}else{																																																															//Activar proveedor
							$btn = '<span id="spanP_'.$listadoProductos1['idProducto'].'"> <a id="'.$listadoProductos1['idProducto'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarProducto(this.id)" data-position="bottom" data-delay="50" data-tooltip="Activar producto"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
						}		
						
						$parametros = "'".$listadoProductos1['idProducto']."','".$listadoProductos1['codigo']."','".$listadoProductos1['descripcion']."','".$listadoProductos1['nombre']."','".$listadoProductos1['nombreCategoria']."','".$listadoProductos1['idCategoria']."','".$listadoProductos1['precio']."'";
						
				?>
							
						<tr style="cursor: pointer;">
							<td <?php if(in_array("45", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarProducto(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoProductos1['codigo']?></td>
							<td <?php if(in_array("45", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarProducto(<?php echo $parametros?>)" <?php } ?>><span class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo $listadoProductos1['descripcion']?>" ><?php echo $listadoProductos1['nombre']?></span></td>
							<td <?php if(in_array("45", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarProducto(<?php echo $parametros?>)" <?php } ?>><?php echo $listadoProductos1['precio']?></td>
							<td <?php if(in_array("45", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarProducto(<?php echo $parametros?>)" <?php } ?>><?php echo $listadoProductos1['nombreCategoria']?></td>													
							<td><a class="waves-effect black btn modal-trigger" href="#modal_productoProveedor" onclick="consultarVinculosProdcutoProveedor('<?php echo $listadoProductos1['idProducto']?>','<?php echo $listadoProductos1['nombre']?>')"><i class="fa fa-truck" aria-hidden="true"></i></a></td>
							<td><a class="waves-effect black btn modal-trigger" href="#modal_productoStock" onclick="consultarStockProdcuto('<?php echo $listadoProductos1['idProducto']?>','<?php echo $listadoProductos1['nombre']?>','click')"><i class="fa fa-cubes" aria-hidden="true"></i></a></td>
							<td><?php echo $btn?></td>
						</tr>
						
				<?php		
					}//fin foreach
				
				?>
				
			</tbody>
			
			
		</table>