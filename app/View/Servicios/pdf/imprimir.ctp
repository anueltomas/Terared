<!--
<br>

	<h2>INVERSIONES TERARED C.A.</h2><strong>Fecha:</strong> <?php echo date('d/m/Y'); ?>
<center>
	<h1>Lista de Servicios</h1>
	
</center>


<br>

<div style="text-align:center;">

			<table border="1" style="margin: 0 auto">
				<thead>
					<tr>
					<th>N</th>
					<th>Nombre Servicio</th>
					<th>Precio</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($servicios as $servicio): ?>
					<tr>
						<td align="center"><?php echo h($servicio['Servicio']['id']); ?>&nbsp;</td>
						<td align="left"><?php echo h($servicio['Servicio']['nombreservicio']); ?>&nbsp;</td>
						<td><?php echo number_format($servicio['Servicio']['precio'], 2,",","."); ?> Bs.S</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

</div>

-->


<?php /*
App::import('Vendor','tcpdf/tcpdf'); 

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Nicola Asuni');

$pdf->SetAuthor('Tomas Anuel');

$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

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
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print

$data = array(
	'servicios' => array(
		'id' => '1',
		'nombreservicio' => 'prueba',
		'precio' => '200'
	)
);

$html=$html.'<div align="center">
			Reporte de usuarios registrados en la Base de Datos.
			<br /><br />			
			<table border="0" bordercolor="#0000CC" bordercolordark="#FF0000">';	
			$html=$html.'<table border="1" style="margin: 0 auto">
				<thead>
					<tr>
					<th>N</th>
					<th>Nombre Servicio</th>
					<th>Precio</th>
					</tr>
				</thead>
				<tbody> ';

			foreach ($servicios as $servicio){

				$html=$html.'<tr>';
				$html = $html.'<td>';
				$html = $html. h($servicio["servicio"]["id"]);
				$html = $html.'</td><td>';
				$html = $html. h($servicio["Servicio"]["nombreservicio"]);
				$html = $html.'</td><td>';
				$html = $html. number_format($servicio["Servicio"]["precio"], 2,",",".");
				$html = $html.'</td></tr>';	

			}			

			$html=$html.'</table></div>';			

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
ob_end_clean();
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+





//============================================================+
// File name   : example_011.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 011 for TCPDF class
//               Colored Table (very simple table)
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */



// Include the main TCPDF library (search for installation path).
App::import('Vendor', 'tcpdf/tcpdf');

// extend TCPF with custom functions
class MYPDF extends TCPDF {


	//Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logotera.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, ' Listado de Servicios '.date('d/m/Y'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Inversiones Terared C.A. >> Page'.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }


    // Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }

    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(10, 60, 10);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    //METODO PARA CREAR LOS DATOS QUE SE CARGARAN AL LA TABLA QUE LOS MOSTRARA EN EL PDF
    public function cargarDatos($servicios){

    	$html = '
<table border="1" style="margin: 0 auto" width="100%">
				<thead>
					<tr>
					<th width="50"><strong>N°</strong></th>
					<th width="500"><strong>Nombre Servicio</strong></th>
					<th width="100"><strong>Precio</strong></th>
					</tr>
				</thead>
				<tbody> ';

				
					foreach ($servicios as $servicio): 
$html .= '
					<tr>
						<td width="50"> ' . h($servicio["Servicio"]["id"]) .' </td>
						<td width="500"> ' . h($servicio["Servicio"]["nombreservicio"]) .' </td>
						<td width="100"> ' . number_format($servicio["Servicio"]["precio"], 2,",",".") .' Bs.</td>
					</tr>';
					endforeach;
$html .= '
				</tbody>
			</table>';

			return $html;


    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('Servicios');
$pdf->SetSubject('');
$pdf->SetKeywords('INVERSIONES TERARED, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('', '', PDF_HEADER_TITLE.' ', PDF_HEADER_STRING);

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
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

// column titles
//$header = array('N°', 'Nombre del Servicio', 'Precio');

// data loading
$data = $pdf->cargarDatos($servicios);
//$data = $pdf->LoadData('data/table_data_demo.txt');


// print colored table
//$pdf->ColoredTable($header, $data);
$pdf->writeHTML($data, true, 0, true, 0);

// ---------------------------------------------------------

// close and output PDF document
ob_end_clean();
$pdf->Output('Servicios.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+



