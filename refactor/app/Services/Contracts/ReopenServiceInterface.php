<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface ReopenServiceInterface
{
    public function reopenJob($data);
}
