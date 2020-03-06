<?php

namespace App\Repository;

use App\Entity\ApiLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
            $this->saveToFile($apiLog);
    }
    public function saveToFile(ApiLog $apiLog): void
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $filesystem = new Filesystem();
        $filesystem->appendToFile('logs.txt', $serializer->serialize($apiLog, 'json') . "\n\n");
    }

}
