<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\GeneralController;
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
use App\Http\Controllers\DocumentController;



// Public routes
Route::get('/profile/{type}-count', [GeneralController::class, 'profileCount']);
Route::get('/ict-sectors', [GeneralController::class, 'sectors']);
Route::get('/document-types', [GeneralController::class, 'document_types']);
Route::get('/funding-stages', [GeneralController::class, 'fundingStages']);
Route::get('/tanzania-regions', [GeneralController::class, 'getRegions']);
Route::post('/register-user-with-profile', [ProfileController::class, 'registerUserWithProfile']);

//User auth Routes
Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) { 
        $user = new UserResource(Auth::user());
        $profile =  ($user->rank === 'profiled') ? new ProfileResource(Auth::user()->profile) : null ;
        return [
        'message' => 'Login Success.',
        'user' => $user,
        'profile' => $profile ];}
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

Route::group(['prefix' => '', 'middleware' => ['auth:sanctum'] ], function () {
    // ================================ Projects Api ===========================================
        Route::get('/projects', [ProjectController::class, 'index']); //get all projects
        Route::post('/project/create', [ProjectController::class, 'projectStore']);
        Route::patch('/project/update', [ProjectController::class, 'projectUpdate']);
        Route::get('/projects-count', [ProjectController::class, 'count']);
        Route::delete('/project-delete/{UUID}', [ProjectController::class, 'projectDelete']);
        Route::get('/project/exportExcel',[ProjectController::class, 'projectExport']);

        Route::get('/projects/project/{uid}',[ProjectController::class,'getProject']);
        Route::post('/project/add-comment/{UUID}',[ProjectController::class, 'storeComment']);

        // ================================ ICT Product Api ===========================================
        Route::get('/products', [IctProductController::class, 'index']); //get all products
        Route::post('/product/create', [IctProductController::class, 'store']);
        Route::patch('/product/update', [IctProductController::class, 'update']);
        Route::get('/products-count', [IctProductController::class, 'count']);
        Route::get('/products/product/{uid}',[IctProductController::class,'show']);
        Route::delete('/product-delete/{uid}', [IctProductController::class, 'destroy']);

        Route::get('/product/exportExcel',[IctProductController::class, 'productExport']);

        // ================================ Programmes =================================
        Route::get('/programmes', [ProgrammeController::class, 'index']);    //get all programmes
//        Route::post('/show-programme', [ProgrammeController::class, 'show']);    //get all programmes
        Route::post('/programme/create', [ProgrammeController::class, 'store']);    //get all programmes
        Route::patch('/programme/update', [ProgrammeController::class, 'update']);    //get all programmes
        Route::patch('/programme/approve', [ProgrammeController::class, 'approve']);    //get all programmes
        Route::delete('/programme-delete/{programme}', [ProgrammeController::class, 'destroy']);    //get all programmes
        Route::get('/programmes/programme/{uid}',[ProgrammeController::class, 'show']); //programme show
        Route::post('/programme/apply',[ProgrammeController::class, 'apply']); //programme apply

        // ================================ Documents =================================
        Route::post('/upload-document', [DocumentController::class, 'docUpload']);
        Route::get('/documents', [DocumentController::class, 'index']);
        Route::delete('/document-delete-{id}', [DocumentController::class, 'destroy']);
        Route::put('/document-update-{id}', [DocumentController::class, 'updateStatus']);
        Route::get('/preview-document', [DocumentController::class, 'previewDocument']);

});

// Admin routes
Route::group(['prefix' => 'admin','middleware' => ['role:admin']], function () {
    // Routes only accessible to users with the 'admin' role
    Route::get('/user-list', [AdminUserController::class, 'userList']);

});

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin'] ], function () {
    Route::get('/admin', function () { return view('admin.dashboard'); });
    Route::post('/project/verify-project/{project}',[ProjectController::class, 'verifyProject']);
    Route::post('/product/verify-product/{product}',[IctProductController::class, 'verifyproduct']);
    Route::get('/profiles/{type}', [AdminProfileController::class, 'profilesOfType']);
    Route::get('/profile-details/{type}/{uid}', [AdminProfileController::class, 'singleDetails']);
    Route::get('/change-status/{item}/{uid}', [AdminProfileController::class, 'changeApprovalStatus']);

});

Route::group(['middleware' => ['permission:edit post']], function () {
    // Routes only accessible to users with the 'edit post' permission
});


// Test apis
Route::get('/test', function(){
    return 'Test Api';
});
