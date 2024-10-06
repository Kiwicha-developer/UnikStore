<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Plataforma;
use App\Models\CuentasPlataforma;
use App\Services\HeaderService;

class PlataformaController extends Controller
{
    public function index(){
        //variables de la cabecera
        $serviceHeader = new HeaderService;
        $userModel = $serviceHeader->getModelUser();
        
        //variables propias del controlador
        $plataformas = Plataforma::all();
        $cuentas = CuentasPlataforma::orderBy('idPlataforma')->get();
        
        return view('plataformas',['user' => $userModel,
                                    'plataformas' => $plataformas,
                                    'cuentas' => $cuentas,
                                    
        ]);
    }
    
    public function updateCuentas(Request $request){
        $estados = $request->input('estado', []);
        
        foreach($estados as $id => $estado){
            try{
                DB::beginTransaction();
                
                $cuenta = CuentasPlataforma::where('idCuentaPlataforma','=',$id)->first();
                $cuenta->estadoCuenta = $estado;
                
                $cuenta->save();
                
                DB::commit();
            }catch(Exception $e){
                DB::rollBack();
            }
            
        }
        
        echo("<script>alert('Cuentas actualizadas')</script>");
        return redirect()->back();
    }
    
    public function createCuenta(Request $request){
        $nombrecuenta = $request->input('cuenta');
        $idplataforma = $request->input('plataforma');
        
        if($nombrecuenta != ''){
            try{
                DB::beginTransaction();
                
                $cuenta = new CuentasPlataforma();
                $cuenta->idCuentaPlataforma = $this->getLastCuenta();
                $cuenta->nombreCuenta = $nombrecuenta;
                $cuenta->idPlataforma = $idplataforma;
                $cuenta->estadoCuenta = 'ACTIVO';
                
                $cuenta->save();
                
                DB::commit();
            }catch(Exception $e){
                DB::rollBack();
            }
            
        }
        
        echo("<script>alert('Cuenta creada')</script>");
        return redirect()->back();
    }
    
    private function getLastCuenta(){
        $lastId = CuentasPlataforma::select('idCuentaPlataforma')->orderBy('idCuentaPlataforma','desc')->first();
        $id = $lastId ? $lastId->idCuentaPlataforma : 0;
        return $id + 1;
    }
}