<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Services\SesionService;
use App\Services\UsuarioServiceInterface;

class ValidateSession   
{
    protected $usuarioService;
    protected $sesionService;

    public function __construct(UsuarioServiceInterface $usuarioService,
                                SesionService $sesionService)
    {
        $this->usuarioService = $usuarioService;
        $this->sesionService = $sesionService;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $idUserSesion = $this->sesionService->getUser();
        $tokenSesion = $this->sesionService->getSesion();
        
        if($idUserSesion == -1 || empty($idUserSesion)){
            echo("<script>alert('Inicia sesion');</script>");
            return redirect('');
        }else{
            $usuario = $this->usuarioService->getUserId($idUserSesion);
            $tokenBase = $usuario->tokenSesion;
            $userBase = $usuario->idUser;
            if($tokenBase == $tokenSesion){
                $this->sesionService->eliminarSesionesCaducadas();
                return $next($request);
            }else{
                echo("<script>alert('Sesion en otro dispositivo');</script>");
                return redirect('');
            }
            
            
        }
    }
}
