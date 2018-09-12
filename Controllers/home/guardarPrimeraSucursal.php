<?php

    session_start();

/*
    * Archivo para almacenar la primera sucursal
*/

    if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
        
        //se importa el archivo config
        require_once("../../Config/config.php");
         //se importa el modelo
        require_once("../../Models/sucursales_model.php");
        
        //objeto sucursales
        $objetoSucursales   = new sucursales();
        
        $identificativoNit          =   $_POST['sucursal_nit'];
        $nombre                     =   $_POST['sucursal_nombre'];
        $telefono1                  =   $_POST['sucursal_telefono1'];
        $telefono2                  =   $_POST['sucursal_telefono2'];
        $celular                    =   $_POST['sucursal_celular'];
        $direccion                  =   $_POST['sucursal_direccion'];
        $email                      =   $_POST['sucursal_email'];
        $leyendaencabezado          =   $_POST['sucursal_leyendaEncabezado'];
        $idPais                     =   $_POST['idPais'];
        $idCiudad                   =   $_POST['idCiudad'];
        $idBarrio                   =   $_POST['idBarrio'];
        
        $sw        = 0;//para controlar si entra en un error_get_last
        
        switch($_SESSION['usuario_idioma']){
            
            case 'Es':
        		$error="Algo salió mal";
        		$ok="Guardada correctamente!";
        		break;
        		
        	case 'En':
        		$error="Something went wrong";
        		$ok="Saved successfully!";
        		break;
            
        }//fin swtich
        
        
        //validar si algun campo obligatorio llega vacio
        if(($nombre == "") or ($telefono1 == "") or ($celular == "") or ($direccion == "") or ($idPais == "0") or ($idCiudad == "0") or ($idBarrio == "0")  ){
             $sw = 1;			
             $_SESSION['mensaje']   = $error;
         }//fin if validar los campos
         
         //guardar el archivo si existe y generar la url
         if($sw == 0){
         	
			$urlLogo = "";
             
             //validar si se subio imagen
             if($_FILES['sucursal_logo']['tmp_name']!=""){
                 
                 //validar el tipo de archivo subido
                 if( ( $_FILES['sucursal_logo']['type'] == "image/jpg" ) or ( $_FILES['sucursal_logo']['type'] == "image/png" ) ){
                     
                     //se copia el archivo en el servidor
                     
                     //se construye el nombre para el archivo
                     $nombreArchivo = $nombre;
				     $nombreArchivo = str_replace(" ","_",$nombreArchivo);//se eliminan los espacios del nombre de la sucursal
				     
				     $tmpNombreLogoServidor = $_FILES["sucursal_logo"]["tmp_name"];  //nombre que el  servidor le da al archivo
				     
				     $ext = explode(".", $_FILES["sucursal_logo"]["name"]); // se toma la extension del archivo
				     
				     $nombreArchivo = $nombreArchivo.".".$ext[1]; //se arma el nombre final del archivo
				     
				     $ruta  = "../../Public/uploads/".$_SESSION['BDC_carpeta']."/img_sucursales/";
				     //si no existe la ruta se crea
				     if(!is_file($ruta)){
                        	mkdir($ruta,0774, true);
                        }
				     
				     copy($tmpNombreLogoServidor,"../../Public/uploads/".$_SESSION['BDC_carpeta']."/img_sucursales/$nombreArchivo");//se copia el archivo al servidor no se puede la ruta absoluta por que contine http
				     
				     $urlLogo   = $nombreArchivo;
				     
				     
                     
                 }//fin if validar tipo de archivo
                 
             }//fin if para saber si se subio logo
             
             
             $guardarSucursal    = $objetoSucursales->guardarSucursal($identificativoNit, $nombre, $telefono1, $telefono2, $celular, $direccion, $email, $urlLogo, $leyendaencabezado, $idPais, $idCiudad, $idBarrio );
                     
             $_SESSION['mensaje']   =   $ok;
             
             
         }//fin if para guardar el archivo y generar url
       
       
        //se redirecciona nuevamente al home
        header('Location: '.Config::ruta().'home/' );
       
        
    }else{
         header('Location: '.Config::ruta() );
    }