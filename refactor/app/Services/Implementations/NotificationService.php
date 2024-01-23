<?php 

class NotificationService implements NotificationServiceInterface
{
    protected $repository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->repository = $notificationRepository;
    }

    public function sendNotification($job, $jobData, $target)
    {
        return $this->repository->sendNotification($job, $jobData, $target);
    }

    public function sendSMSNotification($job)
    {
        return $this->repository->sendSMSNotification($job);
    }
}
