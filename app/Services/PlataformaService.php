<?php
namespace App\Services;

use App\Repositories\PlataformaRepositoryInterface;

class PlataformaService implements PlataformaServiceInterface
{
    protected $plataformaRepository;

    public function __construct(PlataformaRepositoryInterface $plataformaRepository)
    {
        $this->plataformaRepository = $plataformaRepository;
    }

    public function getAllPlataformas(){
        return $this->plataformaRepository->all();
    }
}