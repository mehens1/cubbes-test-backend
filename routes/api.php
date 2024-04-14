<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\TimetableController;
use App\Http\Controllers\Api\UniversityController;
use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\SchoolLevelsController;
use App\Http\Controllers\Api\LevelSemestersController;




Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'createUser'])->name('register');
    Route::post('/login', [AuthController::class, 'loginUser'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [UserController::class, 'show'])->name('me');

    Route::apiResource('time-table', TimetableController::class);
    Route::get('/time-table/course/{courseId}', [TimetableController::class, 'showByCourseId']);

    Route::apiResource('course', CourseController::class);
    Route::get('/courses/my-courses', [CourseController::class, 'showMyCourse']);
});

Route::prefix('/mobile')->group(function () {
    Route::apiResource('universities', UniversityController::class);
    Route::apiResource('universities.faculties', FacultyController::class);
    Route::apiResource('faculties.departments', DepartmentController::class);

    Route::apiResource('levels', SchoolLevelsController::class);
    Route::apiResource('sememsters', LevelSemestersController::class);
});
