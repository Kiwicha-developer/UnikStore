<?php
namespace App\Repositories;

interface ComprobanteRepositoryInterface
{
    public function getOne($column,$data);
    public function getAllByColumn($column,$data);
    public function getAllByMonth($month);
    public function searchOne($column,$data);
    public function searchList($column,$data);
    public function create(array $data);
    public function update($id, array $data);
    public function remove($id);
    public function validateDuplicity($number,$type,$idProveedor);
    public function getLast();
}