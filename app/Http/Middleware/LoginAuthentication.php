<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class LoginAuthentication
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
        //Form request applying here from the LoginRequest class to check the validation of request parameters.

        try {
            $validatedUser = app(LoginRequest::class)->validated();
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->errors(),
            ], 401);
        }
        $token = User::loginUser($validatedUser);
        
        /*
        |   if the above condition turn false then the else case to generate the access token for the login
        |   User to interact with the application and storing the access_token for the user into
        |   $token and also store into database table.
        |   Merge the user object to the request object so that it can be used in the controller.
        */
        $request->merge(['token' => $token]);
        return $next($request);
    }
}
