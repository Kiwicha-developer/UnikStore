<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Calculadora;

class CalculadoraRepository implements CalculadoraRepositoryInterface
{
    protected $modelColumns;

    public function __construct()
    {
        // Define las columnas válidas
        $this->modelColumns = (new Calculadora())->getFillable();
    }
    
    public function get()
    {
        return Calculadora::first();
    }
    
    private function validateColumns($column){
        if (!in_array($column, $this->modelColumns)) {
            throw new \InvalidArgumentException("La columna '$column' no es válida.");
        }
    }
}