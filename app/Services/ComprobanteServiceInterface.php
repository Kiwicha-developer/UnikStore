<?php
namespace App\Services;

interface ComprobanteServiceInterface
{
    public function getOneById($id);
    public function getByMonth($date,$cant,$querys);
    public function getAllRegistrosByComprobanteId($idComprobante);
    public function insertComprobante(array $inputs);
    public function updateComprobante($id,array $inputs,array $details);
    public function searchAjaxComprobante($column,$data);
    public function validateSeriesAjax($idProveedor,array $data);
    public function getAllAlmacen();
    public function deleteComprobante($idComprobante);
    public function filtroUsuario($month);
    public function filtroProveedor($month);
    public function filtroDocumento($month);
    public function filtroEstado($month);
}