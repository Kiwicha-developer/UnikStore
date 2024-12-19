<?php
namespace App\Repositories;

use App\Models\Cliente;

class ClienteRepository implements ClienteRepositoryInterface
{
    protected $modelColumns;

    public function __construct()
    {
        $this->modelColumns = (new Cliente())->getFillable();
    }

    public function all($cant)
    {
        return Cliente::paginate($cant);
    }

    public function getOne($column,$data)
    {
        $this->validateColumns($column);
        return Cliente::where($column,'=',$data)->first();
    }

    public function validateDuplicity($type,$number)
    {
        return Cliente::where('idTipoDocumento','=',$type)->where('numeroDocumento','=',$number)->first();
    }

    public function create(array $data)
    {
        return Cliente::create($data);
    }

    public function getLast(){
        return Cliente::orderBy('idCliente', 'desc')->first();
    }

    private function validateColumns($column){
        if (!in_array($column, $this->modelColumns)) {
            throw new \InvalidArgumentException("La columna '$column' no es válida.");
        }
    }
}