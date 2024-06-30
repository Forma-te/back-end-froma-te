<?php

use App\Http\Controllers\Admin\Plan\PlanController;
use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware([])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');

    //Routes plans
    Route::get('plans/{url}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::get('/plans/{url}', [PlanController::class, 'show'])->name('plans.show');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::delete('/plans/{url}', [PlanController::class, 'destroy'])->name('plans.destroy');
});
