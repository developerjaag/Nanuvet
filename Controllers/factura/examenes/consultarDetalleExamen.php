<?php

/*
 * Archivo para cansultar el detalle de una cirugia
 */
 
 
 require_once("../../../Config/config.php");
 require_once("../../../Models/factura_model.php");
 
 $objetoFactura = new factura(); 
 
 $idExamen = $_POST['idExamen'];
 
 
 $detalleExamen = $objetoFactura->consultarDetalleExamen($idExamen);
?>

<table id="tableListadoExamenes" class="highlight">

<?php

foreach ($detalleExamen as $detalleExamen1) {

?>

	<tr class="tr_detalleExamen" id="tr_<?php echo $detalleExamen1['idListadoExamen'] ?>">
		
		<input class="idListadoExamen" type="hidden" id="id_<?php echo $detalleExamen1['idListadoExamen']?> " value="<?php echo $detalleExamen1['idListadoExamen'] ?>">
		
		<td>
			Examen
		</td>
		
		<td>
			<div class="input-field">
					
					<input disabled id="nombreExamen_<?php echo $detalleExamen1['idListadoExamen'] ?>" type="text" class="validate" value="<?php echo $detalleExamen1['nombre']?>">
          			<label class="labelActivar" for="nombreExamen_<?php echo $detalleExamen1['idListadoExamen'] ?>">Nombre</label>

			</div>
		</td>
		
		<td>
			<div class="input-field">
					
					<input id="valorUnitario_<?php echo $detalleExamen1['idListadoExamen'] ?>" type="text" class="validate valorUnitarioExamen" value="<?php echo $detalleExamen1['precio']?>" onkeypress="return soloNumerosPuntos(event)" maxlength="10" length="10">
          			<label class="labelActivar" for="valorUnitario_<?php echo $detalleExamen1['idListadoExamen'] ?>">Valor unitario</label>

			</div>
		</td>
		
		<td>
			<div class="input-field">
					
					<input id="decuento_<?php echo $detalleExamen1['idListadoExamen'] ?>" type="text" class="validate descuentoExamen" value="0" onkeypress="return soloNumerosPuntos(event)" maxlength="10" length="10">
          			<label class="labelActivar" for="decuento_<?php echo $detalleExamen1['idListadoExamen'] ?>">Descuento</label>

			</div>
		</td>
		
	</tr>


<?php
	
}

?>

</table>

