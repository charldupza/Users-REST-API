<?php

namespace App\Repository;

use App\Entity\ApiLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\ErrorHandler\ErrorHandler;
use Psr\Log\LoggerInterface;

ErrorHandler::register();

class ApiLogRepository implements ApiLogRepositoryInterface
{
    private $entityManager;
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }
    public function save(ApiLog $apiLog): void
    {
            $this->entityManager->persist($apiLog);
            $this->entityManager->flush();
            $this->logTest($apiLog);
    }
    public function logTest(ApiLog $apiLog): void
    {
            $this->saveToFile($apiLog);
    }
    public function saveToFile(ApiLog $apiLog): void
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $filesystem = new Filesystem();
        try {
            $filesystem->appendToFile('logs.txt', $serializer->serialize($apiLog, 'json') . "\n\n");
        }catch(\Exception $e){
            $this->logger->error($e->getMessage());
        }
        

    }

}
