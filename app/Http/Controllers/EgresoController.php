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
        $egresos = $this->egresoService->getEgresosByMonth($month);
        $almacenes = $this->egresoService->getAllAlmacenes();
        
        return view('egresos',['user' => $userModel,
                                'egresos' => $egresos,
                                'almacenes' => $almacenes,
                                'fecha' => $carbonMonth]);
    }
    
    public function insertEgreso(Request $request){
        $userModel = $this->headerService->getModelUser();
        $numeroserie = $request->input('serialnumber');
        $idregistro = $request->input('idregistro');
        $sku = $request->input('sku');
        $idpublicacion = $request->input('idpublicacion');
        $numeroorden = $request->input('numeroorden');
        $fechapedido = $request->input('fechapedido');
        $fechadespacho = $request->input('fechadespacho');
        
        $validateRegistro = '';
        if(is_null($idregistro)){
            $modelRegistro = $this->egresoService->getRegistro($numeroserie);
            $validateRegistro = $modelRegistro == null ? null : $modelRegistro->idRegistro;
        }else{
            $validateRegistro = $idregistro;
        }

        $validatePublicacion = '';
        if(is_null($idpublicacion)){
            $modelPublicacion = $this->egresoService->getPublicacion($sku);
            $validatePublicacion = $modelPublicacion == null ? null : $modelPublicacion->idPublicacion;
        }else{
            $validatePublicacion = $idpublicacion;
        }
        
        if(!is_null($validateRegistro) && !is_null($validatePublicacion) && !is_null($fechapedido) && !is_null($fechadespacho)){
            // try{
                $arrayEgreso = ['idRegistro' => $validateRegistro,
                                'idPublicacion' => $validatePublicacion == 'NULO' ? null : $validatePublicacion,
                                'numeroOrden' => $validatePublicacion == 'NULO' ? null : $numeroorden,
                                'fechaCompra' => $fechapedido,
                                'fechaDespacho' => $fechadespacho];
                
                $producto = $this->egresoService->createEgreso($arrayEgreso);
                $this->productoService->validateState($producto->idProducto);
                
                $this->headerService->sendFlashAlerts('Egreso registrado','Operacion exitosa','success','btn-success');
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
    
}