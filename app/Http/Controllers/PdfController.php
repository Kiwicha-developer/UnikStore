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
        $almacenes = $this->pdfService->getAlmacenes();
        $fechaActual = Carbon::now()->format('d-m-Y');
        $data = ['title' => 'Reporte de stock '.$fechaActual,
                'productos' => $productos,
                'almacenes' => $almacenes];
        $pdf = Pdf::loadView('pdf.stock_pdf', $data);
        
        return $pdf->stream('reporte_stock_'.$fechaActual.'.pdf');
    }

    public function seriesByProductPdf($idProducto)
    {
        $producto = $this->pdfService->getOneProduct($idProducto);
        $registros = $this->pdfService->getSerialsByProduct($idProducto);

        $data = ['title' => 'Series en existencia',
                'producto' => $producto,
                'registros' => $registros];
        $pdf = Pdf::loadView('pdf.series_by_products', $data);
        
        return $pdf->stream('Series_disponibles_'.$producto->codigoProducto.'.pdf');
    }

    public function garantiaPdf($idGarantia)
    {
        $garantia = $this->pdfService->getOneGarantia($idGarantia);

        $cabRel = 'storage/cabecera_garantia.jpg';
        $cabUrl = $this->getBase64Image($cabRel,'jpg');

        $firmaRel = 'storage/firmaflor.png';
        $firmaUrl = $this->getBase64Image($firmaRel,'png'); 

        $data = ['title' => 'Registro Producto Garantía',
                'garantia' => $garantia,
                'cabecera' => $cabUrl,
                'firma' => $firmaUrl];
        $pdf = Pdf::loadView('pdf.garantia_pdf', $data);
        return $pdf->stream('Garantia_Registro_'.(1000000 + $garantia->idGarantia).'.pdf');
    }

    private function getBase64Image($pathRel,$type){
        $pathCab = public_path($pathRel);
        $imgCab = base64_encode(file_get_contents($pathCab));
        return 'data:image/'.$type.';base64,' . $imgCab;
    }
}