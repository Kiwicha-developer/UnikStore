<?php
namespace App\Services;

use App\Repositories\AlmacenRepositoryInterface;
use Carbon\Carbon;
use App\Repositories\IngresoProductoRepositoryInterface;
use App\Repositories\InventarioRepositoryInterface;
use App\Repositories\ProveedorRepositoryInterface;
use App\Repositories\RegistroProductoRepositoryInterface;
use App\Repositories\TipoComprobanteRepositoryInterface;

class IngresoProductoService implements IngresoProductoServiceInterface
{
    protected $ingresoRepository;
    protected $tipoComprobanteRepository;
    protected $proveedorRepository;
    protected $registroProductoRepository;
    protected $headerService;
    protected $inventarioRepository;
    protected $almacenRepository;

    public function __construct(IngresoProductoRepositoryInterface $ingresoRepository,
                                ProveedorRepositoryInterface $proveedorRepository,
                                TipoComprobanteRepositoryInterface $tipoComprobanteRepository,
                                RegistroProductoRepositoryInterface $registroProductoRepository,
                                HeaderServiceInterface $headerService,
                                InventarioRepositoryInterface $inventarioRepository,
                                AlmacenRepositoryInterface $almacenRepository
                                )
    {
        $this->ingresoRepository = $ingresoRepository;
        $this->proveedorRepository = $proveedorRepository;
        $this->tipoComprobanteRepository = $tipoComprobanteRepository;
        $this->registroProductoRepository = $registroProductoRepository;
        $this->headerService = $headerService;
        $this->inventarioRepository = $inventarioRepository;
        $this->almacenRepository = $almacenRepository;
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
                        $x->Usuario = $x->Usuario->makeHidden(['pass','tokenSesion','registroSesion','estadoUsuario','horaSesion','bandeja']);
                        $x->Registro = $x->RegistroProducto;
                        $x->Producto = $x->RegistroProducto ? $x->RegistroProducto->DetalleComprobante->Producto->makeHidden(['descripcionProducto','imagenProducto1','imagenProducto2','imagenProducto3','imagenProducto4']) : null;
                        $x->Proveedor = $x->RegistroProducto ? $x->RegistroProducto->DetalleComprobante->Comprobante->Preveedor : null;
                        $x->Almacen = $x->RegistroProducto ? $x->RegistroProducto->Almacen : null;
                        return $x;
                    });
        return $ingreso;
    }
    
    public function deleteIngreso($id){
        if($id){
            $ingreso = $this->ingresoRepository->getOne('idIngreso',$id);
            $dataRegistro = ['estado' => 'INVALIDO',
                            'fechaMovimiento' => now()];
            $dataIngreso = ['idUser' => $this->headerService->getModelUser()->idUser];

            $registro = $ingreso->RegistroProducto;
            $this->registroProductoRepository->update($ingreso->idRegistro,$dataRegistro);
            $this->ingresoRepository->update($ingreso->idIngreso,$dataIngreso);
            $this->inventarioRepository->removeStock($registro->DetalleComprobante->idProducto,$registro->idAlmacen);
        }
    }

    public function updateRegistro($idRegistro,$estado,$observacion){
        $data = ['estado' => $estado,
                'fechaMovimiento' => now(),
                'observacion' => $observacion];

        $this->registroProductoRepository->update($idRegistro,$data);
    }
    
    public function getAllLabelProveedor(){
        return $this->proveedorRepository->all();
    }

    public function getAllTipoComprobante(){
        $tipoComprobante = $this->tipoComprobanteRepository->all();
        return $tipoComprobante;
    }

    public function getAllAlmacen(){
        return $this->almacenRepository->all();
    }
}