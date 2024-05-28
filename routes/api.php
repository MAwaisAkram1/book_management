<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\BookController;
use App\Http\Middleware\RegisterAuthentication;
use App\Http\Middleware\LoginAuthentication;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route to Register a New User
Route::post('/auth/register', [UserController::class, 'register'])->middleware('auth.register')->name('register');
// Route to login a Existing User
Route::post('auth/login', [UserController::class, 'login'])->middleware('auth.login')->name('login');

// Group routes using the auth:sanctum middleware
Route::middleware('auth:sanctum')->group(function (){
    // Route to get all the books
    Route::get('/book', [BookController::class, 'index']);
    // Route to Create a new book
    Route::post('/book/create', [BookController::class, 'store']);
    // Route to Update a book
    Route::put('/book/update/{id}', [BookController::class, 'update']);
    // Route to Delete a book route
    Route::delete('/book/{id}', [BookController::class, 'destroy']);

    // Route to Logout the User
    Route::post('auth/logout', [UserController::class, 'logout'])->name('logout');
});
