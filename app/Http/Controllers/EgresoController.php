<?php

namespace App\Http\Controllers;

use App\Services\EgresoProductoServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\HeaderServiceInterface;
use App\Services\ProductoServiceInterface;
use Exception;

class EgresoController extends Controller
{
    protected $headerService;
    protected $egresoService;
    protected $productoService;
    
    public function __construct(HeaderServiceInterface $headerService,
                                EgresoProductoServiceInterface $egresoService,
                                ProductoServiceInterface $productoService)
    {
        $this->headerService = $headerService;
        $this->egresoService = $egresoService;
        $this->productoService = $productoService;
    }
    
    public function index($month){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //variables propias del controlador
        Carbon::setLocale('es');
        $carbonMonth = Carbon::createFromFormat('Y-m', $month);
        $egresos = $this->egresoService->getEgresosByMonth($month,150);
        $almacenes = $this->egresoService->getAllAlmacenes();
        
        return view('egresos',['user' => $userModel,
                                'egresos' => $egresos,
                                'almacenes' => $almacenes,
                                'fecha' => $carbonMonth]);
    }

    public function create(){
        $userModel = $this->headerService->getModelUser();
        return view('createegreso',['user' => $userModel]);
    }
    
    public function insertEgreso(Request $request){
        $userModel = $this->headerService->getModelUser();
        $sku = $request->input('sku');
        $idpublicacion = $request->input('idpublicacion');
        $numeroorden = $request->input('numeroorden');
        $fechapedido = $request->input('fechapedido');
        $fechadespacho = $request->input('fechadespacho');
        $registros = $request->input('idregistros');
        
        if(count($registros) < 1){
            $this->headerService->sendFlashAlerts('Error en el formulario','Verifica que las series esten correctas existan','info','btn-warning');
            return back();
        }

        $validatePublicacion = '';
        if(is_null($idpublicacion)){
            $modelPublicacion = $this->egresoService->getPublicacion($sku);
            $validatePublicacion = $modelPublicacion == null ? null : $modelPublicacion->idPublicacion;
        }else{
            $validatePublicacion = $idpublicacion;
        }
        
        if(!is_null($validatePublicacion) && !is_null($fechapedido) && !is_null($fechadespacho)){
                $arrayEgreso = ['idPublicacion' => $validatePublicacion == 'NULO' ? null : $validatePublicacion,
                                'numeroOrden' => $validatePublicacion == 'NULO' ? null : $numeroorden,
                                'fechaCompra' => $fechapedido,
                                'fechaDespacho' => $fechadespacho];
                
                $productos = $this->egresoService->createEgreso($arrayEgreso,$registros);
                foreach($productos as $producto){
                    $this->productoService->validateState($producto->idProducto);
                }
                $this->headerService->sendFlashAlerts('Egreso registrado','Operacion exitosa','success','btn-success');
                return back();
                
        }else{
            $this->headerService->sendFlashAlerts('Datos incompletos','Verifica que los datos ingresados existan','info','btn-warning');
            return back();
        }
            
        
    }

    public function devolucionEgreso(Request $request){
        $transaccion = $request->input('transaccion');
        $idegreso = $request->input('idegreso');
        $observacion = $request->input('observacion');

        if(isset($transaccion) && isset($idegreso)){
            $this->egresoService->updateEgreso($transaccion,$idegreso,$observacion);

            $this->headerService->sendFlashAlerts('Operacion exitosa','No hubo ningún error en la operacion','success','btn-success');
            return back();
        }else{
            $this->headerService->sendFlashAlerts('Datos incompletos','Verifica que los datos ingresados existan','info','btn-warning');
            return back();
        }
    }
    
    public function searchRegistro(Request $request){
        $query = $request->input('query');
        $results = $this->egresoService->searchAjaxRegistro($query);
    
        return response()->json($results);
    }

    public function searchEgreso(Request $request){
        $query = $request->input('query');
        $results = $this->egresoService->searchAjaxEgreso($query,5);
    
        return response()->json($results);
    }
    
}