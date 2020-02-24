<?php
namespace App\Service;

use App\Entity\ApiLog;
use App\Repository\ApiLogRepository;
use App\Repository\ApiLogRepositoryInterface;

class ApiLogService
{
    private $apiLogRepository;

    //Use Interface To Seperate from Persistence
    public function __construct(ApiLogRepositoryInterface $ApiLogRepository)
    {
        $this->apiLogRepository = $ApiLogRepository;
    }

    // Send Call To Save Log
    public function saveCall(ApiLog $apilog): void
    {
        $this->apiLogRepository->save($apilog);
    }

}
