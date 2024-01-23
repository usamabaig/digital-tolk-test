<?php

class ReopenService implements ReopenServiceInterface
{
    protected $repository;

    public function __construct(ReopenRepository $reopenRepository)
    {
        $this->repository = $reopenRepository;
    }

    public function reopenJob($data)
    {
        return $this->repository->reopenJob($data);
    }

}

