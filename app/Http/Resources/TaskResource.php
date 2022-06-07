<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'name' => $this->name,
            'user_id' => $this->user_id,
            'priority' => $this->priority,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'user_tag' => $this->user_tag,
            'hash_tag' => $this->hash_tag,
            'status' => $this->status,
            'description' => $this->description,
            'createBy' => $this->user->name,
            'difftime' => $this->difftime,
            'todo_task' => $this->todotasks,
            // 'sum_todo' => $this->sum_todo,
            // 'sum_done' => $this->sum_done,
        ];
    }
}
