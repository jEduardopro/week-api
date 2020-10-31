<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post("login", 'LoginController@login');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'ResetPasswordController@reset');
    Route::post('logout', 'LoginController@logout');
    Route::post('refresh/token', 'LoginController@refreshToken');
});

Route::middleware('auth:api')->group(function () {
    $exceptCreateEdit = ['except' => ['create', 'edit']];
    Route::apiResource('proyects', 'Proyect\ProyectController', $exceptCreateEdit);
    Route::apiResource('tasks', 'Task\TaskController', $exceptCreateEdit);
    Route::apiResource('subtasks', 'Subtask\SubtaskController', $exceptCreateEdit);
    Route::apiResource('users.proyects', 'User\UserProyectController', $exceptCreateEdit);
});


Route::get("tasks/all", function () {
    $user = new User();
    $u = $user->whereId(1)->first();
    return $u->allTasks();
});
