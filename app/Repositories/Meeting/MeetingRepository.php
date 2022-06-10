<?php

namespace App\Repositories\Meeting;

use App\Models\Meeting;
use App\Repositories\BaseRepository;

class MeetingRepository extends BaseRepository implements MeetingInterface
{
    public function __construct(Meeting $model)
    {
        $this->model = $model;
    }

    public function getMeeting()
    {
        return $this->model->with('user')->get();
    }

    public function findMeeting($meeting_id)
    {
        return $this->model->where('meeting_id', $meeting_id)->first();
    }
}
