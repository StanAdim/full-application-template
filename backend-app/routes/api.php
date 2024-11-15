<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\IctProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



// Public routes

Route::post('/register-user-with-profile', [ProfileController::class, 'registerUserWithProfile']);

//User auth Routes
Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) { 
        $user = new UserResource(Auth::user());
        $profile =  ($user->rank === 'profiled') ? new ProfileResource(Auth::user()->profile) : null ;
        return [
        'message' => 'Login Success.',
        'user' => $user,
        'profile' => $profile
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

// ================================ Projects Api ===========================================
Route::post('/project/create', [ProjectController::class, 'projectStore']);
Route::get('/projects', [ProjectController::class, 'index']); //get all projects
Route::get('/project/exportExcel',[ProjectController::class, 'projectExport']);

Route::get('/project/getProject/{UUID}',[ProjectController::class,'getProject']);
Route::patch('/project/update-project/{UUID}', [ProjectController::class, 'projectUpdate']);
Route::post('/project/add-comment/{UUID}',[ProjectController::class, 'storeComment']);
Route::post('/project/verify-project/{project}',[ProjectController::class, 'verifyProject']);
Route::delete('/project/delete/{UUID}', [ProjectController::class, 'projectDelete']);

// ================================ ICT Product Api ===========================================
Route::get('/product/all', [IctProductController::class, 'index']); //get all products
Route::get('/product/exportExcel',[IctProductController::class, 'productExport']);
Route::get('/product/getproduct/{UUID}',[IctProductController::class,'getproduct']);
Route::post('/product/create-product', [IctProductController::class, 'productStore']);
Route::patch('/product/update-product/{UUID}', [IctProductController::class, 'productUpdate']);
Route::post('/product/verify-product/{product}',[IctProductController::class, 'verifyproduct']);
Route::delete('/product/delete/{UUID}', [IctProductController::class, 'productDelete']);

// ================================ Programmes =================================
Route::get('/programmes', [ProgrammeController::class, 'index']);    //get all programmes
Route::post('/show-programme', [ProgrammeController::class, 'show']);    //get all programmes
Route::post('/create-programme', [ProgrammeController::class, 'store']);    //get all programmes
Route::patch('/update-programme/{programme}', [ProgrammeController::class, 'update']);    //get all programmes
Route::delete('/delete-programme/{programme}', [ProgrammeController::class, 'destroy']);    //get all programmes
// Route::get('/programmes/applicant-groups',[GeneralController::class, 'get_applicantsGroup']); //programme groups

// Admin routes
Route::group(['prefix' => 'admin','middleware' => ['role:admin']], function () {
    // Routes only accessible to users with the 'admin' role
    Route::get('/user-list', [AdminUserController::class, 'userList']);

});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });
});

Route::group(['middleware' => ['permission:edit post']], function () {
    // Routes only accessible to users with the 'edit post' permission
});


// Test apis
Route::get('/test', function(){
    return 'Test Api';
});
