<?php
namespace App\Http\Controllers;

use App\Services\ClienteServiceInterface;
use App\Services\HeaderServiceInterface;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected $headerService;
    protected $clienteService;

    public function __construct(HeaderServiceInterface $headerService,
                                ClienteServiceInterface $clienteService)
    {
        $this->headerService = $headerService;
        $this->clienteService = $clienteService;
    }

    public function index(){
        $userModel = $this->headerService->getModelUser();
        $tipoDocumentos = $this->clienteService->getAllTipoDocumentos();
        $clientes = $this->clienteService->paginateAllCliente(20);
        return view('clientes',['user' => $userModel,
                                'tipoDocumentos' => $tipoDocumentos,
                                'clientes' => $clientes]);
    }

    public function createCliente(Request $request){
        $userModel = $this->headerService->getModelUser();
        $nombre = $request->input('nombre');
        $apePaterno = $request->input('apepaterno');
        $apeMaterno = $request->input('apematerno');
        $tipoDoc = $request->input('tipodoc');
        $numeroDoc = $request->input('numerodoc');
        $telefono = $request->input('numerotelf');
        $correo = $request->input('correo');

        if(isset($nombre) && isset($tipoDoc) && isset($numeroDoc)){
            $this->clienteService->createCliente($nombre,$apePaterno,$apeMaterno,$tipoDoc,$numeroDoc,$telefono,$correo);
            $this->headerService->sendFlashAlerts('Cliente registrado','Operación exitosa','success','btn-success');
            return back();
        }
    }
}