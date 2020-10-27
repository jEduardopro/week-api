<?php

namespace App\Http\Resources\Proyect;

use App\Http\Resources\Subtask\SubtaskCollection;
use App\Http\Resources\Task\TaskCollection;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProyectResource extends JsonResource
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
            "name" => $this->name,
            "description" => $this->description,
            "color" => $this->color,
            "relationships" => [
                "user" => UserResource::make($this->whenLoaded('user')),
                "tasks" => TaskCollection::make($this->whenLoaded('tasks')),
                "subtasks" => SubtaskCollection::make($this->whenLoaded('subtasks')),
            ],
            "meta" => [
                "tasksCount" => count($this->tasks),
                "subtasksCount" => count($this->subtasks),
            ],
            "dates" => [
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
            ]
        ];
    }
}
