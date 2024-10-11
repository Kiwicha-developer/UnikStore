<?php
namespace App\Services;

use App\Repositories\CuentasPlataformaRepositoryInterface;
use App\Repositories\PlataformaRepositoryInterface;

class PlataformaService implements PlataformaServiceInterface
{
    protected $plataformaRepository;
    protected $cuentasRepository;

    public function __construct(PlataformaRepositoryInterface $plataformaRepository,
                                CuentasPlataformaRepositoryInterface $cuentasRepository)
    {
        $this->plataformaRepository = $plataformaRepository;
        $this->cuentasRepository = $cuentasRepository;
    }

    public function getAllPlataformas(){
        return $this->plataformaRepository->all();
    }

    public function updateCuentas(array $cuentas){
        if($cuentas){
            foreach($cuentas as $id => $state){
                $data = ['estadoCuenta' => $state];
                $this->cuentasRepository->update($id,$data);
            }
        }
    }

    public function createCuenta($idPlataforma,$nombreCuenta){
        if($idPlataforma && $nombreCuenta){
            $data = ['idCuentaPlataforma' => $this->getNewIdCuentas(),
                    'nombreCuenta' => $nombreCuenta,
                    'idPlataforma' => $idPlataforma,
                    'estadoCuenta' => 'ACTIVO'];
            $this->cuentasRepository->create($data);
        }
    }

    private function getNewIdCuentas(){
        $lastId = $this->cuentasRepository->getLast();
        $id = $lastId ? $lastId->idCuentaPlataforma : 0;
        return $id + 1;
    }
}