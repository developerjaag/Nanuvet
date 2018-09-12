<?php

/*
 * Controlador para facturas factura
 */
 
 //se listan las facturas que se encuentren en un estado distinto a iniciado
 		
 		
 //se consulta el total de las facturas existentes
		$TotalFacturas = $objetoFactura->tatalFacturas();	
		$records_per_page = 15;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id1');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoFacturas = $objetoFactura->listarFacturas($paginaActual,$records_per_page);//se llama al metodo para listar las facturas segun los limites de la consulta
		
		$pagination->records($TotalFacturas);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina

?>