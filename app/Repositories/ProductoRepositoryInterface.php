<?php
namespace App\Repositories;

interface ProductoRepositoryInterface
{
    public function all();
    public function getOne($column,$data);
    public function getLast();
    public function getAllByColumn($column,$data);
    public function searchOne($column,$data);
    public function searchList($column,$data);
    public function searchIntensiveProducts($data);
    public function create(array $productoData);
    public function update($idProducto, array $data);
    public function getCodes();
    public function validateSerial($id,$serial);
    public function total();
    public function getStockMinProducts();
    public function getProductsWithStock();
}