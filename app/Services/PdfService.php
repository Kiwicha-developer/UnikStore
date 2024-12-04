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

    public function __construct(ComprobanteRepositoryInterface $comprobanteRepository,
                                ProductoRepositoryInterface $productoRepository,
                                AlmacenRepositoryInterface $almacenRepository)
    {
        $this->comprobanteRepository = $comprobanteRepository;
        $this->productoRepository =  $productoRepository;
        $this->almacenRepository = $almacenRepository;
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

    public function getReportsAlmacen(){
        return $this->productoRepository->getProductsWithStock()->sortBy('codigoProducto');
    }

    public function getAlmacenes(){
        return $this->almacenRepository->all()->sortBy('idAlmacen');
    }
    
}