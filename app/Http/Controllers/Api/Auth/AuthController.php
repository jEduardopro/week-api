<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginFormRequest $request)
    {
        $user = User::query()->where('email', $request->email)->first();
        if ($user) {
            $password = Hash::check($request->password, $user->password);
            if ($password) {
                Passport::personalAccessTokensExpireIn(now()->addMinutes(2));

                $token = $user->createToken('token');
                $expireIn = Carbon::parse($token->token->expires_at)->timestamp;

                return response()->json(["access_token" => $token->accessToken, "expires_in" => $expireIn, "user" => $user]);
            }
            return response()->json(["message" => "creadentials are invalid."], 401);
        }
        return response()->json(["message" => "creadentials are invalid."], 401);
    }

    public function logout()
    {
        if (auth()->check()) {
            auth()->user()->tokens->each(function ($token) {
                $token->delete();
            });

            return response()->json('Logged out successfully', 200);
        }
        return response(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }
}
