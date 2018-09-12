<?php

    /*
        * Contolador para gestionar los productos
    */
    
    if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
    	
				
		//se importa el modelo
		require_once("Models/agenda_model.php");
		require_once("Models/tiposCita_model.php"); 
		

		//se define el objeto
		$objetoAgenda		= new agenda();
		$objetoTiposCita	= new tiposCita();
		
		//se consultan los usuarios activos para el select
		$usuariosActivos = $objetoAgenda->usuariosActivos();
		
		//tipos de cita activos , par slect
		$tiposDeCita	= $objetoTiposCita->listarTiposCitaSelect();
		
		
		//se importa el layout del menu
        require_once("Views/Layout/menu.phtml");
			
		//se importa la vista de los productos
		require_once("Views/agenda/agenda.phtml");	
		
		//se importa el footer
        require_once("Views/Layout/footer.phtml");	
			
    }else{
        header('Location: '.Config::ruta());
		exit();
    }    	