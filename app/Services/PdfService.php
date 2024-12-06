<?php
namespace App\Services;

use App\Repositories\AlmacenRepositoryInterface;
use App\Repositories\ComprobanteRepositoryInterface;
use App\Repositories\ProductoRepositoryInterface;
use Picqer\Barcode\BarcodeGeneratorPNG;

class PdfService implements PdfServiceInterface
{
    protected $comprobanteRepository;
    protected $productoRepository;
    protected $almacenRepository;
    protected $generadorSeries;

    public function __construct(ComprobanteRepositoryInterface $comprobanteRepository,
                                ProductoRepositoryInterface $productoRepository,
                                AlmacenRepositoryInterface $almacenRepository,
                                BarcodeGeneratorPNG $generadorSeries)
    {
        $this->comprobanteRepository = $comprobanteRepository;
        $this->productoRepository =  $productoRepository;
        $this->almacenRepository = $almacenRepository;
        $this->generadorSeries = $generadorSeries;
    }
    
    public function getSerialsPrint($idComprobante){
        $registros = $this->comprobanteRepository->getAllRegistrosByComprobanteId($idComprobante);
        $registrosFiltrados = $registros->filter(function($register) {
            return strpos($register->numeroSerie, 'UNK-') !== false;
        });

        $series = array();

        foreach($registrosFiltrados as $reg){
            $barcode = $this->generadorSeries->getBarcode($reg->numeroSerie, BarcodeGeneratorPNG::TYPE_CODE_128,1);
            $series[] = ['serie' => $reg->numeroSerie,'barcode' => base64_encode($barcode)];
        }
        return $series;
    }

    public function getReportsAlmacen(){
        return $this->productoRepository->getProductsWithStock()->sortBy('codigoProducto');
    }

    public function getAlmacenes(){
        return $this->almacenRepository->all()->sortBy('idAlmacen');
    }
    
}