<?php
namespace App\Repositories;

interface PlataformaRepositoryInterface
{
    public function all();
    public function getOne($column,$data);
    public function getAllByColumn($column,$data);
    public function searchOne($column,$data);
    public function searchList($column,$data);
    public function getByRelation($table);  
    public function create(array $data);
    public function update($id, array $data);
}