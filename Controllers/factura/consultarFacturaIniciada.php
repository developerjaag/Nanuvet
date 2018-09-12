<?php

/*
 * Archivo para consultar en detalle los datos de una factura iniciada
 */

	if(!isset($_SESSION)){
		    session_start();
		}
 

 require_once("../../Config/config.php");
 require_once("../../Models/factura_model.php");
 
 $objetoFactura = new factura();
 
 $idUsuario = $_SESSION['usuario_idUsuario'];
 
 $datosFacturaIniciada =  $objetoFactura->consultarFacturaIniciada($idUsuario);
 
 ?>
 
 <h5 class="center-align">Factura en curso (#<?php echo $datosFacturaIniciada[0]['numeroFactura'] ?>)</h5>
 
 <input type="hidden" id="idFacturaIniciada" name="idFacturaIniciada" value="<?php echo $datosFacturaIniciada[0]['idFactura'] ?>"  />
 
 <br>
 <br>
 
 <div class="row">
 	
 	<div class="col s12 m6 l6 input-field">
	    <select id="rFI_facturadorResolucion">
	      <option value="" disabled selected><?php echo $datosFacturaIniciada[0]['nombreFacturador']."/".$datosFacturaIniciada[0]['numeroResolucion']?></option>
	    </select>
	    <label>Faturador/Resolución</label>
 	</div><!-- Fin col -->
 	
 	
 	<div class="input-field col s12 m3 l3">
	  	<input disabled  id="rFI_factura_iva" value="<?php echo $datosFacturaIniciada[0]['iva'] ?>"  type="text" class="validate">
		<label id="rFI_label_factura_iva" for="rFI_factura_iva">% IVA</label>
	</div>
	  
	<div id="rFI_div_factura_metodoPago" class="input-field col s12 m3 l3">
	  	<select id="rFI_factura_metodoPago" name="rFI_factura_metodoPago">
	  		
	      <option value="" disabled>Elige una opción</option>
	      <option value="bono" 		<?php if($datosFacturaIniciada[0]['metodopago'] == "bono" ){?> selected <?php } ?> >Bono</option>
	      <option value="cheque" 	<?php if($datosFacturaIniciada[0]['metodopago'] == "cheque" ){?> selected <?php } ?> >Cheque</option>
	      <option value="efectivo"  <?php if($datosFacturaIniciada[0]['metodopago'] == "efectivo" ){?> selected <?php } ?> >Efectivo</option>
	      <option value="tdebito" 	<?php if($datosFacturaIniciada[0]['metodopago'] == "tdebito" ){?> selected <?php } ?> >Tarjeta debito</option>
	      <option value="tcredito"  <?php if($datosFacturaIniciada[0]['metodopago'] == "tcredito" ){?> selected <?php } ?> >Tarjeta crédito</option>
	      
	      		      
	    </select>
	    <label>Metodo de pago</label>
	</div>
 	
 </div><!-- Fin row-->
 
 
    <div class="row">
		
		<div class="input-field col s12 m4 l4">
			<input disabled id="rFI_factura_identificacionPropietario" name="rFI_factura_identificacionPropietario" value="<?php echo $datosFacturaIniciada[0]['identificacionPropietario'] ?>"  type="text" class="validate">
      		<label id="rFI_label_factura_identificacionPropietario" for="rFI_factura_identificacionPropietario">Identificación</label>
		</div>
		
		<div class="input-field col s12 m4 l4">
			<input disabled id="rFI_factura_nombrePropietario" name="rFI_factura_nombrePropietario" value="<?php echo $datosFacturaIniciada[0]['nombrePropietario'] ?>"  type="text" class="validate">
      		<label id="rFI_label_factura_nombrePropietario" for="rFI_factura_nombrePropietario">Nombre</label>
		</div>
		
		<div class="input-field col s12 m4 l4">
			<input disabled id="rFI_factura_apellidoPropietario" name="rFI_factura_apellidoPropietario" value="<?php echo $datosFacturaIniciada[0]['apellido'] ?>"  type="text" class="validate">
      		<label id="rFI_label_factura_apellidoPropietario" for="rFI_factura_apellidoPropietario">Apellido</label>
		</div>
		
	</div><!-- Fin row-->  
	
	
	<div class="row">
		
		<div class="input-field col s12 m12 l12">
			<textarea id="rFI_factura_observaciones" name="rFI_factura_observaciones" class="materialize-textarea" length="300" maxlength="300" ><?php echo $datosFacturaIniciada[0]['observaciones'] ?></textarea>
          	<label class="labelActivar" id="rFI_label_factura_observaciones" for="rFI_factura_observaciones">Observaciones</label>
		</div>
		
	</div><!-- Fin row-->
 
 
 <h5 class="center-align">Detalle</h5>
 
 <table class="bordered highlight">
	
 
 	<tbody>
 
<?php

 foreach ($datosFacturaIniciada as $datosFacturaIniciada1) {
     
	 if($datosFacturaIniciada1['tipoDetalle'] == "Producto"){
	 	//consultar el nombre del producto
	 	$nombreTipoDetalle = $objetoFactura->consultarNombreProducto($datosFacturaIniciada1['idTipoDetalle']);
		$bloquearCampoPrecio = "readonly";
		
	 }else if($datosFacturaIniciada1['tipoDetalle'] == "Servicio"){
	 	//consultar el nombre del servicio
	 	$nombreTipoDetalle = $objetoFactura->consultarNombreServicio($datosFacturaIniciada1['idTipoDetalle']);
		$bloquearCampoPrecio = "readonly";
	 }else{
	 	
	 	$nombreTipoDetalle = $datosFacturaIniciada1['tipoDetalle'];
	 	$bloquearCampoPrecio = "";
	 }

	 
?>
	
		
		<tr id="tr_facturaIniciada_<?php echo $datosFacturaIniciada1['idPagoFacturaCajaDetalle'] ?>" class="tr_facturaIniciada">		
			
			<th id="td_nombre" ><?php echo $nombreTipoDetalle?></th>
			
			<td>
				<div class="input-field">
					
					<input <?php echo $bloquearCampoPrecio ?> class="rFI_valorUnitario calculoTotalesFacturaIniciada" id="inputValorUnitario_<?php echo $datosFacturaIniciada1['idTipoDetalle'] ?>" type="text" class="validate" value="<?php echo $datosFacturaIniciada1['valorUnitario']?>" onkeypress="return soloNumerosPuntos(event)" maxlength="10" length="10">
          			<label class="labelActivar" for="inputValorUnitario_<?php echo $datosFacturaIniciada1['idTipoDetalle'] ?>">Valor unitario</label>

				</div>
			</td>
			
			<td>
				<div class="input-field">
					
					<input class="rFI_cantidad calculoTotalesFacturaIniciada" id="inputCantidad_<?php echo $datosFacturaIniciada1['idTipoDetalle'] ?>" type="text" class="validate" value="<?php echo $datosFacturaIniciada1['cantidad']?>" onkeypress="return soloNumerosPuntos(event)" maxlength="10" length="10">
          			<label class="labelActivar " for="inputCantidad_<?php echo $datosFacturaIniciada1['idTipoDetalle'] ?>">Cantidad</label>

				</div>
				
			</td>
			
			<td>
				<div class="input-field">
					
					<input class="rFI_descuento calculoTotalesFacturaIniciada" id="inputDescuento_<?php echo $datosFacturaIniciada1['idTipoDetalle'] ?>" type="text" class="validate" value="<?php echo $datosFacturaIniciada1['descuento']?>" onkeypress="return soloNumerosPuntos(event)" maxlength="10" length="10">
          			<label class="labelActivar " for="inputDescuento_<?php echo $datosFacturaIniciada1['idTipoDetalle'] ?>">Descuento</label>

				</div>
				
			</td>
			
			<td>
				<i style="cursor: pointer;" class="fa fa-trash fa-3x" aria-hidden="true" onclick="anularItem('<?php echo $datosFacturaIniciada1['idPagoFacturaCajaDetalle'] ?>')"></i>
			</td>
			
		</tr>
  				
	
	
<?php
	 
 }//fin foreach

?>

	</tbody>

</table>