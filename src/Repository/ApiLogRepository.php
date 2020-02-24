<?php

namespace App\Repository;

use App\Entity\ApiLog;
use Doctrine\ORM\EntityManagerInterface;

class ApiLogRepository implements ApiLogRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function save(ApiLog $apiLog): void
    {
        $this->entityManager->persist($apiLog);
        $this->entityManager->flush();
    }

}
