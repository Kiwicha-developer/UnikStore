<?php
namespace App\Services;

use App\Repositories\UsuarioRepositoryInterface;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB as Database;

class SesionService
{
    protected $userRepository;

    public function __construct(UsuarioRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function getUser(){
        $idUser = session()->get('idUser',-1);
        return $idUser;
    }
    
    public function setUser($id){
        session(['idUser' => $id]);
    }
    
    public function getSesion(){
        $token = session()->get('token',0);
        return $token;
    }
    
    public function setSesion($id){
        $randomNumber = random_int(1, 99999);
        $data = ['tokenSesion' => $randomNumber];
        $this->userRepository->update($id,$data);
        session(['token' => $randomNumber]);
    }
    
    public function eliminarSesionesCaducadas()
    {
         $threeDaysAgo = Carbon::now()->subDays(3)->getTimestamp();

        $proba = Database::table('sessions')
            ->where('last_activity', '>', $threeDaysAgo)->get();
        //dd($proba);
    }
   
}