<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\Proyect\ProyectResource;
use App\Http\Resources\Subtask\SubtaskCollection;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "proyect_id" => $this->proyect_id,
            "name" => $this->name,
            "description" => $this->description,
            "due_date" => $this->due_date,
            "responsable_id" => $this->responsable_id,
            "priority" => $this->priority,
            "status" => $this->status,
            "relationships" => [
                "user" => UserResource::make($this->whenLoaded('user')),
                "proyect" => ProyectResource::make($this->whenLoaded('proyect')),
                "subtasks" => SubtaskCollection::make($this->whenLoaded('subtasks')),
            ],
            "dates" => [
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
            ]
        ];
    }
}
