<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



// Public routes

Route::post('/register-user-with-profile', [ProfileController::class, 'registerUserWithProfile']);

//User auth Routes
Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) { return [
        'message' => 'Login Success.',
        'user' => Auth::user(),
        'profile' => Auth::user()->profile,
        'profileable' => $request->user()->profileable,
    ];}
);

    //Users endpoints
Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum'] ], function () {
        Route::get('/{user:uid}', [UserController::class, 'getUserById'])->can("index-user");
        Route::post('/change_password', [UserController::class, 'changePassword'])->can("can-change-password");
        Route::post('/update/{user:uid}', [UserController::class, 'update'])->can("update-user");
        Route::post('/block/{user:uid}', [UserController::class, 'blockUser'])->can("can-deactivate-user");
        Route::post('/assign-roles/{user:uid}', [UserController::class, 'assignRoles'])->can("assign-user-roles");
    });
});

// Test apis
Route::get('/test', function(){
    return 'Test Api';
});
