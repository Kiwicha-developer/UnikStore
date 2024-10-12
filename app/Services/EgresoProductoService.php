<?php
namespace App\Services;

use Carbon\Carbon;
use App\Repositories\EgresoProductoRepositoryInterface;
use App\Repositories\PublicacionRepositoryInterface;
use App\Repositories\RegistroProductoRepositoryInterface;

class EgresoProductoService implements EgresoProductoServiceInterface
{
    protected $egresoRepository;
    protected $registroRepository;
    protected $publicacionRepository;
    protected $headerService;

    public function __construct(EgresoProductoRepositoryInterface $egresoRepository,
                                RegistroProductoRepositoryInterface $registroRepository,
                                PublicacionRepositoryInterface $publicacionRepository,
                                HeaderServiceInterface $headerService
                                )
    {
        $this->egresoRepository = $egresoRepository;
        $this->registroRepository = $registroRepository;
        $this->publicacionRepository = $publicacionRepository;
        $this->headerService = $headerService;
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

    public function createEgreso(array $data){
        if($data){
            $data['idEgreso'] = $this->getNewIdEgreso();
            $data['idUser'] = $this->headerService->getModelUser()->idUser;

            $arrayRegistro =['estado' => 'ENTREGADO'];

            $this->egresoRepository->create($data);
            $this->registroRepository->update($data['idRegistro'],$arrayRegistro);
        }
    }

    private function getNewIdEgreso(){
        $lastEgreso = $this->egresoRepository->getLast();
        $id = $lastEgreso ? $lastEgreso->idEgreso : 0;
        return $id + 1;
    }
}