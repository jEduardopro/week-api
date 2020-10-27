<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Proyect\ProyectCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;


class UserProyectController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            $user = User::whereId($id)->firstOrFail();
            $proyects = $user->proyects()->with(["tasks", "subtasks"])->get();
            return $this->responseResource(ProyectCollection::make($proyects), 'user.proyect.index');
        } catch (Exception $e) {
            return $this->responseError($e, 'user.proyect.index');
        }
    }
}
