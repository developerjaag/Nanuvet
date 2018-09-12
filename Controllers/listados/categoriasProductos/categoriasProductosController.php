<?php

/*
 * Archivo controller para ciudades
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de las categoriasProductos
	    require_once("Models/categoriasProductos_model.php");
	    
	    //se define el objeto categoriasProductos
	    $objetoCategoriasProductos   = new categoriasProductos();
 
 
 //si llega el formulario para guardar una nueva categoria
 if( isset($_POST['envioNuevaCategoria']) and $_POST['envioNuevaCategoria'] == "envio" ){
 	
	//se reciben las variables
	$nombreCategoria	= $_POST['nombreCategoria'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="La categoría ya existe!";
    		$ok="Categoría guardada correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The category it already exists!";
    		$ok="Category successfully saved!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($nombreCategoria == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si la categoria existe
		    $comprobarExistencia    = $objetoCategoriasProductos->comprobarExistenciaCategoria($nombreCategoria);
		    
		    //comprobar si la consulta arrojo datos (Existe la categoría)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta la categoria
		        
		        $guardarCiudad  = $objetoCategoriasProductos->guardarCategoria($nombreCategoria);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a categorias productos listado
	 header('Location: '.Config::ruta().'listados/categoriasProductos/' );	
	 		
	exit();	
	
	
 }//fin si llega una categoria para guardar
 
 
 //si llega el formulario para editar una categoria
 if( isset($_POST['idEditarCategoria']) and $_POST['idEditarCategoria'] != "" ){
 	

	//se reciben las variables
	$idCategoria			= $_POST['idEditarCategoria'];
	$nombreCategoria	    = $_POST['editarNombreCategoria'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="La categoría ya existe!";
    		$ok="Categoría editada correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The category it already exists!";
    		$ok="Category edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if(($idCategoria == "") or ($idCategoria == "0") or ($nombreCategoria == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	

		   
		    
		    if($nombreCategoria != $_POST['replicaNombre']){
				
				 //se llama al metodo que consulta si la ciudad existe
		    	$comprobarExistencia    = $objetoCategoriasProductos->comprobarExistenciaCategoria($nombreCategoria);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se edita la categoría
		        
		        $guardarCiudad  = $objetoCategoriasProductos->editarCategoria($idCategoria, $nombreCategoria);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a ciudades listado
	 header('Location: '.Config::ruta().'listados/categoriasProductos/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar categoría
 
 
 
 

 
 //se consulta el total de las categorías existentes
		$TotalCategorias = $objetoCategoriasProductos->tatalCategorias();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoCategorias = $objetoCategoriasProductos->listarCategorias($paginaActual,$records_per_page);//se llama al metodo para listar las categorías segun los limites de la consulta
		
		$pagination->records($TotalCategorias);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>