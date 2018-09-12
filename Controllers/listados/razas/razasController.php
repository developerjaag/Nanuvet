<?php

/*
 * Archivo controller para razas
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de los razas
	    require_once("Models/razas_model.php");
	    
	    //se define el objeto razas
	    $objetoRazas   = new razas();
 
 
 //si llega el formulario para guardar una nueva raza
 if( isset($_POST['envioNuevaRaza']) and $_POST['envioNuevaRaza'] == "envio" ){
 	
	//se reciben las variables
	$idEspecie		= $_POST['idEspecie'];
	$nombreRaza	= $_POST['nombreRaza'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="La raza ya existe!";
    		$ok="Raza guardada correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The race already exists!";
    		$ok="Race successfully saved!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($idEspecie == "") or ($idEspecie == "0") or ($nombreRaza == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si la razaexiste
		    $comprobarExistencia    = $objetoRazas->comprobarExistenciaRaza($idEspecie, $nombreRaza);
		    
		    //comprobar si la consulta arrojo datos (Existe la raza)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta la raza
		        
		        $guardarRaza  = $objetoRazas->guardarRaza($nombreRaza, $idEspecie);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a razas listado
	 header('Location: '.Config::ruta().'listados/razas/' );	
	 		
	exit();	
	
	
 }//fin si llega una raza para guardar
 
 
 //si llega el formulario para editar una raza
 if( isset($_POST['idEditarRaza']) and $_POST['idEditarRaza'] != "" ){
 	

	//se reciben las variables
	$idEspecie		= $_POST['idEditarEspecie'];
	$idRaza			= $_POST['idEditarRaza'];
	$nombreRaza		= $_POST['editarNombreRaza'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="La raza ya existe!";
    		$ok="Raza editada correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The race it already exists!";
    		$ok="Race edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if( (($idEspecie == "") or ($idEspecie == "0")) or (($idRaza == "") or ($idRaza == "0")) or ($nombreRaza == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	


		    
		     if($nombreRaza != $_POST['replicaNombre']){
				
			    //se llama al metodo que consulta si la raza existe
			    $comprobarExistencia    = $objetoRazas->comprobarExistenciaRaza($idRaza, $nombreRaza);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el barrio
		        
		        $editarRaza  = $objetoRazas->editarRaza($idRaza, $nombreRaza);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a razas listado
	 header('Location: '.Config::ruta().'listados/razas/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar una raza
 
 
 
 

 
 //se consulta el total de los razas existentes
		$TotalRazas = $objetoRazas->tatalRazas();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoRazas = $objetoRazas->listarRazas($paginaActual,$records_per_page);//se llama al metodo para listar las razas segun los limites de la consulta
		
		$pagination->records($TotalRazas);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>