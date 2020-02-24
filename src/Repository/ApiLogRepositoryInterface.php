<?php
namespace App\Repository;

use App\Entity\ApiLog;

interface ApiLogRepositoryInterface
{
    public function save(ApiLog $apiLog): void;
}
