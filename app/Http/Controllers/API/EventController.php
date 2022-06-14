<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;
use App\Http\Resources\EventResource;
use App\Repositories\Calendar\CalendarInterface;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;

class EventController extends Controller
{
    protected $calendarReposity;

    public function __construct(CalendarInterface $calendarInterface)
    {
        $this->calendarReposity = $calendarInterface;
    }

    public function createEvent(CreateEventRequest $request)
    {
        $e = Event::create([
            'name' => $request->name,
            'startDateTime' => Carbon::create(
                $request->start_time['year'],
                $request->start_time['month'],
                $request->start_time['day'],
                $request->start_time['hour'],
                $request->start_time['minute'],
                $request->start_time['second'],
            ),
            'endDateTime' => Carbon::create(
                $request->end_time['year'],
                $request->end_time['month'],
                $request->end_time['day'],
                $request->end_time['hour'],
                $request->end_time['minute'],
                $request->end_time['second'],
            ),
        ]);
        $data = [
            'event_id' => $e->id,
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'start_time' => $request->start_date,
            'end_time' => $request->end_date,
            'link' => $e->htmlLink,
        ];

        $event = $this->calendarReposity->store($data);

        return response()->json([
            'data' => $event,
            'message' => "Create Successfully",
        ]);
    }

    public function getAllEvent()
    {
        $now = Carbon::now();
        $events = $this->calendarReposity->getAllEvent();
        collect($events)->map(function ($event) use ($now) {
            $dt = Carbon::create($event->updated_at);
            $event->difftime = $dt->diffForHumans($now);
        });
        return EventResource::collection($events);
    }

    public function deleteEvent($event_id)
    {
        $e = Event::find($event_id);

        $this->calendarReposity->findEvent($event_id)->delete();

        $e->delete();

        return response()->json([
            'data' => true,
            'message' => 'Deleted Successfully',
        ]);
    }
}
