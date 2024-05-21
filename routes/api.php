<?php

use App\Http\Controllers\Api\{
    CourseController
};
use App\Http\Controllers\Api\Auth\{
    AuthController,
    ResetPasswordController
};
use Illuminate\Support\Facades\Route;

/**
 * Auth
 */
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::post('/auth', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

/**
 * Reset Password
 */
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->middleware('guest');
Route::post('/reset-password', [ResetPasswordController::class, 'resetSenha'])->middleware('guest');


Route::get('/courses', [CourseController::class, 'getCoursesForAuthenticatedUser']);
Route::get('/courses/{id}', [CourseController::class, 'getCourseById']);

Route::get('/', function () {
    return response()->json([
        'success' => true,
    ]);
});
