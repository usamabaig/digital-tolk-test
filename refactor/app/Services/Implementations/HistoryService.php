<?php 

use Illuminate\Http\Request;
use DTApi\Repository\HistoryRepository;

class HistoryService implements HistoryServiceInterface
{
    protected $repository;

    public function __construct(HistoryRepository $historyRepository)
    {
        $this->repository = $historyRepository;
    }

    public function getUsersJobsHistory($userId, Request $request)
    {
        return $this->repository->getUsersJobsHistory($userId, $request);
    }
}
