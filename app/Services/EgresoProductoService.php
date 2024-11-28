<?php
namespace App\Services;

use App\Repositories\AlmacenRepositoryInterface;
use Carbon\Carbon;
use App\Repositories\EgresoProductoRepositoryInterface;
use App\Repositories\InventarioRepositoryInterface;
use App\Repositories\PublicacionRepositoryInterface;
use App\Repositories\RegistroProductoRepositoryInterface;

class EgresoProductoService implements EgresoProductoServiceInterface
{
    protected $egresoRepository;
    protected $registroRepository;
    protected $publicacionRepository;
    protected $headerService;
    protected $productoRepository;
    protected $inventarioRepository;
    protected $almacenRepository;

    public function __construct(EgresoProductoRepositoryInterface $egresoRepository,
                                RegistroProductoRepositoryInterface $registroRepository,
                                PublicacionRepositoryInterface $publicacionRepository,
                                HeaderServiceInterface $headerService,
                                ProductoServiceInterface $productoRepository,
                                InventarioRepositoryInterface $inventarioRepository,
                                AlmacenRepositoryInterface $almacenRepository
                                )
    {
        $this->egresoRepository = $egresoRepository;
        $this->registroRepository = $registroRepository;
        $this->publicacionRepository = $publicacionRepository;
        $this->headerService = $headerService;
        $this->productoRepository = $productoRepository;
        $this->inventarioRepository = $inventarioRepository;
        $this->almacenRepository = $almacenRepository;
    }
    
    public function getEgresosByMonth($date){
        Carbon::setLocale('es');
        $carbonMonth = Carbon::createFromFormat('Y-m', $date);
        return $this->egresoRepository->getAllByMonth($carbonMonth->month);
    }

    public function searchAjaxRegistro($serial){
        $egresos = $this->registroRepository->searchByEgreso($serial);
        $result = $egresos->take(5)->map(function($details) {
                        return [
                            'nombreProducto' => $details->DetalleComprobante->Producto->nombreProducto,
                            'idRegistroProducto' => $details->idRegistro,
                            'numeroSerie' => $details->numeroSerie
                        ];
                    });
        return $result;
    }

    public function getRegistro($serial){
        $registro = $this->registroRepository->getByEgreso($serial);
        return $registro;
    }

    public function getPublicacion($sku){
        $publicacion = $this->publicacionRepository->getOne('sku',$sku);
        return $publicacion;
    }

    public function getAllAlmacenes(){
        return $this->almacenRepository->all();
    }

    public function createEgreso(array $data){
        if($data){
            $registro = $this->registroRepository->getOne('idRegistro',$data['idRegistro']);
            $idAlmacen = $registro->idAlmacen;
            $data['idEgreso'] = $this->getNewIdEgreso();
            $data['idUser'] = $this->headerService->getModelUser()->idUser;

            $arrayRegistro =['estado' => 'ENTREGADO',
                            'fechaMovimiento' => now()];
            
            $this->egresoRepository->create($data);
            $this->registroRepository->update($data['idRegistro'],$arrayRegistro);
            $producto = $this->updateStock($idAlmacen,$data['idRegistro']);
            return $producto;
        }
    }

    private function updateStock($idAlmacen,$idRegistro){
        if($idAlmacen && $idRegistro){
            $producto = $this->registroRepository->getOne('idRegistro',$idRegistro)
                        ->DetalleComprobante->Producto;
            $this->inventarioRepository->removeStock($producto->idProducto,$idAlmacen);
            return $producto;
        }
    }

    private function getNewIdEgreso(){
        $lastEgreso = $this->egresoRepository->getLast();
        $id = $lastEgreso ? $lastEgreso->idEgreso : 0;
        return $id + 1;
    }
}