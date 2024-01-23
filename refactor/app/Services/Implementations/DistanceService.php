<?php

namespace DTApi\Repository;

use App\Models\Distance;

class DistanceService implements DistanceServiceInterface
{
    protected $repository;

    public function __construct(DistanceRepository $distanceRepository)
    {
        $this->repository = $distanceRepository;
    }

    public function updateDistanceAndTime($data)
    {
        $distance = $data['distance'] ?? "";
        $time = $data['time'] ?? "";
        $jobid = $data['jobid'] ?? "";

        if ($time || $distance) {
            Distance::where('job_id', '=', $jobid)->update(['distance' => $distance, 'time' => $time]);
        }

        return response('Distance and time updated!');
    }
}
