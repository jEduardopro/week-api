<?php

namespace App\Http\Controllers\Api\Proyect;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Proyect\ProyectCollection;
use App\Http\Resources\Proyect\ProyectResource;
use App\Models\Proyect;
use Exception;
use Illuminate\Http\Request;

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
            return $this->responseResource(ProyectCollection::make(Proyect::with('user')->get()), 'proyect.index');
        } catch (Exception $e) {
            return $this->responseError($e, 'proyect.index');
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
            $data = $request->only(["name", "description"]);
            $data["user_id"] = $request->user()->id;
            $proyect = Proyect::create($data);
            return $this->responseResource(ProyectResource::make($proyect), 'proyect.store');
        } catch (Exception $e) {
            return $this->responseError($e, 'proyect.store');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->only(["name", "description", "color"]);
            $proyect = Proyect::whereId($id)->firstOrFail();
            $proyect->fill($data)->save();
            return $this->responseResource(ProyectResource::make($proyect), 'proyect.update');
        } catch (Exception $e) {
            return $this->responseError($e, 'proyect.update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $proyect = Proyect::whereId($id)->firstOrFail();
            $proyect->delete();
            return $this->responseMessage('proyect.destroy');
        } catch (Exception $e) {
            return $this->responseError($e, 'proyect.destroy');
        }
    }
}
