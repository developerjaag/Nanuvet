<?php

/*
 * Archivo para imprimir una factura
 */

  
 	if(!isset($_SESSION)){
		    session_start();
		}
 
 ob_start();
 
 $idFactura = $_GET['id2'];
 
 //se importa el archivo de la libreria que genera el pdf
 require_once("libs/TCPDF-master/tcpdf.php");
 
 
 //se consulta la información de la cuenta y la sucursal para mostrar el encabezado
 require_once("Models/cuenta_model.php");
 
 $objetoCuenta	= new cuenta(); 
 $datosCuenta	= $objetoCuenta->consultarInformacionCuenta();
 
 //se consulta la información de la factura
 require_once("Models/factura_model.php");
 
 $objetofacturas	= new factura(); 
 
 //aumentar el número de impresiones de la factura
 //$objetofacturas->aumentarNumeroImpresion($idFactura);
 
 $datosFactura	= $objetofacturas->listarUnaFactura($idFactura);	
 
 //consultar el detalle de una factura
 $detalleFactura = $objetofacturas->consultarDetalleFacturaImprimir($datosFactura[0]['idPagoFacturaCaja'], $datosFactura[0]['estado']);
 
 
 // Extend the TCPDF class to create custom Header and Footer

 

// create new PDF document
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF('P', 'mm', array('250', 80), true, 'UTF-8', false);

//$pdf->setDataHeader($datosCuenta['identificativoNit'], $datosCuenta['nombre'], $datosCuenta['telefono1'], $datosCuenta['telefono2'], $datosCuenta['celular'], $datosCuenta['direccion'], $datosCuenta['email'], $datosCuenta['urlLogo']);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NanuVet');
$pdf->SetTitle('NanuVet::Factura '.$idFactura);
$pdf->SetSubject('NanuVet');


// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
/*if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}*/

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();


$html = '

<div>
	'.$datosCuenta['nombre'].'
</div>

<table>
	<tr>
		<td style="font-size: 9px; " >Fecha resolución: &nbsp; '.$datosFactura[0]['fechaResolucion'].' </td>
		<td style="font-size: 9px; " >Resolución: &nbsp; '.$datosFactura[0]['numeroResolucion'].'</td>
		<td style="font-size: 9px;" >Expedida: &nbsp; '.$datosFactura[0]['fechaFin'].' '.$datosFactura[0]['horaFin'].'</td>
		
		<th style="text-align: right; ">Factura N°: &nbsp;&nbsp; <b>'.$datosFactura[0]['numeroFactura'].'</b></th>
	</tr>
</table>

<br/>

<div>
	<table>
		<tr>
			<td>Identificación:</td>
			<td>'.$datosFactura[0]['identifiacacionPropietario'].'</td>
			<td>Nombres y apellidos:</td>
			<td>'.$datosFactura[0]['nombrePropietario'].' '.$datosFactura[0]['apellidoPropietario'].'</td>
		</tr>
		<br />
		<tr>		
			<td>Teléfono:</td>
			<td>'.$datosFactura[0]['telefono'].'</td>
			<td>Dirección:</td>
			<td>'.$datosFactura[0]['direccion'].'</td>
		</tr>
		
	</table>
	
</div>
<hr />

	<div></div>
	<div></div>
	<div></div>

<div>
	<table style="border-collapse:collapse; ">
		<tr>
			<th style="border:1px solid black;" ><b>Código</b></th>
			<th style="border:1px solid black;" ><b>Nombre</b></th>
			<th style="border:1px solid black;" ><b>V. Unitario</b></th>
			<th style="border:1px solid black;" ><b>Cantidad</b></th>
			<th style="border:1px solid black;" ><b>Descuento</b></th>
		</tr>
';		
		
foreach ($detalleFactura as $detalleFactura1) {
	
	if($detalleFactura1['tipoDetalle'] == "Cirugia"){
		
		//se consulta el nombre con los subiDs
		$respuesta = $objetofacturas->consultarNombreCirugia($detalleFactura1['idTipoSubDetalle']);
		$nombre = $respuesta[0]['nombre'];
		$codigo = $respuesta[0]['codigo'];
		
	}else if($detalleFactura1['tipoDetalle'] == "Examen"){
		//se consulta el nombre con los subiDs
		$respuesta = $objetofacturas->consultarNombreExamen($detalleFactura1['idTipoSubDetalle']);
		$nombre = $respuesta[0]['nombre'];
		$codigo = $respuesta[0]['codigo'];
		
	}else if($detalleFactura1['tipoDetalle'] == "Producto"){
		//se consulta el nombre con los subiDs
		$respuesta = $objetofacturas->consultarNombreProductoImpresion($detalleFactura1['idTipoDetalle']);
		$nombre = $respuesta[0]['nombre'];
		$codigo = $respuesta[0]['codigo'];
		
	}else if ($detalleFactura1['tipoDetalle'] == "Servicio"){
		//se consulta el nombre con los subiDs
		$respuesta = $objetofacturas->consultarNombreServicioImpresion($detalleFactura1['idTipoDetalle']);
		$nombre = $respuesta[0]['nombre'];
		$codigo = $respuesta[0]['codigo'];
	}else{
		$nombre = $detalleFactura1['tipoDetalle'];
		$codigo = "";
	}
	
	$html .= '
		<tr>
			<td style="border:1px solid black;" >'.$codigo.'</td>
			<td style="border:1px solid black;" >'.$nombre.'</td>
			<td style="border:1px solid black;" >'.$detalleFactura1['valorUnitario'].'</td>
			<td style="border:1px solid black;" >'.$detalleFactura1['cantidad'].'</td>
			<td style="border:1px solid black;" >'.$detalleFactura1['descuento'].'</td>
		</tr>	
	';
	
	
}//fin foreach		
		
		
$html .= '		
	</table>

</div>

<h3>Observaciones:</h3>
	<div>
		'.$datosFactura[0]['observaciones'].' 
	</div>
	
<div></div>
<hr />
<div></div>
<table>
	<tr>
		<td style="text-align: left; font-size: 9px;" >Medio de pago: &nbsp; '.$datosFactura[0]['metodopago'].'</td>
	</tr>
</table>
<table style="border-collapse:collapse; ">

	<tr>
		<td>SubTotal: &nbsp; '.$datosFactura[0]['subtotal'].' </td>
		<td>IVA: &nbsp; '.$datosFactura[0]['valorIva'].'  </td>
		<td>Descuento: &nbsp; '.$datosFactura[0]['descuento'].'</td>
		<td style="border:1px solid black; text-align: center;"  >Total: &nbsp; <b>'.$datosFactura[0]['total'].'</b> </td>
	</tr>
</table>	
	
	';




// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');





    $table = '<table style="border:1px solid black;">
    <tr>
        <td width="33.3%" style="border:1px solid black;">
            <table>
                <tr>
                	<td colspan="2"><b>Emisor de la factura</b></td>
                </tr>
                <br />
                <tr>
                	<td>Firma:</td>
                	<td></td>
                </tr>
                <br />
                <tr>
                	<td>Nombre:</td>
                	<td>'.$datosFactura[0]['nombre'].' '.$datosFactura[0]['apellido'].' </td>
                </tr>
                <br />
                <tr>
                	<td>Identificación:</td>
                	<td>'.$datosFactura[0]['identificacion'].'</td>
                </tr>
            </table>
        </td>
        <td width="33.3%" style="border:1px solid black;">
            <table>
                <tr>
                	<td colspan="2"><b>Recibo a conformidad</b></td>
                </tr>
                <br />
                <tr>
                	<td>Fecha:</td>
                	<td></td>
                </tr>
                <br />
                <tr>
                	<td>Firma:</td>
                	<td></td>
                </tr>
                <br />
                <tr>
                	<td>Nombre:</td>
                	<td></td>
                </tr>
                <br />
                <tr>
                	<td>Identificación:</td>
                	<td></td>
                </tr>
            </table>
        </td>
        <td width="33.3%" style="border:1px solid black;">
            <table>
                <tr>
                	<td colspan="2"><b>Aceptación de la factura</b></td>
                </tr>
                <br />
                <tr>
                	<td>Firma:</td>
                	<td></td>
                </tr>
                <br />
                <tr>
                	<td>Nombre:</td>
                	<td></td>
                </tr>
                <br />
                <tr>
                	<td>Identificación:</td>
                	<td></td>
                </tr>
            </table>
        </td>
    </tr>
    </table>';

    $html = <<<EOD
    $table
EOD;

  $pdf -> SetY(222);

    $pdf -> writeHTML($html, true, false, false, false, '');

    $pdf -> SetY(200);
    $pdf -> SetX(3);


//Close and output PDF document
$pdf->Output('NanuVet factura '.$idFactura.'.pdf', 'I');

?> 
 

?>