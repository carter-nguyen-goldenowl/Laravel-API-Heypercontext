<?php

namespace App\Repositories\Meeting;

use App\Repositories\RepositoryInterface;

interface MeetingInterface extends RepositoryInterface
{
    public function getMeeting();

    public function findMeeting($meeting_id);
}
