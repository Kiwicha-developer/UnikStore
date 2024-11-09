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
        $registros = $this->comprobanteService->getAllRegistrosByComprobanteId(decrypt($id));
        $registrosFiltrados = $registros->filter(function($register) {
            return strpos($register->numeroSerie, 'UNK-') !== false;
        });
        
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

        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 8 && $bool){
                return view('documento',['user' => $userModel,
                'documento' => $documento,
                'ubicaciones' => $ubicaciones,
                'estados' => $estados,
                'medidas' => $medidas,
                'adquisiciones' => $adquisiciones,
                'validate' => $bool
                ]);
            }

            if($acceso->idVista == 3 && !$bool){
                return view('documento',['user' => $userModel,
                'documento' => $documento,
                'ubicaciones' => $ubicaciones,
                'estados' => $estados,
                'medidas' => $medidas,
                'adquisiciones' => $adquisiciones,
                'validate' => $bool,
                'pdf' => $registrosFiltrados
                ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
    
    public function list($date){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        foreach($userModel->Accesos as $acceso){
            if($acceso->idVista == 3){
                $carbonMonth = Carbon::createFromFormat('Y-m-d', $date . '-01');
                $documentos = $this->comprobanteService->getByMonth($date);
                
                return view('documentos',['user' => $userModel,
                                            'documentos' => $documentos,
                                            'fecha' => $carbonMonth
                                        ]);
            }
        }
        $this->headerService->sendFlashAlerts('Acceso denegado','No tienes permiso para ingresar a esta pestaña','warning','btn-danger');
        return redirect()->route('dashboard',['user' => $userModel]);
    }
    
    
    
    public function searchDocument(Request $request){
        $query = $request->input('query');
    
        $results = $this->comprobanteService->searchAjaxComprobante('numeroComprobante',$query);
    
        return response()->json($results);
    }
    
}