<?php
namespace App\Services;

interface HeaderServiceInterface
{
    public function getModelUser();
    public function newTransaccion($referencia,$descripcion,$tipo);
    public function sendFlashAlerts($title, $message, $icon, $button);
}