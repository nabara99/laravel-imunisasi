<?php

use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IblController;
use App\Http\Controllers\IblTargetController;
use App\Http\Controllers\IdlController;
use App\Http\Controllers\IdlTargetController;
use App\Http\Controllers\MotherTargetController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentImunController;
use App\Http\Controllers\StudentTargetController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\WusController;
use App\Http\Controllers\WusImunController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.login');
})->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('village', VillageController::class);
    Route::resource('school', SchoolController::class);
    Route::resource('children', ChildrenController::class);
    Route::resource('idl-target', IdlTargetController::class);
    Route::resource('ibl-target', IblTargetController::class);
    Route::resource('mother-target', MotherTargetController::class);
    Route::resource('student-target', StudentTargetController::class);
    Route::resource('idl-imun', IdlController::class);
    Route::resource('wus', WusController::class);
    Route::resource('ibl-imun', IblController::class);
    Route::resource('tt-imun', WusImunController::class);
    Route::resource('child-sch', StudentController::class);
    Route::resource('bias', StudentImunController::class);
    Route::resource('report', ReportController::class);
    Route::post('report-idl', [ReportController::class, 'reportIDL'])->name('report-idl');
    Route::post('report-ibl', [ReportController::class, 'reportIBL'])->name('report-ibl');
    Route::post('report-tt', [ReportController::class, 'reportTT'])->name('report-tt');
});
