<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Services\HeaderServiceInterface;

class EgresoController extends Controller
{
    protected $headerService;
    
    public function __construct(HeaderServiceInterface $headerService)
    {
        $this->headerService = $headerService;
    }
    
    public function index($month){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //variables propias del controlador
        Carbon::setLocale('es');
        $carbonMonth = Carbon::createFromFormat('Y-m', $month);
        $egresos = EgresoProducto::whereMonth('fechaSalida', $carbonMonth->month)
                                    ->get();
        
        return view('egresos',['user' => $userModel,
                                'egresos' => $egresos,
                                'fecha' => $carbonMonth]);
    }
    
    public function insertEgreso(Request $request){
        $numeroserie = $request->input('serialnumber');
        $idregistro = $request->input('idregistro');
        $sku = $request->input('sku');
        $idpublicacion = $request->input('idpublicacion');
        $numeroorden = $request->input('numeroorden');
        $fechapedido = $request->input('fechapedido');
        $fechadespacho = $request->input('fechadespacho');
        
        $validateRegistro = '';
        if(is_null($idregistro)){
            $validateRegistro = RegistroProducto::select('idRegistroProducto')->where('estado','!=','ENTREGADO')->where('numeroSerie','=',$numeroserie)->value('idRegistroProducto');
        }else{
            $validateRegistro = $idregistro;
        }
        
        $validatePublicacion = '';
        if(is_null($idpublicacion)){
            $validatePublicacion = Publicacion::select('idPublicacion')->where('sku','=',$sku)->value('idPublicacion');
        }else{
            $validatePublicacion = $idpublicacion;
        }
        
        try{
            if(!is_null($validateRegistro) && !is_null($validatePublicacion) && !is_null($fechapedido) && !is_null($fechadespacho)){
                $serviceHeader = new HeaderService;
                $userModel = $serviceHeader->getModelUser();
        
                $newIdEgreso = $this->getNewIdEgreso();
                $egreso = new EgresoProducto();
                $egreso->idEgreso = $newIdEgreso;
                $egreso->idRegistroProducto = $validateRegistro;
                if($validatePublicacion == 'NULO'){
                    $egreso->idPublicacion = null;
                }else{
                    $egreso->idPublicacion = $validatePublicacion;
                }
                $egreso->idUser = $userModel->idUser;
                $egreso->numeroPedido = $numeroorden;
                $egreso->fechaPedido = $fechapedido;
                $egreso->fechaSalida = $fechadespacho;
                
                $egreso->save();
                
                $registro = RegistroProducto::where('idRegistroProducto','=',$validateRegistro)->first();
                $registro->estado = 'ENTREGADO';
                
                $registro->save();
                
                echo("<script>alert('Egreso registrado')</script>");
                return back();
                
            }else{
                echo("<script>alert('Datos incompletos')</script>");
                return back();
            }
            
        }catch(Exception $e){
            echo("<script>alert('Hubo un error en la operacion')</script>");
            return back();
        }
    }
    
    public function searchRegistro(Request $request){
        $query = $request->input('query');
    
        $results = RegistroProducto::where('estado','!=','ENTREGADO')->where('estado','!=','INVALIDO')->where('numeroSerie', 'LIKE', "%{$query}%")
                    ->take(5) // Limitar a 5 resultados, por ejemplo
                    ->get()
                    ->map(function($details) {
                         return [
                            'nombreProducto' => $details->Producto->nombreProducto,
                            'almacen' => $details->Almacen->descripcion,
                            'idRegistroProducto' => $details->idRegistroProducto,
                            'numeroSerie' => $details->numeroSerie
                        ];
                    });
    
        return response()->json($results);
    }
    
    public function searchPublicacion(Request $request){
        $query = $request->input('query');
    
        $results = Publicacion::where('estado','=',1)->where('sku', 'LIKE', "%{$query}%")
                    ->take(5) // Limitar a 5 resultados, por ejemplo
                    ->get()
                    ->map(function($details) {
                         return [
                            'sku' => $details->sku,
                            'fechaPublicacion' => $details->fechaPublicacion->format('Y-m-d'),
                            'idPublicacion' => $details->idPublicacion,
                            'titulo' => $details->titulo
                        ];
                    });
    
        return response()->json($results);
    }
    
    private function getNewIdEgreso(){
        $lastEgreso = EgresoProducto::orderBy('idEgreso', 'desc')->first();
        $id = $lastEgreso ? $lastEgreso->idEgreso : 0;
        return $id + 1;
    }
}