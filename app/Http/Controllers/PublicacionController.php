<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\HeaderServiceInterface;
use App\Services\PublicacionServiceInterface;

class PublicacionController extends Controller
{
    protected $headerService;
    protected $publicacionService;
    
    public function __construct(HeaderServiceInterface $headerService,
                                PublicacionServiceInterface $publicacionService){
        $this->headerService = $headerService;
        $this->publicacionService = $publicacionService;
    }
    
    public function index($date){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //variables propias del controlador
        Carbon::setLocale('es');
        $carbonMonth = Carbon::createFromFormat('Y-m', $date);
        $publicaciones = $this->publicacionService->getAllPubliByMonth($date);
        $plataformas = $this->publicacionService->getAllPlatafromasByTipe('TIENDA');
        
        return view('publicaciones',['user' => $userModel,
                                    'publicaciones' => $publicaciones,
                                    'plataformas' => $plataformas,
                                    'fecha' => $carbonMonth
                                ]);
    }
    
    public function create($idPlataforma){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //variables propias del controlador
        $plataforma = $this->publicacionService->getOneByPlataformaId(decrypt($idPlataforma));
        return view('createpublicacion',['user' => $userModel,
                                        'plataforma' => $plataforma
                                ]);
    }
    
    public function insertPublicacion(Request $request){
        $titulo = $request->input('titulo');
        $sku = $request->input('sku');
        $fecha = $request->input('fecha');
        $cuenta = $request->input('cuenta');
        $idproducto = $request->input('idproducto');
        $precio = $request->input('precio');
        
        if($cuenta && $precio && $titulo && $fecha && $sku){
            if($idproducto ){
                $data = ['idCuentaPlataforma' => $cuenta,
                        'idProducto' => $idproducto,
                        'sku' => $sku,
                        'titulo' => $titulo,
                        'fechaPublicacion' => $fecha,
                        'precioPublicacion' => $precio];
                        
                $message = $this->publicacionService->insertPublicacion($data);
                echo("<script>alert('".$message['mensaje']."')</script>");
                return $message['transaccion'] ? 
                        redirect()->route('publicaciones',[now()->format('Y-m')]) : 
                        back()->withInput();
            }else{
                echo("<script>alert('Producto no encontrado')</script>");
                return back()->withInput();
            }
        }else{
            echo("<script>alert('Datos vacios')</script>");
            return back()->withInput();
        }
    }
    
    public function updateEstado(Request $request){
        $id = $request->input('id');
        $data = $request->input('data');
        
        if($id && $data){
            $message = $this->publicacionService->updatePublicacion($id,$data);
            echo("<script>alert('".$message."')</script>");
            return back();
        }else{
            echo("<script>alert('Ocurrio un error')</script>");
            return back();
        }
    }
}