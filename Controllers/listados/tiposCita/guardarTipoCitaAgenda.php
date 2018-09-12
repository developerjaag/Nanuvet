<?php


	if(!isset($_SESSION)){
		    session_start();
		}

 	    //se importa el archivo de config
	    require_once("../../../Config/config.php");
	    
	    //se importa el modelo de los tiposCita
	    require_once("../../../Models/tiposCita_model.php");
	    
	    //se define el objeto tiposCita
	    $objetoTiposCita   = new tiposCita();

	//se reciben las variables
	$nombreTipoCita		= $_POST['nombreTipoCita'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($nombreTipoCita == "")){
         $sw = 1;			
         echo $error;
     }//fin if validar los campos
     
     if($sw == 0){     	

		    //se llama al metodo que consulta si el tipo de cita existe
		    $comprobarExistencia    = $objetoTiposCita->comprobarExistenciaTipoCita($nombreTipoCita);
		    
		    //comprobar si la consulta arrojo datos (Existe la vacuna)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		       echo 2;
		        
		    }else{//sino se inserta el tipo de cita
		        
		        $guardarTipoCita  = $objetoTiposCita->guardarTipoCita($nombreTipoCita);
		        
		        $tiposDeCita	= $objetoTiposCita->listarTiposCitaSelect();
?>				
				
					<select id="cita_tipoCita">
					      <option value="" disabled selected>Elige un tipo cita</option>
					      <?php
					      	foreach ($tiposDeCita as $tiposDeCita1) {
						  ?>
						  		<option value="<?php echo $tiposDeCita1['idTipoCita']?>"><?php echo $tiposDeCita1['nombre']?></option>
						  <?php	  
							  }
					      ?>
					      
					    </select>							
				
<?php		        
		    } //fin else
	
     }//fin sw == 0
	

?>	