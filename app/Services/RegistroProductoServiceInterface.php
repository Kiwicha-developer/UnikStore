<?php
namespace App\Services;

interface RegistroProductoServiceInterface
{
    public function getByMonth($date);
    public function updateRegistro($id,array $data);
}