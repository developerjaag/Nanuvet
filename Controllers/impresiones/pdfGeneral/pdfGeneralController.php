<?php


/*
 * Controlador para la impresion de una formula
 */
 
 	if(!isset($_SESSION)){
		    session_start();
		}
 
 ob_start();
 
 
 //se importa el archivo de la libreria que genera el pdf
 if(is_file("../../../libs/TCPDF-master/tcpdf.php")){
 	require_once("../../../libs/TCPDF-master/tcpdf.php");
 }else{
 	require_once("libs/TCPDF-master/tcpdf.php");
 }
 
 if(is_file("../../../Config/config.php")){
 	require_once("../../../Config/config.php");
 }else{
 	require_once("Config/config.php");
 } 
 
 //se consulta la información de la cuenta y la sucursal para mostrar el encabezado
 if(is_file("../../../Models/cuenta_model.php")){
 	require_once("../../../Models/cuenta_model.php");
 }else{
 	require_once("Models/cuenta_model.php");
 }
 
 
 $objetoCuenta	= new cuenta(); 
 $datosCuenta	= $objetoCuenta->consultarInformacionCuenta();
 

 
 
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
				
				
					$imgtype = TCPDF_IMAGES::getImageFileType('http://www.nanuvet.com/Public/uploads/'.$_SESSION['BDC_carpeta'].'/logoClinica/'.$this->header_urlLogo);
					if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
						$this->ImageEps('http://www.nanuvet.com/Public/uploads/'.$_SESSION['BDC_carpeta'].'/logoClinica/'.$this->header_urlLogo, '', '', $headerdata['logo_width']);
					} elseif ($imgtype == 'svg') {
						$this->ImageSVG('http://www.nanuvet.com/Public/uploads/'.$_SESSION['BDC_carpeta'].'/logoClinica/'.$this->header_urlLogo, '', '', $headerdata['logo_width']);
					} else {
						$this->Image('http://www.nanuvet.com/Public/uploads/'.$_SESSION['BDC_carpeta'].'/logoClinica/'.$this->header_urlLogo, '', '', '20','20');
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
$pdf->SetTitle('NanuVet');
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

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = $_POST['envioFormPdf'];		
		
	

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


//Close and output PDF document
$pdf->Output('NanuVet.pdf', 'I');

?>
