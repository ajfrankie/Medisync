<?php

use App\Http\Controllers\Backend\AppointmentController;
use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Auth\RegisterController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DoctorController;
use App\Http\Controllers\Backend\EHRController;
use App\Http\Controllers\Backend\NurseController;
use App\Http\Controllers\Backend\PatientController;

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
    // Show register form
    Route::get('/register', [RegisterController::class, 'index'])->name('admin.register.index');

    // Handle form submission
    Route::post('/register', [RegisterController::class, 'register'])->name('admin.register.store');


    // Protected admin routes
    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
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
        Route::post('/deactivate/{id}', [NurseController::class, 'deactivateNurse'])->name('admin.nurse.deactivate');
        Route::post('/activate/{id}', [NurseController::class, 'activateNurse'])->name('admin.nurse.activate');
    });

    //doctors
    Route::prefix('/patient')->middleware('auth')->group(function () {
        Route::get('/', [PatientController::class, 'index'])->name('admin.patient.index');
        Route::get('/create', [PatientController::class, 'create'])->name('admin.patient.create');
        Route::post('/store', [PatientController::class, 'store'])->name('admin.patient.store');
        Route::get('/show/{id}', [PatientController::class, 'show'])->name('admin.patient.show');
        Route::get('/edit/{id}', [PatientController::class, 'edit'])->name('admin.patient.edit');
        Route::put('update/{id}', [PatientController::class, 'update'])->name('admin.patient.update');
        Route::delete('delete/{id}', [PatientController::class, 'destroy'])->name('admin.patient.destroy');
    });

    //appointments
    Route::prefix('/AppointmentController')->middleware('auth')->group(function () {
        Route::get('/', [AppointmentController::class, 'index'])->name('admin.appointment.index');
        Route::get('/create', [AppointmentController::class, 'create'])->name('admin.appointment.create');
        Route::post('/store', [AppointmentController::class, 'store'])->name('admin.appointment.store');
        Route::get('/show/{id}', [AppointmentController::class, 'show'])->name('admin.appointment.show');
        Route::get('/edit/{id}', [AppointmentController::class, 'edit'])->name('admin.appointment.edit');
        Route::put('update/{id}', [AppointmentController::class, 'update'])->name('admin.appointment.update');
        Route::delete('delete/{id}', [AppointmentController::class, 'destroy'])->name('admin.appointment.destroy');
        Route::get('/get-doctor-details', [AppointmentController::class, 'getDoctorDetails'])->name('admin.appointment.getDoctorDetails');
        Route::get('/view-appointment-details/{id}', [AppointmentController::class, 'viewAppointmentDetails'])->name('admin.appointment.viewAppointmentDetails');
    });

    //EHR Records
    Route::prefix('/ehr')->middleware('auth')->group(function () {
        Route::get('/', [EHRController::class, 'index'])->name('admin.ehr.index');
        Route::get('/create', [EHRController::class, 'create'])->name('admin.ehr.create');
        Route::post('/store', [EHRController::class, 'store'])->name('admin.ehr.store');
        Route::get('/show/{id}', [EHRController::class, 'show'])->name('admin.ehr.show');
        Route::get('/edit/{id}', [EHRController::class, 'edit'])->name('admin.ehr.edit');
        Route::put('update/{id}', [EHRController::class, 'update'])->name('admin.ehr.update');
    });
});
