<?php
namespace App\Services;

use Carbon\Carbon;
use App\Repositories\AlmacenRepositoryInterface;
use App\Repositories\ComprobanteRepositoryInterface;
use App\Repositories\DetalleComprobanteRepositoryInterface;
use App\Repositories\ProductoRepositoryInterface;
use App\Repositories\RegistroProductoRepositoryInterface;
use App\Repositories\IngresoProductoRepositoryInterface;
use App\Repositories\InventarioRepositoryInterface;
use Exception;

class ComprobanteService implements ComprobanteServiceInterface
{
    protected $comprobanteRepository;
    protected $almacenRepository;
    protected $detalleComprobanteRepository;
    protected $productoRepository;
    protected $registroProductoRepository;
    protected $ingresoRepository;
    protected $headerService;
    protected $inventarioRepository;

    public function __construct(ComprobanteRepositoryInterface $comprobanteRepository,
                                AlmacenRepositoryInterface $almacenService,
                                DetalleComprobanteRepositoryInterface $detalleComprobanteRepository,
                                ProductoRepositoryInterface $productoRepository,
                                RegistroProductoRepositoryInterface $registroProductoRepository,
                                IngresoProductoRepositoryInterface $ingresoRepository,
                                HeaderServiceInterface $headerService,
                                InventarioRepositoryInterface $inventarioRepository)
    {
        $this->comprobanteRepository = $comprobanteRepository;
        $this->almacenRepository = $almacenService;
        $this->detalleComprobanteRepository = $detalleComprobanteRepository;
        $this->productoRepository = $productoRepository;
        $this->registroProductoRepository = $registroProductoRepository;
        $this->ingresoRepository = $ingresoRepository;
        $this->headerService = $headerService;
        $this->inventarioRepository = $inventarioRepository;
    }

    public function getAllRegistrosByComprobanteId($idComprobante){
        return $this->comprobanteRepository->getAllRegistrosByComprobanteId($idComprobante);
    }
    
     public function getAllAlmacen(){
        $almacenes = $this->almacenRepository->all();
        return $almacenes;
    }
    
    public function getOneById($id){
        return $this->comprobanteRepository->getOne('idComprobante',$id);
    }
    
    public function getByMonth($date){
        Carbon::setLocale('es');
        $fechacompleta = $date. '-01';
        $carbonMonth = Carbon::createFromFormat('Y-m-d', $fechacompleta);
        return $this->comprobanteRepository->getAllByMonth($carbonMonth);
    }
    
    public function insertComprobante(array $inputs){
        $exists = $this->comprobanteRepository->validateDuplicity($inputs['numeroComprobante'],$inputs['idTipoComprobante'],$inputs['idProveedor']);
        
        if(!$exists){
            $inputs['idComprobante'] = $this->getNewIdComprobante();
            $comprobante = $this->comprobanteRepository->create($inputs);
            return $inputs['idComprobante'];
        }else{
            return null;
        }
    }
    
    public function updateComprobante($id,array $inputs,array $details){
          if ($id && $inputs) {
            if (empty($details)) {
                // Elimina si no hay detalles
                $this->comprobanteRepository->remove($id);
            } else {
                // Actualiza el comprobante si hay detalles
                $arrayComprobante = [
                    'moneda' => $inputs['moneda'],
                    'adquisicion' => $inputs['adquisicion'],
                    'totalCompra' => $inputs['total'],
                    'estado' => 'REGISTRADO',
                ];
                
                $comprobante = $this->comprobanteRepository->update($id, $arrayComprobante);
                foreach($details as $detail){
                    $arrayDetalle = [
                    'idComprobante' => $id,
                    'idProducto' => $detail['producto'],
                    'medida' => $detail['medida'],
                    'precioUnitario' => $detail['preciounitario'],
                    'precioCompra' => $detail['preciototal'],
                    ];
                    
                    $registros = $detail['ingreso'];
                    $almacen = $inputs['almacen'];
                    
                    $this->insertDetalleComprobante($arrayDetalle,$registros,$almacen);
                }
            }
        }
    }
    
    public function searchAjaxComprobante($column,$data){
        $comprobantes = $this->comprobanteRepository->searchList($column,$data)
                        ->take(5)
                        ->map(function($comprobante) {
                            $comprobante->fechaPersonalizada = Carbon::parse($comprobante->fechaRegistro)->format('d-m-Y');
                            $comprobante->encryptId = encrypt($comprobante->idComprobante );
                            $comprobante->Preveedor = $comprobante->Preveedor;
                            return $comprobante;
                        });
        return $comprobantes;
    }

    public function validateSeriesAjax($idProveedor,array $data){
        $series = array();
        foreach($data as $serie){
            if($serie != 0){
                $find = $this->registroProductoRepository->validateSerie($idProveedor,$serie);
                if($find){
                    $series[] = $serie;
                }
            }
        }
        return $series;
    }

    private function insertDetalleComprobante(array $data, array $registros,$idAlmacen){
        if($data){
            //Para actualizar stock
            $idProducto = $data['idProducto'];
            //Para el detalle del Comprobante
            $data['idDetalleComprobante'] = $this-> getNewIdDetalleComprobante();
            $detalle = $this->detalleComprobanteRepository->create($data);
            if($detalle && $idAlmacen){
                foreach($registros as $registro){
                    if($registro['serialnumber'] == 0){
                        $validate = null;
                        $registro['serialnumber'] = $this->generateSerial($idProducto);
                    }else{
                        $validate = $this->productoRepository->validateSerial($idProducto,$registro['serialnumber']);
                    }
                    
                    if(!$validate){
                        $arrayRegistro = [
                        'idDetalleComprobante' => $data['idDetalleComprobante'],
                        'numeroSerie' => $registro['serialnumber'],
                        'estado' => $registro['estado'],
                        'observacion' => $registro['observacion'],
                        'idAlmacen' => $idAlmacen
                        ];
                        try {
                            $this->insertRegistro($arrayRegistro);
                            $this->addStock($idProducto, $idAlmacen);
                        } catch (Exception $e) {
                            // Manejo de errores: puedes registrar el error o mostrar un mensaje
                            // Log::error('Error al insertar registro: ' . $e->getMessage());
                        }
                    }
                    
                }
            }
        }
    }

    private function generateSerial($idProduct){
        try {
            $product = $this->productoRepository->getOne('idProducto', $idProduct);
            
            if (!$product) {
                throw new \Exception('Producto no encontrado.');
            }
    
            $parcialCode = 'UNK-' . $product->codigoProducto;
            $validateCode = $this->registroProductoRepository->searchList('numeroSerie', $parcialCode);
            
            $code = $parcialCode . '-' . (100000 + (count($validateCode) + 1));
            
            return $code;
    
        } catch (\Exception $e) {
            throw new \Exception('Error al generar el número de serie: ' . $e->getMessage());
        }
    }

    private function insertRegistro(array $data){
        if($data){
            $data['idRegistro'] = $this->getNewIdRegistro();
            $data['fechaMovimiento'] = now();
            $registro = $this->registroProductoRepository->create($data);
            if($registro){
                $this->insertIngreso($data['idRegistro']);
            }
        }
    }

    private function insertIngreso($idRegistro){
        $user = $this->headerService->getModelUser();
        if($idRegistro){
            $data = [
                'idIngreso' => $this->getNewIdIngreso(),
                'idRegistro' => $idRegistro,
                'idUser' => $user->idUser,
                'fechaIngreso' => now(),
                ];
            $this->ingresoRepository->create($data);
        }
    }

    private function addStock($idProducto,$idAlmacen){
        $this->inventarioRepository->addStock($idProducto,$idAlmacen);
    }

    private function getNewIdIngreso(){
        $lastIngreso = $this->ingresoRepository->getLast();
        $id = $lastIngreso ? $lastIngreso->idIngreso : 0;
        
        return $id + 1;
    }

    private function getNewIdDetalleComprobante(){
        $lastComprobante = $this->detalleComprobanteRepository->getLast();
        $id = $lastComprobante ? $lastComprobante->idDetalleComprobante : 0;
        
        return $id + 1;
    }
    
    private function getNewIdComprobante(){
        $lastComprobante = $this->comprobanteRepository->getLast();
        $id = $lastComprobante ? $lastComprobante->idComprobante : 0;
        
        return $id + 1;
    }

    private function getNewIdRegistro(){
        $lastRegistro = $this->registroProductoRepository->getLast();
        $id = $lastRegistro ? $lastRegistro->idRegistro : 0;
        
        return $id + 1;
    }
}