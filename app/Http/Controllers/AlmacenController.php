<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\HeaderService;
use App\Models\Empresa;
use App\Models\RangoPrecio;
use App\Models\Comision;
use App\Models\Calculadora;
use App\Models\CategoriaProducto;
use App\Models\GrupoProducto;
use App\Models\Almacen;
use Illuminate\Support\Facades\Hash;

class AlmacenController extends Controller
{
    public function index(){
        //variables de la cabecera
        $serviceHeader = new HeaderService;
        $userModel = $serviceHeader->getModelUser();
        
        //Variables propias del controlador
        $categorias = Almacen::all();
        dd($categorias);
            return redirect()->route('dashboard',['user' => $userModel]);

    }
}