<?php

namespace App\Repositories\Calendar;

use App\Models\Event;
use App\Repositories\BaseRepository;

class CalendarRepository extends BaseRepository implements CalendarInterface
{
    public function __construct(Event $moel)
    {
        $this->model = $moel;
    }

    public function getALlEvent()
    {
        return $this->model->with('user')->get();
    }

    public function findEvent($event_id)
    {
        return $this->model->where('event_id', $event_id)->first();
    }
}
