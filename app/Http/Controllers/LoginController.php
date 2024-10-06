<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Services\SesionService;
use App\Services\UsuarioServiceInterface;

class LoginController extends Controller
{
    protected $usuarioService;
    protected $sesionService;

    public function __construct(UsuarioServiceInterface $usuarioService,
                                SesionService $sesionService)
    {
        $this->usuarioService = $usuarioService;
        $this->sesionService = $sesionService;
    }
    
    public function index(){
        $this->sesionService->setUser(-1);
        return view('login');
    }
    
    public function validation(Request $request)
    {
        $validatedData = $request->validate([
            'user' => 'required|string',
            'pass' => 'required|string',
        ]);
        
        $user = $validatedData['user'];
        $pass = $validatedData['pass'];
        
        $usuario = $this->usuarioService->getUser($user);
        
        $alerta = 'Credenciales incorrectas';
        if(!empty($usuario) && !$usuario->estadoUsuario){
            $alerta = 'Usuario invalido';
        }

        if(!empty($usuario) && Hash::check($pass,$usuario->pass) && $usuario->estadoUsuario){
            $this->sesionService->setUser($usuario->idUser);
            $this->sesionService->setSesion($usuario->idUser);
            return redirect()->route('dashboard');
        }else{
            session()->flash('alerta', $alerta);
            return redirect()->back();
        }
        
    }
}