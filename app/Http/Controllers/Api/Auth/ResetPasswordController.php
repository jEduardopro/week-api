<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
    }

    protected function sendResetResponse(Request $request, $response)
    {
        $user = User::whereEmail($request->email)->first();
        $token = $user->createToken('token');
        $expireIn = Carbon::parse($token->token->expires_at)->timestamp;

        return response()->json([
            'message' => trans($response),
            "access_token" => $token->accessToken,
            "expires_in" => $expireIn,
            'user' => $user
        ], 200);
    }
}
