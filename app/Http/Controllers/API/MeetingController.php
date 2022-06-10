<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMeetingRequest;
use App\Http\Resources\MeetingResource;
use App\Repositories\Meeting\MeetingInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MacsiDigital\Zoom\Facades\Zoom;

class MeetingController extends Controller
{
    protected $meetingRepository;

    public function __construct(MeetingInterface $meetingInterface)
    {
        $this->meetingRepository = $meetingInterface;
    }

    public function getAllMeeting()
    {
        $now = Carbon::now();
        $meetings = $this->meetingRepository->getMeeting();
        collect($meetings)->map(function ($meeting) use ($now) {
            $dt = Carbon::create($meeting->updated_at);
            $meeting->difftime = $dt->diffForHumans($now);
        });
        return MeetingResource::collection($meetings);
    }

    public function createMeeting(CreateMeetingRequest $request)
    {
        $user = Zoom::user()->first();

        $zoom = Zoom::meeting()->make($request->all());

        $zoom->settings()->make([
            'join_before_host' => false,
            'host_video' => false,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'waiting_room' => true,
            'approval_type' => config('zoom.approval_type'),
            'audio' => config('zoom.audio'),
            'auto_recording' => config('zoom.auto_recording')
        ]);

        $meeting = $user->meetings()->save($zoom);

        $data = [
            'meeting_id' => $meeting->id,
            'user_id' => $request->user()->id,
            'topic' => $request->topic,
            'start_at' => $request->start_time,
            'duration' => $request->duration,
            'password' => $request->password,
            'start_url' => $meeting->start_url,
            'join_url' => $meeting->join_url,
        ];
        $meet = $this->meetingRepository->store($data);

        return response()->json([
            'data' => $meet,
            'message' => 'Created Successfully',
        ]);
    }

    public function deleteMeeting($id)
    {
        $meeting = Zoom::meeting()->find($id);

        $this->meetingRepository->findMeeting($meeting->id)->delete();

        $meeting->delete();

        return response()->json([
            'data' => true,
            'message' => 'Deleted Successfully',
        ]);
    }
}
