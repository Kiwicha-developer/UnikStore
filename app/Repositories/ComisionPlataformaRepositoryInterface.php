<?php
namespace App\Repositories;

interface ComisionPlataformaRepositoryInterface{
    public function all();
    public function getOne($column,$data);
    public function getAllByColumn($column,$data);
    public function searchOne($column,$data);
    public function searchList($column,$data);
    public function create(array $data);
    public function update($id, array $comisionData);
    public function delete($id);
    public function getLast();
}