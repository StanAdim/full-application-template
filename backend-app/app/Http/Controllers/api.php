<?php

use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\AuthPermissionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\DigitalAccelaratorController;
use App\Http\Controllers\FirmExtraController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\GrassrootProgramController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\StartupController;
use App\Http\Controllers\UserProfileCategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HubController;
use App\Http\Controllers\IctProductController;
use App\Http\Controllers\IncubatorController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\StudentController;
use App\Models\FirmExtra;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| General API Routes
|--------------------------------------------------------------------------
|
*/
Route::post('/auth/register-user',[UserAuthController::class,'register']);
Route::post('/auth/login-user',[UserAuthController::class,'login']);
Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm']);
Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm']);
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm']);
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm']);
Route::post('/reset-password-from-email', [ForgotPasswordController::class, 'passwordResetFromEmail']);
Route::get('/get-profiles',[UserProfileCategoryController::class, 'get_profiles']);

Route::post('/profile/create-digital-accelerator', [DigitalAccelaratorController::class, 'createAccelerator']);
Route::post('/profile/create-investor', [InvestorController::class, 'createInvestor']);
Route::post('/profile/create-developer', [DeveloperController::class, 'createDeveloperDetails']);
Route::post('/profile/create-designer', [DesignerController::class, 'createDesignerDetaitails']);
Route::post('/profile/create-student',[StudentController::class,'createStudentDetails']);
Route::post('/profile/create-hub', [HubController::class, 'createHub']);
Route::post('/profile/create-incubator', [IncubatorController::class, 'createIncubator']);
Route::post('/profile/create-startup/', [StartupController::class, 'createStartup']);
Route::post('/profile/create-grassroot-program', [GrassrootProgramController::class, 'createGrassrootProgram']);
Route::post('/profile/create-company/', [CompanyController::class, 'createCompany']);
 // ================ LOCATION API ============================================
 Route::get('/get-regions',[GeneralController::class, 'get_regions']);
 Route::get('/get-countries',[GeneralController::class, 'get_countries']);
 Route::get('/get-districts/{targetRegion}',[GeneralController::class, 'get_district']);
 Route::get('/get-system-evalutes',[UserProfileCategoryController::class, 'getProfilesEvaluates']);
// ==================== guest profiles
 Route::get('/guest/startups-all', [StartupController::class, 'guestStartup']);
 Route::get('/guest/grassroot-programs-all', [GrassrootProgramController::class, 'guestGrassrootPrograms']);
 Route::get('/guest/incubators-all', [IncubatorController::class, 'guestIncubators']);
 Route::get('/guest/investors-all', [InvestorController::class, 'guestInvestors']);
 Route::get('/guest/digital-accelerators-all', [DigitalAccelaratorController::class, 'guestDigitalAccelerators']);
 Route::get('/guest/project-all', [ProjectController::class, 'guestViewProjects']); //get all projects


#----------------------------------------------------------------
#                       Authenticated API
#----------------------------------------------------------------
Route::middleware("auth:sanctum")->group(
    function() {
        Route::post('/user/edit-user',[UserAuthController::class, 'editUser']);  //for editing user details
        // Moved `Change Password` Here because it needs authenticated user object
        Route::post('/user/change-password',[UserAuthController::class, 'updatePassword']);  //for changing password
        Route::get('/system-analytics',[UserProfileCategoryController::class, 'getProfilesCount']);
        Route::get('/get-projectsType',[ProjectTypeController::class, 'get_projectType']);

        Route::get('/get-startups', [StartupController::class, 'index']);
        Route::get('/get-designers', [DesignerController::class, 'index']);
        Route::get('/get-developers', [DeveloperController::class, 'index']);
        Route::get('/get-students', [StudentController::class, 'index']);
        Route::get('/profile/get-all-investors', [InvestorController::class, 'index']);

        Route::get('/get-grassroot-programs', [GrassrootProgramController::class, 'index']);
        Route::get('/get-startup/with/{uuid}', [StartupController::class, 'getStartupProfile']);
        Route::get('/get-grassroot-program/with/{uuid}', [GrassrootProgramController::class, 'getGrassrootProgramProfile']);
        Route::get('/get-hubs/with/{uuid}', [HubController::class, 'getHubProfile']);
        Route::get('/get-incubators/with/{uuid}', [IncubatorController::class, 'getIncubatorProfile']);

        //================================ Post API ================================================
        Route::post('/profile/update-digital-accelerator', [DigitalAccelaratorController::class, 'editProfile']);
        Route::post('/digitalaccelerator/verify-profile/{UUID}',[DigitalAccelaratorController::class, 'verifyProfile']);  //verify accelerator

        Route::post('/profile/update-investor', [InvestorController::class, 'editProfile']);
        Route::post('/investor/verify-profile/{UUID}',[InvestorController::class, 'verifyProfile']);  //verify investor

        Route::post('/profile/update-developer', [DeveloperController::class, 'updateDevoloperDetails']);
        Route::post('/developer/verify-profile/{UUID}',[DeveloperController::class, 'verifyProfile']);  //verify developer

        Route::post('/profile/update-designer', [DesignerController::class, 'udpatingDesigner']);
        Route::post('/designer/verify-profile/{UUID}',[DesignerController::class, 'verifyProfile']);  //verify designer

        Route::post('/profile/update-student', [StudentController::class, 'updateStudentDetails']);
        Route::post('/student/verify-profile/{UUID}',[StudentController::class, 'verifyProfile']);  //verify student

        Route::post('/profile/update-hub/{UUID}', [HubController::class, 'editHub']);
        Route::post('/hub/verify-profile/{UUID}',[HubController::class, 'verifyProfile']); //verify hub

        Route::post('/profile/update-incubator/{UUID}', [IncubatorController::class, 'editIncubator']);
        Route::post('/incubator/verify-profile/{UUID}',[IncubatorController::class, 'verifyProfile']);  //verify incubator

        Route::post('/profile/edit-startup/{UUID}', [StartupController::class, 'editProfile']);
        Route::post('/startup/verify-profile/{UUID}',[StartupController::class, 'verifyProfile']);  //verify startup

        Route::post('/profile/edit-grassroot-program/{UUID}', [GrassrootProgramController::class, 'editProfile']);
        Route::post('/grassroot/verify-profile/{UUID}',[GrassrootProgramController::class, 'verifyProfile']);  //verify grassroot

        //Firm Extra info routes
        Route::post('/firm/create-firm-info', [FirmExtraController::class, 'createFirmDetaitails']);
        Route::post('/firm/edit-firm-info/{UUID}', [FirmExtraController::class, 'editFirmDetaitails']);


        //================== Register & LOgin Api ===================================
        #___________dont know if this works ???
        Route::post('/auth/udpate-user-profile/{uuid}/{profile_id}',[UserAuthController::class,'setProfile']);
       // Route::post('/profile/upload-photo',[UserAuthController::class, 'uploadPhoto']);

        Route::post('/profile/upload-photo',[UserAuthController::class, 'uploadPhoto']);  //for uploading photo

        //======================== Protected API endpoint & Logout ====================
        //tunaadd (->middleware('auth:sanctum)); to protect route"

        Route::get('/auth/user', [UserAuthController::class, 'user']);
        Route::get('/auth/user/with/{uuid}', [UserAuthController::class, 'userbyid']);
        Route::get('/auth/user/{uuid}', [UserAuthController::class, 'getUserProfile']);# Pull user profile and Details
        Route::post('/auth/logout-user', [UserAuthController::class, 'logout']);

        #assigning role and retriving user groups and permissions
        Route::post('/admin/assign-role/', [AuthPermissionController::class, 'assignRoleToAuthUser']);
        Route::post('/admin/auth-user-permissions/', [AuthPermissionController::class, 'getAuthUserPermissions']);
        Route::post('/admin/user-permissions/', [AuthPermissionController::class, 'getPermissionsAuthUser']);

        //=============================== Verify Email =================================================================
        Route::get('/account/verify/{token}', [UserAuthController::class, 'verifyAccount']);
        Route::get('email/edashboard', [UserAuthController::class, 'dashboard'])->middleware(['auth', 'is_verify_email']);

        // ================================ Projects Api ===========================================
        Route::get('/project/all', [ProjectController::class, 'index']); //get all projects
        Route::get('/project/exportExcel',[ProjectController::class, 'projectExport']);

        Route::get('/project/getProject/{UUID}',[ProjectController::class,'getProject']);
        Route::post('/project/create-project', [ProjectController::class, 'projectStore']);
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
        Route::get('/programmes/applicant-groups',[GeneralController::class, 'get_applicantsGroup']); //programme groups

         // ================================ Get Project Categories =================================
        Route::get('/get-categories',[ProjectController::class, 'get_categories']);
        Route::get('/admin/auth-permissions', [AuthPermissionController::class, 'authPermissions']);
        Route::get('/admin/auth-groups', [AuthPermissionController::class, 'authGroups']);
        Route::get('/admin/auth-roles', [AuthPermissionController::class, 'authRoles']);

        Route::get('/admin/get-auth-role/{slug}', [AuthPermissionController::class, 'getRole']);
        Route::get('/admin/get-auth-group/{slug}', [AuthPermissionController::class, 'getAuthGroup']);

        Route::post('/admin/assign-permission-group/', [AuthPermissionController::class, 'assignPermissionGroup']);
        Route::post('/admin/assign-group-role/', [AuthPermissionController::class, 'assignGroupRole']);

        // Route::get('/auth/user', [UserAuthController::class, 'user']);
        Route::post('/admin/create-auth-group', [AuthPermissionController::class, 'createAuthGroup']);
        Route::delete('/admin/delete-auth-group/{group}', [AuthPermissionController::class, 'deleteAuthGroup']);
        Route::post('/admin/create-auth-role', [AuthPermissionController::class, 'createRole']);
        Route::delete('/admin/delete-auth-role/{role}', [AuthPermissionController::class, 'deleteRole']);

        Route::post('/admin/create-profile', [UserProfileCategoryController::class, 'createProfile']);

        //--------------------_________ALL PROFILES_______-----------------------------
        Route::get('admin/startups-all', [StartupController::class, 'index']);
        Route::get('/admin/accelerators-all', [DigitalAccelaratorController::class, 'index']);
        Route::get('admin/students-all', [StudentController::class, 'index']);
        Route::get('admin/designers-all', [DesignerController::class, 'index']);
        Route::get('admin/developers-all', [DeveloperController::class, 'index']);
        Route::get('/admin/grassroot-programs', [GrassrootProgramController::class, 'index']);
        Route::get('/profile/getallhubs', [HubController::class, 'index']);
        Route::get('/profile/get-all-incubators', [IncubatorController::class, 'index']);
    }
);
