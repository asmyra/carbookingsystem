<?php

// This PHP code generates a yearly and monthly report of vehicle usage in a company in PDF format.

// Import the necessary libraries.
require_once('vendor/autoload.php');

// Create a new PDF document.
$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set the document information.
$pdf->SetCreator('Majlis Daerah Kota Tinggi');
$pdf->SetAuthor('John Doe');
$pdf->SetTitle('Laporan Tempahan Kenderaan');
$pdf->SetSubject('This report shows the yearly and monthly usage of vehicles in the company.');

// Set the header and footer.
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Vehicle Usage Report', 'Generated on ' . date('Y-m-d'));
$pdf->SetFooterData(array(0, 0, 0), array(0, 0, 0), 'Page ' . $pdf->getPageNo() . '/' . $pdf->getPages());

// Add some content to the document.
$pdf->AddPage();
$pdf->Write(5, 'This report shows the yearly and monthly usage of vehicles in the company.');
$pdf->Write(5, 'The following table shows the yearly usage of vehicles in the company:');
$pdf->WriteTable(array(
  'Year', 'Total Miles Driven', 'Average Miles Driven per Month'
), $data);
$pdf->Write(5, 'The following table shows the monthly usage of vehicles in the company:');
$pdf->WriteTable(array(
  'Month', 'Total Miles Driven', 'Average Miles Driven per Day'
), $data);

// Close the document.
$pdf->Output('Laporan_TempahanKenderaan.pdf', 'I');

?>
