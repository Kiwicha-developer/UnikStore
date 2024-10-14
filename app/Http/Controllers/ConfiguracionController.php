<?php

namespace App\Http\Controllers;

use App\Services\CalculadoraServiceInterface;
use App\Services\ConfiguracionServiceInterface;
use App\Services\HeaderServiceInterface;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    protected $headerService;
    protected $calculadoraService;
    protected $configuracionService;

    public function __construct(HeaderServiceInterface $headerService,
                                CalculadoraServiceInterface $calculadoraService,
                                ConfiguracionServiceInterface $configuracionService)
    {
        $this->headerService = $headerService;
        $this->calculadoraService = $calculadoraService;
        $this->configuracionService = $configuracionService;
    }
    public function web(){
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                $empresas = $this->configuracionService->getAllEmpresas();
                
                    return view('configuracion',['user' => $userModel,
                                            'pagina' => 'web',
                                            'empresas' => $empresas
                    ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function calculos(){
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                $categorias = $this->configuracionService->getAllCategorias();
                $rangos = $this->configuracionService->getAllRangos();
                
                $calculos = $this->calculadoraService->get();
                
                $empresas = $this->configuracionService->getAllEmpresas();
                
                    return view('configuracion',['user' => $userModel,
                                            'pagina' => 'calculos',
                                            'empresas' => $empresas,
                                            'calculos' => $calculos,
                                            'categorias' => $categorias,
                                            'rangos' =>$rangos
                    ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function almacen(){
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                
                    return view('configuracion',['user' => $userModel,
                                            'pagina' => 'almacen'
                    ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function categorias(){
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                
                    return view('configuracion',['user' => $userModel,
                                            'pagina' => 'categorias'
                    ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function especificaciones(){
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                
                return view('configuracion',['user' => $userModel,
                                        'pagina' => 'especificaciones'
                ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
    
    public function updateComision(Request $request){
        $userModel = $this->headerService->getModelUser();
        $comisiones = $request->input('comision');
        $grupo = $request->input('grupo');

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if(!empty($comisiones) && !empty($grupo)){
                    foreach($comisiones as $rango => $comision){
                        $this->configuracionService->updateComisionValue($grupo,$rango,$comision);
                    }
                    $this->headerService->sendFlashAlerts('Actualizacion correcta','Operacion realizada con exito','success','btn-success');
                    return back();
                }else{
                    $this->headerService->sendFlashAlerts('Error','Hubo un error en la operacion','error','btn-danger');
                    return back()->withInput();
                }
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
    
    public function updateCalculos(Request $request){
        $userModel = $this->headerService->getModelUser();
        $igv = $request->input('igv');
        $facturacion = $request->input('facturacion');
        $empresas = $request->input('empresas');

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if(!empty($igv) && !empty($facturacion) && !empty($empresas)){
                    $this->configuracionService->updateCalculadora($igv,$facturacion);
                    
                    foreach($empresas as $idEmpresa => $comision){
                        $this->configuracionService->updateComisionEmpresa($idEmpresa,$comision);
                    }
                    
                    return back()->withInput();
                }else{
                    $this->headerService->sendFlashAlerts('Error','Hubo un error en la operacion','error','btn-danger');
                    return back()->withInput();
                }
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);

    }
    
    public function updateCorreos(Request $request){
        $userModel = $this->headerService->getModelUser();
        $correos = $request->input('correos');

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if(!empty($correos)){
                    foreach($correos as $idEmpresa => $correo){
                        $this->configuracionService->updateCorreoEmpresa($idEmpresa,$correo);
                    }
                    
                    return back();
                }else{
                    $this->headerService->sendFlashAlerts('Error','Hubo un error en la operacion','error','btn-danger');
                    return back()->withInput();
                }
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
}