<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Services\HeaderService;
use App\Models\Empresa;
use App\Models\EmpresaRedSocial;

class PublicidadController extends Controller
{
    public function index(){
        //variables de la cabecera
        $serviceHeader = new HeaderService;
        $userModel = $serviceHeader->getModelUser();
        
        //variables propias del controlador
        $empresas = Empresa::select('idEmpresa','nombreComercial','rucEmpresa','colorUno','colorDos','colorTres','logo','icon','correoEmpresa','ubicacion','ubicacionLink','linkPaginaWeb')->get();
        
        return view('publicidad',['user' => $userModel,
                                    'empresas' => $empresas
                                ]);
    }
    
    public function empresa($idEmpresa){
        //variables de la cabecera
        $serviceHeader = new HeaderService;
        $userModel = $serviceHeader->getModelUser();
        
        //variables propias del controlador
        $empresa = Empresa::where('idEmpresa','=',decrypt($idEmpresa))->first();
        
        return view('empresa-publicidad',['user' => $userModel,
                                            'empresa' => $empresa
                                ]);
    }
    
    public function updatePublicaion(Request $request){
        $enlaces = $request->input('enlaces');
        $idEmpresa = $request->input('empresa');
        
        if(!empty($idEmpresa)){
            $empresa = Empresa::where('idEmpresa','=',$idEmpresa)->first();
            if(!empty($enlaces)){
                foreach($enlaces as $id => $enlace){
                    $redSocial = EmpresaRedSocial::where('idEmpresa','=',$idEmpresa)->where('idRedSocial','=',$id)->first();
                    $redSocial->enlace = $enlace;
                    
                    $redSocial->save();
                }
            }
            //dd($request->file('imgRed'));
        }
        
        echo("<script>alert('Funka')</script>");
        return redirect()->route('publicidad');
    }
}