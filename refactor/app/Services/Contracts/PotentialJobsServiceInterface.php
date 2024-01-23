<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface PotentialJobsServiceInterface
{
    public function getPotentialJobs($user);
}
