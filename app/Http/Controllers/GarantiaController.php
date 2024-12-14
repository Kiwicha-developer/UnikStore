<?php

namespace App\Http\Controllers;

use App\Services\GarantiaServiceInterface;
use App\Services\HeaderServiceInterface;
use Carbon\Carbon;

class GarantiaController extends Controller
{
    protected $headerService;
    protected $garantiaService;

    public function __construct(HeaderServiceInterface $headerService,
                                GarantiaServiceInterface $garantiaService)
    {
        $this->headerService = $headerService;
        $this->garantiaService = $garantiaService;
    }

    public function index($date){
        $userModel = $this->headerService->getModelUser();

        $month = Carbon::createFromFormat('Y-m', $date);
        $garantias = $this->garantiaService->getGarantiasByMonth($month,50);

        return view('garantias',['user' => $userModel,
                                'garantias' => $garantias]);
    }

    public function create(){
        $userModel = $this->headerService->getModelUser();

        return view('creategarantia',['user' => $userModel]);
    }
}
