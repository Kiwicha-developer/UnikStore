<?php
namespace App\Repositories;

interface CaracteristicasGrupoRepositoryInterface
{
    public function getOne($idGrupo,$idCaracteristica);
    public function getAllByColumn($column,$data);
    public function create(array $data);
}