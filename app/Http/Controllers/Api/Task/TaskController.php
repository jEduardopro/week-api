<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Task\{TaskCollection, TaskResource};
use App\Models\Task;
use App\Traits\{DocumentTrait, TaskTrait};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends ApiController
{
    use DocumentTrait, TaskTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tasks = Task::with(['user', 'proyect', 'responsable', 'subtasks', 'documents'])->get();
            return $this->responseResource(TaskCollection::make($tasks), 'task.index');
        } catch (Exception $e) {
            return $this->responseError($e, 'task.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $task = $this->createTask($request);
            DB::commit();
            return $this->responseResource(TaskResource::make($task), 'task.store');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseError($e, 'task.store');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
