<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HeaderService;

class HomeController extends Controller
{
    public function index(Request $request){
        //variables de la cabecera
        $serviceHeader = new HeaderService;
        $userModel = $serviceHeader->getModelUser();
        
        //variables del controlador
        
        return view('dashboard',['user' => $userModel,
                                ]);
    }
}