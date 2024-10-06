<?php
namespace App\Services;

interface PublicacionServiceInterface
{
    public function getOneById($id);
    public function getAllPubliByMonth($month);
    public function insertPublicacion(array $data);
    public function updatePublicacion($id,$type);
    public function getAllPlatafromasByTipe($type);
    public function getOneByPlataformaId($id);
}