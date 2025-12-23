<?php

use App\Http\Controllers\Backend\AdminDashboardController;
use App\Http\Controllers\Backend\AIController;
use App\Http\Controllers\Backend\AppointmentController;
use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Auth\RegisterController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DoctorController;
use App\Http\Controllers\Backend\DoctorDashboardController;
use App\Http\Controllers\Backend\EHRController;
use App\Http\Controllers\Backend\NotificationController;
use App\Http\Controllers\Backend\NurseController;
use App\Http\Controllers\Backend\PatientController;
use App\Http\Controllers\Backend\PatientDashboardController;
use App\Http\Controllers\Backend\VitalController;
use App\Http\Controllers\Backend\PrescriptionController;
use App\Http\Controllers\Backend\SupportiveDocumentController;

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
        //Doctor Profile 
        Route::get('/showDoctor/{id}', [DoctorController::class, 'showDoctor'])->name('admin.doctor.showDoctor');
        Route::get('/editDoctor/{id}', [DoctorController::class, 'editDoctor'])->name('admin.doctor.editDoctor');
        Route::put('updateDoctor/{id}', [DoctorController::class, 'updateDoctor'])->name('admin.doctor.updateDoctor');
    });

    //nurse
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

    //patient
    Route::prefix('/patient')->middleware('auth')->group(function () {
        Route::get('/', [PatientController::class, 'index'])->name('admin.patient.index');
        Route::get('/create', [PatientController::class, 'create'])->name('admin.patient.create');
        Route::post('/store', [PatientController::class, 'store'])->name('admin.patient.store');
        Route::get('/show/{id}', [PatientController::class, 'show'])->name('admin.patient.show');
        Route::get('/edit/{id}', [PatientController::class, 'edit'])->name('admin.patient.edit');
        Route::put('update/{id}', [PatientController::class, 'update'])->name('admin.patient.update');
        Route::delete('delete/{id}', [PatientController::class, 'destroy'])->name('admin.patient.destroy');
        //patient profile
        Route::get('/showPatient/{id}', [PatientController::class, 'showPatient'])->name('admin.patient.showPatient');
        Route::get('/editPatient/{id}', [PatientController::class, 'editPatient'])->name('admin.patient.editPatient');
        Route::put('updatePatient/{id}', [PatientController::class, 'updatePatient'])->name('admin.patient.updatePatient');
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

    //vital Records
    Route::prefix('/vital')->middleware('auth')->group(function () {
        Route::get('/', [VitalController::class, 'index'])->name('admin.vital.index');
        Route::get('/create', [VitalController::class, 'create'])->name('admin.vital.create');
        Route::post('/store', [VitalController::class, 'store'])->name('admin.vital.store');
        Route::get('/show/{id}', [VitalController::class, 'show'])->name('admin.vital.show');
        Route::get('/edit/{id}', [VitalController::class, 'edit'])->name('admin.vital.edit');
        Route::put('update/{id}', [EHRController::class, 'update'])->name('admin.vital.update');
    });

    //prescription Records
    Route::prefix('/prescription')->middleware('auth')->group(function () {
        Route::get('/', [PrescriptionController::class, 'index'])->name('admin.prescription.index');
        Route::get('/create', [PrescriptionController::class, 'create'])->name('admin.prescription.create');
        Route::post('/store', [PrescriptionController::class, 'store'])->name('admin.prescription.store');
        Route::get('/show/{id}', [PrescriptionController::class, 'show'])->name('admin.prescription.show');
        Route::get('/edit/{id}', [PrescriptionController::class, 'edit'])->name('admin.prescription.edit');
        Route::put('update/{id}', [PrescriptionController::class, 'update'])->name('admin.prescription.update');
        Route::get('showPrescription/{id}', [PrescriptionController::class, 'showPrescription'])->name('admin.prescription.showPrescription');
    });

    //document
    Route::prefix('/document')->middleware('auth')->group(function () {
        Route::get('/', [SupportiveDocumentController::class, 'index'])->name('admin.document.index');
        // Route::get('/create', [SupportiveDocumentController::class, 'create'])->name('admin.document.create');
        Route::get('/create/{patient_id}', [SupportiveDocumentController::class, 'create'])
            ->name('admin.document.create');

        Route::post('/store', [SupportiveDocumentController::class, 'store'])->name('admin.document.store');
        Route::get('show/{patient_id}', [SupportiveDocumentController::class, 'show'])
            ->name('admin.document.show');
    });

    //document
    Route::prefix('/notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('admin.notification.index');
        Route::get('/show/{id}', [NotificationController::class, 'show'])->name('admin.notification.show');
        Route::get('/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('admin.notification.mark-as-read');
        Route::get('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notification.mark-all-as-read');
    });


    //doctor-dashboard
    Route::prefix('/doctor-dashboard')->group(function () {
        Route::get('/', [DoctorDashboardController::class, 'index'])->name('admin.doctor-dashboard.index');
    });

    //patient-dashboard
    Route::prefix('/patient-dashboard')->group(function () {
        Route::get('/', [PatientDashboardController::class, 'index'])->name('admin.patient-dashboard.index');
    });

    //admin-dashboard
    Route::prefix('/admin-dashboard')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.admin-dashboard.index');
    });

    Route::prefix('/admin-dashboard')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.admin-dashboard.index');
    });

    Route::prefix('/ai-chat')->group(function () {
        Route::get('/', [AIController::class, 'index'])->name('admin.ai-chat.index');
        Route::post('/send', [AIController::class, 'sendMessage'])->name('admin.ai-chat.send');
        Route::get('/history', [AIController::class, 'history'])->name('admin.ai-chat.history');
    });

});
