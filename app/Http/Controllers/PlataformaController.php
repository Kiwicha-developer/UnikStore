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
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 4){
                $plataformas = $this->plataformaService->getAllPlataformas();
                
                return view('plataformas',['user' => $userModel,
                                            'plataformas' => $plataformas
                ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
    
    public function updateCuentas(Request $request){
        $userModel = $this->headerService->getModelUser();
        $acounts = $request->input('cuentas', []);

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 4){
                $this->plataformaService->updateCuentas($acounts);
                $this->headerService->sendFlashAlerts('Cuentas actualizadas','Operacion realizada correctamente','success','btn-success');
                return redirect()->back();
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
    
    public function createCuenta(Request $request){
        $userModel = $this->headerService->getModelUser();
        $nombrecuenta = $request->input('cuenta');
        $idplataforma = $request->input('plataforma');

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 4){
                if($nombrecuenta != ''){
                    $this->plataformaService->createCuenta($idplataforma,$nombrecuenta);
                    $this->headerService->sendFlashAlerts('Cuenta Registrada','Operacion realizada correctamente.','success','btn-success');
                    return redirect()->back();
                }else{
                    $this->headerService->sendFlashAlerts('Faltan datos','Ingresa datos en el formulario.','info','btn-warning');
                    return redirect()->back();
                }
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
}