<?php

/*
 * Archivo para cansultar el detalle de una cirugia
 */
 
 
 require_once("../../../Config/config.php");
 require_once("../../../Models/factura_model.php");
 
 $objetoFactura = new factura(); 
 
 $idCirugia = $_POST['idCirugia'];
 
 
 $detalleCirugia = $objetoFactura->consultarDetalleCirugia($idCirugia);
?>

<table id="tableListadoCirugias" class="highlight">

<?php

foreach ($detalleCirugia as $detalleCirugia1) {

?>

	<tr class="tr_detalleCirugia" id="tr_<?php echo $detalleCirugia1['idPanelCirugiaDiagnostico'] ?>">
		
		<input class="idPanelCirugiaDiagnostico" type="hidden" id="id_<?php echo $detalleCirugia1['idPanelCirugiaDiagnostico']?> " value="<?php echo $detalleCirugia1['idPanelCirugiaDiagnostico'] ?>">
		
		<td>
			Cirugía
		</td>
		
		<td>
			<div class="input-field">
					
					<input disabled id="nombreCirugia_<?php echo $detalleCirugia1['idPanelCirugiaDiagnostico'] ?>" type="text" class="validate" value="<?php echo $detalleCirugia1['nombre']?>">
          			<label class="labelActivar" for="nombreCirugia_<?php echo $detalleCirugia1['idPanelCirugiaDiagnostico'] ?>">Nombre</label>

			</div>
		</td>
		
		<td>
			<div class="input-field">
					
					<input id="valorUnitario_<?php echo $detalleCirugia1['idPanelCirugiaDiagnostico'] ?>" type="text" class="validate valorUnitarioCirugia" value="<?php echo $detalleCirugia1['precio']?>" onkeypress="return soloNumerosPuntos(event)" maxlength="10" length="10">
          			<label class="labelActivar" for="valorUnitario_<?php echo $detalleCirugia1['idPanelCirugiaDiagnostico'] ?>">Valor unitario</label>

			</div>
		</td>
		
		<td>
			<div class="input-field">
					
					<input id="decuento_<?php echo $detalleCirugia1['idPanelCirugiaDiagnostico'] ?>" type="text" class="validate descuentoCirugia" value="0" onkeypress="return soloNumerosPuntos(event)" maxlength="10" length="10">
          			<label class="labelActivar" for="decuento_<?php echo $detalleCirugia1['idPanelCirugiaDiagnostico'] ?>">Descuento</label>

			</div>
		</td>
		
	</tr>


<?php
	
}

?>

</table>

