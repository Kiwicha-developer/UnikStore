<?php

namespace App\Http\Controllers;

use App\Services\DashboardServiceInterface;
use App\Services\HeaderServiceInterface;

class HomeController extends Controller
{
    protected $dashboardService;
    protected $headerService;

    public function __construct(DashboardServiceInterface $dashboardService,
                                HeaderServiceInterface $headerService)
    {
        $this->dashboardService = $dashboardService;
        $this->headerService = $headerService;
    }

    public function index(){
        //variables de la cabecera
        $userModel = $this->headerService->getModelUser();
        
        //variables del controlador
        $registros = $this->dashboardService->getRegistrosXEstados();
        $inventario = $this->dashboardService->getAllInventory()->sum('stock');
        $almacenes = $this->dashboardService->getAllInventory()->unique('idAlmacen')->pluck('Almacen');
        $colors = ['#ff5733','#33c6ff','#75e93c','#f4d84d'];
        $stock = array();

        foreach($almacenes as $almacen){
            $stock[] = ['almacen' => $almacen,'cantidad' => $this->dashboardService->getInventoryByAlmacen($almacen->idAlmacen)->sum('stock')];
        }
        
        return view('dashboard',['user' => $userModel,
                                    'registros' => $registros,
                                    'inventario' => $inventario,
                                    'stock' => $stock,
                                    'colors' => $colors
                                ]);
    }
}