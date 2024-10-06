<?php
namespace App\Services;

use App\Repositories\CargoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

use App\Repositories\UsuarioRepositoryInterface;

class UsuarioService implements UsuarioServiceInterface
{
    protected $userRepository;
    protected $cargoRepository;

    public function __construct(UsuarioRepositoryInterface $userRepository,
                                CargoRepositoryInterface $cargoRepository)
    {
        $this->userRepository = $userRepository;
        $this->cargoRepository = $cargoRepository;
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

    public function allCargos(){
        return $this->cargoRepository->all();
    }
    
}