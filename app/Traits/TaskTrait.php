<?php

namespace App\Traits;

use App\Jobs\SendAssignNotification;
use App\Models\{Subtask, Task};
use Illuminate\Http\Request;

trait TaskTrait
{
    public function createTask(Request $request)
    {
        $this->request = $request;
        return $this->buildData()
            ->resolveModel()
            ->saveTask()
            ->attachFileWhenReceiveOne()
            ->sendNotificationWhenAssignResponsable()
            ->loadRelationships();
    }

    private function buildData()
    {
        $data = $this->request->all();
        $data["user_id"] = $this->request->user()->id;
        $data["status"] = 0;
        $this->data = $data;
        return $this;
    }

    private function resolveModel()
    {
        $this->model = Task::class;
        if ($this->request->has('task_id')) {
            $this->model = Subtask::class;
        }
        return $this;
    }

    private function saveTask()
    {
        $this->task = $this->model::create($this->data);
        return $this;
    }


    private function attachFileWhenReceiveOne()
    {
        if (!$this->request->has('file')) {
            return $this;
        }

        $this->attach($this->task, $this->request->file);
        return $this;
    }

    private function sendNotificationWhenAssignResponsable()
    {
        if (!$this->task->responsable_id) {
            return $this;
        }
        SendAssignNotification::dispatch($this->task)->onQueue('tasks');
        return $this;
    }

    private function loadRelationships()
    {
        $relationships = [];
        if ($this->request->filled('proyect_id')) {
            array_push($relationships, 'proyect');
        }
        if ($this->request->filled('task_id')) {
            array_push($relationships, 'task');
        }
        if ($this->request->filled('responsable_id')) {
            array_push($relationships, 'responsable');
        }
        if ($this->request->has('file')) {
            array_push($relationships, 'documents');
        }
        $this->task->load($relationships);
        return $this->task;
    }
}
