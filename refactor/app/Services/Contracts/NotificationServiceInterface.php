<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface NotificationServiceInterface
{
    public function sendNotification($job, $jobData, $target);

    public function sendSMSNotification($job);
}
