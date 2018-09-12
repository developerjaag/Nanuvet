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
class MYPDF extends TCPDF {

	 public $header_identificativoNit;
	 public $header_nombre;
	 public $header_telefono1;
	 public $header_telefono2;
	 public $header_celular;
	 public $header_direccion;
	 public $header_email;
	 public $header_urlLogo;

	///inicializar variables
	public function setDataHeader($header_identificativoNit, $header_nombre, $header_telefono1, $header_telefono2, $header_celular, $header_direccion, 
									$header_email, $header_urlLogo){
										
    	$this->header_identificativoNit = $header_identificativoNit;
		$this->header_nombre 			= $header_nombre;
		$this->header_telefono1 		= $header_telefono1;
		$this->header_telefono2 		= $header_telefono2;
		$this->header_celular 			= $header_celular;
		$this->header_direccion 		= $header_direccion;
		$this->header_email 			= $header_email;
		$this->header_urlLogo 			= $header_urlLogo;
    }


    //Page header
    public function Header() {   	
		
        if ($this->header_xobjid === false) {
			// start a new XObject Template
			$this->header_xobjid = $this->startTemplate($this->w, $this->tMargin);
			$headerfont = $this->getHeaderFont();
			$headerdata = $this->getHeaderData();
			$this->y = $this->header_margin;
			if ($this->rtl) {
				$this->x = $this->w - $this->original_rMargin;
			} else {
				$this->x = $this->original_lMargin;
			}

			
			//saber si existe una imagen
			if($this->header_urlLogo != ""){
				
				
					$imgtype = TCPDF_IMAGES::getImageFileType('Public/uploads/'.$_SESSION['BDC_carpeta'].'/logoClinica/'.$this->header_urlLogo);
					if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
						$this->ImageEps('Public/uploads/'.$_SESSION['BDC_carpeta'].'/logoClinica/'.$this->header_urlLogo, '', '', $headerdata['logo_width']);
					} elseif ($imgtype == 'svg') {
						$this->ImageSVG('Public/uploads/'.$_SESSION['BDC_carpeta'].'/logoClinica/'.$this->header_urlLogo, '', '', $headerdata['logo_width']);
					} else {
						$this->Image('Public/uploads/'.$_SESSION['BDC_carpeta'].'/logoClinica/'.$this->header_urlLogo, '', '', '20','20');
					}
					$imgy = $this->getImageRBY();
				
				
				
			}else{
				$imgy = $this->y;
			}//fin if para saber si se muestra un logo
			
			 
			
			$cell_height = $this->getCellHeight($headerfont[2] / $this->k);
			// set starting margin for text data cell
			if ($this->getRTL()) {
				$header_x = $this->original_rMargin + ($headerdata['logo_width'] * 1.1);
			} else {
				$header_x = $this->original_lMargin + ($headerdata['logo_width'] * 1.1);
			}
			$cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($headerdata['logo_width'] * 1.1);
			$this->SetTextColorArray($this->header_text_color);
			
			// header title
			$this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
			$this->SetX($header_x);
			$this->Cell($cw, $cell_height, $this->header_nombre, 0, 1, '', 0, '', 0);
			// header string
			$this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
			$this->SetX($header_x);
			$this->MultiCell($cw, $cell_height, $this->header_telefono1.' - '.$this->header_telefono2.' - '.$this->header_celular   , 0, '', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
			
			$this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
			$this->SetX($header_x);
			$this->MultiCell($cw, $cell_height, $this->header_direccion , 0, '', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
			
			$this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
			$this->SetX($header_x);
			$this->MultiCell($cw, $cell_height, $this->header_email , 0, '', 0, 1, '', '', true, 0, false, true, 0, 'T', false);

			
			// print an ending header line
			$this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
			$this->SetY((2.835 / $this->k) + max($imgy, $this->y));
			if ($this->rtl) {
				$this->SetX($this->original_rMargin);
			} else {
				$this->SetX($this->original_lMargin);
			}
			$this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
			$this->endTemplate();
		}
		// print header template
		$x = 0;
		$dx = 0;
		if (!$this->header_xobj_autoreset AND $this->booklet AND (($this->page % 2) == 0)) {
			// adjust margins for booklet mode
			$dx = ($this->original_lMargin - $this->original_rMargin);
		}
		if ($this->rtl) {
			$x = $this->w + $dx;
		} else {
			$x = 0 + $dx;
		}
		$this->printTemplate($this->header_xobjid, $x, 0, 0, 0, '', '', false);
		if ($this->header_xobj_autoreset) {
			// reset header xobject template at each page
			$this->header_xobjid = false;
		}
    }//fin metodo header
    
    //page footer
    public function footer(){
    	$cur_y = $this->y;
		$this->SetTextColorArray($this->footer_text_color);
		//set style for cell border
		$line_width = (0.85 / $this->k);
		$this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));
		//print document barcode
		$barcode = $this->getBarcode();
		if (!empty($barcode)) {
			$this->Ln($line_width);
			$barcode_width = round(($this->w - $this->original_lMargin - $this->original_rMargin) / 3);
			$style = array(
				'position' => $this->rtl?'R':'L',
				'align' => $this->rtl?'R':'L',
				'stretch' => false,
				'fitwidth' => true,
				'cellfitalign' => '',
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(0,0,0),
				'bgcolor' => false,
				'text' => false
			);
			$this->write1DBarcode($barcode, 'C128', '', $cur_y + $line_width, '', (($this->footer_margin / 3) - $line_width), 0.3, $style, '');
		}
		$w_page = isset($this->l['w_page']) ? $this->l['w_page'].' ' : '';
		if (empty($this->pagegroups)) {
			$pagenumtxt = $w_page.$this->getAliasNumPage().' / '.$this->getAliasNbPages();
		} else {
			$pagenumtxt = $w_page.$this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias();
		}
		$this->SetY($cur_y);
		//Print page number
		if ($this->getRTL()) {
			$this->SetX($this->original_rMargin);
			$this->Cell(0, 0, $pagenumtxt, 'T', 0, 'L');
			
			$this->SetX($this->original_rMargin);
			$this->Cell(0, 0, $pagenumtxt, 'T', 0, 'L');
		} else {
			$this->SetX($this->original_lMargin);
			$this->Cell(0, 0, $this->getAliasRightShift().$pagenumtxt, 'T', 0, 'R');
			
			$this->SetX($this->original_rMargin);
			$this->Cell(17, 0, $this->getAliasRightShift().'www.nanuvet.com', 'T', 0, 'R');
		}
		

    } //fin metodo footer 


}//fin clase para personalizar el header y el footer
 

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setDataHeader($datosCuenta['identificativoNit'], $datosCuenta['nombre'], $datosCuenta['telefono1'], $datosCuenta['telefono2'], $datosCuenta['celular'], $datosCuenta['direccion'], $datosCuenta['email'], $datosCuenta['urlLogo']);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NanuVet');
$pdf->SetTitle('NanuVet::Factura '.$idFactura);
$pdf->SetSubject('NanuVet');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

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