<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\HeaderServiceInterface;
use App\Services\ComprobanteServiceInterface;

class DocumentoController extends Controller
{
    protected $headerService;
    protected $comprobanteService;

    public function __construct(HeaderServiceInterface $headerService,
                                ComprobanteServiceInterface $comprobanteService)
    {
        $this->headerService = $headerService;
        $this->comprobanteService = $comprobanteService;
    }
    
    public function index($id,$bool){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //variables propias del controlador
        $documento = $this->comprobanteService->getOneById(decrypt($id));
        $ubicaciones = $this->comprobanteService->getAllAlmacen();
        
        $estados = [['value' => 'NUEVO', 'name' => 'Nuevo'],
                    ['value' => 'ABIERTO', 'name' => 'Abierto'],
                    ['value' => 'ROTO', 'name' => 'Roto'],
                    ['value' => 'DEFECTUOSO', 'name' => 'Defectuoso'],
                    ['value' => 'DEVOLUCION', 'name' => 'Devolucion']
                    ];
                    
        $medidas = [['value' => 'CAJA', 'name' => 'Caja'],
                    ['value' => 'UNIDAD', 'name' => 'Unidad']];
                    
        $adquisiciones = [['value' => 'NORMAL', 'name' => 'Normal'],
                        ['value' => 'OFERTA', 'name' => 'Oferta']];
                        
        return view('documento',['user' => $userModel,
                                'documento' => $documento,
                                'ubicaciones' => $ubicaciones,
                                'estados' => $estados,
                                'medidas' => $medidas,
                                'adquisiciones' => $adquisiciones,
                                'validate' => $bool
                                ]);
    }
    
    public function list($date){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //variables propias del controlador
        $carbonMonth = Carbon::createFromFormat('Y-m-d', $date . '-01');
        $documentos = $this->comprobanteService->getByMonth($date);
        
        return view('documentos',['user' => $userModel,
                                    'documentos' => $documentos,
                                    'fecha' => $carbonMonth
                                ]);
    }
    
    public function insertComprobante(Request $request){
        $userModel = $this->headerService->getModelUser();
        $proveedor = $request->input('proveedor');
        $tipoComprobante = $request->input('tipocomprobante');
        $numeroComprobante = $request->input('numerocomprobante');
        
        if($proveedor && $tipoComprobante && $numeroComprobante){
            $array = array();
            $array['idProveedor'] = $proveedor;
            $array['idTipoComprobante'] = $tipoComprobante;
            $array['idUser'] = $userModel->idUser;
            $array['numeroComprobante'] = $numeroComprobante;
            $array['moneda'] = 'SOL';
            $array['totalCompra'] = 0;
            $array['fechaRegistro'] = now();
            
            $operation = $this->comprobanteService->insertComprobante($array);
            if($operation){
                return redirect()->route('documento',[encrypt($operation),true]);
            }else{
                $this->headerService->sendFlashAlerts('Operacion Fallida','Ocurrio un error en la transaccion','error','btn-danger');
                return back()->withInput();
            }
        }else{
            $this->headerService->sendFlashAlerts('Datos Repetidos','Ya se encuentran en la base de datos','info','btn-danger');
            return back()->withInput();
        }
        
    }
    
    public function searchDocument(Request $request){
        $query = $request->input('query');
    
        $results = $this->comprobanteService->searchAjaxComprobante('numeroComprobante',$query);
    
        return response()->json($results);
    }
    
}