<?php
namespace App\Services;

use Carbon\Carbon;

interface GarantiaServiceInterface
{
    public function getGarantiasByMonth(Carbon $date,int $cant);
}