<?php
namespace App\Repositories;

interface AccesosRepositoryInterface
{
    public function all();
    public function getOne($column,$data);
    public function getAllByColumn($column,$data);
    public function searchOne($column,$data);
    public function searchList($column,$data);
    public function deleteByUser($id);
    public function create($idVista,$idUser);
}