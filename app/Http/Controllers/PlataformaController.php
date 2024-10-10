<?php

namespace App\Http\Controllers;

use App\Services\HeaderServiceInterface;
use App\Services\PlataformaServiceInterface;
use Illuminate\Http\Request;

class PlataformaController extends Controller
{
    protected $headerService;
    protected $plataformaService;

    public function __construct(HeaderServiceInterface $headerService,
                                PlataformaServiceInterface $plataformaService)
    {
        $this->headerService = $headerService;
        $this->plataformaService = $plataformaService;
    }
    public function index(){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //variables propias del controlador
        $plataformas = $this->plataformaService->getAllPlataformas();
        
        return view('plataformas',['user' => $userModel,
                                    'plataformas' => $plataformas
                                    
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