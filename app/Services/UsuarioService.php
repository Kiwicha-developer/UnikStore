<?php
namespace App\Services;

use App\Repositories\CargoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

use App\Repositories\UsuarioRepositoryInterface;
use App\Repositories\VistaRepositoryInterface;

class UsuarioService implements UsuarioServiceInterface
{
    protected $userRepository;
    protected $vistaRepository;

    public function __construct(UsuarioRepositoryInterface $userRepository,
                                VistaRepositoryInterface $vistaRepository)
    {
        $this->userRepository = $userRepository;
        $this->vistaRepository = $vistaRepository;
    }
    
    public function getUsersXCargos($arrayCargos){
        $users = new Collection();
        foreach($arrayCargos as $cargo){
            $user = $this->userRepository->getAllByColumn('idCargo',$cargo);
            $users = $users->concat($user);
        }
        return $users;
    }
    
    public function getUser($user){
        return $this->userRepository->getOne('user',$user);
    }
    
    public function getUserId($id){
        return $this->userRepository->getOne('idUser',$id);
    }

    public function allUsers(){
        return $this->userRepository->all();
    }

    public function getAllViews(){
        return $this->vistaRepository->all();
    }

    public function updatePass($id,$pass){
        $this->userRepository->updatePass($id,$pass);
    }

    public function createUser(array $array){
        $array['idUser'] = $this->getNewUser(); 
        $this->userRepository->create($array);
    }

    private function getNewUser(){
        $lastId = $this->userRepository->getLast();
        $id = $lastId ? $lastId->idUser : 0;
        return $id + 1;
    }

}