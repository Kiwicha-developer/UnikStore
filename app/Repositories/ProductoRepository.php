<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use Exception;

class ProductoRepository implements ProductoRepositoryInterface
{
    protected $modelColumns;

    public function __construct()
    {
        // Define las columnas válidas
        $this->modelColumns = (new Producto())->getFillable();
    }
    
    public function all()
    {
        return Producto::all();
    }

    public function getOne($column, $data)
    {
        $this->validateColumns($column);
        return Producto::where($column,'=', $data)->first();
    }
    
    public function getLast()
    {
        $product = Producto::select('idProducto')->orderBy('idProducto','desc')->first();
        return $product;
    }

    public function getAllByColumn($column, $data)
    {
        $this->validateColumns($column);
        return Producto::where($column,'=', $data)->get();
    }

    public function paginateAllByColumn($column, $data,$cant,$querys){
        $this->validateColumns($column);

        $query = Producto::query();
        $query->where($column,'=', $data);

        if(isset($querys)){
            if(isset($querys['marca'])){
                $query->where('idMarca','=', $querys['marca']);
            }

            if(isset($querys['estado'])){
                $query->where('estadoProductoWeb','=', $querys['estado']);
            }
        }

        return $query->paginate($cant);
    }

    public function searchOne($column, $data)
    {
        $this->validateColumns($column);
        return Producto::where($column, 'LIKE', '%' . $data . '%')->first();
    }

    public function searchList($column, $data)
    {
        $this->validateColumns($column);
        return Producto::where($column, 'LIKE', '%' . $data . '%')->get();
    }

    public function searchTakeList($column, $data,$cont)
    {
        $this->validateColumns($column);
        return Producto::where($column, 'LIKE', '%' . $data . '%')->take($cont)->get();
    }

    public function searchPaginateList($column,$cont,$data)
    {
        $this->validateColumns($column);
        return Producto::where($column, 'LIKE', '%' . $data . '%')->paginate($cont);
    }

    public function getMarcasByColumn($column,$data){
        $this->validateColumns($column);
        return Producto::select('idMarca')->distinct()
                        ->where($column,'=',$data)->get();
    }

    public function getEstadosByColumn($column,$data){
        $this->validateColumns($column);
        return Producto::select('estadoProductoWeb')->distinct()
                        ->where($column,'=',$data)->get();
    }
    
    public function getCodes(){
        $codes = Producto::select('idGrupo', DB::raw('MAX(codigoProducto) as codigoProducto'))->groupBy('idGrupo')->get(); 
        return $codes;
    }
    public function total(){
        return Producto::where('estadoProductoWeb','=','DISPONIBLE')->count();
    }

    public function getStockMinProducts() {
        $query = "
            SELECT p.*
            FROM Producto p
            JOIN Inventario i ON p.idProducto = i.idProducto
            WHERE p.estadoProductoWeb = 'DISPONIBLE'
            GROUP BY p.idProducto, p.stockMin
            HAVING SUM(i.stock) < p.stockMin
            AND SUM(i.stock) > 0
        ";

        $resultados = DB::select($query);

        $productIds = collect($resultados)->pluck('idProducto');
        $productos = Producto::whereIn('idProducto', $productIds)->paginate(50);
        return $productos;
    }

    public function getProductsWithStock(){
        $query = "
            SELECT p.*
            FROM Producto p
            JOIN Inventario i ON p.idProducto = i.idProducto
            WHERE p.estadoProductoWeb = 'DISPONIBLE'
            GROUP BY p.idProducto
            HAVING SUM(i.stock) > 0
        ";

        $resultados = DB::select($query);

        $productos = collect($resultados)->map(function ($item) {
            return Producto::find($item->idProducto); 
        });
        return $productos;
    }
    
    public function validateSerial($id,$serial){
        $serial = Producto::join('DetalleComprobante', 'DetalleComprobante.idProducto', '=', 'Producto.idProducto')
                    ->join('RegistroProducto', 'DetalleComprobante.idDetalleComprobante', '=', 'RegistroProducto.idDetalleComprobante')
                    ->where('RegistroProducto.estado','<>','INVALIDO')
                    ->where('Producto.idProducto', '=', $id)
                    ->where('RegistroProducto.numeroSerie', '=', $serial)
                    ->first();
                    
        return $serial;
    }
    
    public function searchIntensiveProducts($query,$cant,$filtros){
        $consulta = Producto::query();
        $consulta->where('codigoProducto', 'LIKE', '%'.$query.'%')
        ->orWhere('partNumber', 'LIKE', '%'.$query.'%')
        ->orWhere('modelo', 'LIKE', '%'.$query.'%');
        return $consulta->paginate($cant);
    }

    public function getProductsCodes(){
        return Producto::select('idGrupo', DB::raw('MAX(codigoProducto) as codigoProducto'))->groupBy('idGrupo')->get();
    }

    public function getPaginationNull(){
        return Producto::whereRaw('1=0')->paginate(10);
    }

    public function create(array $productoData)
    {
        return Producto::create($productoData);
    }
    
    public function update($idProducto, array $productoData)
    {
        $producto = Producto::findOrFail($idProducto);
        $producto->update($productoData);
        return $producto;
    }
    
    private function validateColumns($column){
        if (!in_array($column, $this->modelColumns)) {
            throw new \InvalidArgumentException("La columna '$column' no es válida.");
        }
    }
}