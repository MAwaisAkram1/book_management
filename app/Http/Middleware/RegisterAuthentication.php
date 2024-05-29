<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class RegisterAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /*
        |   Form request applying here from the RegisterRequest class to check the validation of request
        |   parameters.
        */
        // $user = app(RegisterRequest::class)->validated();
        try {
            $validatedUser = app(RegisterRequest::class)->validated();
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 401);
        }
        $user = User::registerUser($validatedUser);

        // Merge the user object to the request object so that it can be used in the controller.
        $request->merge(['user' => $user]);
        return $next($request);
    }
}
