<?php

/*
 * MOstrar el resultado de la busqueda de un proveedor
 */
 	if(!isset($_SESSION)){
		    session_start();
		}
  
  	$idProveedor = $_POST['idProveedor'];
  
	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los proveedores
	require_once("../../Models/proveedores_model.php");
	
	$objetoProveedores = new proveedores(); 
	
	$listadoProveedores = $objetoProveedores->listarUnProveedor($idProveedor);
	
	$lang_proveedores	= array();
	
	switch($_SESSION['usuario_idioma']){
			        
			        case 'Es':
			    		$lang_proveedores[3]	= "Identificación";
						$lang_proveedores[4]	= "Nombre";
						$lang_proveedores[5]	= "Teléfono";
						$lang_proveedores[6]	= "Celular";
						$lang_proveedores[7]	= "Dirección";
						$lang_proveedores[10]	= "Estado";
			    		break;
			    		
			    	case 'En':
						$lang_proveedores[3]	= "ID";
						$lang_proveedores[4]	= "Name";
						$lang_proveedores[5]	= "Phone";
						$lang_proveedores[6]	= "Cell phone";
						$lang_proveedores[7]	= "Address";
						$lang_proveedores[10]	= "State";
			    		break;
			        
			    }//fin swtich
	

?>

			<table class="bordered highlight centered responsive-table">
					
					<thead>
						<tr>
							<th><?php echo $lang_proveedores[3]//Identificación?></th>
							<th><?php echo $lang_proveedores[4]//Nombre?></th>
							<th><?php echo $lang_proveedores[5]//Teléfono?> 1</th>
							<th><?php echo $lang_proveedores[5]//Teléfono?> 2</th>
							<th><?php echo $lang_proveedores[6]//Celular?></th>
							<th><?php echo $lang_proveedores[7]//Dirección?></th>
							<th>E-mail</th>
							<th><?php echo $lang_proveedores[10]//Estado?></th>
						</tr>
					</thead>
					
					<tbody>
						
						<?php
						
							foreach ($listadoProveedores as $listadoproveedores1) {
													
								if($listadoproveedores1['estado'] == "A"){																																																						//Desactivar proveedor
									$btn = '<span id="spanP_'.$listadoproveedores1['idProveedor'].'"> <a id="'.$listadoproveedores1['idProveedor'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarProveedor(this.id)"  data-position="bottom" data-delay="50" data-tooltip="Desactivar proveedor" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
								}else{																																																															//Activar proveedor
									$btn = '<span id="spanP_'.$listadoproveedores1['idProveedor'].'"> <a id="'.$listadoproveedores1['idProveedor'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarProveedor(this.id)" data-position="bottom" data-delay="50" data-tooltip="Activar proveedor"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
								}				
												
								$parametros = "'".$listadoproveedores1['idProveedor']."','".$listadoproveedores1['nombre']."','".$listadoproveedores1['telefono1']."','".$listadoproveedores1['telefono2']."','".$listadoproveedores1['celular']."','".$listadoproveedores1['direccion']."','".$listadoproveedores1['email']."','".$listadoproveedores1['identificativoNit']."'";				
						?>					
							<tr style="cursor: pointer;">
								<td  <?php if(in_array("47", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarProveedor(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoproveedores1['identificativoNit']?></td>
								<td <?php if(in_array("47", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarProveedor(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoproveedores1['nombre']?></td>
								<td <?php if(in_array("47", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarProveedor(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoproveedores1['telefono1']?></td>
								<td <?php if(in_array("47", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarProveedor(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoproveedores1['telefono2']?></td>
								<td <?php if(in_array("47", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarProveedor(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoproveedores1['celular']?></td>
								<td <?php if(in_array("47", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarProveedor(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoproveedores1['direccion']?></td>
								<td <?php if(in_array("47", $_SESSION['permisos_usuario'] )){ ?>  onclick="editarProveedor(<?php echo $parametros?>)" <?php } ?> ><?php echo $listadoproveedores1['email']?></td>
								<td  ><?php echo $btn?></td>
							</tr>
										
									
						<?php		
							}//fin foreach
						
						?>
						
					</tbody>
					
					
				</table>