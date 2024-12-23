<?php
namespace App\Services;

interface PdfServiceInterface
{
    public function getSerialsPrint($idComprobante);
    public function getReportsAlmacen();
    public function getAlmacenes();
    public function getSerialsByProduct($idProducto);
    public function getOneProduct($idProducto);
    public function getOneGarantia($idGarantia);
}