<?php
namespace App\Services;

use App\Repositories\ClienteRepositoryInterface;
use App\Repositories\TipoDocumentoRepositoryInterface;

class ClienteService implements ClienteServiceInterface
{
    protected $tipoDocumentoRepository;
    protected $clienteRepository;

    public function __construct(TipoDocumentoRepositoryInterface $tipoDocumentoRepository,
                                ClienteRepositoryInterface $clienteRepository)
    {
        $this->tipoDocumentoRepository = $tipoDocumentoRepository;
        $this->clienteRepository = $clienteRepository;
    }

    public function getAllTipoDocumentos(){
        return $this->tipoDocumentoRepository->all();
    }

    public function createCliente($nombre,$apePaterno,$apeMaterno,$tipoDoc,$numeroDoc,$telefono,$correo)
    {
        if(isset($nombre) && isset($tipoDoc) && isset($numeroDoc)){
            $data = ['idCliente' => $this->getNewIdCliente(),
                    'nombre' => $nombre,
                    'apellidoPaterno' => $apePaterno,
                    'apellidoMaterno' => $apeMaterno,
                    'numeroDocumento' => $numeroDoc,
                    'idTipoDocumento' => $tipoDoc,
                    'telefono' => $telefono,
                    'correo' => $correo];
            return $this->clienteRepository->create($data);
        }
        return null;
    }

    public function paginateAllCliente($cant){
        return $this->clienteRepository->all($cant);
    }

    private function getNewIdCliente(){
        $lastId = $this->clienteRepository->getLast();
        $id = $lastId ? $lastId->idCliente : 0;
        return $id + 1;
    }
}