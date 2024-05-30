<?php

use App\Http\Controllers\Api\{
    CategoryController,
    CourseController,
    LessonController,
    ModuleController,
    SupportController
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



Route::apiResource('/courses', CourseController::class)->parameters([
    'course' => 'id'
]);

Route::apiResource('/categories', CategoryController::class)->parameters([
    'category' => 'id'
]);

Route::apiResource('/modules', ModuleController::class)->parameters([
    'module' => 'id'
]);

Route::get('courses/module-creation-data', [CourseController::class, 'getCoursesForModuleCreation']);

Route::get('/courses/{id}/modules', [ModuleController::class, 'index']);

//Route::get('/modules/{id}/lessons', [LessonController::class, 'index']);
//Route::get('/lesson/{id}', [LessonController::class, 'show']);

Route::get('/my-supports', [SupportController::class, 'mySupports']);
Route::get('/supports', [SupportController::class, 'index']);
Route::post('/supports', [SupportController::class, 'store']);
Route::post('/supports/{id}/replies', [SupportController::class, 'createReply']);

Route::get('/get-courses', [CourseController::class, 'getCoursesForAuthenticatedUser']);
Route::get('/courses/{id}', [CourseController::class, 'getCourseById']);
// Route::post('/lessons/viewed', [LessonController::class, 'viewed']);



Route::get('/', function () {
    return response()->json([
        'success' => true,
    ]);
});
