<?php
namespace App\Repositories;

interface InventarioRepositoryInterface
{
    public function all();
    public function getOne($column,$data);
    public function getAllByColumn($column,$data);
    public function searchOne($column,$data);
    public function searchList($column,$data);
    public function create(array $data);
    public function update($id, array $data);
    public function addStock($idProducto,$idAlmacen);
    public function removeStock($idProducto,$idAlmacen);
}