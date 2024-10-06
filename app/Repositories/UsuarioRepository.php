<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    protected $modelColumns;

    public function __construct()
    {
        // Define las columnas válidas
        $this->modelColumns = (new Usuario())->getFillable();
    }
    
    public function all()
    {
        return Usuario::all();
    }

    public function getOne($column, $data)
    {
        $this->validateColumns($column);
        return Usuario::where($column,'=', $data)->first();
    }

    public function getAllByColumn($column, $data)
    {
        $this->validateColumns($column);
        return Usuario::where($column,'=', $data)->get();
    }

    public function searchOne($column, $data)
    {
        $this->validateColumns($column);
        return Usuario::where($column, 'LIKE', '%' . $data . '%')->first();
    }

    public function searchList($column, $data)
    {
        $this->validateColumns($column);
        return Usuario::where($column, 'LIKE', '%' . $data . '%')->get();
    }
    
    
    public function create(array $data)
    {
        return Usuario::create($data);
    }
    
    
    public function update($id, array $data)
    {
        $user = Usuario::findOrFail($id);
        $user->update($data);
        return $user;
    }
    
    private function validateColumns($column){
        if (!in_array($column, $this->modelColumns)) {
            throw new \InvalidArgumentException("La columna '$column' no es válida.");
        }
    }
}