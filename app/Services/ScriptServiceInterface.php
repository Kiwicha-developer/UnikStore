<?php
namespace App\Services;

interface ScriptServiceInterface
{
    public function getAllCategorias();
    public function getAllAlmacen();
    public function getOneComprobante($idComprobante);
}