<?php
namespace App\Repositories;

use App\Models\Cliente;

class ClienteRepository implements ClienteRepositoryInterface
{
    public function all($cant)
    {
        return Cliente::paginate($cant);
    }

    public function create(array $data)
    {
        return Cliente::create($data);
    }

    public function getLast(){
        return Cliente::orderBy('idCliente', 'desc')->first();
    }
}