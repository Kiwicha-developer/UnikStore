<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HeaderServiceInterface;
use App\Services\UsuarioServiceInterface;

class UsuarioController extends Controller
{
    protected $headerService;
    protected $usuarioService;


    public function __construct(HeaderServiceInterface $headerService,
                                UsuarioServiceInterface $usuarioService)
    {
     $this->headerService = $headerService;
     $this->usuarioService = $usuarioService;
    }
    public function index(){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //Variables propias del controlador
        $usuarios = $this->usuarioService->allUsers();
        $vistas = $this->usuarioService->getAllViews();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 6){
                return view('usuarios',['user' => $userModel,
                'usuarios' => $usuarios,
                'vistas' => $vistas
                ]);
            }
        }

        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
        
    }
    
    public function create(){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 6){
                return view('createuser',['user' => $userModel]);
            }
        }

        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
    
    public function createUser(Request $request){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //Variables propias del controlador
        $user = $request->input('user');
        $pass = $request->input('pass');

        $validateUser = $this->usuarioService->getUser($user);
        if($validateUser){
            $this->headerService->sendFlashAlerts('Usuario existente','Verificar si el usuario existe en la base','error','btn-danger');
            return redirect()->back();
        }

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 6){
                $array = ['user' => $user,
                        'pass'=>$pass];

                $this->usuarioService->createUser($array);

                $this->headerService->sendFlashAlerts('Usuario registrado','Operacion realizada correctamente','success','btn-success');
                return redirect()->back();
            }
        }

        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->back();return redirect()->route('dashboard',['user' => $userModel]);

    }
    
    public function updatePass(Request $request){
        //Variables propias del controlador
        $id = $request->input('id');
        $pass = $request->input('pass');

        $this->usuarioService->updatePass($id,$pass);
        
        $this->headerService->sendFlashAlerts('Contraseña actualizada','Actualizacion correcta','success','btn-success');
        return redirect()->back();
    }
    
    public function updateUser(Request $request){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //Variables propias del controlador
        $id = $request->input('id');
        $user = $request->input('user');
        $cargo = $request->input('cargo');
        $stringEstado = $request->input('estado');
        
        $boolEstado = false;
        if($stringEstado == 'true'){
            $boolEstado = true;
        }
        
        if($userModel->idCargo == 1){
            if(!is_null($id) && !is_null($user) && !is_null($cargo) && !is_null($boolEstado)){
                try{
                    DB::beginTransaction();
                    
                    $usuario = Usuario::where('idUser','=',$id)->first();
                    $usuario->user = $user;
                    $usuario->idCargo = $cargo;
                    $usuario->estadoUsuario = $boolEstado;
                    
                    $usuario->save();
                    
                    DB::commit();
                    
                    echo("<script>alert('Datos actualizados.')</script>");
                    return redirect()->back();
                }catch(Exception $e){
                    DB::rollBack();
                    
                    echo("<script>alert('Datos actualizados.')</script>");
                    return redirect()->back();
                }
                
            }else{
                echo("<script>alert('No puedes dejar un campo vacio.')</script>");
                return redirect()->back();
            }  
        }else{
            echo("<script>alert('No tienes permiso')</script>");
            return redirect()->route('dashboard',['user' => $userModel]);
        }
    }
}