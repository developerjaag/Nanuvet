<?php

/*
 * Controlador del login
 */
 
 //variable para mostrar un error en el inicio de sesion si es neceserio
 $errorIniciarSesion = "&nbsp;";
 
 
 //si se envia una peticion para inciar sesión
 if(isset($_POST['hidden_login']) and $_POST['hidden_login'] === 'login'){
  
  //se importa el modelo para valida los datos ingresados
  require_once("Shop/ShopModels/shop_model.php");
  require_once("Models/login_model.php");
  
  $objetoShopModel  = new shop_model();

  
  //se llama el metodo para obtener la conexión del cliente
  $conexionCliente = $objetoShopModel->conexionBDCliente($_POST['login_identificacionTitular']);
  
   if(sizeof($conexionCliente) > 0){//conprobar si la consulta retorno resultados, es decir, si existe el títular

                if($conexionCliente['BDC_estado'] == 'I'){//en caso tal de que el títular se encuentre incativo, se muestra un mensaje
           
                    $errorIniciarSesion           = $lang_error[3];//Cuenta inactiva
                }else{//sino. se comprueba los datos del usuario
         
                    $objetoLoginModel = new login();
                    
                    $comprobarDatos     = $objetoLoginModel->loginUsuario($conexionCliente['BDC_ubicacion_BD'],$conexionCliente['BDC_nombre_BD'], 
                                                                            $conexionCliente['BDC_usuario_BD'], $conexionCliente['BDC_pass_BD'], $_POST['login_identificacion']);
        			
        			if(sizeof($comprobarDatos) > 0){//comprobar si existe el usuario
	
                			if( ($comprobarDatos['estado'] == 'I') or ($comprobarDatos['idLicencia'] == '0') ){//comprobar el estado del usuario
                				
                				 $errorIniciarSesion           = $lang_error[4];//Usuario inactivo
                				
                			}else{
								
								//comprobar el estado de la licencia
								$comprobarLicenciaVencida = $objetoLoginModel->comprobarVencimientoLicencia($comprobarDatos['idLicencia']);
								
								if($comprobarLicenciaVencida == 0){
									
									$errorIniciarSesion           = $lang_error[5];//Licencia vencida
									
								}else if ( (password_verify($_POST['login_pass'], $comprobarDatos['pass'])) and ($comprobarDatos['idLicencia'] != '0' ) ) {//se utiliza la funcion nativa para verificar la contraseña
                   				   //'¡La contraseña es válida!';
                   					$_SESSION['usuario_idUsuario'] 					= $comprobarDatos['idUsuario'];
                   					$_SESSION['usuario_identificacion'] 			= $_POST['login_identificacion'];
                   					$_SESSION['usuario_nombre'] 				    = $comprobarDatos['nombre'];
                   					$_SESSION['Usuario_Apellido'] 		       		= $comprobarDatos['apellido'];
                   					$_SESSION['usuario_urlFoto'] 			       	= $comprobarDatos['urlFoto'];
                   					$_SESSION['usuario_idioma'] 		       		= $comprobarDatos['urlArchivo'];
                					
                                    //Datos de la base de datos almacenados en variables de session para evitar idas a la BD
                                    $_SESSION['BDC_id']                  = $conexionCliente['BDC_id'];
                                    $_SESSION['BDC_ubicacion_BD']        = $conexionCliente['BDC_ubicacion_BD'];
                                    $_SESSION['BDC_usuario_BD']          = $conexionCliente['BDC_usuario_BD'];
                                    $_SESSION['BDC_pass_BD']             = $conexionCliente['BDC_pass_BD'];
                                    $_SESSION['BDC_nombre_BD']           = $conexionCliente['BDC_nombre_BD'];
                                    $_SESSION['BDC_estado']              = $conexionCliente['BDC_estado'];
									$_SESSION['BDC_carpeta']             = $conexionCliente['BDC_id']."_".$_POST['login_identificacionTitular'];
									
									//variable de sesion con la identificacion del cliente
									$_SESSION['identificacion_cliente'] = $_POST['login_identificacionTitular'];
                					
									echo "<script>window.location.href = '".Config::ruta()."home/.';</script>";
									
                					//header('Location:'.Config::ruta().'home/');//se redirecciona al home de la palicación
                					exit;
                						
                				} else {
                				   //'La contraseña no es válida.';
                				   if(!isset($_SESSION)){
									    session_start();
									}
                       			   session_destroy();
                				   $errorIniciarSesion           = $lang_error[2];//Datos incorrectos
                				   echo "<script>window.location='#login';</script>";
                				}//fin else si los datos no son correctos
                				
                			}
            			}else{//else sino existe el usuario
            			    //'El suario no es valido.';
                           if(!isset($_SESSION)){
									    session_start();
									}
                           session_destroy();
                           $errorIniciarSesion           = $lang_error[2];//Datos incorrectos
                           echo "<script>window.location='#login';</script>";
            			}
                    }//fin else si el estado del cliente es activo

            }else{//fin si existe el títular ingresado
                  	if(!isset($_SESSION)){
					    session_start();
					}
                   session_destroy();
                   $errorIniciarSesion           = $lang_error[2];//Datos incorrectos
                   echo "<script>window.location='#login';</script>";
            }//fin else si no existe el títular
  
  
  
 }//fin if para la peticion de iniciar sesión
 
 
