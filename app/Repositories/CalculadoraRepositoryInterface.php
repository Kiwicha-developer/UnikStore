<?php
namespace App\Repositories;

interface CalculadoraRepositoryInterface
{
    public function get();
    public function update(array $data);
}