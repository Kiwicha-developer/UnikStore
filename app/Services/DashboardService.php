<?php
namespace App\Services;

use App\Repositories\InventarioRepositoryInterface;
use App\Repositories\RegistroProductoRepositoryInterface;

class DashboardService implements DashboardServiceInterface
{
    protected $registroRepository;
    protected $inventarioRepository;

    public function __construct(RegistroProductoRepositoryInterface $registroRepository,
                                InventarioRepositoryInterface $inventarioRepository)
    {
        $this->registroRepository = $registroRepository;
        $this->inventarioRepository = $inventarioRepository;
    }

    public function getRegistrosXEstados(){
        $array = array();
        $array[] = ['estado' => 'NUEVOXMES', 'titulo' => 'Nuevos' , 'cantidad' => count($this->registroRepository->getAllByColumnByThisMonth('estado','NUEVO')),'bg' => 'bg-sistema-uno','icon' => 'boxes','fecha' => 'Este mes'];
        $array[] = ['estado' => 'ENTREGADOXMES', 'titulo' => 'Entregados' , 'cantidad' => count($this->registroRepository->getAllByColumnByThisMonth('estado','ENTREGADO')),'bg' => 'bg-green','icon' => 'cart','fecha' => 'Este mes'];
        $array[] = ['estado' => 'DEVOLUCION', 'titulo' => 'Devoluciones' , 'cantidad' => count($this->registroRepository->getAllByColumn('estado','DEVOLUCION')),'bg' => 'bg-warning','icon' => 'truck','fecha' => 'Hasta la fecha'];
        $array[] = ['estado' => 'ABIERTO', 'titulo' => 'Abiertos' , 'cantidad' => count($this->registroRepository->getAllByColumn('estado','ABIERTO')),'bg' => 'bg-marron','icon' => 'dropbox','fecha' => 'Hasta la fecha'];
        $array[] = ['estado' => 'DEFECTUOSO', 'titulo' => 'Defectuosos' , 'cantidad' => count($this->registroRepository->getAllByColumn('estado','DEFECTUOSO')),'bg' => 'bg-purple','icon' => 'ban','fecha' => 'Hasta la fecha'];
        $array[] = ['estado' => 'ROTO','titulo' => 'Rotos' ,'cantidad' => count($this->registroRepository->getAllByColumn('estado','ROTO')),'bg' => 'bg-danger','icon' => 'x-lg','fecha' => 'Hasta la fecha'];
        
        return $array;
    }

    public function getAllInventory(){
        return $this->inventarioRepository->getAllWhereFindStock();
    }

    public function getInventoryByAlmacen($idAlmacen){
        return $this->inventarioRepository->getAllByColumnWhereFindStock('idAlmacen',$idAlmacen);
    }
}