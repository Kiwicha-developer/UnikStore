<?php
namespace App\Services;

use Carbon\Carbon;
use App\Repositories\RegistroProductoRepositoryInterface;

class RegistroProductoService implements RegistroProductoServiceInterface
{
    protected $registroProductoRepository;
    protected $ingresoProductoService;

    public function __construct(RegistroProductoRepositoryInterface $registroProductoRepository,
                                IngresoProductoServiceInterface $ingresoProductoService)
    {
        $this->registroProductoRepository = $registroProductoRepository;
        $this->ingresoProductoService = $ingresoProductoService;
    }
    
    public function getByMonth($date){
        Carbon::setLocale('es');
        $fechacompleta = $date. '-01';
        $carbonMonth = Carbon::createFromFormat('Y-m-d', $fechacompleta);
        
        return $this->registroProductoRepository->getByIngreso($carbonMonth);
    }
    
    
    
    public function updateRegistro($id,array $data){
        if($id && $data){
            // $this->registroProductoRepository->update($id,$data);
        }
    }
    
    
}