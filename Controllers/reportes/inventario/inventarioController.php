<?php

/*
 * Subcontrolador para el reporte del inventario
 * */
				$idSucursal = $_SESSION['sucursalActual_idSucursal'];

			 //se consulta el total de los productos existentes
				$TotalProductos = $objetoReportes->inventario_tatalProductos();	
				$records_per_page = 10;//total de registros por pagina
				
				require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo
			
				
				$pagination = new Zebra_Pagination();//se instancia el objeto
				
				$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
				
				$pagination->method('get');//metod por el que se recive la variable
			
				$pagination->variable_name('id2');//nombre de la variable get
				
				$pagination->padding(false);//para que no se muestre un cero adelante
				
				$paginaActual = $pagination->get_page() - 1;
				
				$listadoInventario = $objetoReportes->inventario_listarProductos($paginaActual,$records_per_page, $idSucursal);//se llama al metodo para listar los productos segun los limites de la consulta
				
				$pagination->records($TotalProductos);
				
				$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
				
				//para el contenido a exportar, son todos los propietarios	
				$listadoProductosExportar = $objetoReportes->inventario_listarProductos('0',$TotalProductos);	
			//fin paginación
			
			$totalRegistros = $TotalProductos;

?>