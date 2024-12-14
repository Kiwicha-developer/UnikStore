<?php
namespace App\Http\Controllers;

use App\Services\HeaderServiceInterface;

class ClienteController extends Controller
{
    protected $headerService;

    public function __construct(HeaderServiceInterface $headerService)
    {
        $this->headerService = $headerService;
    }

    public function index(){
        $userModel = $this->headerService->getModelUser();

        return view('clientes',['user' => $userModel]);
    }
}