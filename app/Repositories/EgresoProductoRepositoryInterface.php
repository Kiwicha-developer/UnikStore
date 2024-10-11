<?php
namespace App\Repositories;

interface EgresoProductoRepositoryInterface
{
    public function getOne($column,$data);
    public function getAllByColumn($column,$data);
    public function getAllByMonth($month);
    public function searchOne($column,$data);
    public function searchList($column,$data);
    public function create(array $data);
    public function update($id, array $data);
    public function getLast();
}