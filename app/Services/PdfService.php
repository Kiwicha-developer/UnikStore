<?php
namespace App\Services;

use App\Repositories\ComprobanteRepositoryInterface;
use App\Repositories\RegistroProductoRepositoryInterface;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorPNG;

class PdfService implements PdfServiceInterface
{
    protected $comprobanteRepository;

    public function __construct(ComprobanteRepositoryInterface $comprobanteRepository,
                                )
    {
        $this->comprobanteRepository = $comprobanteRepository;
    }
    
    public function getSerialsPrint($idComprobante){
        $generador = new BarcodeGeneratorPNG();
        $registros = $this->comprobanteRepository->getAllRegistrosByComprobanteId($idComprobante);
        $registrosFiltrados = $registros->filter(function($register) {
            return strpos($register->numeroSerie, 'UNK-') !== false;
        });

        $series = array();

        foreach($registrosFiltrados as $reg){
            $barcode = $generador->getBarcode($reg->numeroSerie, BarcodeGeneratorPNG::TYPE_CODE_128);
            $series[] = ['serie' => $reg->numeroSerie,'barcode' => base64_encode($barcode)];
        }
        return $series;
    }
    
}