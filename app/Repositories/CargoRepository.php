<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Cargo;

class CargoRepository implements CargoRepositoryInterface
{
    protected $modelColumns;

    public function __construct()
    {
        // Define las columnas válidas
        $this->modelColumns = (new Cargo())->getFillable();
    }
    
    public function all()
    {
        return Cargo::all();
    }
    
    private function validateColumns($column){
        if (!in_array($column, $this->modelColumns)) {
            throw new \InvalidArgumentException("La columna '$column' no es válida.");
        }
    }
}