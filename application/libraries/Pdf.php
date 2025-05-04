<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'third_party/tcpdf/tcpdf.php';

class Pdf extends TCPDF {
    public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false) {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
        
        // Set document information
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('Sistem Pelatihan');
        
        // Set default header data
        $this->SetHeaderData('', 0, 'Data Peserta Pelatihan', 'Dicetak pada: '.date('d F Y H:i'));
        
        // Set header and footer fonts
        $this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // Set margins
        $this->SetMargins(15, 20, 15);
        $this->SetHeaderMargin(10);
        $this->SetFooterMargin(10);
        
        // Set auto page breaks
        $this->SetAutoPageBreak(TRUE, 15);
    }
    
    public function createPDF($html, $filename, $download=TRUE, $orientation='L') {
        // Set orientation before adding page
        $this->setPageOrientation($orientation);
        
        // Add a page
        $this->AddPage();
        
        // Output HTML content
        $this->writeHTML($html, true, false, true, false, '');
        
        // Close and output PDF document
        if($download) {
            $this->Output($filename.'.pdf', 'I');
        } else {
            $this->Output(FCPATH.'uploads/pdf/'.$filename.'.pdf', 'F');
            return 'uploads/pdf/'.$filename.'.pdf';
        }
    }
}