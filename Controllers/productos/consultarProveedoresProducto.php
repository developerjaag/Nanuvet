<?php

/*
 * Archivo para consultar los proveedores de un producto y llenar el select de nueva entrada
 */
 
 
 	$idProducto	= $_POST['idProducto'];

	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los productos
	require_once("../../Models/productos_model.php");
	
	$objetoProductos = new productos();
	
	$proveedores	= $objetoProductos->consultarVinculoProductoProveedores($idProducto, 'Select');
	
		switch($_SESSION['usuario_idioma']){
	        
	        case 'Es':
	    		$lang_productos	= array();
				$lang_productos[0] = "Elige un proveedor";
				$lang_productos[1] = "Proveedor";
	    		break;
	    		
	    	case 'En':
	    		$lang_productos	= array();
				$lang_productos[0] = "Choose a supplier";
				$lang_productos[1] = "Supplier";
	    		break;
	        
	    }//fin swtich
	
?>


		<select id="nuevaEntrada_proveedores" name="nuevaEntrada_proveedores" onchange="cambiarPlaceholderCosto()">
	      <option value="" disabled selected><?php echo $lang_productos[0]//Elige un proveedor?></option>
	      
	      <?php	      
	      	foreach ($proveedores as $proveedores1) {
			?>
			
				<option value="<?php echo $proveedores1['idProveedor']?>" data-costo="<?php echo $proveedores1['costo']?>" ><?php echo "(".$proveedores1['identificativoNit'].") ".$proveedores1['nombreProveedor']?></option>
			
			<?php	  
			  }
	      ?>
	      
	    </select>
	    <label><?php echo $lang_productos[1]//Proveedor?></label>