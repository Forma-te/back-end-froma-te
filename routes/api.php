<?php

use App\Http\Controllers\Api\Producer\{
    BankController,
    CategoryController,
    CourseController,
    EbookContentController,
    EbookController,
    FileController,
    LessonController,
    ModuleController,
    ReplySupportController,
    SaleController,
    SubscriptionController,
    UserController
};
use App\Http\Controllers\Api\Auth\{
    AuthController,
    ResetPasswordController
};
use App\Http\Controllers\Api\Cart\{
    CartPlanController,
    CartController
};
use App\Http\Controllers\Api\Member\{
    MemberController,
    SupportController
};
use Illuminate\Support\Facades\Route;

/**
 * Auth
 */
Route::post('/register', [UserController::class, 'registerUser']);
Route::put('/update-user/{Id}', [UserController::class, 'updateUser'])->middleware('auth:sanctum');
Route::get('/getMe', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::post('/auth', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

/**
 * Reset Password
 */
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->middleware('guest');
Route::post('/reset-password', [ResetPasswordController::class, 'resetSenha'])->middleware('guest');

Route::middleware(['auth:sanctum'])->group(function () {

    /**
    * Route categories
    */
    Route::get('/categories', [CategoryController::class, 'getAllCategories']);
    Route::get('/categories/{categoryId}', [CategoryController::class, 'getCategoryById']);
    Route::post('/categories', [CategoryController::class, 'storeCategory']);
    Route::put('/categories/{Id}', [CategoryController::class, 'updateCategory']);
    Route::delete('/categories/{Id}', [CategoryController::class, 'destroyCategory']);

    /**
    * Route Course
    */
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/get-products', [CourseController::class, 'getProducts']);
    Route::get('/courses/producers', [CourseController::class, 'fetchAllCoursesByProducers']);
    Route::get('/course/{courseId}', [CourseController::class, 'getCourseById']);
    Route::post('/course', [CourseController::class, 'createCourse']);
    Route::put('/course/{Id}', [CourseController::class, 'updateCourse']);
    Route::delete('/course/{Id}', [CourseController::class, 'destroyCourse']);

    /**
    * Route Modules
    */
    Route::get('/course/{courseId}/modules', [ModuleController::class, 'getModulesByCourse']);
    Route::get('/module/{Id}', [ModuleController::class, 'getModuleById']);
    Route::post('/module', [ModuleController::class, 'createModule']);
    Route::put('/module/{Id}', [ModuleController::class, 'updateModule']);
    Route::delete('/module/{Id}', [ModuleController::class, 'destroyModule']);

    /**
    * Route Lesson
    */
    Route::get('/lessons', [LessonController::class, 'getAllLesson']);
    Route::get('/lessons/{moduleId}', [LessonController::class, 'getLessonByModuleId']);
    Route::post('/lesson', [LessonController::class, 'createLesson']);
    Route::put('/lesson/{Id}', [LessonController::class, 'updateLesson']);
    Route::put('/lesson/edit/name/{Id}', [LessonController::class, 'editNameLesson']);
    Route::post('/lesson/create/name', [LessonController::class, 'createNameLesson']);
    Route::post('/lesson/file/create', [LessonController::class, 'createFileLesson']);
    Route::put('/lesson/{Id}/file', [LessonController::class, 'updateFileLesson']);
    Route::delete('/lesson/{Id}', [LessonController::class, 'destroyLesson']);
    // Route::post('/lessons/viewed', [LessonController::class, 'viewed']);

    /**
    * Route Ebook
    */
    Route::get('/ebooks', [EbookController::class, 'getAllEbook']);
    Route::get('/ebook/{Id}', [EbookController::class, 'getEbookById']);
    Route::get('/ebooks/producers', [EbookController::class, 'fetchAllEbooksByProducers']);
    Route::post('/ebook', [EbookController::class, 'createEbook']);
    Route::put('/ebook/{Id}', [EbookController::class, 'updateEbook']);
    Route::delete('/ebook/{Id}', [EbookController::class, 'destroyEbook']);

    /**
    * Route File
    */
    Route::get('/files', [FileController::class, 'getAllFiles']);
    Route::get('/file/{Id}', [FileController::class, 'getFileById']);
    Route::get('/producers/files', [FileController::class, 'fetchAllFilesByProducers']);
    Route::post('/file', [FileController::class, 'createFile']);
    Route::put('/file/{Id}', [FileController::class, 'updateFile']);
    Route::delete('/file/{Id}', [FileController::class, 'destroyFile']);

    /**
    * Route Ebook Content
    */
    Route::get('/ebook/{ebookId}/ebook-content', [EbookContentController::class, 'getContentByEbookId']);
    Route::post('/ebook-content', [EbookContentController::class, 'createEbookContent']);
    Route::put('/ebook-content/{Id}', [EbookContentController::class, 'updateEbookContent']);
    Route::delete('/ebook-content/{Id}', [EbookContentController::class, 'destroyEbookContent']);


    Route::get('/get-courses', [CourseController::class, 'getCoursesForAuthenticatedUser']);
    Route::get('/courses/{id}', [CourseController::class, 'getCourseById']);

    /**
    * Route Bank
    */
    Route::post('/bank', [BankController::class, 'createBank']);
    Route::put('/bank/{Id}', [BankController::class, 'updateBank']);
    Route::delete('/bank/{Id}', [BankController::class, 'deleteBank']);

    /**
    * Route Member
    */
    Route::get('/courses-member', [MemberController::class, 'getAllCourseMember']);
    Route::get('/course/{id}/member', [MemberController::class, 'getCourseByIdMember']);

    /**
    * Route Sale
    */
    Route::get('/members-status', [SaleController::class, 'getMembersByStatus']);
    Route::get('/members', [SaleController::class, 'getMyMembers']);
    Route::get('/sale/{Id}', [SaleController::class, 'getSaleById']);
    Route::post('/sales', [SaleController::class, 'newSale']);
    Route::put('/sales/{Id}', [SaleController::class, 'updateSale']);
    Route::delete('/sales/{Id}', [SaleController::class, 'destroySele']);
    Route::post('/import-csv', [SaleController::class, 'csvImportMember']);

    /**
    * Route supports
    */
    Route::post('/supports', [SupportController::class, 'createSupport']);
    Route::get('/my-supports', [SupportController::class, 'mySupports']);

    /**
    * Route Reply support
    */
    // Route::post('/replies', [ReplySupportController::class, 'createReply']);
    Route::post('/support/reply', [ReplySupportController::class, 'createReply']);
    Route::get('/supports', [ReplySupportController::class, 'getSupportProducerByStatus']);
    Route::get('/support/{Id}', [ReplySupportController::class, 'message']);

    /**
    * Route CartPlan
    */
    Route::get('/plans', [CartPlanController::class, 'getAllPlans']);
    Route::get('/cart/plans/{url}', [CartPlanController::class, 'createSessionPlan']);
    Route::get('/cart/checkout', [CartPlanController::class, 'checkoutPlan']);
    Route::get('/cart/plan-pay', [CartPlanController::class, 'planPay']);

    /**
    * Route Subscription
    */
    Route::get('/subscription', [SubscriptionController::class, 'getSubscription']);

    Route::post('/member/verificar-ou-criar', [CartController::class, 'validateOrCreateCustomer']);

    /**
    * Route Cart
    */
    Route::prefix('cart')->group(function () {

        // Adicionar produto ao carrinho
        Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');

        // Visualizar carrinho
        Route::get('/view', [CartController::class, 'viewCart'])->name('cart.view');

        // Atualizar quantidade no carrinho
        Route::put('/update', [CartController::class, 'updateCart'])->name('cart.update');

        // Remover produto do carrinho
        Route::delete('/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

        // Sincronizar carrinho da sessão
        Route::post('/sync-session', [CartController::class, 'syncSessionCart'])->name('cart.syncSession');

        // Finalizar compra (checkout)
        Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    });


});

Route::get('/', function () {
    return response()->json([
        'success' => true,
    ]);
});
