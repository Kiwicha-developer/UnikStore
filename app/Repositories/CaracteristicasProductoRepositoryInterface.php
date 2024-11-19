<?php
namespace App\Repositories;

interface CaracteristicasProductoRepositoryInterface
{
    public function updateCaracteristica($idCaracteristica,$idProducto,$descripcion);
    public function insertCaracteristica($idCaracteristica,$idProducto,$descripcion);
    public function deleteSpect($idProducto,$idCaracteristica);
}