<?php

namespace App\Http\Controllers;

use App\Services\Contracts\BookingServiceInterface;
use App\Services\Contracts\NotificationServiceInterface;
use App\Services\Contracts\HistoryServiceInterface;
use App\Services\Contracts\DistanceServiceInterface;
use App\Services\Contracts\PotentialJobsServiceInterface;
use App\Services\Contracts\ReopenServiceInterface;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;
    protected $notificationService;
    protected $historyService;
    protected $distanceService;
    protected $potentialJobsService;
    protected $reopenService;

    public function __construct(
        BookingServiceInterface $bookingService,
        NotificationServiceInterface $notificationService,
        HistoryServiceInterface $historyService,
        DistanceServiceInterface $distanceService,
        PotentialJobsServiceInterface $potentialJobsService,
        ReopenServiceInterface $reopenService
    ) {
        $this->bookingService = $bookingService;
        $this->notificationService = $notificationService;
        $this->historyService = $historyService;
        $this->distanceService = $distanceService;
        $this->potentialJobsService = $potentialJobsService;
        $this->reopenService = $reopenService;
    }

    public function index(Request $request): Response
    {
        return response($this->bookingService->index($request));
    }

    public function show($id): Response
    {
        return response($this->bookingService->show($id));
    }

    public function store(Request $request): Response
    {
        $data = $request->all();
        $response = $this->bookingService->store($request->__authenticatedUser, $data);
        return response($response);
    }

    public function update($id, Request $request): Response
    {
        $data = $request->all();
        $response = $this->bookingService->update($id, $data);
        return response($response);
    }

    public function immediateJobEmail(Request $request): Response
    {
        $response = $this->bookingService->immediateJobEmail($request);
        return response($response);
    }

    public function getHistory(Request $request): Response
    {
        if ($user_id = $request->get('user_id')) {
            $response = $this->historyService->getUsersJobsHistory($user_id, $request);
            return response($response);
        }

        return null;
    }

    public function acceptJob(Request $request): Response
    {
        $data = $request->all();
        $user = $request->__authenticatedUser;
        $response = $this->bookingService->acceptJob($data, $user);
        return response($response);
    }

    public function acceptJobWithId(Request $request): Response
    {
        $data = $request->get('job_id');
        $user = $request->__authenticatedUser;
        $response = $this->bookingService->acceptJobWithId($data, $user);
        return response($response);
    }

    public function cancelJob(Request $request): Response
    {
        $data = $request->all();
        $user = $request->__authenticatedUser;
        $response = $this->bookingService->cancelJob($data, $user);
        return response($response);
    }

    public function endJob(Request $request): Response
    {
        $data = $request->all();
        $response = $this->bookingService->endJob($data);
        return response($response);
    }

    public function customerNotCall(Request $request): Response
    {
        $data = $request->all();
        $response = $this->bookingService->customerNotCall($data);
        return response($response);
    }

    public function getPotentialJobs(Request $request): Response
    {
        $data = $request->all();
        $user = $request->__authenticatedUser;
        $response = $this->potentialJobsService->getPotentialJobs($user);
        return response($response);
    }

    public function distanceFeed(Request $request): Response
    {
        $data = $request->all();
        $response = $this->distanceService->updateDistanceAndTime($data);
        return response($response);
    }

    public function reopen(Request $request): Response
    {
        $data = $request->all();
        $response = $this->reopenService->reopenJob($data);
        return response($response);

        git config --global user.email "ahamad.nazir627@gmail.com"
        git config --global user.name "Ahmad Nazir"
    }

    public function resendNotifications(Request $request): Response
    {
        $data = $request->all();
        $response = $this->bookingService->resendNotifications($data);
        return response($response);
    }

    public function resendSMSNotifications(Request $request): Response
    {
        $data = $request->all();
        $response = $this->bookingService->resendSMSNotifications($data);
        return response($response);
    }
}
