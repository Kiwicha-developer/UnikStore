<?php
namespace App\Services;

interface PdfServiceInterface
{
    public function getSerialsPrint($idComprobante);
    public function getReportsAlmacen();
}