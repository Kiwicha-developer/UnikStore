<?php
namespace App\Services;

use App\Repositories\GarantiaRepositoryInterface;
use App\Repositories\TipoDocumentoRepositoryInterface;
use Carbon\Carbon;

class GarantiaService implements GarantiaServiceInterface
{
    protected $garantiaRepository;
    protected $tipoDocumentoRepository;

    public function __construct(GarantiaRepositoryInterface $garantiaRepository,
                                TipoDocumentoRepositoryInterface $tipoDocumentoRepository)
    {
        $this->garantiaRepository = $garantiaRepository;
        $this->tipoDocumentoRepository = $tipoDocumentoRepository;
    }

    public function getGarantiasByMonth(Carbon $date, int $cant)
    {
        return $this->garantiaRepository->paginateAllByMonth($date,$cant);
    }

    public function getAllTipoDocumentos(){
        return $this->tipoDocumentoRepository->all();
    }
}