<?php

    /*
        * Contolador para gestionar los productos
    */
    
    if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
    	
				
		//se importa el modelo
		require_once("Models/productos_model.php"); 
		require_once("Models/categoriasProductos_model.php"); 
		
		require_once("Models/sucursales_model.php"); 
		
		require_once("Models/vacunas_model.php"); 
		require_once("Models/medicamentos_model.php"); 
		require_once("Models/desparasitantes_model.php"); 
		
		//se intancia el objeto
		$objetoProductos 			= new productos();
		$objetoCategoriasProductos	= new categoriasProductos();
		$objetoSucursales			= new sucursales();
		$objetoVacunas				= new vacunas();
		$objetoMedicamentos			= new medicamentos();
		$objetoDesparasitantes		= new desparasitantes();
		
		//se consultan las vacunas que no se encuentren vinculadas con los productos
		$vacunasSinVincular	= $objetoVacunas->vacunasNoVinculadasProductos();
		//se consultan los medicamentios que no estan vinculados con productos
		$medicamentosSinVincular = $objetoMedicamentos->medicamentosNoVinculadosProductos();
		//se consultan los desparasitantes que no estan vinculados con productos
		$desparasitantesSinVincular = $objetoDesparasitantes->desparasitantesNoVinculadosProductos();
		//se consultan las sucursales que se encuentran activas
		$sucursales	= $objetoSucursales->consultarSucursalesSelect();
		//se consultan las categorias que se encuentran activas
		$categoriasProductos = $objetoCategoriasProductos->listarCategoriasSelect();
		
		if( isset($_POST['envioNuevoProducto']) and $_POST['envioNuevoProducto'] == "envio" ){
			
				//se reciben las variables
				$proveedor		= $_POST['idProveedor'];
				$nombre			= $_POST['nombre'];
				$descripcion	= $_POST['descripcion'];
				$codigo			= $_POST['codigo'];
				$precio			= $_POST['precio'];
				$idCategoria	= $_POST['categoria'];
				$costo			= $_POST['costo'];


				$sw        = 0;//para controlar si entra en un 
			        
			    switch($_SESSION['usuario_idioma']){
			        
			        case 'Es':
			    		$error="Algo salió mal";
			    		$ok="Producto guardado correctamente!";
			    		break;
			    		
			    	case 'En':
			    		$error="Something went wrong";
			    		$ok="Product successfully saved!";
			    		break;
			        
			    }//fin swtich
			    
			    //validar si algun campo obligatorio llega vacio
			    if(($nombre == "") or ($codigo == "") or ($precio == "")){
			         $sw = 1;			
			         $_SESSION['mensaje']   = $error;
			     }//fin if validar los campos
			     
			     if($sw == 0){
			     	
					$idProducto = $objetoProductos->guardarProducto($nombre, $descripcion, $codigo, $precio, $idCategoria);
					
					//para vincular el producto con un proveedor
					if($proveedor != "" or $proveedor != "0"){
						
						$objetoProductos->vincularProductoProveedor($idProducto, $proveedor, $costo);
						
					}
					
					
					$_SESSION['mensaje']   = $ok;
				 }			
			
				//se redirecciona nuevamente a productos
				 header('Location: '.Config::ruta().'productos/' );	
				 		
				exit();	    
		}//fin si llega un  nuevo producto
		
		// si llega un producto para editar	
		if( isset($_POST['editar_idProducto']) and $_POST['editar_idProducto'] != "0" ){
			
				//se reciben las variables
				$idProducto		= $_POST['editar_idProducto'];
				$nombre			= $_POST['editar_nombre'];
				$codigo			= $_POST['editar_codigo'];
				$precio			= $_POST['editar_precio'];
				$idCategoria	= $_POST['editar_categoria'];
				$descripcion	= $_POST['editar_descripcion'];


				$sw        = 0;//para controlar si entra en un 
			        
			    switch($_SESSION['usuario_idioma']){
			        
			        case 'Es':
			    		$error="Algo salió mal";
			    		$ok="Producto editado correctamente!";
			    		break;
			    		
			    	case 'En':
			    		$error="Something went wrong";
			    		$ok="Product successfully edit!";
			    		break;
			        
			    }//fin swtich
			    
			    //validar si algun campo obligatorio llega vacio
			    if(($codigo == "") or ($nombre == "") or ($precio == "")){
			         $sw = 1;			
			         $_SESSION['mensaje']   = $error;
			     }//fin if validar los campos
			     
			     if($sw == 0){
			     	
					$editarProducto = $objetoProductos->editarProducto($idProducto, $nombre, $codigo, $precio, $idCategoria,$descripcion);
					
					
					$_SESSION['mensaje']   = $ok;
				 }	

				//se redirecciona nuevamente a productos
				 header('Location: '.Config::ruta().'productos/' );	
				 		
				exit();	
							
		}//fin si ellega un proveedor para editar			
				
		
 //se consulta el total de los productos existentes
		$TotalProductos = $objetoProductos->tatalProductos();	
		$records_per_page = 15;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id1');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoProductos = $objetoProductos->listarProductos($paginaActual,$records_per_page);//se llama al metodo para listar los proveedores segun los limites de la consulta
		
		$pagination->records($TotalProductos);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
		
		
		//se importa el layout del menu
        require_once("Views/Layout/menu.phtml");
			
		//se importa la vista de los productos
		require_once("Views/productos/productos.phtml");	
		
		//se importa el footer
        require_once("Views/Layout/footer.phtml");	
			
    }else{
        header('Location: '.Config::ruta());
		exit();
    }    	