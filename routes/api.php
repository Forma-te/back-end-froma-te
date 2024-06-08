<?php

use App\Http\Controllers\Api\{
    BankController,
    CategoryController,
    CourseController,
    EbookContentController,
    EbookController,
    LessonController,
    ModuleController,
    SaleController,
    SupportController,
    UserController
};
use App\Http\Controllers\Api\Auth\{
    AuthController,
    ResetPasswordController
};

use Illuminate\Support\Facades\Route;

/**
 * Auth
 */
Route::post('register', [UserController::class, 'register']);
Route::get('/getAuthenticatedUser', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::post('/auth', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

/**
 * Reset Password
 */
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->middleware('guest');
Route::post('/reset-password', [ResetPasswordController::class, 'resetSenha'])->middleware('guest');


Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('/categories', CategoryController::class)->parameters([
        'category' => 'id'
    ]);

    /**
    * Route Course
    */
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/course/{courseId}', [CourseController::class, 'getCourseById']);
    Route::post('/course', [CourseController::class, 'createCourse']);
    Route::put('/course/{Id}', [CourseController::class, 'updateCourse']);
    Route::delete('/course/{Id}', [CourseController::class, 'destroyCourse']);

    /**
    * Route Modules
    */
    Route::get('/course/{courseId}/modules', [ModuleController::class, 'getModulesByCourse']);
    Route::post('/module', [ModuleController::class, 'createModule']);
    Route::put('/module/{Id}', [ModuleController::class, 'updateModule']);
    Route::delete('/module/{Id}', [ModuleController::class, 'destroyModule']);

    /**
    * Route Lesson
    */
    Route::get('/module/{moduleId}/lessons', [LessonController::class, 'getLessonByModuleId']);
    Route::post('/lesson', [LessonController::class, 'createLesson']);
    Route::put('/lesson/{Id}', [LessonController::class, 'updateLesson']);
    Route::delete('/lesson/{Id}', [LessonController::class, 'destroyLesson']);


    /**
    * Route Ebook
    */
    Route::get('/ebooks', [EbookController::class, 'getAllEbook']);
    Route::get('/ebook/{Id}', [EbookController::class, 'getEbookById']);
    Route::post('/ebook', [EbookController::class, 'createEbook']);
    Route::put('/ebook/{Id}', [EbookController::class, 'updateEbook']);
    Route::delete('/ebook/{Id}', [EbookController::class, 'destroyEbook']);

    /**
    * Route Ebook Content
    */
    Route::get('/ebook/{ebookId}/ebook-content', [EbookContentController::class, 'getContentByEbookId']);
    Route::post('/ebook-content', [EbookContentController::class, 'createEbookContent']);
    Route::put('/ebook-content/{Id}', [EbookContentController::class, 'updateEbookContent']);
    Route::delete('/ebook-content/{Id}', [EbookContentController::class, 'destroyEbookContent']);


    //Route::get('/modules/{id}/lessons', [LessonController::class, 'index']);
    //Route::get('/lesson/{id}', [LessonController::class, 'show']);

    Route::get('/my-supports', [SupportController::class, 'mySupports']);
    Route::get('/supports', [SupportController::class, 'index']);
    Route::post('/supports', [SupportController::class, 'store']);
    Route::post('/supports/{id}/replies', [SupportController::class, 'createReply']);

    Route::get('/get-courses', [CourseController::class, 'getCoursesForAuthenticatedUser']);
    Route::get('/courses/{id}', [CourseController::class, 'getCourseById']);
    // Route::post('/lessons/viewed', [LessonController::class, 'viewed']);

    /**
    * Route Bank
    */
    Route::post('/bank', [BankController::class, 'createBank']);
    Route::put('/bank/{Id}', [BankController::class, 'updateBank']);
    Route::delete('/bank/{Id}', [BankController::class, 'deleteBank']);

    /**
    * Route Sale
    */
    Route::get('/sales', [SaleController::class, 'getAllSales']);
    Route::get('/sale/{Id}', [SaleController::class, 'getSaleById']);
    Route::post('/new-sale', [SaleController::class, 'newSale']);
    Route::put('/sale/{Id}', [SaleController::class, 'updateSale']);
    Route::delete('/sale/{Id}', [SaleController::class, 'destroySele']);

});

Route::get('/', function () {
    return response()->json([
        'success' => true,
    ]);
});
