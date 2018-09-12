<?php

/*
 * Archivo controller para especies
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de las especies
	    require_once("Models/especies_model.php");
	    
	    //se define el objeto especies
	    $objetoEspecies   = new especies();
 
 
 //si llega el formulario para guardar una nueva especie
 if( isset($_POST['envioNuevaEspecie']) and $_POST['envioNuevaEspecie'] == "envio" ){
 	
	//se reciben las variables
	$nombreEspecie	= $_POST['nombreEspecie'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="La especie ya existe!";
    		$ok="Especie guardada correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The especie it already exists!";
    		$ok="Especie successfully saved!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($nombreEspecie == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si la especie existe
		    $comprobarExistencia    = $objetoEspecies->comprobarExistenciaEspecie($nombreEspecie);
		    
		    //comprobar si la consulta arrojo datos (Existe la especie)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta la especie
		        
		        $guardarEspecie = $objetoEspecies->guardarEspecie($nombreEspecie);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a especies listado
	 header('Location: '.Config::ruta().'listados/especies/' );	
	 		
	exit();	
	
	
 }//fin si llega una especie para guardar
 
 
 //si llega el formulario para editar una especie
 if( isset($_POST['idEditarEspecie']) and $_POST['idEditarEspecie'] != "" ){
 	

	//se reciben las variables
	$idEspecie		= $_POST['idEditarEspecie'];
	$nombreEspecie	= $_POST['editarNombreEspecie'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="La especie ya existe!";
    		$ok="Especie editada correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The especie it already exists!";
    		$ok="Especie edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if(($nombreEspecie == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	


		    
		     if($nombreEspecie != $_POST['replicaNombre']){
				
			    //se llama al metodo que consulta si la especie existe
			    $comprobarExistencia    = $objetoEspecies->comprobarExistenciaEspecie($nombreEspecie);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta la especie
		        
		        $editarEspecie  = $objetoEspecies->editarEspecie($idEspecie, $nombreEspecie);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a especies listado
	 header('Location: '.Config::ruta().'listados/especies/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar especie
 
 
 
 

 
 //se consulta el total de las especies existentes
		$TotalEspecies = $objetoEspecies->tatalEspecies();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoEspecies = $objetoEspecies->listarEspecies($paginaActual,$records_per_page);//se llama al metodo para listar las especies segun los limites de la consulta
		
		$pagination->records($TotalEspecies);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>