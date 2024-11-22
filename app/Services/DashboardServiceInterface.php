<?php
namespace App\Services;

interface DashboardServiceInterface 
{
    public function getRegistrosXEstados();
    public function getAllInventory();
    public function getInventoryByAlmacen($idAlmacen);
    public function getTotalProducts();
    public function getStockMinProducts();
    public function getOldPublicaciones();
}