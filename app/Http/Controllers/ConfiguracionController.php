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

                $plataformas = $this->configuracionService->getAllPlataformas();
                
                return view('configcalculos',['user' => $userModel,
                                        'pagina' => 'calculos',
                                        'empresas' => $empresas,
                                        'calculos' => $calculos,
                                        'categorias' => $categorias,
                                        'rangos' =>$rangos,
                                        'plataformas' => $plataformas
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
                $tipos = $this->configuracionService->getAllTipoProductos();

                return view('configproductos',['user' => $userModel,
                                        'pagina' => 'productos',
                                        'categorias' => $categorias,
                                        'marcas' => $marcas,
                                        'tipos' => $tipos
                ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function especificaciones($idCategoria){
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                $categorias = $this->configuracionService->getAllCategorias();
                $categoria = $this->configuracionService->getOneCategoria(decrypt($idCategoria));
                $spects = $this->configuracionService->getAllEspecificaciones();
                
                return view('configespecificaciones',['user' => $userModel,
                                        'pagina' => 'especificaciones',
                                        'categorias' => $categorias,
                                        'categoria' => $categoria,
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

    public function updateCuentasBancarias(Request $request){
        $userModel = $this->headerService->getModelUser();
        $idCuenta = $request->input('id');
        $titular = $request->input('titular');
        $numeroCuenta = $request->input('cuenta');
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if($idCuenta && $titular && $numeroCuenta){
                    $this->configuracionService->updateCuentaBancaria($idCuenta,$titular,$numeroCuenta);
                    return back();
                }else{
                    $this->headerService->sendFlashAlerts('Faltan Datos','Faltan datos para completar las transaccion','warning','btn-warning');
                    return back();
                }
                dd($request);
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function createAlmacen(Request $request){
        $userModel = $this->headerService->getModelUser();
        $descripcion = $request->input('descripcion');
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                $this->configuracionService->createAlmacen($descripcion);
                return back();
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function createProveedor(Request $request){
        $userModel = $this->headerService->getModelUser();
        $razSocial = $request->input('razonsocial');
        $nombreComercial = $request->input('nombrecomercial');
        $ruc = $request->input('ruc');
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                $this->configuracionService->createProveedor($razSocial,$nombreComercial,$ruc);
                return back();
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function createComisionPlataforma(Request $request){
        $userModel = $this->headerService->getModelUser();
        $idPlataforma = $request->input('plataforma');
        $comision = $request->input('comision');
        $flete = $request->input('flete');

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if(isset($idPlataforma) && isset($comision) && isset($flete)){
                    $this->configuracionService->createComisionPlataforma($idPlataforma,$comision,$flete);
                }
                return back();
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function deleteComisionPlataforma(Request $request){
        $userModel = $this->headerService->getModelUser();
        $idComisionPlataforma = $request->input('id');
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if(isset($idComisionPlataforma)){
                    $this->configuracionService->deleteComisionPlataforma($idComisionPlataforma);
                }
                return back();
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function createMarcaProducto(Request $request){
        $userModel = $this->headerService->getModelUser();
        $nombre = $request->input('nombre');
        $img = $request->file('img');
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if(isset($nombre) && isset($img)){
                    $this->configuracionService->createMarcaProducto($nombre,$img);
                }
                return back();
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }

    public function createGrupoProducto(Request $request){
        $userModel = $this->headerService->getModelUser();
        $categoria = $request->input('categoria');
        $grupo = $request->input('grupo');
        $img = $request->file('img');
        $tipo = $request->input('tipo');
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 7){
                if(isset($categoria) && isset($grupo) && isset($img) && isset($tipo)){
                    $this->configuracionService->createGrupoProducto($categoria,$grupo,$tipo,$img);
                }
                return back();
            }
        }    
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
}