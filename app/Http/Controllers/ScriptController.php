<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Calculadora;
use App\Models\Almacen;
use Illuminate\Support\Facades\DB;

class ScriptController extends Controller
{
    public function headerScript(){
        
        $js = view('js.header-scripts')->render();
        dd('problema');
        return response($js)->header('Content-Type', 'application/javascript');
    }
    
    public function createProductScript($tc)
    {
        $latestProductCodes = Producto::select('idGrupo', DB::raw('MAX(codigoProducto) as codigoProducto'))->groupBy('idGrupo')->get();        
        $js = view('js.create-product-scripts',['tc' => $tc,
                                                'codigos' => $latestProductCodes])->render();
        
        return response($js)->header('Content-Type', 'application/javascript');
    }
    
    public function updateProductScript($tc){
        
        $js = view('js.update-product-scripts',['tc' => $tc])->render();
        
        return response($js)->header('Content-Type', 'application/javascript');
    }
    
    public function listProductScript($tc){
        
        $js = view('js.list-products-scripts',['tc' => $tc])->render();
        
        return response($js)->header('Content-Type', 'application/javascript');
    }
    
    public function calculatorScript(){
        $valores = Calculadora::first();
        
        $js = view('js.calculator-scripts',['valores' => $valores])->render();
        
        return response($js)->header('Content-Type', 'application/javascript');
    }
    
    public function documentoScript(){
        $ubicaciones = Almacen::all();
        
        $estados = [['value' => 'NUEVO', 'name' => 'Nuevo'],
                    ['value' => 'ABIERTO', 'name' => 'Abierto'],
                    ['value' => 'ROTO', 'name' => 'Roto'],
                    ['value' => 'DEFECTUOSO', 'name' => 'Defectuoso'],
                    ['value' => 'DEVOLUCION', 'name' => 'Devolucion']
                    ];
                    
        $medidas = [['value' => 'CAJA', 'name' => 'Caja'],
                    ['value' => 'UNIDAD', 'name' => 'Unidad']];
                    
        $adquisiciones = [['value' => 'NORMAL', 'name' => 'Normal'],
                        ['value' => 'OFERTA', 'name' => 'Oferta']];
        
        $js = view('js.documento-scripts',['ubicaciones' => $ubicaciones,
                                            'estados' => $estados,
                                            'medidas' => $medidas,
                                            'adquisiciones' => $adquisiciones])->render();
        
        return response($js)->header('Content-Type', 'application/javascript');
    }
}