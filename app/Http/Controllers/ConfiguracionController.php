<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\HeaderService;
use App\Models\Empresa;
use App\Models\RangoPrecio;
use App\Models\Comision;
use App\Models\Calculadora;
use App\Models\CategoriaProducto;
use App\Models\GrupoProducto;
use Illuminate\Support\Facades\Hash;

class ConfiguracionController extends Controller
{
    public function index(){
        //variables de la cabecera
        $serviceHeader = new HeaderService;
        $userModel = $serviceHeader->getModelUser();
        
        //Variables propias del controlador
        $categorias = CategoriaProducto::select('idCategoria','nombreCategoria','iconCategoria')->get();
        $rangos = RangoPrecio::select('idRango','descripcion')->get();
        
        $calculos = Calculadora::first();
        
        $empresas = Empresa::all();
        
        if($userModel->idCargo == 1){
            return view('configuracion',['user' => $userModel,
                                    'categorias' => $categorias,
                                    'rangos' => $rangos,
                                    'calculos' => $calculos,
                                    'empresas' => $empresas
            ]);
        }else{
            echo("<script>alert('No tienes permiso')</script>");
            return redirect()->route('dashboard',['user' => $userModel]);
        }
        
        
    }
    
    public function updateComision(Request $request){
        //variables de la cabecera
        $serviceHeader = new HeaderService;
        $userModel = $serviceHeader->getModelUser();
        
        //variables del controlador
        $comisiones = $request->input('comision');
        $grupo = $request->input('grupo');
        
        
        $category = $request->input('category');
        
        
        if($userModel->idCargo == 1){
            if(!empty($comisiones) && !empty($grupo)){
                foreach($comisiones as $rango => $comision){
                    $comisionModel = Comision::where('idGrupoProducto','=',$grupo)->where('idRango','=',$rango)->first();
                    $comisionModel->comision = $comision;
                    
                    $comisionModel->save();
                }
                
                echo("<script>alert('Guardado')</script>");
                return back()->withInput();
            }else{
                echo("<script>alert('Error en la actualización')</script>");
                return back()->withInput();
            }
            
            
        }else{
            echo("<script>alert('No tienes permiso')</script>");
            return redirect()->route('dashboard',['user' => $userModel]);
        }
    }
    
    public function updateCalculos(Request $request){
        //variables de la cabecera
        $serviceHeader = new HeaderService;
        $userModel = $serviceHeader->getModelUser();
        
        //variables del controlador
        $igv = $request->input('igv');
        $facturacion = $request->input('facturacion');
        $empresas = $request->input('empresas');
        
        if($userModel->idCargo == 1){
                if(!empty($igv) && !empty($facturacion) && !empty($empresas)){
                    $calculadora = Calculadora::first();
                    $calculadora->igv = $igv;
                    $calculadora->facturacion = $facturacion;
                    
                    $calculadora->save();
                    
                    foreach($empresas as $idEmpresa => $comision){
                        $empresaModel = Empresa::where('idEmpresa','=',$idEmpresa)->first();
                        $empresaModel->comision = $comision;
                        
                        $empresaModel->save();
                    }
                    
                    echo("<script>alert('Valores actualizados')</script>");
                    return back()->withInput();
                }else{
                    echo("<script>alert('Error en la operacion')</script>");
                    return back()->withInput();
                }
        }else{
            echo("<script>alert('No tienes permiso')</script>");
            return redirect()->route('dashboard',['user' => $userModel]);
        }
    }
    
    public function updateCorreos(Request $request){
        //variables de la cabecera
        $serviceHeader = new HeaderService;
        $userModel = $serviceHeader->getModelUser();
        
        //variables propias del controlador
        $correos = $request->input('correos');
        
        if($userModel->idCargo == 1){
            if(!empty($correos)){
                foreach($correos as $idEmpresa => $correo){
                    $empresaModel = Empresa::where('idEmpresa','=',$idEmpresa)->first();
                    $empresaModel->correoEmpresa = $correo;
                    
                    $empresaModel->save();
                }
                
                echo("<script>alert('Fuynka')</script>");
                return back()->withInput();
            }else{
                echo("<script>alert('Error en la operacion.')</script>");
                return back()->withInput();
            }
            
        }else{
            echo("<script>alert('No tienes permiso')</script>");
            return redirect()->route('dashboard',['user' => $userModel]);
        }
    }
}