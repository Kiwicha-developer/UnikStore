<?php
namespace App\Services;

use App\Repositories\CalculadoraRepositoryInterface;
use App\Repositories\PlataformaRepositoryInterface;
use App\Repositories\CategoriaProductoRepositoryInterface;
use App\Repositories\ComisionRepositoryInterface;

class CalculadoraService implements CalculadoraServiceInterface
{
    protected $calcRepository;
    protected $plataformaRepository;
    protected $categoriaRepository;
    protected $comisionRepository;

    public function __construct(CalculadoraRepositoryInterface $calcRepository,
                                PlataformaRepositoryInterface $plataformaRepository,
                                CategoriaProductoRepositoryInterface $categoriaRepository,
                                ComisionRepositoryInterface $comisionRepository)
    {
        $this->calcRepository = $calcRepository;
        $this->plataformaRepository = $plataformaRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->comisionRepository = $comisionRepository;
    }
    
    public function get(){
        return $this->calcRepository->get();
    }
    
    public function allComision(){
        return $this ->comisionRepository->all();
    }
    
    public function getTasaCambio(){
        $tc = $this->calcRepository->get()->value('tasaCambio');
        return $tc;
    }
    
    public function getIgv(){
        $igv = $this->calcRepository->get()->value('igv');
        return ($igv / 100) +1;
    }
    
    public function getComisionByRelation($table){
        return $this->plataformaRepository->getByRelation($table);
    }
    
    public function getAllLabelCategory(){
        $categoriaModel = $this->categoriaRepository->all();
        $categoria = $categoriaModel->map(function ($cat) {
        return [
                    'idCategoria' => $cat->idCategoria,
                    'nombreCategoria' => $cat->nombreCategoria,
                    'GrupoProducto' => $cat->GrupoProducto
                ];
            });
        return $categoria;
    }
}