<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\TimetableController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'createUser'])->name('register');
    Route::post('/login', [AuthController::class, 'loginUser'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [UserController::class, 'show'])->name('me');

    Route::apiResource('time-table', TimetableController::class);
    Route::get('/time-table/course/{courseId}', [TimetableController::class, 'showByCourseId']);

    Route::apiResource('course', CourseController::class);

});

