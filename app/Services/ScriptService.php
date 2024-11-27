<?php
namespace App\Services;

use App\Repositories\AlmacenRepositoryInterface;
use App\Repositories\CalculadoraRepositoryInterface;
use App\Repositories\CategoriaProductoRepositoryInterface;
use App\Repositories\ComprobanteRepositoryInterface;
use App\Repositories\ProductoRepositoryInterface;

class ScriptService implements ScriptServiceInterface
{
    protected $categoriaRepository;
    protected $almacenRepository;
    protected $comprobanteRepository;
    protected $calculadoraRepository;
    protected $productoRepository;

    public function __construct(CategoriaProductoRepositoryInterface $categoriaRepository,
                                AlmacenRepositoryInterface $almacenRepository,
                                ComprobanteRepositoryInterface $comprobanteRepository,
                                CalculadoraRepositoryInterface $calculadoraRepository,
                                ProductoRepositoryInterface $productoRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
        $this->almacenRepository = $almacenRepository;
        $this->comprobanteRepository = $comprobanteRepository;
        $this->calculadoraRepository = $calculadoraRepository;
        $this->productoRepository = $productoRepository;
    }
    public function getAllCategorias(){
        return $this->categoriaRepository->all();
    }

    public function getAllAlmacen(){
        return $this->almacenRepository->all();
    }

    public function getOneComprobante($idComprobante){
        return $this->comprobanteRepository->getOne('idComprobante',$idComprobante);
    }

    public function getCalculadora(){
        return $this->calculadoraRepository->get();
    }

    public function getCodigosProductos(){
        return $this->productoRepository->getProductsCodes();
    }
}