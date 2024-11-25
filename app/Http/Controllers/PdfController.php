<?php

namespace App\Http\Controllers;

use App\Services\PdfServiceInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

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

    public function reportStockPdf()
    {
        $productos = $this->pdfService->getReportsAlmacen();
        $fechaActual = Carbon::now()->format('d-m-Y');
        $data = ['title' => 'Reporte de stock '.$fechaActual,
                'productos' => $productos];
        $pdf = Pdf::loadView('pdf.stock_pdf', $data);
        
        return $pdf->stream('reporte_stock_'.$fechaActual.'.pdf');
    }
}