<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\ComisionPlataforma;

class ComisionPlataformaRepository implements ComisionPlataformaRepositoryInterface
{
    protected $modelColumns;
    
    public function __construct(){
        
        $this->modelColumns = (new ComisionPlataforma())->getFillable();
    }

    public function all(){
        
        return ComisionPlataforma::all();
    }

    public function getOne($column, $data){
        $this->validateColumns($column);
        return ComisionPlataforma::where($column,'=',$data)->first();
        
    }

    public function getAllByColumn($column, $data){
        $this->validateColumns($column);
        return ComisionPlataforma::where($column, '=',$data)->get();
    }

    public function searchOne($column, $data){
        $this->validateColumns($column);
        return ComisionPlataforma::where($column, 'LIKE' , '%' . $data . '%')->first();
    }

    public function searchList($column, $data){
        $this->validateColumns($column);
        return ComisionPlataforma::where($column, 'LIKE', '%' . $data . '%')->get();
    }

    public function create(array $ComisionData){
        return ComisionPlataforma::create($ComisionData);
    }

    public function update($idRango,$idGrupo, array $comisionData){
        $comision = ComisionPlataforma::where('idGrupoProducto','=',$idGrupo)
                            ->where('idRango','=', $idRango)->first();
        $comision->update($comisionData);
        return $comision;
    }

    public function getLast(){
        return ComisionPlataforma::orderBy('idComisionPlataforma', 'desc')->first();
    }

    private function validateColumns($column){
        if(!in_array($column, $this->modelColumns)){
            throw new \InvalidArgumentException("La Columna o fila '$column' no es válida");
        }

    }
}