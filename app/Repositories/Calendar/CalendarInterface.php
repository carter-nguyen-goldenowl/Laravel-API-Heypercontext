<?php

namespace App\Repositories\Calendar;

use App\Repositories\RepositoryInterface;

interface CalendarInterface extends RepositoryInterface
{
    public function getALlEvent();

    public function findEvent($event_id);
}
