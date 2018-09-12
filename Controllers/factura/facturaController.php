<?php


/*
 * Archivo para mostrar el contenido de la historia clinica d eun paciente
 */
 
 if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
 	
			require_once("Models/factura_model.php");
	 
	 		$objetoFactura = new factura();
	
			//se importa el controlador segun el item de factura
			if(isset($_GET['id1'])){
								if(is_file("Controllers/factura/".$_GET['id1']."/".$_GET['id1']."Controller.php")){
					//se importa el controlador de apoyo
					require_once("Controllers/factura/".$_GET['id1']."/".$_GET['id1']."Controller.php");
				}else{
					//se importa el controlador de facturas por defecto
					require_once("Controllers/factura/facturas/facturasController.php");
				}
				
			}else{
					//se importa el controlador de facturas por defecto
					require_once("Controllers/factura/facturas/facturasController.php");
				}
	
			//consultar si se encuentra una factura iniciada por el usuario
			$totalFacturasIniciadasUsuario = $objetoFactura->comprobarFacturaIniciada($_SESSION['usuario_idUsuario']);
	
			//se consultan los items de detalles pendientes por facturar (consultas, cirugias, etc)	
			$menuTotalFacConsultas = $objetoFactura->consultasPendientes();
			$menuTotalFacCirugias = $objetoFactura->cirugiasPendientes();
			$menuTotalFacExamenes = $objetoFactura->examenesPendientes();
			$menuTotalFacHospitalizaciones = $objetoFactura->hospitalizacionesPendientes();
			
			
			//consultar los facturadores con sus resoluciones
			$listadoFacturadoresResoluciones = $objetoFactura->consultarFacturadoresResolucion();

            //se importa el layout del menu
            require_once("Views/Layout/menu.phtml");
            
			if(isset($_GET['id1'])){
				
						//saber si tiene permisos de acceder a facturas
		
				if(!in_array("36", $_SESSION['permisos_usuario'] )){
					
					require_once("Views/Layout/sinPermiso.phtml");	
					
				}else{
					
					if( is_file("Views/factura/".$_GET['id1']."/".$_GET['id1'].".phtml") ){
						//se importa la vista que corresponda al item de factura
						require_once("Views/factura/".$_GET['id1']."/".$_GET['id1'].".phtml");
					}else{
						//se importa la vista de facturas por defecto
						require_once("Views/factura/facturas/facturas.phtml");
					}	
					
				}
				
			
				
			}else{
				
				//saber si tiene permisos de acceder a facturas
				if(!in_array("36", $_SESSION['permisos_usuario'] )){
					
					require_once("Views/Layout/sinPermiso.phtml");	
					
				}else{
					
					//se importa la vista de facturas por defecto
					require_once("Views/factura/facturas/facturas.phtml");	
					
				}
				
				
			}
			
	
			//se importa el footer
            require_once("Views/Layout/footer.phtml");
	
     }else{
        header('Location: '.Config::ruta());
		exit();
    }	


?>