<?php

namespace App\Http\Controllers\Api\Proyect;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Proyect\ProyectCollection;
use App\Http\Resources\Proyect\ProyectResource;
use App\Models\Proyect;
use Exception;

class ProyectController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return $this->responseResource(ProyectCollection::make(Proyect::all()), 'proyect.index');
        } catch (Exception $e) {
            return $this->responseError($e, 'proyect.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $proyect = Proyect::whereId($id)->firstOrFail();
            $proyect->load('tasks', 'subtasks');
            return $this->responseResource(ProyectResource::make($proyect), 'proyect.show');
        } catch (Exception $e) {
            return $this->responseError($e, 'proyect.show');
        }
    }
}
