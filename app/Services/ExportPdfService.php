<?php
namespace App\Services;

use TCPDF;

class ExportPdfService
{
    public function __construct()
    {
        //$this->pdf = new TCPDF();
    }
    public function export_orders()
    {
        $pdf = new TCPDF();

    }

}