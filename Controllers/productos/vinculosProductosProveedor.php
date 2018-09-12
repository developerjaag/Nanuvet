<?php

/*
 * Controlador para consultar la informacion de los proveedores de un producto
 */
 
 
 	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los productos
	require_once("../../Models/productos_model.php");
	
	$objetoProducto = new productos();
	
	$idProducto = $_POST['idProducto'];
	
	$vinculosProductoProveedores = $objetoProducto->consultarVinculoProductoProveedores($idProducto);

		switch($_SESSION['usuario_idioma']){
	        
	        case 'Es':
	    		$lang_productos	= array();
				$lang_productos[0] = "Proveedor";
				$lang_productos[1] = "Costo";
	    		break;
	    		
	    	case 'En':
	    		$lang_productos	= array();
				$lang_productos[0] = "supplier";
				$lang_productos[1] = "Cost";
	    		break;
	        
	    }//fin swtich


?>

		<table class="bordered">
			
			<thead>
				<tr>
					<th><?php echo $lang_productos[0]//Proveedor?></th>
					<th><?php echo $lang_productos[1]//costo?></th>
					
				</tr>
			</thead>
			
			<tbody>

<?php

	foreach ($vinculosProductoProveedores as $vinculosProductoProveedores1) {
	
		/*if($vinculosProductoProveedores1['estado']){
			$btnEstado = '<span id="spanV_'.$vinculosProductoProveedores1['idProductosProveedores'].'"> <a id="'.$vinculosProductoProveedores1['idProductosProveedores'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarVinculo(this.id)"  data-position="bottom" data-delay="50" data-tooltip="Desactivar vinculo" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
		}else{
			$btnEstado = '<span id="spanV_'.$vinculosProductoProveedores1['idProductosProveedores'].'"> <a id="'.$vinculosProductoProveedores1['idProductosProveedores'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarVinculo(this.id)" data-position="bottom" data-delay="50" data-tooltip="Activar vinculo"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
		}*/
		
		$parametros = "'".$vinculosProductoProveedores1['idProductosProveedores']."','".$vinculosProductoProveedores1['costo']."','".$vinculosProductoProveedores1['identificativoNit']."','".$vinculosProductoProveedores1['nombreProveedor']."'";
	
	
?>	
	

				<tr style="cursor: pointer;">
					<td onclick="editarVinculoProductoProveedor(<?php echo $parametros?>)"><?php echo "(".$vinculosProductoProveedores1['identificativoNit'].") ".$vinculosProductoProveedores1['nombreProveedor']?></td>
					<td onclick="editarVinculoProductoProveedor(<?php echo $parametros?>)"><?php echo $vinculosProductoProveedores1['costo']?></td>
					
				</tr>

	
		
<?php		
		
	}//fin foreach

?>
			</tbody>
			
			
		</table>
