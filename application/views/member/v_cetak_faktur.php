<?php
header('Content-type: application/pdf');
header('Content-Disposition: inline');
date_default_timezone_set('Asia/Jakarta');
$pdf_path = realpath(APPPATH . '../pdf_cache/');
$this->fpdf->AddPage();
$this->fpdf->SetFont('Arial','B',24);
$this->fpdf->Cell(50,18,'OMAHIKLAN.COM',0,1,'L');
$this->fpdf->SetFont('Arial','B',15);
$this->fpdf->Cell(50,0.7,'Tagihan #'.$data_premium->ticket,0,1,'L');
$this->fpdf->Output($pdf_path.'/'.$data_premium->ticket.'.pdf','F');
//$this->fpdf->Output($data_premium->ticket.'.pdf','I');
@readfile($pdf_path.'/'.$data_premium->ticket.'.pdf');
//echo $pdf_path.'ok.pdf';