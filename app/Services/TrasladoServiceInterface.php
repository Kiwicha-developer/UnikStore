<?php
namespace App\Services;

interface TrasladoServiceInterface
{
    public function getAllAlmacenes();
    public function updateRegistros(array $array);
}