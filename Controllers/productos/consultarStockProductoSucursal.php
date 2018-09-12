<?php

/*
 * Archivo para consultar el stock de un producto en las distintas sucursales
 */

 $idProducto	= $_POST['idProducto'];

	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los productos
	require_once("../../Models/productos_model.php");
	
	$objetoProductos = new productos();
	
	$stockDelProducto	= $objetoProductos->consultarStockProductoSucursales($idProducto);

		switch($_SESSION['usuario_idioma']){
	        
	        case 'Es':
	    		$lang_productos	= array();
				$lang_productos[0] = "Sucursal";
				$lang_productos[1] = "Cantidad";
				$lang_productos[2] = "Stock mínimo";
				$lang_productos[3] = "Registrar entrada";
	    		break;
	    		
	    	case 'En':
	    		$lang_productos	= array();
				$lang_productos[0] = "Branch";
				$lang_productos[1] = "Quantity";
				$lang_productos[2] = "Stock minimum";
				$lang_productos[3] = "Register entry";
	    		break;
	        
	    }//fin swtich

	
?>

	<table>
		
		<thead>
			<tr>
				<th><?php echo $lang_productos[0]//Sucursal?></th>
				<th><?php echo $lang_productos[1]//Cantidad?></th>
				<th><?php echo $lang_productos[0]//Stock minimo?></th>
				<th></th>
			</tr>
		</thead>
		
		<tbody>


<?php	
	foreach ($stockDelProducto as $stockDelProducto1) {
		
		$parametros = "'".$stockDelProducto1['idProductoSucursal']."','".$stockDelProducto1['cantidad']."','".$stockDelProducto1['stockMinimo']."','".$stockDelProducto1['idSucursal']."'";
		
		$parametros2 = "'".$stockDelProducto1['idSucursal']."','".$idProducto."','".$stockDelProducto1['identificativoNit']."','".$stockDelProducto1['nombre']."'";
?>
	<tr style="cursor: pointer;">
		<td onclick="editarStockProductoSucursal(<?php echo $parametros ?>)"><?php echo "(".$stockDelProducto1['identificativoNit'].") ".$stockDelProducto1['nombre']?></td>
		<td onclick="editarStockProductoSucursal(<?php echo $parametros ?>)"><?php echo $stockDelProducto1['cantidad']?></td>
		<td onclick="editarStockProductoSucursal(<?php echo $parametros ?>)"><?php echo $stockDelProducto1['stockMinimo']?></td>			
		<td>
			<a class="waves-effect black btn tooltipped" data-position="right" data-delay="50" data-tooltip="<?php echo $lang_productos[3]//Registrar entrada?>" onclick="abrirFormAdicionarEntrada(<?php echo $parametros2?>)" ><i class="fa fa-cube" aria-hidden="true"></i></a>
		</td>
	</tr>


<?php		
		
	}//fin foreach

?>
		</tbody>
	</table>