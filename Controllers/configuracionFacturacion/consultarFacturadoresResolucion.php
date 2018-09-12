<?php

/*
 * Archivo para consultar la relacion de una resolucion con facturadores
 */

  
 	require_once ("../../Config/config.php");
	require_once ("../../Models/configuracionFacturacion_model.php");
	
	$objetoConfiguracion = new configuracionFacturacion();
	
	
	$idResolucion = $_POST['idResolucion'];
	
	$facturadoresSelect = $objetoConfiguracion->consultarFacturadoresSelect();
	
	$listadoFacturadoresDeResolucion = $objetoConfiguracion->consultarFacturadoresResolucion($idResolucion);
	
	$lang_configuracionFacturacion	= array();
	
   switch($_SESSION['usuario_idioma']){
        
        case 'Es':
				
				$txt1 	= "Elige una opción";
				$txt2 	= "Facturadores";	
				$txt3 	= "Vincular";
				$txt4	= "El vínculo ya existe!";
				$txt5   = "Desactivar vínculo";
				$txt6	= "Activar vínculo";
				$txt7	= "Identificación";
				$txt8	= "Nombre";
				$txt9	= "Apellido";
				$txt10	= "Régimen";
				$txt11	= "Razón social";
				$txt12	= "Iden. emisor";
				$txt13	= "Nombre emisor";
				
    		break;
    		
    	case 'En':

				$txt1 	= "Choose an option";
				$txt2 	= "Billers";	
				$txt3 	= "Link";
				$txt4	= "The link already exists!";
				$txt5   = "Disable link";
				$txt6	= "Enable link";
				$txt7	= "identification";
				$txt8	= "Name";
				$txt9	= "Last name";
				$txt10	= "Regime";
				$txt11	= "Business name";
				$txt12	= "Iden. transmitter";
				$txt13	= "Issuer name";

    		break;
        
    }//fin swtich
 
?>


     <div class="row">
     	
      	 <input type="hidden" id="modal_idResolucion" name="modal_idResolucion" value="<?php echo $idResolucion ?>" />
      	 
      	 <div class="input-field col s10" id="div_selectFacturadoresActivos">
		    <select id="selectFacturadoresActivos" name="selectFacturadoresActivos">
		      <option value="" disabled selected><?php echo $txt1//Elige una opción?></option>
		      <?php
		      	foreach ($facturadoresSelect as $facturadoresSelect1) {
				?>
					<option value="<?php echo $facturadoresSelect1['idFacturador'] ?>"><?php echo "(".$facturadoresSelect1['identificacion'].") ".$facturadoresSelect1['nombre']." ".$facturadoresSelect1['apellido']?></option>
				<?php	  
				  }
		      ?>
		      
		    </select>
		    <label><?php echo $txt2//Facturadores?></label>
		  </div>
		  
		  <div class="input-field col s2">
		  	<a class="waves-effect waves-light btn" onclick="vincularFacturadorResolucion()" ><?php echo $txt3//Vincular?></a>
		  </div>
		  
		  <div class="col s12">
		  	<span id="errorVinculo" class="red-text center-align" style="display: none;"><?php echo $txt4 //El vinculo ya existe!?></span>
		  </div>
		  
      </div><!-- Fin row-->
      
      <span id="spanDesactivarVinculo" style="display: none;"><?php echo $txt5//Desactivar vinculo?></span>
      <span id="spanActivarVinculo" style="display: none;"><?php echo $txt6//Activar vinculo?></span>

<table>
	<thead>
		<tr>
			<th><?php echo $txt7//Identificación?></th>
			<th><?php echo $txt8//Nombre?></th>
			<th><?php echo $txt9//Apellido?></th>
			<th><?php echo $txt10//Régimen?></th>
			<th><?php echo $txt11//Razón social?></th>
			<th><?php echo $txt12//Iden. emisor?></th>
			<th><?php echo $txt13//Nombre emisor?></th>
			<th></th>
		</tr>
	</thead>
	
	<tbody>
		
		<?php
			foreach ($listadoFacturadoresDeResolucion as $listadoFacturadoresDeResolucion1) {
				
				if($listadoFacturadoresDeResolucion1['estado'] == "A"){
					$btn = '<span id="spanVFR_'.$listadoFacturadoresDeResolucion1['idFacturadoresResolucionDian'].'"> <a id="'.$listadoFacturadoresDeResolucion1['idFacturadoresResolucionDian'].'" class="waves-effect waves-light btn tooltipped" onclick="desactivarVinculoFacuradorResolucion(this.id)"  data-position="bottom" data-delay="50" data-tooltip="'.$txt5.'" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
				}else{
					$btn = '<span id="spanVFR_'.$listadoFacturadoresDeResolucion1['idFacturadoresResolucionDian'].'"> <a id="'.$listadoFacturadoresDeResolucion1['idFacturadoresResolucionDian'].'" class="waves-effect red darken-1 btn tooltipped" onclick="activarVinculoFacuradorResolucion(this.id)" data-position="bottom" data-delay="50" data-tooltip="'.$txt6.'"><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a></span>';
				}
				
		?>
		
			<tr>
				
				<td><?php echo $listadoFacturadoresDeResolucion1['identificacion']?></td>
				<td><?php echo $listadoFacturadoresDeResolucion1['nombre']?></td>
				<td><?php echo $listadoFacturadoresDeResolucion1['apellido']?></td>
				<td><?php echo $listadoFacturadoresDeResolucion1['tipoRegimen']?></td>
				<td><?php echo $listadoFacturadoresDeResolucion1['razonSocial']?></td>
				<td><?php echo $listadoFacturadoresDeResolucion1['identificacionEmisor']?></td>
				<td><?php echo $listadoFacturadoresDeResolucion1['nombreEmisor']?></td>
				<td><?php echo $btn?></td>
				
			</tr>
		
		<?php		
			}
		?>
		
	</tbody>
	
</table>

