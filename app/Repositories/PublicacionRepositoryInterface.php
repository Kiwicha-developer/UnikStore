<?php
namespace App\Repositories;

interface PublicacionRepositoryInterface
{
    public function all();
    public function getOne($column,$data);
    public function getAllByColumn($column,$data);
    public function searchOne($column,$data);
    public function searchList($column,$data);
    public function getByMonth($month);
    public function validateSkuDuplicity($sku,$idPlataforma);
    public function create(array $data);
    public function update($id, array $data);
    public function getLast();
}