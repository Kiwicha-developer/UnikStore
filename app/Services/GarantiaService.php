<?php
namespace App\Services;

use App\Repositories\GarantiaRepositoryInterface;
use Carbon\Carbon;

class GarantiaService implements GarantiaServiceInterface
{
    protected $garantiaRepository;

    public function __construct(GarantiaRepositoryInterface $garantiaRepository)
    {
        $this->garantiaRepository = $garantiaRepository;
    }

    public function getGarantiasByMonth(Carbon $date, int $cant)
    {
        return $this->garantiaRepository->paginateAllByMonth($date,$cant);
    }
}