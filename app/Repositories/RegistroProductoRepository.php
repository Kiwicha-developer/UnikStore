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

    public function getAllByColumn($column,$data)
    {
        $this->validateColumns($column);
        return RegistroProducto::where($column,'=', $data)->get();
    }

    public function paginateAllByColumn($column,$data,$cant)
    {
        $this->validateColumns($column);
        return RegistroProducto::where($column,'=', $data)->paginate($cant);
    }

    public function getAllByColumnByThisMonth($column,$data,$cant){
        $this->validateColumns($column);
        return RegistroProducto::where($column,'=',$data)->whereMonth('fechaMovimiento','=',now()->month-1)->paginate($cant);
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

    public function searchByEgreso($serial,$cant){
        return RegistroProducto::where('estado','!=','ENTREGADO')
                                ->where('estado','!=','INVALIDO')
                                ->where('numeroSerie', 'LIKE', "%{$serial}%")
                                ->take($cant)
                                ->get();
    }

    public function getByEgreso($serial){
        return RegistroProducto::where('estado','!=','ENTREGADO')
                                ->where('estado','!=','INVALIDO')
                                ->where('numeroSerie','=',$serial)
                                ->first();
    }

    public function validateSerie($idProveedor,$serie){
        $response = RegistroProducto::join('DetalleComprobante','RegistroProducto.idDetalleComprobante','=','DetalleComprobante.idDetalleComprobante')
                                    ->join('Comprobante','DetalleComprobante.idComprobante','=','Comprobante.idComprobante')
                                    ->where('RegistroProducto.estado','<>','INVALIDO')
                                    ->where('Comprobante.idProveedor','=',$idProveedor)
                                    ->where('RegistroProducto.numeroSerie','=',$serie)->first();
        return $response;
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