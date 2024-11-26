<?php
namespace App\Services;

use App\Repositories\AlmacenRepositoryInterface;
use App\Repositories\CategoriaProductoRepositoryInterface;
use App\Repositories\ComprobanteRepositoryInterface;

class ScriptService implements ScriptServiceInterface
{
    protected $categoriaRepository;
    protected $almacenRepository;
    protected $comprobanteRepository;

    public function __construct(CategoriaProductoRepositoryInterface $categoriaRepository,
                                AlmacenRepositoryInterface $almacenRepository,
                                ComprobanteRepositoryInterface $comprobanteRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
        $this->almacenRepository = $almacenRepository;
        $this->comprobanteRepository = $comprobanteRepository;
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
}