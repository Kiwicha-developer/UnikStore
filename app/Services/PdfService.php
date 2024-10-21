<?php
namespace App\Services;

use App\Repositories\ComprobanteRepositoryInterface;
use App\Repositories\RegistroProductoRepositoryInterface;

class PdfService implements PdfServiceInterface
{
    protected $comprobanteRepository;

    public function __construct(ComprobanteRepositoryInterface $comprobanteRepository,
                                )
    {
        $this->comprobanteRepository = $comprobanteRepository;
    }
    
    public function getSerialsPrint($idComprobante){
        $registros = $this->comprobanteRepository->getAllRegistrosByComprobanteId($idComprobante);
        $registrosFiltrados = $registros->filter(function($register) {
            return strpos($register->numeroSerie, 'UNK-') !== false;
        });
        return $registrosFiltrados->pluck('numeroSerie');
    }
    
}