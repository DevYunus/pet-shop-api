<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(UserLoginRequest $request)
    {
        $this->ensureNotRateLimited();

        if (!Auth::attempt($request->only('email', 'password'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        $user = User::where('email', $request->input('email'))->firstOrFail();

        $token = $user->createToken($user->email)->plainTextToken;

        return response([
            'data' => [
                'token' => $token
            ]
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     * @throws ValidationException
     */
    public function logout()
    {
        $tokenDeleted = Auth::user()?->currentAccessToken()->delete();

        if (!$tokenDeleted) {
            throw ValidationException::withMessages([
                'message' => 'Unable to logout user',
            ]);
        }

        return response([
            'data' => []
        ]);

    }

    /**
     * @throws ValidationException
     */
    public function ensureNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(\request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey(): string
    {
        return Str::lower(\request()?->input('email')) . '|' . \request()?->ip();
    }
}
