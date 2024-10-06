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
        $cargos = $this->usuarioService->allCargos();
        
        if($userModel->idCargo == 1){
            return view('usuarios',['user' => $userModel,
                                    'usuarios' => $usuarios,
                                    'cargos' => $cargos
            ]);
        }else{
            $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
            return redirect()->route('dashboard',['user' => $userModel]);
        }
        
        
    }
    
    public function create(){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //Variables propias del controlador
        $cargos = $this->usuarioService->allCargos();
                      
        if($userModel->idCargo == 1){
            return view('createuser',['user' => $userModel,
                                    'cargos' => $cargos]);
        }else{
            $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para realizar esta operacion','warning','btn-danger');
            return redirect()->route('dashboard',['user' => $userModel]);
        }
    }
    
    public function createUser(Request $request){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //Variables propias del controlador
        $user = $request->input('user');
        $cargo = $request->input('cargo');
        $pass = $request->input('pass');
        $validatePass = $request->input('confirmpass');
        
        
        
        
        if($userModel->idCargo == 1){
            try{
                DB::beginTransaction();
                
                $usuario = new Usuario();
                $usuario->idUser = $this->newIdUser();
                $usuario->user = $user;
                $usuario->idCargo = $cargo;
                $usuario->pass = Hash::make($pass);
                $usuario->tokenSesion = 0;
                $usuario->registroSesion = false;
                $usuario->horaSesion = date('Y-m-d H:i:s');
                $usuario->estadoUsuario = true;
                
                $usuario->save();
                
                DB::commit();
                
                echo("<script>alert('Usuario creado')</script>");
                return redirect()->back();
            }catch(Exception $e){
                DB::rollBack();
                echo("<script>alert('Error en la transacion.')</script>");
                return redirect()->back();
            }
                
        }else{
            echo("<script>alert('No tienes permiso')</script>");
            return redirect()->route('dashboard',['user' => $userModel]);
        }
    }
    
    public function updatePass(Request $request){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //Variables propias del controlador
        $id = $request->input('id');
        $pass = $request->input('pass');
        
        $user = Usuario::where('idUser','=',$id)->first();
        $user->pass = Hash::make($pass);
        
        $user->save();
        
        if($userModel->idCargo == 1){
                echo("<script>alert('Contraseña actualizada".$id."')</script>");
                return redirect()->back();
        }else{
            echo("<script>alert('No tienes permiso')</script>");
            return redirect()->route('dashboard',['user' => $userModel]);
        }
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
    
    private function newIdUser(){
        $id = Usuario::select('idUser')->orderBy('idUser','desc')->first();
        $newId = $id ? $id->idUser : 0;
        return $newId + 1;
    }
}