<?php
namespace App\Services;

use App\Repositories\AlmacenRepositoryInterface;
use App\Repositories\ComprobanteRepositoryInterface;
use App\Repositories\ProductoRepositoryInterface;
use App\Repositories\RegistroProductoRepositoryInterface;
use Picqer\Barcode\BarcodeGeneratorPNG;

class PdfService implements PdfServiceInterface
{
    protected $comprobanteRepository;
    protected $productoRepository;
    protected $almacenRepository;
    protected $generadorSeries;
    protected $registroRepository;

    public function __construct(ComprobanteRepositoryInterface $comprobanteRepository,
                                ProductoRepositoryInterface $productoRepository,
                                AlmacenRepositoryInterface $almacenRepository,
                                BarcodeGeneratorPNG $generadorSeries,
                                RegistroProductoRepositoryInterface $registroRepository)
    {
        $this->comprobanteRepository = $comprobanteRepository;
        $this->productoRepository =  $productoRepository;
        $this->almacenRepository = $almacenRepository;
        $this->generadorSeries = $generadorSeries;
        $this->registroRepository = $registroRepository;
    }
    
    public function getSerialsPrint($idComprobante){
        $registros = $this->comprobanteRepository->getAllRegistrosByComprobanteId($idComprobante);
        $registrosFiltrados = $registros->filter(function($register) {
            return strpos($register->numeroSerie, 'UNK-') !== false;
        });

        $series = array();

        foreach($registrosFiltrados as $reg){
            $barcode = $this->generadorSeries->getBarcode($reg->numeroSerie, BarcodeGeneratorPNG::TYPE_CODE_128,1,50);
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
    
    public function getSerialsByProduct($idProducto){
        return $this->registroRepository->getSerialsByProduct($idProducto);
    }

    public function getOneProduct($idProducto){
        return $this->productoRepository->getOne('idProducto',$idProducto);
    }
}