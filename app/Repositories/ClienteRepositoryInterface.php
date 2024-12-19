<?php
namespace App\Repositories;

interface ClienteRepositoryInterface
{
    public function all($cant);
    public function getOne($column,$data);
    public function validateDuplicity($type,$number);
    public function create(array $data);
    public function getLast();
}