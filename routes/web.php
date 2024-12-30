<?php

use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IblTargetController;
use App\Http\Controllers\IdlTargetController;
use App\Http\Controllers\MotherTargetController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.login');
})->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('village', VillageController::class);
    Route::resource('children', ChildrenController::class);
    Route::resource('idl-target', IdlTargetController::class);
    Route::resource('ibl-target', IblTargetController::class);
    Route::resource('mother-target', MotherTargetController::class);
});
