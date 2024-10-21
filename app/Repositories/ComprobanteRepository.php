<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Comprobante;

class ComprobanteRepository implements ComprobanteRepositoryInterface
{
    protected $modelColumns;

    public function __construct()
    {
        // Define las columnas válidas
        $this->modelColumns = (new Comprobante())->getFillable();
    }

    public function getOne($column, $data)
    {
        $this->validateColumns($column);
        return Comprobante::where($column,'=', $data)->first();
    }

    public function getAllByColumn($column, $data)
    {
        $this->validateColumns($column);
        return Comprobante::where($column,'=', $data)->get();
    }
    
    public function getAllByMonth($month)
    {
        return Comprobante::whereMonth('fechaRegistro', $month)
                                    ->orderBy('fechaRegistro','desc')
                                    ->get();
    }
    
    public function searchOne($column, $data)
    {
        $this->validateColumns($column);
        return Comprobante::where($column, 'LIKE', '%' . $data . '%')->first();
    }

    public function searchList($column, $data)
    {
        $this->validateColumns($column);
        return Comprobante::where($column, 'LIKE', '%' . $data . '%')->get();
    }
    
    
    public function create(array $data)
    {
        return Comprobante::create($data);
    }
    
    
    public function update($id, array $data)
    {
        $comprobante = Comprobante::findOrFail($id);
        $comprobante->update($data);
        return $comprobante;
    }
    
    public function remove($id){
        $comprobante = Comprobante::findOrFail($id);
        $comprobante->delete();
    }
    
    public function validateDuplicity($number,$type,$idProveedor){
        $validate = Comprobante::where('numeroComprobante','=',$number)->where('idTipoComprobante','=',$type)->where('idProveedor','=',$idProveedor)->first();
        if($validate){
            return true;
        }else{
            return false;
        }
    }
    
    public function getLast(){
        return Comprobante::orderBy('idComprobante', 'desc')->first();
    }

    public function getAllRegistrosByComprobanteId($id){
        return Comprobante::join('DetalleComprobante','DetalleComprobante.idComprobante','=','Comprobante.idComprobante')
                ->join('RegistroProducto','DetalleComprobante.idDetalleComprobante','=','RegistroProducto.idDetalleComprobante')
                ->select('RegistroProducto.*')->where('Comprobante.idComprobante','=',$id)->get();
    }
    
    private function validateColumns($column){
        if (!in_array($column, $this->modelColumns)) {
            throw new \InvalidArgumentException("La columna '$column' no es válida.");
        }
    }
}