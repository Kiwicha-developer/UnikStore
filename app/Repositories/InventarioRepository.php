<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Inventario;
use Exception;

class InventarioRepository implements InventarioRepositoryInterface
{
    protected $modelColumns;

    public function __construct()
    {
        // Define las columnas válidas
        $this->modelColumns = (new Inventario())->getFillable();
    }
    
    public function all()
    {
        return Inventario::all();
    }

    public function getOne($column, $data)
    {
        $this->validateColumns($column);
        return Inventario::where($column,'=', $data)->first();
    }

    public function getAllByColumn($column, $data)
    {
        $this->validateColumns($column);
        return Inventario::where($column,'=', $data)->get();
    }

    public function searchOne($column, $data)
    {
        $this->validateColumns($column);
        return Inventario::where($column, 'LIKE', '%' . $data . '%')->first();
    }

    public function searchList($column, $data)
    {
        $this->validateColumns($column);
        return Inventario::where($column, 'LIKE', '%' . $data . '%')->get();
    }

    public function create(array $productoData)
    {
        return Inventario::create($productoData);
    }

    public function update($idProducto, array $data)
    {
        $inventarios = Inventario::where('idProducto','=',$idProducto)->get();
        foreach($inventarios as $inventario){
            foreach($data as $almacen => $stock){
                if($inventario->idAlmacen == $almacen){
                    $array = array();
                    $array['idAlmacen'] = $almacen;
                    $array['stock'] = $stock;
                    
                    $inventario->update($array);
                }
            }
        }
        
        return $inventarios;
    }
    
    public function addStock($idProducto,$idAlmacen){
        try{
            $inventario = Inventario::where('idProducto', '=', $idProducto)
            ->where('idAlmacen', '=', $idAlmacen)
            ->first();
            if ($inventario) {
                $inventario->stock++;
                $inventario->save();
            } else {
                // Manejo si no se encuentra el inventario
                throw new Exception('Inventario no encontrado.');
            }
        }catch(Exception $e){
            throw new Exception('Error en la operacion.');
        }
        
    }
    
    public function removeStock($idProducto,$idAlmacen){
        try{
            $inventario = Inventario::where('idProducto', '=', $idProducto)
            ->where('idAlmacen', '=', $idAlmacen)
            ->first();

            if ($inventario) {
                $inventario->stock--;
                $inventario->save();
            } else {
                // Manejo si no se encuentra el inventario
                throw new Exception('Inventario no encontrado.');
            }
        }catch(Exception $e){
            throw new Exception('Error en la operacion.');
        }
        
    }
    
    private function validateColumns($column){
        if (!in_array($column, $this->modelColumns)) {
            throw new \InvalidArgumentException("La columna '$column' no es válida.");
        }
    }
}