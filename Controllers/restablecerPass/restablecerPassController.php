<?php

/*
 * Archivo donde entra un usuario para restablecer la contraseña
 */
 

 
  //se incorpora el modelo encargado de registrar los datos en la BD
 require_once ("Models/index_model.php");	
 
 //se instancian el objeto del modelo
 $objetoIndex = new index();	
 
 //si llega el formulario para cambiar el pass
 if( isset($_POST['titular']) ){
 	
	
	$titular 		= $_POST['titular'];
	$idUsuario		= $_POST['idUsuario'];
	$nuevoPass		= $_POST['nuevoPass'];
	$token			= $_POST['token'];
	
	$passCambiada = password_hash($nuevoPass, PASSWORD_DEFAULT);
	
	$objetoIndex->cambiarPassUsuario($titular, $idUsuario, $passCambiada);
	
	$objetoIndex->desactivarTokenPass($token);
	
	header('Location: http://www.nanuvet.com/' );	
	
	exit();
 }
 
 
 
  //se toman las variables mediante get
 
 $titular 		= $_GET['id1'];
 $usuario 		= $_GET['id2'];
 $token 		= $_GET['id3'];
 $sw = 0;
 
 //se verifica si el token es valido
 $resultado = $objetoIndex->verificarTokenCambioPass($token);
 
 if(sizeof($resultado) > 0){
 	
	if(sha1($resultado['titular']) == $titular AND sha1($resultado['identificacionIngresada']) == $usuario){
		$sw = 1;
	}else{//si el link es valido
		$sw = 0;
	}
	
 }else{//fin sizeof resultado
 	$sw = 0;
 }

	require_once("Views/Layout/menuReplica.phtml");
?>

	<main>
		
	 <div class="row">
        <div class="col s12 m12 l12">
          <div class="card">
            <div class="card-content">
              <span class="card-title">Restablecer contraseña</span>
              <br />
              <br />
              <br />
              <br />
              <br />
		
<?php
	if($sw == 1){//se muestra el formulario para reestablecer la pass

		?>
		
		<form id="form_restablecerPass" name="form_restablecerPass" method="post" action="">
			
			<input type="hidden" id="token" name="token" value="<?php echo $token?>" />
			<input type="hidden" id="titular" name="titular" value="<?php echo $resultado['titular']?>" />
			<input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $resultado['idUsuarioEncontrado']?>" />
			
			<div class="row">
				
				<div class="input-field col s6">
					<input id="nuevoPass" name="nuevoPass" type="password" class="validate">
	          		<label id="label_nuevoPass" for="nuevoPass" data-error="<?php echo $lang_error[0]//Debe completar este campo?>" data-success="<?php echo $lang_error[1]//Ok?>" style="width:100%; text-align: left;">Nueva contraseña</label>
				</div>
				
				<div class="input-field col s6">
					<input id="repetirNuevoPass" name="repetirNuevoPass" type="password" class="validate">
	          		<label id="label_repetirNuevoPass" for="repetirNuevoPass" data-error="<?php echo $lang_error[0]//Debe completar este campo?>" data-success="<?php echo $lang_error[1]//Ok?>" style="width:100%; text-align: left;">Repetir contraseña</label>
				</div>
				
			</div>
		
		</form>
		
		<div class="row">
			<div class="input-field center-align col s12">
				<a class="waves-effect waves-light btn" onclick="valirCambioPass()">Guardar</a>
			</div>
		</div>
		
		<div class="row">
			<div class="col s12 center-align">
				<span id="mensajeErrorPassNuevaConfirmar" style="display: none;">Las contraseñas no coinciden!</span>
				<span id="paraMostrarMensaje" class="red-text text-darken-2">&nbsp;</span>
			</div>
		</div>
		
		
		
		<?php
		
	}else{//se indica que el link esta roto o no es valido
	
		?>

		<div class="row">
			
			<div class="col s12">
				<h4 class="center-align">El enlace se encuentra roto o ya no es valido.</h4>
			</div>
			
		</div>


		
		<?php
	}
?>
			</div>
			
          </div>
        </div>
      </div>
	</main>
	
<?php
	require_once("Views/Layout/footer.phtml");

?>