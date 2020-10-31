<?php

namespace App\Http\Controllers\Api\Subtask;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Subtask\{SubtaskCollection, SubtaskResource};
use App\Models\Subtask;
use App\Traits\{DocumentTrait, TaskTrait};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubtaskController extends ApiController
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
            $tasks = Subtask::with(['task', 'responsable', 'documents'])->get();
            return $this->responseResource(SubtaskCollection::make($tasks), 'subtask.index');
        } catch (Exception $e) {
            return $this->responseError($e, 'subtask.index');
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
            $task = $this->updateOrCreateTask($request);
            DB::commit();
            return $this->responseResource(SubtaskResource::make($task), 'subtask.store');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseError($e, 'subtask.store');
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
        try {
            $task = Subtask::whereId($id)->firstOrFail();
            $task->load('task', 'responsable', 'documents');
            return $this->responseResource(SubtaskResource::make($task), 'subtask.show');
        } catch (Exception $e) {
            return $this->responseError($e, 'subtask.show');
        }
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
        try {
            DB::beginTransaction();
            $task = $this->updateOrCreateTask($request, $id);
            DB::commit();
            return $this->responseResource(SubtaskResource::make($task), 'subtask.update');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseError($e, 'subtask.update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $task = Subtask::whereId($id)->firstOrFail();
            $this->destroyTask($task);
            return $this->responseMessage("Tarea eliminada");
        } catch (Exception $e) {
            return $this->responseError($e, 'subtask.destroy');
        }
    }
}
