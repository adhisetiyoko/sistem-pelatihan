<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'third_party/tcpdf/tcpdf.php';

class Pdf extends TCPDF {
    public function __construct() {
        parent::__construct();
    }
    
    public function createPDF($html, $filename, $download=TRUE) {
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Sistem Pelatihan');
        $pdf->SetTitle($filename);
        $pdf->SetSubject('Data Peserta');
        
        // Set default header data
        $pdf->SetHeaderData('', 0, 'Data Peserta Pelatihan', 'Dicetak pada: '.date('d F Y H:i'));
        
        // Set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // Set margins
        $pdf->SetMargins(15, 20, 15);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        
        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);
        
        // Add a page
        $pdf->AddPage();
        
        // Output HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // Close and output PDF document
        if($download) {
            $pdf->Output($filename.'.pdf', 'I');
        } else {
            $pdf->Output(FCPATH.'uploads/pdf/'.$filename.'.pdf', 'F');
            return 'uploads/pdf/'.$filename.'.pdf';
        }
    }
}