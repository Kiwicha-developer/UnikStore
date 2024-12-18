<?php
namespace App\Repositories;

interface ClienteRepositoryInterface
{
    public function all($cant);
    public function create(array $data);
    public function getLast();
}