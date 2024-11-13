<?php
namespace App\Repositories;

interface RegistroProductoRepositoryInterface
{
    public function getOne($column,$data);
    public function getAllByColumn($column,$data);
    public function searchOne($column,$data);
    public function searchList($column,$data);
    public function getByIngreso($month);
    public function create(array $data);
    public function update($id, array $data);
    public function getLast();
    public function searchByEgreso($serial);
    public function getByEgreso($serial);
    public function validateSerie($idProveedor,$serie);
}