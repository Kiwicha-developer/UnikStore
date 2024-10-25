<?php
namespace App\Services;

interface UsuarioServiceInterface
{
    public function getUsersXCargos($arrayCargos);
    public function getUser($user);
    public function getUserId($id);
    public function allUsers();
    public function getAllViews();
    public function createUser(array $array);
    public function updatePass($id,$pass);
    public function updateAccesos($user,$state,$accesos);
    public function updateBandeja($id,$bandeja);
}