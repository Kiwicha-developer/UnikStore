<?php

namespace App\Http\Controllers;

use App\Services\HeaderServiceInterface;
use App\Services\TrasladoServiceInterface;
use Illuminate\Http\Request;

class TrasladoController extends Controller
{
    protected $headerService;
    protected $trasladoService;

    public function __construct(HeaderServiceInterface $headerService,
                                TrasladoServiceInterface $trasladoService)
    {
        $this->headerService = $headerService;
        $this->trasladoService = $trasladoService;
    }

    public function index(){
        $userModel = $this->headerService->getModelUser();
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 8){
                $almacenes = $this->trasladoService->getAllAlmacenes();
                return view('traslado',['user' => $userModel,
                                        'almacenes' => $almacenes]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta accion','warning','btn-danger');
        return back();
    }

    public function updateRegistroAlmacen(Request $request){
        $userModel = $this->headerService->getModelUser();
        $data = $request->input('traslado');
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 8){
                $this->trasladoService->updateRegistros($data);
                $this->headerService->sendFlashAlerts('Traslado Existoso','Los registros se actualizaron correctamente','success','btn-success');
                return back();
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta accion','warning','btn-danger');
        return back();

    }
}