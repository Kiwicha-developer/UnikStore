<?php
namespace App\Services;

interface EgresoProductoServiceInterface
{
    public function getEgresosByMonth($date);
    public function searchAjaxRegistro($serial);
}