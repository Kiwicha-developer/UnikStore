<?php
namespace App\Services;

interface EgresoProductoServiceInterface
{
    public function getEgresosByMonth($date);
    public function searchAjaxRegistro($serial);
    public function getRegistro($serial);
    public function getPublicacion($sku);
    public function createEgreso(array $data);
    public function getAllAlmacenes();
}