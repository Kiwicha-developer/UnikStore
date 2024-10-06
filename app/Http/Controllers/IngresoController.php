<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\HeaderService;
use App\Services\IngresoProductoServiceInterface;
use App\Services\UsuarioServiceInterface;
use App\Services\ComprobanteServiceInterface;

class IngresoController extends Controller
{
    protected $userService;
    protected $ingresoService;
    protected $comprobanteService;

    public function __construct(UsuarioServiceInterface $userService,
                                IngresoProductoServiceInterface $ingresoService,
                                ComprobanteServiceInterface $comprobanteService)
    {
        $this->userService = $userService;
        $this->ingresoService = $ingresoService;
        $this->comprobanteService = $comprobanteService;
    }
    
    public function index($month){
        //variables de la cabecera
        $serviceHeader = new HeaderService;
        $userModel = $serviceHeader->getModelUser();
        
        //variables del controlador
        
        Carbon::setLocale('es');
        $fechacompleta = $month. '-01';
        $carbonMonth = Carbon::createFromFormat('Y-m-d', $fechacompleta);
        $registros = $this->ingresoService->getByMonth($month);
        
        $cargos = [1,2];
        $usuarios = $this->userService->getUsersXCargos($cargos);
        
        $proveedores = $this->ingresoService->getAllLabelProveedor();
        
        $documentos = $this->ingresoService->getAllTipoComprobante();
        
        return view('ingresos',['user' => $userModel,
                                'registros' => $registros,
                                'documentos' => $documentos,
                                'proveedores' => $proveedores,
                                'usuarios' => $usuarios,
                                'fecha' => $carbonMonth
                                ]);
    }
    
    public function insertIngreso($comprobante,Request $request){
        $serviceHeader = new HeaderService;
        $datacomprobante = $request->input('comprobante');
        $detalle = $request->input('detalle');
        if($datacomprobante){
            $this->comprobanteService->updateComprobante(decrypt($comprobante),$datacomprobante,$detalle);
            
            return redirect()->route('documento', [$comprobante, 0]);
        }else{
            
            $serviceHeader->sendFlashAlerts('Datos Faltantes','Revisa los campos','info','btn-warning');
            return back();
        }
        
    }
    
    public function searchIngreso(Request $request){
        $query = $request->input('query');
    
        $results = $this->ingresoService->searchAjaxIngreso($query);
    
        return response()->json($results);
    }
    
    public function deleteIngreso(Request $request){
        $idIngreso = $request->input('idingreso');
        $this->ingresoService->deleteIngreso($idIngreso);
        return back();
    }
    
}