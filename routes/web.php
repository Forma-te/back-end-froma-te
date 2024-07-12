<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Plan\ActivateUserPlanController;
use App\Http\Controllers\Admin\Plan\PlanController;
use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware([])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/producers', [AdminController::class, 'getAllProducers'])->name('get.producers');

    //Routes plans
    Route::get('plans/{url}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::get('/plans/{url}', [PlanController::class, 'show'])->name('plans.show');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::delete('/plans/{url}', [PlanController::class, 'destroy'])->name('plans.destroy');

    //Routes ActivateUserPlan
    Route::get('/user-requests', [ActivateUserPlanController::class, 'getAllUserRequests'])->name('user.requests.all');
    Route::get('/user-requests/{id}', [ActivateUserPlanController::class, 'getUserRequestsById'])->name('user.request');
    Route::post('/user-request/{id}/activate', [ActivateUserPlanController::class, 'activatePlan'])->name('plans.activate');
    Route::get('/active-plans', [ActivateUserPlanController::class, 'getActivePlans'])->name('active.plans');

});
