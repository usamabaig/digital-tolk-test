<?php

use App\Repository\BookingRepository;

class BookingService implements BookingServiceInterface
{
    protected $repository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->repository = $bookingRepository;
    }


    public function index(Request $request)
    {
        if ($user_id = $request->get('user_id')) {
            return $this->repository->getUsersJobs($user_id);
        }

        if ($request->__authenticatedUser->user_type == env('ADMIN_ROLE_ID') || $request->__authenticatedUser->user_type == env('SUPERADMIN_ROLE_ID')) {
            return $this->repository->getAll($request);
        }

        // Handle other cases based on your requirements
        return null;
    }

    public function show($id)
    {
        $job = $this->repository->with('translatorJobRel.user')->find($id);

        return $job;
    }

    public function store($authenticatedUser, $data)
    {
        return $this->repository->store($authenticatedUser, $data);
    }

    public function update($id, $data)
    {
        $cuser = request()->__authenticatedUser;

        return $this->repository->updateJob($id, array_except($data, ['_token', 'submit']), $cuser);
    }

    public function immediateJobEmail($data)
    {
        $adminSenderEmail = config('app.adminemail');
        return $this->repository->storeJobEmail($data);
    }

    public function getHistory($user_id, Request $request)
    {
        if ($user_id) {
            return $this->repository->getUsersJobsHistory($user_id, $request);
        }

        return null;
    }

    public function acceptJob($data, $user)
    {
        return $this->repository->acceptJob($data, $user);
    }

    public function acceptJobWithId($jobId, $user)
    {
        return $this->repository->acceptJobWithId($jobId, $user);
    }

    public function cancelJob($data, $user)
    {
        return $this->repository->cancelJobAjax($data, $user);
    }

    public function endJob($data)
    {
        return $this->repository->endJob($data);
    }

    public function customerNotCall($data)
    {
        return $this->repository->customerNotCall($data);
    }

    public function getPotentialJobs($user)
    {
        return $this->repository->getPotentialJobs($user);
    }

    public function distanceFeed($data)
    {
        $distance = $data['distance'] ?? "";
        $time = $data['time'] ?? "";
        $jobid = $data['jobid'] ?? "";
        $session = $data['session_time'] ?? "";
        $flagged = ($data['flagged'] == 'true') ? 'yes' : 'no';
        $manually_handled = ($data['manually_handled'] == 'true') ? 'yes' : 'no';
        $by_admin = ($data['by_admin'] == 'true') ? 'yes' : 'no';
        $admincomment = $data['admincomment'] ?? "";

        if ($flagged == 'yes' && $admincomment == '') {
            return response("Please, add comment");
        }

        if ($time || $distance) {
            Distance::where('job_id', '=', $jobid)->update(['distance' => $distance, 'time' => $time]);
        }

        if ($admincomment || $session || $flagged || $manually_handled || $by_admin) {
            Job::where('id', '=', $jobid)->update([
                'admin_comments' => $admincomment,
                'flagged' => $flagged,
                'session_time' => $session,
                'manually_handled' => $manually_handled,
                'by_admin' => $by_admin
            ]);
        }

        return response('Record updated!');
    }

    public function reopen($data)
    {
        return $this->repository->reopen($data);
    }

    public function resendNotifications($data)
    {
        $job = $this->repository->find($data['jobid']);
        $job_data = $this->repository->jobToData($job);

        $this->repository->sendNotificationTranslator($job, $job_data, '*');

        return response(['success' => 'Push sent']);
    }

    public function resendSMSNotifications($data)
    {
        $job = $this->repository->find($data['jobid']);
        $job_data = $this->repository->jobToData($job);

        try {
            $this->repository->sendSMSNotificationToTranslator($job);
            return response(['success' => 'SMS sent']);
        } catch (\Exception $e) {
            return response(['success' => $e->getMessage()]);
        }
    }

}
