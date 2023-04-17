<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::controller(RegisterController::class)->group(function()
// {
//     Route::post('register', 'register');
//     Route::post('login', 'login');
   

// });

// Route::post('register', RegisterController::class);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::post('password', [AuthController::class, 'Password']);
Route::middleware('auth:sanctum')->group(function() {

    Route::get('get-courses', [MainController::class, 'getCourses']);
    Route::post('enrollment', [MainController::class, 'createCourseStudent']); 
    Route::get('get-enrollment', [MainController::class, 'getCourseStudent']); 

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('register-instractor', [AuthController::class, 'registerInstractor']);
Route::post('login-instractor', [AuthController::class, 'loginInstractor']);

Route::middleware('auth:sanctum','abilities:instractors')->group(function() {
    Route::post('create-course', [MainController::class, 'createCourse']);
    
    Route::post('update-course/{id}', [MainController::class, 'update']);
    Route::get('show-course/{id}', [MainController::class, 'showCourseById']);
    Route::get('get-All-courses', [MainController::class, 'getCoursesInstractour']);   
    Route::post('delete/{id}', [MainController::class, 'delete']);
    Route::post('logout-instructor', [AuthController::class, 'logoutInstructor']);  
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
