<?php
namespace App\Services;

interface PlataformaServiceInterface
{
    public function getAllPlataformas();
    public function updateCuentas(array $cuentas);
    public function createCuenta($idPlataforma,$nombreCuenta);
}