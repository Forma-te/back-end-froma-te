<?php

use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware([])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
});
