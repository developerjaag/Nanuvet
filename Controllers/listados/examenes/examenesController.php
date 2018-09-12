<?php

/*
 * Archivo controller para examenes
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de los examenes
	    require_once("Models/examenes_model.php");
	    
	    //se define el objeto examenes
	    $objetoExamenes  = new examenes();
 
 
 //si llega el formulario para guardar un nuevo examen
 if( isset($_POST['envioNuevoExamen']) and $_POST['envioNuevoExamen'] == "envio" ){
 	
	//se reciben las variables
	$nombreExamen		= $_POST['nombreExamen'];
	$codigoExamen		= $_POST['codigoExamen'];
	$precioExamen		= $_POST['precioExamen'];	
	$descripcionExamen	= $_POST['descripcionExamen'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El examen ya existe!";
    		$ok="Examen guardado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The examination already exists!";
    		$ok="Examination saved correctly!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($nombreExamen == "") or ($precioExamen == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si el examen existe
		    $comprobarExistencia    = $objetoExamenes->comprobarExistenciaExamen($nombreExamen);
		    
		    //comprobar si la consulta arrojo datos (Existe el examen)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el examen
		        
		        $guardarExamen  = $objetoExamenes->guardarExamen($nombreExamen, $codigoExamen, $precioExamen, $descripcionExamen );
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a examenes listado
	 header('Location: '.Config::ruta().'listados/examenes/' );	
	 		
	exit();	
	
	
 }//fin si llega un examen para guardar
 
 
 //si llega el formulario para editar un examen
 if( isset($_POST['idEditarExamen']) and $_POST['idEditarExamen'] != "" ){
 	

	//se reciben las variables
	$idExamen		= $_POST['idEditarExamen'];
	$nombreExamen	= $_POST['editarNombreExamen'];
	$codigoExamen	= $_POST['editarCodigoExamen'];
	$precioExamen	= $_POST['editarPrecioExamen'];
	$descripcionExamen	= $_POST['editarDescripcionExamen'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El examen ya existe!";
    		$ok="Examen editado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="Examination it already exists!";
    		$ok="Examination edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if(($nombreExamen == "") or ($precioExamen == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	


		    
		     if($nombreExamen != $_POST['replicaNombre']){
				
			    //se llama al metodo que consulta si el examen existe
			    $comprobarExistencia    = $objetoExamenes->comprobarExistenciaExamen($nombreExamen);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el examen
		        
		        $editarExamen  = $objetoExamenes->editarExamen($idExamen, $nombreExamen, $codigoExamen, $precioExamen, $descripcionExamen );
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a examenes listado
	 header('Location: '.Config::ruta().'listados/examenes/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar examenes
 
 
 
 

 
 //se consulta el total de los examenes existentes
		$TotalExamenes = $objetoExamenes->tatalExamenes();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoExamenes = $objetoExamenes->listarExamenes($paginaActual,$records_per_page);//se llama al metodo para listar los examenes segun los limites de la consulta
		
		$pagination->records($TotalExamenes);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>