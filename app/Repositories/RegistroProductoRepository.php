<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\RegistroProducto;

class RegistroProductoRepository implements RegistroProductoRepositoryInterface
{
    protected $modelColumns;

    public function __construct()
    {
        // Define las columnas válidas
        $this->modelColumns = (new RegistroProducto())->getFillable();
    }
    
    public function getOne($column, $data)
    {
        $this->validateColumns($column);
        return RegistroProducto::where($column,'=', $data)->first();
    }

    public function getAllByColumn($column, $data)
    {
        $this->validateColumns($column);
        return RegistroProducto::where($column,'=', $data)->get();
    }

    public function searchOne($column, $data)
    {
        $this->validateColumns($column);
        return RegistroProducto::where($column, 'LIKE', '%' . $data . '%')->first();
    }

    public function searchList($column, $data)
    {
        $this->validateColumns($column);
        return RegistroProducto::where($column, 'LIKE', '%' . $data . '%')->get();
    }
    
    public function getByIngreso($month){
        return RegistroProducto::join('IngresoProducto','RegistroProducto.idRegistro','=','IngresoProducto.idRegistro')
                                    ->select('RegistroProducto.*')->whereMonth('IngresoProducto.fechaIngreso', $month)
                                    ->orderBy('IngresoProducto.fechaIngreso','desc')
                                    ->get();
    }

    public function searchByEgreso($serial){
        return RegistroProducto::where('estado','!=','ENTREGADO')
                                ->where('estado','!=','INVALIDO')
                                ->where('numeroSerie', 'LIKE', "%{$serial}%")
                                ->get();
    }
    
    public function create(array $data)
    {
        return RegistroProducto::create($data);
    }
    
    public function update($id, array $data)
    {
        $reg = RegistroProducto::findOrFail($id);
        $reg->update($data);
        return $reg;
    }
    
    public function getLast(){
        return RegistroProducto::orderBy('idRegistro', 'desc')->first();
    }
    
    private function validateColumns($column){
        if (!in_array($column, $this->modelColumns)) {
            throw new \InvalidArgumentException("La columna '$column' no es válida.");
        }
    }
}