<?php
namespace App\Services;

interface ComprobanteServiceInterface
{
    public function getOneById($id);
    public function getByMonth($date);
    public function insertComprobante(array $inputs);
    public function updateComprobante($id,array $inputs,array $details);
    public function searchAjaxComprobante($column,$data);
    public function getAllAlmacen();
}