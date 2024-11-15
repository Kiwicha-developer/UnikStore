<?php
namespace App\Services;

interface IngresoProductoServiceInterface
{
    public function getByComprobante($idComprobante);
    public function getByMonth($date);
    public function searchAjaxIngreso($data);
    public function deleteIngreso($id);
    public function getAllLabelProveedor();
    public function getAllTipoComprobante();
    public function getAllAlmacen();
    public function updateRegistro($idRegistro,$estado,$observacion);
}