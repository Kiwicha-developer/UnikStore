<?php
namespace App\Services;

use App\Repositories\CalculadoraRepositoryInterface;
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

    public function __construct(CategoriaProductoRepositoryInterface $categoriaRepository,
                                RangoPrecioRepositoryInterface $rangoRepository,
                                EmpresaRepositoryInterface $empresaRepository,
                                CalculadoraRepositoryInterface $calculadoraRepository,
                                ComisionRepositoryInterface $comisionRepository,
                                CaracteristicasRepositoryInterface $caracteristicasRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
        $this->rangoRepository = $rangoRepository;
        $this->empresaRepository = $empresaRepository;
        $this->calculadoraRepository = $calculadoraRepository;
        $this->comisionRepository = $comisionRepository;
        $this->caracteristicasRepository = $caracteristicasRepository;
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
}