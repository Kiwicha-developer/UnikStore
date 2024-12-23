<?php
namespace App\Services;

use App\Repositories\GarantiaRepositoryInterface;
use App\Repositories\RegistroProductoRepositoryInterface;
use App\Repositories\TipoDocumentoRepositoryInterface;
use Carbon\Carbon;

class GarantiaService implements GarantiaServiceInterface
{
    protected $garantiaRepository;
    protected $tipoDocumentoRepository;
    protected $registroRepository;

    public function __construct(GarantiaRepositoryInterface $garantiaRepository,
                                TipoDocumentoRepositoryInterface $tipoDocumentoRepository,
                                RegistroProductoRepositoryInterface $registroRepository)
    {
        $this->garantiaRepository = $garantiaRepository;
        $this->tipoDocumentoRepository = $tipoDocumentoRepository;
        $this->registroRepository = $registroRepository;
    }

    public function getGarantiasByMonth(Carbon $date, int $cant)
    {
        return $this->garantiaRepository->paginateAllByMonth($date,$cant);
    }

    public function getAllTipoDocumentos(){
        return $this->tipoDocumentoRepository->all();
    }

    public function insertGarantia($idRegistro,$idCliente,$numeroComprobante,$recepcion,$estado,$fallo){
        $data = ['idGarantia' => $this->getNewIdGarantia(),
                'idRegistro' => $idRegistro,
                'idCliente' => $idCliente,
                'fechaGarantia' => now(),
                'numeroComprobante' => $numeroComprobante,
                'recepcion' => $recepcion,
                'estado' => $estado,
                'falla' => $fallo
                ];
        
        $this->garantiaRepository->create($data);
        $this->updateStateGarantia($data['idRegistro']);
        $response = $this->garantiaRepository->getOne($data['idGarantia']);
        return $response;
    }

    private function updateStateGarantia($idGarantia){
        if(!empty($idGarantia)){
            $data = ['estado' => 'GARANTIA'];
            $this->registroRepository->update($idGarantia,$data);
        }
    }

    private function getNewIdGarantia(){
        $garantia = $this->garantiaRepository->getLast();
        $id = $garantia ? $garantia->idGarantia : 0;
        return $id + 1;
    } 
}