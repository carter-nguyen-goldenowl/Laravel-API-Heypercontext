<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'meeting_id' => $this->meeting_id,
            'user_name' => $this->user->name,
            'topic' => $this->topic,
            'start_time' => $this->start_at,
            'duration' => $this->duration,
            'start_url' => $this->start_url,
            'join_url' => $this->join_url,
            'difftime' => $this->difftime,
        ];
    }
}
