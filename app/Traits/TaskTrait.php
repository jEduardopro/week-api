<?php

namespace App\Traits;

use App\Jobs\SendAssignNotification;
use App\Models\{Subtask, Task};
use Illuminate\Http\Request;

trait TaskTrait
{
    public function updateOrCreateTask(Request $request, $id = null)
    {
        $this->request = $request;
        $this->id = $id;
        return $this->buildData()
            ->resolveModel()
            ->setOldTaskIfExists()
            ->saveTask()
            ->attachFilesWhenReceive()
            ->sendNotificationWhenAssignResponsable()
            ->loadRelationships();
    }

    private function buildData()
    {
        $data = $this->request->all();
        $data["user_id"] = $this->request->user()->id;
        $data["status"] = $this->request->filled('status') ? $this->request->status : 0;
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

    private function setOldTaskIfExists()
    {
        $this->oldTask = null;
        if ($this->id) {
            $this->oldTask = $this->model::whereId($this->id)->firstOrFail();
            return $this;
        }
        return $this;
    }

    private function saveTask()
    {
        if ($this->id) {
            $this->task = $this->model::where('id', $this->id)->firstOrFail();
            $this->task->fill($this->data)->save();
            return $this;
        }
        $this->task = $this->model::create($this->data);
        return $this;
    }


    private function attachFilesWhenReceive()
    {
        if (!$this->request->has('attachments')) {
            return $this;
        }

        foreach ($this->request->attachments as $file) {
            $this->attach($this->task, $file);
        }
        return $this;
    }

    private function sendNotificationWhenAssignResponsable()
    {
        if ($this->shouldNotify()) {
            SendAssignNotification::dispatch($this->task)->onQueue('tasks');
            return $this;
        }
        return $this;
    }

    private function loadRelationships()
    {
        $relationships = [];
        if ($this->task->proyect_id) {
            array_push($relationships, 'proyect');
        }
        if ($this->task->task_id) {
            array_push($relationships, 'task');
        } else {
            array_push($relationships, 'subtasks');
        }
        if ($this->task->responsable_id) {
            array_push($relationships, 'responsable');
        }
        // if ($this->request->has('file')) {
        array_push($relationships, 'documents');
        // }
        $this->task->load($relationships);
        return $this->task;
    }


    private function shouldNotify()
    {
        if ($this->oldTask && $this->request->filled('responsable_id')) {
            if ($this->oldResponsableIsEqualCurrent()) {
                return false;
            }
            return true;
        }
        if ($this->request->filled('responsable_id')) {
            return true;
        }
        return false;
    }

    private function oldResponsableIsEqualCurrent()
    {
        return $this->oldTask->responsable_id == $this->request->responsable_id;
    }

    public function destroyTask($task)
    {
        $this->detach($task);
        $task->delete();
    }
}
