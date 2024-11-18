<?php
namespace App\Services;

interface DashboardServiceInterface 
{
    public function getRegistrosXEstados();
    public function getAllInventory();
    public function getInventoryByAlmacen($idAlmacen);
}