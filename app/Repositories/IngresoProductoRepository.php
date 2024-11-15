<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\IngresoProducto;

class IngresoProductoRepository implements IngresoProductoRepositoryInterface
{
    protected $modelColumns;

    public function __construct()
    {
        // Define las columnas válidas
        $this->modelColumns = (new IngresoProducto())->getFillable();
    }

    public function getOne($column, $data)
    {
        $this->validateColumns($column);
        return IngresoProducto::where($column,'=', $data)->first();
    }

    public function getAllByColumn($column, $data)
    {
        $this->validateColumns($column);
        return IngresoProducto::where($column,'=', $data)->get();
    }
    
    public function getAllByComprobante($idComprobante){
        return IngresoProducto::join('RegistroProducto','RegistroProducto.idRegistro','=','IngresoProducto.idRegistro')
                    ->join('DetalleComprobante','DetalleComprobante.idDetalleComprobante','=','RegistroProducto.idDetalleComprobante')
                    ->join('Comprobante','Comprobante.idComprobante','=','DetalleComprobante.idComprobante')
                    ->where('Comprobante.idComprobante','=',$idComprobante)->select('IngresoProducto.*')->get();
    }
    
    public function getAllByMonth($month){
        return IngresoProducto::whereMonth('fechaIngreso', $month)
                                    ->orderBy('fechaIngreso','desc')
                                    ->get();
    }

    public function searchOne($column, $data)
    {
        $this->validateColumns($column);
        return IngresoProducto::where($column, 'LIKE', '%' . $data . '%')->first();
    }

    public function searchList($column, $data)
    {
        $this->validateColumns($column);
        return IngresoProducto::where($column, 'LIKE', '%' . $data . '%')->get();
    }
    
    public function searchBySerialNumber($data)
    {
        return IngresoProducto::join('RegistroProducto','RegistroProducto.idRegistro','=','IngresoProducto.idRegistro')
                                ->where('RegistroProducto.estado', '<>', 'ENTREGADO')
                                ->where('RegistroProducto.estado', '<>', 'INVALIDO')
                                ->where('RegistroProducto.numeroSerie', 'LIKE', '%' . $data . '%')
                                ->get();
    }
    
    public function create(array $data)
    {
        return IngresoProducto::create($data);
    }
    
    
    public function update($id, array $data)
    {
        $ingreso = IngresoProducto::findOrFail($id);
        $ingreso->update($data);
        return $ingreso;
    }
    
    public function getLast(){
        return IngresoProducto::orderBy('idIngreso', 'desc')->first();
    }
    
    private function validateColumns($column){
        if (!in_array($column, $this->modelColumns)) {
            throw new \InvalidArgumentException("La columna '$column' no es válida.");
        }
    }
}