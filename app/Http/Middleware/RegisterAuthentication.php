<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        app(RegisterRequest::class);

        // Create user with name, email and password after the validation of data is true
        $user = User::create([
            'name' => $validatedUser['name'],
            'email' => $validatedUser['email'],
            'password' =>  Hash::make($validatedUser['password']),
        ]);
        // Merge the user object to the request object so that it can be used in the controller.
        $request->merge(['user' => $user]);
        return $next($request);
    }
}
