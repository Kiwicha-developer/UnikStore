<?php
namespace App\Services;

use App\Repositories\CalculadoraRepositoryInterface;
use App\Repositories\CaracteristicasGrupoRepositoryInterface;
use App\Repositories\CaracteristicasRepositoryInterface;
use App\Repositories\CategoriaProductoRepositoryInterface;
use App\Repositories\ComisionRepositoryInterface;
use App\Repositories\EmpresaRepositoryInterface;
use App\Repositories\RangoPrecioRepositoryInterface;

class ConfiguracionService implements ConfiguracionServiceInterface
{
    protected $categoriaRepository;
    protected $rangoRepository;
    protected $empresaRepository;
    protected $calculadoraRepository;
    protected $comisionRepository;
    protected $caracteristicasRepository;
    protected $caracteristicasGrupoRepository;

    public function __construct(CategoriaProductoRepositoryInterface $categoriaRepository,
                                RangoPrecioRepositoryInterface $rangoRepository,
                                EmpresaRepositoryInterface $empresaRepository,
                                CalculadoraRepositoryInterface $calculadoraRepository,
                                ComisionRepositoryInterface $comisionRepository,
                                CaracteristicasRepositoryInterface $caracteristicasRepository,
                                CaracteristicasGrupoRepositoryInterface $caracteristicasGrupoRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
        $this->rangoRepository = $rangoRepository;
        $this->empresaRepository = $empresaRepository;
        $this->calculadoraRepository = $calculadoraRepository;
        $this->comisionRepository = $comisionRepository;
        $this->caracteristicasRepository = $caracteristicasRepository;
        $this->caracteristicasGrupoRepository = $caracteristicasGrupoRepository;
    }

    public function getAllCategorias(){
        return $this->categoriaRepository->all();
    }

    public function getAllRangos(){
        return $this->rangoRepository->all();
    }

    public function getAllEmpresas(){
        return $this->empresaRepository->all();
    }

    public function updateCorreoEmpresa($id,$correo){
        if($id && $correo){
            $data = ['correoEmpresa' => $correo];
            $this->empresaRepository->update($id,$data);
        }
    }

    public function updateComisionEmpresa($id,$comision){
        if($id && !is_null($comision)){
            $data = ['comision' => $comision];
            $this->empresaRepository->update($id,$data);
        }
    }

    public function updateCalculadora($igv,$fact){
        if($igv && $fact){
            $data = ['igv' => $igv,
                    'facturacion' => $fact];
            $this->calculadoraRepository->update($data);
        }
    }

    public function updateComisionValue($idGrupo,$idRango,$comision){
        if(!is_null($idGrupo) && !is_null($idRango) && !is_null($comision)){
            $data = ['comision' => $comision];
            $this->comisionRepository->update($idRango,$idGrupo,$data);
        }
    }

    public function getAllEspecificaciones(){
        return $this->caracteristicasRepository->all()->sortBy('especificacion');
    }

    public function insertCaracteristicaXGrupo($idGrupo,$idCaracteristica){
        if($idGrupo && $idCaracteristica){
            $data = ['idGrupoProducto' => $idGrupo,
                    'idCaracteristica' => $idCaracteristica];
            $this->caracteristicasGrupoRepository->create($data);
        }
    }

    public function createCaracteristica($descripcion){
        if($descripcion){
            $data = ['idCaracteristica' => $this->getNewIdCaracteristica(),
                    'especificacion' => $descripcion,
                    'tipo' => 'FILTRO'];
            $this->caracteristicasRepository->create($data);
        }
    }

    private function getNewIdCaracteristica(){
        $caracteristica = $this->caracteristicasRepository->getLast();
        $id = $caracteristica ? $caracteristica->idCaracteristica : 0;
        return $id + 1;
    }
}