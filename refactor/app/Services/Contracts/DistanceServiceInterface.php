<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface DistanceServiceInterface
{
    public function updateDistanceAndTime($data);
}
