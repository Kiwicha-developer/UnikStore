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
                
                    return view('configweb',['user' => $userModel,
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
                
                    return view('configcalculos',['user' => $userModel,
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

    public function inventario(){
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                $almacenes = $this->configuracionService->getAllAlmacenes();
                $proveedores = $this->configuracionService->getAllProveedores();

                return view('configinventario',['user' => $userModel,
                                        'pagina' => 'inventario',
                                        'almacenes' => $almacenes,
                                        'proveedores' => $proveedores
                ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function productos(){
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                $categorias = $this->configuracionService->getAllCategorias();
                $marcas = $this->configuracionService->getAllMarcas();

                return view('configproductos',['user' => $userModel,
                                        'pagina' => 'productos',
                                        'categorias' => $categorias,
                                        'marcas' => $marcas
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
                $categorias = $this->configuracionService->getAllCategorias();
                $spects = $this->configuracionService->getAllEspecificaciones();
                
                return view('configespecificaciones',['user' => $userModel,
                                        'pagina' => 'especificaciones',
                                        'categorias' => $categorias,
                                        'caracteristicas' => $spects
                ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function createCaracteristica(Request $request){
        $userModel = $this->headerService->getModelUser();
        $descripcion = $request->input('descripcion');

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if($descripcion){
                    $this->configuracionService->createCaracteristica($descripcion);
                    $this->headerService->sendFlashAlerts('Especificacion creada',$descripcion . ' creada correctamente.','success','btn-success');
                    return back();
                }else{
                    $this->headerService->sendFlashAlerts('Faltan datos','Ingresa datos validos','warning','btn-danger');
                    return back();
                }
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function removeCaracteristica(Request $request){
        $userModel = $this->headerService->getModelUser();
        $idCaracteristica = $request->input('caracteristica');

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if($idCaracteristica){
                    $this->configuracionService->removeCaracteristica($idCaracteristica);
                    $this->headerService->sendFlashAlerts('Operacion exitosa','Datos eliminados correctamente','success','btn-success');
                    return back();
                }else{
                    $this->headerService->sendFlashAlerts('Faltan Datos','Verifica los campos de entrada','warning','btn-danger');
                    return back();
                }

            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function insertCaracteristicaXGrupo(Request $request){
        $userModel = $this->headerService->getModelUser();
        $idGrupo = $request->input('grupo');
        $idCaracteristica = $request->input('caracteristica');

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if($idGrupo && $idCaracteristica){
                    $this->configuracionService->insertCaracteristicaXGrupo($idGrupo,$idCaracteristica);
                    $this->headerService->sendFlashAlerts('Operacion exitosa','Datos registrados correctamente','success','btn-success');
                    return back();
                }else{
                    $this->headerService->sendFlashAlerts('Faltan datos','Ingresa datos validos','warning','btn-danger');
                    return back();
                }
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function deleteCaracteristicaXGrupo(Request $request){
        $userModel = $this->headerService->getModelUser();
        $idCaracteristica = $request->input('caracteristica');
        $idGrupo = $request->input('grupo');

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if($idCaracteristica && $idGrupo){
                    $this->configuracionService->deleteCaracteristicaXGrupo($idGrupo,$idCaracteristica);
                    $this->headerService->sendFlashAlerts('Operacion exitosa','Datos eliminados correctamente','success','btn-success');
                    return back();
                }
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
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