<?php

namespace App\Http\Middleware;

use App\Services\LoginService;
use Closure;
use Illuminate\Http\Response;

class BasicAuthorization
{
    const EMPTY_AUTH_PARAMS_ERROR_TEXT = 'User and password cannot be empty.';
    const INVALID_AUTH_PARAMS_ERROR_TEXT = 'User doesn\'t exist.';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->getUser();
        $password = $request->getPassword();

        if (empty($user) || empty($password)) {
            return response()->json([
                'success' => false,
                'message' => self::EMPTY_AUTH_PARAMS_ERROR_TEXT
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!(new LoginService($user, $password))->login()) {
            return response()->json([
                'success' => false,
                'message' => self::INVALID_AUTH_PARAMS_ERROR_TEXT
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
