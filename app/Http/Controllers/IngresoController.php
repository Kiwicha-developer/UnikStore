<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\IngresoProductoServiceInterface;
use App\Services\UsuarioServiceInterface;
use App\Services\ComprobanteServiceInterface;
use App\Services\HeaderServiceInterface;

class IngresoController extends Controller
{
    protected $userService;
    protected $ingresoService;
    protected $comprobanteService;
    protected $headerService;

    public function __construct(HeaderServiceInterface $headerService,
                                UsuarioServiceInterface $userService,
                                IngresoProductoServiceInterface $ingresoService,
                                ComprobanteServiceInterface $comprobanteService)
    {
        $this->userService = $userService;
        $this->ingresoService = $ingresoService;
        $this->comprobanteService = $comprobanteService;
        $this->headerService = $headerService;
    }
    
    public function index($month,Request $request){
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 8){
                Carbon::setLocale('es');
                $fechacompleta = $month. '-01';
                $carbonMonth = Carbon::createFromFormat('Y-m-d', $fechacompleta);
                
                $registros = $this->ingresoService->getByMonth($month,250,$request->query('filtro'))->appends($request->all());

                if($request->query('page') || $request->query('filtro')){
                    $view = view('components.lista_ingresos', ['registros' => $registros,'container' => $request->query('container')])->render();
                    return response()->json(['html' => $view]);
                }
                
                $proveedores = $this->ingresoService->getAllLabelProveedor();
                
                $documentos = $this->ingresoService->getAllTipoComprobante();

                $almacenes = $this->ingresoService->getAllAlmacen();

                $estados = [['value' => 'NUEVO', 'name' => 'Nuevo'],
                    ['value' => 'ABIERTO', 'name' => 'Abierto'],
                    ['value' => 'DEFECTUOSO', 'name' => 'Defectuoso'],
                    ['value' => 'DEVOLUCION', 'name' => 'Devolución'],
                    ['value' => 'ENTREGADO', 'name' => 'Entregado'],
                    ['value' => 'GARANTIA', 'name' => 'Garantía']
                    ];
                
                $filtros = ['users' => $this->ingresoService->filtroUsuario($month),
                            'proveedores' => $this->ingresoService->filtroProveedor($month),
                            'almacenes' => $this->ingresoService->filtroAlmacen($month),
                            'estados' => $this->ingresoService->filtroEstado($month)];

                
                return view('ingresos',['user' => $userModel,
                                        'registros' => $registros,
                                        'documentos' => $documentos,
                                        'proveedores' => $proveedores,
                                        'fecha' => $carbonMonth,
                                        'almacenes' => $almacenes,
                                        'estados' => $estados,
                                        'filtros' => $filtros
                                        ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return back();
    }
    
    public function insertIngreso($comprobante,Request $request){
        $userModel = $this->headerService->getModelUser();
        $datacomprobante = $request->input('comprobante');
        $detalle = $request->input('detalle');

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 8){
                if($datacomprobante){
                    $this->comprobanteService->updateComprobante(decrypt($comprobante),$datacomprobante,$detalle);
                    
                    return redirect()->route('documento', [$comprobante, 0]);
                }else{
                    
                    $this->headerService->sendFlashAlerts('Datos Faltantes','Revisa los campos','info','btn-warning');
                    return back();
                }
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
    
    public function searchIngreso(Request $request){
        $query = $request->input('query');
    
        $results = $this->ingresoService->searchAjaxIngreso($query);
    
        return response()->json($results);
    }
    
    public function deleteIngreso(Request $request){
        $userModel = $this->headerService->getModelUser();
        $idIngreso = $request->input('idingreso');
        $userModel = $this->headerService->getModelUser();
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 8){
                $this->ingresoService->deleteIngreso($idIngreso);
                return back();
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta accion','warning','btn-danger');
        return back();
    }

    public function insertComprobante(Request $request){
        $userModel = $this->headerService->getModelUser();
        $proveedor = $request->input('proveedor');
        $tipoComprobante = $request->input('tipocomprobante');
        $numeroComprobante = $request->input('numerocomprobante');
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 8){
                if($proveedor && $tipoComprobante && $numeroComprobante){
                    $array = array();
                    $array['idProveedor'] = $proveedor;
                    $array['idTipoComprobante'] = $tipoComprobante;
                    $array['idUser'] = $userModel->idUser;
                    $array['numeroComprobante'] = $numeroComprobante;
                    $array['moneda'] = 'SOL';
                    $array['totalCompra'] = 0;
                    $array['fechaRegistro'] = now();
                    $array['estado'] = 'PENDIENTE';
                    
                    $operation = $this->comprobanteService->insertComprobante($array);
                    if($operation){
                        return redirect()->route('documento',[encrypt($operation),true]);
                    }else{
                        $this->headerService->sendFlashAlerts('Operacion Fallida','Ocurrio un error en la transaccion','error','btn-danger');
                        return back()->withInput();
                    }
                }else{
                    $this->headerService->sendFlashAlerts('Datos Repetidos','Ya se encuentran en la base de datos','info','btn-danger');
                    return back()->withInput();
                }
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
    
    public function updateRegistro(Request $request){
        $userModel = $this->headerService->getModelUser();
        $idRegistro =  $request->input('idregistro');
        $estado =  $request->input('estado');
        $observacion =  $request->input('observacion');

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 8){
                if(isset($idRegistro)){
                    $this->ingresoService->updateRegistro($idRegistro,$estado,$observacion);
                }
                return back();
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta accion','warning','btn-danger');
        return back();
    }
}