<?php
namespace App\Services;

use Carbon\Carbon;
use App\Repositories\EgresoProductoRepositoryInterface;
use App\Repositories\RegistroProductoRepositoryInterface;

class EgresoProductoService implements EgresoProductoServiceInterface
{
    protected $egresoRepository;
    protected $registroRepository;

    public function __construct(EgresoProductoRepositoryInterface $egresoRepository,
                                RegistroProductoRepositoryInterface $registroRepository
                                )
    {
        $this->egresoRepository = $egresoRepository;
        $this->registroRepository = $registroRepository;
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
                            'idRegistroProducto' => $details->idRegistroProducto,
                            'numeroSerie' => $details->numeroSerie
                        ];
                    });
        return $result;
    }
}