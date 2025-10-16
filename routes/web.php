<?php

use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DoctorController;
use App\Http\Controllers\NurseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin.login');
})->name('index');


// Admin
Route::prefix('/admin')->group(function () {
    // Admin login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');

    // Protected admin routes
    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
        Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
        Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
    });


    //doctors
    Route::prefix('/doctor')->middleware('auth')->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->name('admin.doctor.index');
        Route::get('/create', [DoctorController::class, 'create'])->name('admin.doctor.create');
        Route::post('/store', [DoctorController::class, 'store'])->name('admin.doctor.store');
        Route::get('/show/{id}', [DoctorController::class, 'show'])->name('admin.doctor.show');
        Route::get('/edit/{id}', [DoctorController::class, 'edit'])->name('admin.doctor.edit');
        Route::put('update/{id}', [DoctorController::class, 'update'])->name('admin.doctor.update');
        Route::delete('delete/{id}', [DoctorController::class, 'destroy'])->name('admin.doctor.destroy');
        Route::post('/deactivate/{id}', [DoctorController::class, 'deactivateDoctor'])->name('admin.doctor.deactivate');
        Route::post('/activate/{id}', [DoctorController::class, 'activateDoctor'])->name('admin.doctor.activate');
    });

    //doctors
    Route::prefix('/nurse')->middleware('auth')->group(function () {
        Route::get('/', [NurseController::class, 'index'])->name('admin.nurse.index');
        Route::get('/create', [NurseController::class, 'create'])->name('admin.nurse.create');
        Route::post('/store', [NurseController::class, 'store'])->name('admin.nurse.store');
        Route::get('/show/{id}', [NurseController::class, 'show'])->name('admin.nurse.show');
        Route::get('/edit/{id}', [NurseController::class, 'edit'])->name('admin.nurse.edit');
        Route::put('update/{id}', [NurseController::class, 'update'])->name('admin.nurse.update');
        Route::delete('delete/{id}', [NurseController::class, 'destroy'])->name('admin.nurse.destroy');
        // Route::post('/deactivate/{id}', [DoctorController::class, 'deactivateDoctor'])->name('admin.doctor.deactivate');
        // Route::post('/activate/{id}', [DoctorController::class, 'activateDoctor'])->name('admin.doctor.activate');
    });
});
