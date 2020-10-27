<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\LoginFormRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class LoginController extends ApiController
{

    use AuthenticatesUsers;

    public function login(LoginFormRequest $request)
    {
        try {
            $user = User::query()->where('email', $request->email)->first();
            if ($user) {
                $password = Hash::check($request->password, $user->password);
                if ($password) {
                    Passport::personalAccessTokensExpireIn(now()->addMinutes(120));

                    $token = $user->createToken('token');
                    $expireIn = Carbon::parse($token->token->expires_at)->timestamp;

                    return $this->responseData([
                        "access_token" => $token->accessToken,
                        "expires_in" => $expireIn,
                        "user" => $user
                    ]);
                }
                return $this->responseErrorMessage("Credentials are invalid.");
            }
            return $this->responseErrorMessage("Credentials are invalid.");
        } catch (Exception $e) {
            return $this->responseError($e, 'login');
        }
    }

    public function refreshToken(Request $request)
    {
        try {
            $user = User::query()->where('email', $request->email)->first();
            if ($user) {
                Passport::personalAccessTokensExpireIn(now()->addMinutes(120));

                $token = $user->createToken('token');
                $expireIn = Carbon::parse($token->token->expires_at)->timestamp;

                return $this->responseData([
                    "access_token" => $token->accessToken,
                    "expires_in" => $expireIn,
                    "user" => $user
                ]);
            }
            return $this->responseErrorMessage("Refresh token failed.");
        } catch (Exception $e) {
            return $this->responseError($e, 'refreshToken');
        }
    }

    public function logout()
    {
        try {
            if (auth()->check()) {
                auth()->user()->tokens->each(function ($token) {
                    $token->delete();
                });
                return $this->responseMessage("Logged out successfully");
            }
            return $this->responseErrorMessage("Unauthorized", 401);
        } catch (Exception $e) {
            return $this->responseError($e, 'logout');
        }
    }
}
