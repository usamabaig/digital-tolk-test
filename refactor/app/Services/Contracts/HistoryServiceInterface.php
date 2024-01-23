<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface HistoryServiceInterface
{
    public function getUsersJobsHistory($userId, $request);
}
