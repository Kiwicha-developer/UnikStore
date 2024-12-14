<?php
namespace App\Repositories;

use Carbon\Carbon;

interface GarantiaRepositoryInterface
{
    public function paginateAllByMonth(Carbon $date,int $cant);
}