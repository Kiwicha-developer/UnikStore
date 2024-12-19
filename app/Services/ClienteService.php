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
        $message = 'Faltan Datos';
        if(!empty($nombre) && !empty($tipoDoc) && !empty($numeroDoc)){
            $validate = $this->clienteRepository->validateDuplicity($tipoDoc,$numeroDoc);
            if($validate){
                $message = 'Cliente ya registrado en la base de datos.';
                return $message;
            }
            $data = ['idCliente' => $this->getNewIdCliente(),
                    'nombre' => $nombre,
                    'apellidoPaterno' => $apePaterno,
                    'apellidoMaterno' => $apeMaterno,
                    'numeroDocumento' => $numeroDoc,
                    'idTipoDocumento' => $tipoDoc,
                    'telefono' => $telefono,
                    'correo' => $correo];

            $response = $this->clienteRepository->create($data);
            $message = 'Cliente '.$response->numeroDocumento.' Registrado';
            return $message;
        }
        return $message;
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