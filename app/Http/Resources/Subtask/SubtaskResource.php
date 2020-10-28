<?php

namespace App\Http\Resources\Subtask;

use App\Http\Resources\Document\DocumentResource;
use App\Http\Resources\Task\TaskResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SubtaskResource extends JsonResource
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
            "task_id" => $this->task_id,
            "name" => $this->name,
            "description" => $this->description,
            "due_date" => $this->due_date,
            "responsable_id" => $this->responsable_id,
            "priority" => (int) $this->priority,
            "status" => (int) $this->status,
            "relationships" => [
                "user" => UserResource::make($this->whenLoaded('user')),
                "task" => TaskResource::make($this->whenLoaded('task')),
                "responsable" => UserResource::make($this->whenLoaded('responsable')),
                "documents" => DocumentResource::collection($this->whenLoaded('documents')),
            ],
            "meta" => [
                "documentsCount" => count($this->documents),
            ],
            "dates" => [
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
            ]
        ];
    }
}
