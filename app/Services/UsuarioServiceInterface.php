<?php
namespace App\Services;

interface UsuarioServiceInterface
{
    public function getUsersXCargos($arrayCargos);
    public function getUser($user);
    public function getUserId($id);
    public function allUsers();
    public function allCargos();
}