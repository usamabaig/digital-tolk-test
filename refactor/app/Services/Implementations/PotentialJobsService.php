<?php

class PotentialJobsService implements PotentialJobsServiceInterface
{
    protected $repository;

    public function __construct(PotentialJobsRepository $potentialJobsRepository)
    {
        $this->repository = $potentialJobsRepository;
    }

    public function getPotentialJobs($user)
    {
        return $this->repository->getPotentialJobs($user);
    }

}
