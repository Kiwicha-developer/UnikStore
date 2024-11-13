<?php

namespace App\Http\Controllers;

use App\Services\PdfServiceInterface;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    protected $pdfService;

    public function __construct(PdfServiceInterface $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function generateSerialPdf($idDocumento)
    {
        $series = $this->pdfService->getSerialsPrint($idDocumento);
        $data = ['title' => 'Números de series',
                'series' => $series];
        $pdf = Pdf::loadView('pdf.series_pdf', $data);
        
        return $pdf->stream('series.pdf');
    }
}