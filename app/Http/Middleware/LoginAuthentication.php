<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        $validatedUser = app(LoginRequest::class)->validated();

        /*
        |   Check if the requested user email is exist in the database
        |   after retrieving  the user email from database then fist handle the exception case check weather
        |   the email provided or password is not matched return the error message
        */
        $user = User::where('email', $validatedUser['email'])->first();
        if (!$user || !Hash::check($validatedUser['password'], $user->password)) {
            return response()->json([
               'message' => "User does't Exist",
                'errors' => $validatedUser->errors(),
            ]);
        }

        /*
        |   if the above condition turn false then the else case to generate the access token for the login
        |   User to interact with the application and storing the access_token for the user into
        |   $token and also store into database table.
        |   Merge the user object to the request object so that it can be used in the controller.
        */
        $token = $user->createToken('authToken')->plainTextToken;
        $request->merge(['token' => $token]);
        return $next($request);
    }
}
