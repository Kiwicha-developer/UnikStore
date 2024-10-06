<?php
namespace App\Services;

use Carbon\Carbon;
use App\Repositories\IngresoProductoRepositoryInterface;
use App\Repositories\ProveedorRepositoryInterface;
use App\Repositories\TipoComprobanteRepositoryInterface;

class IngresoProductoService implements IngresoProductoServiceInterface
{
    protected $ingresoRepository;
    protected $tipoComprobanteRepository;
    protected $proveedorRepository;

    public function __construct(IngresoProductoRepositoryInterface $ingresoRepository,
                                ProveedorRepositoryInterface $proveedorRepository,
                                TipoComprobanteRepositoryInterface $tipoComprobanteRepository
                                )
    {
        $this->ingresoRepository = $ingresoRepository;
        $this->proveedorRepository = $proveedorRepository;
        $this->tipoComprobanteRepository = $tipoComprobanteRepository;
    }
    
    public function getByComprobante($idComprobante){
        return $this->ingresoRepository->getAllByComprobante($idComprobante);
    }
    
    public function getByMonth($date){
        $fechacompleta = $date. '-01';
        $carbonMonth = Carbon::createFromFormat('Y-m-d', $fechacompleta);
        return $this->ingresoRepository->getAllByMonth($carbonMonth);
    }
    
    
    
    public function searchAjaxIngreso($data){
        $ingreso = $this->ingresoRepository->searchBySerialNumber($data)->take(5)
                    ->map(function($x){
                        $x->fechaIngresoPerso = Carbon::parse($x->fechaIngreso)->format('d-m-Y');
                        $x->fechaMovimiento = Carbon::parse($x->fechaMovimiento)->format('d-m-Y');
                        $x->Usuario = $x->Usuario;
                        $x->Registro = $x->RegistroProducto;
                        $x->Producto = $x->RegistroProducto ? $x->RegistroProducto->DetalleComprobante->Producto : null;
                        return $x;
                    });;
        return $ingreso;
    }
    
    public function deleteIngreso($id){
        if($id){
            $ingreso = $this->ingresoRepository->getOne('idIngreso',$id);
            $data = ['estado' => 'INVALIDO'];
            
            // $this->registroService->updateRegistro($ingreso->idRegistro,$data);
        }
    }
    
    public function getAllLabelProveedor(){
        return $this->proveedorRepository->all();
    }

    public function getAllTipoComprobante(){
        $tipoComprobante = $this->tipoComprobanteRepository->all();
        return $tipoComprobante;
    }
}