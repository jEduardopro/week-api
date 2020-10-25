<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth', 'namespace' => 'Api\Auth'], function () {
    Route::post("login", 'LoginController@login');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'ResetPasswordController@reset');
    Route::post('logout', 'LoginController@logout');
});

Route::get("tasks/all", function () {
    $user = new User();
    $u = $user->whereId(1)->first();
    return $u->allTasks();
});
