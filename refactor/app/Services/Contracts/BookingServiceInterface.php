<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface BookingServiceInterface
{
    public function index(Request $request);

    public function show($id);

    public function store($authenticatedUser, $data);

    public function update($id, $request);

    public function immediateJobEmail($request);

    public function getHistory($request);

    public function acceptJob($request);

    public function acceptJobWithId($request);

    public function cancelJob($request);

    public function endJob($request);

    public function customerNotCall($request);

    public function getPotentialJobs($request);

    public function distanceFeed($request);

    public function reopen($request);

    public function resendNotifications($request);

    public function resendSMSNotifications($request);
}
