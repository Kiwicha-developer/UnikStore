<?php
namespace App\Repositories;

use Carbon\Carbon;

interface GarantiaRepositoryInterface
{
    public function paginateAllByMonth(Carbon $date,int $cant);
    public function getOne($id);
    public function getLast();
    public function create(array $data);
}