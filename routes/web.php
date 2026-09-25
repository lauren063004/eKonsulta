<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\PatientAppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientMedicalRecordController;
use App\Http\Controllers\DoctorDashboardController;
use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\DoctorConsultationController;
use App\Http\Controllers\DoctorPrescriptionController;
use App\Http\Controllers\PatientPrescriptionController;
use App\Http\Controllers\DoctorPatientController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\StaffPatientController;
use App\Http\Controllers\StaffAppointmentController;
use App\Http\Controllers\StaffConsultationController;
use App\Http\Controllers\StaffHealthCenterController;
use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminHealthCenterController;
use App\Http\Controllers\StaffProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffPrescriptionController;
use App\Http\Controllers\StaffAppointmentScheduleController;
use App\Http\Controllers\AdminActivityLogController;
use App\Http\Controllers\AdminDoctorController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');


Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {



   Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/users', [AdminUserController::class, 'index'])
    ->name('users.index');

    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])
    ->name('users.toggle-status');

Route::get('/users/{user}', [AdminUserController::class, 'show'])
    ->name('users.show');

Route::get('/health-centers', [AdminHealthCenterController::class, 'index'])
    ->name('health-centers.index');

Route::get('/health-centers/create', [AdminHealthCenterController::class, 'create'])
    ->name('health-centers.create');

Route::post('/health-centers', [AdminHealthCenterController::class, 'store'])
    ->name('health-centers.store');

Route::get('/health-centers/{healthCenter}', [AdminHealthCenterController::class, 'show'])
    ->name('health-centers.show');

Route::get('/health-centers/{healthCenter}/edit', [AdminHealthCenterController::class, 'edit'])
    ->name('health-centers.edit');

Route::put('/health-centers/{healthCenter}', [AdminHealthCenterController::class, 'update'])
    ->name('health-centers.update');

Route::patch('/health-centers/{healthCenter}/toggle-status', [AdminHealthCenterController::class, 'toggleStatus'])
    ->name('health-centers.toggle-status');

    Route::get('/doctors', [AdminDoctorController::class, 'index'])
    ->name('doctors.index');

Route::get('/doctors/create', [AdminDoctorController::class, 'create'])
    ->name('doctors.create');

Route::post('/doctors', [AdminDoctorController::class, 'store'])
    ->name('doctors.store');

Route::get('/doctors/{doctor}', [AdminDoctorController::class, 'show'])
    ->name('doctors.show');

Route::get('/doctors/{doctor}/edit', [AdminDoctorController::class, 'edit'])
    ->name('doctors.edit');

Route::put('/doctors/{doctor}', [AdminDoctorController::class, 'update'])
    ->name('doctors.update');

Route::patch('/doctors/{doctor}/toggle-status', [AdminDoctorController::class, 'toggleStatus'])
    ->name('doctors.toggle-status');

    Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])
    ->name('activity-logs.index');

    });


/*
|--------------------------------------------------------------------------
| Doctor Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:doctor'])
    ->prefix('doctor')
    ->name('doctor.')
    ->group(function () {

        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])
    ->name('dashboard');

    Route::get('/consultations', [DoctorConsultationController::class, 'index'])
    ->name('consultations.index');

    Route::get('/consultations/{consultation}', [DoctorConsultationController::class, 'show'])
    ->name('consultations.show');

        Route::get('/appointments/{appointment}/consultation/create', [DoctorConsultationController::class, 'create'])
    ->name('appointments.consultation.create');

        Route::post('/appointments/{appointment}/consultation', [DoctorConsultationController::class, 'store'])
    ->name('appointments.consultation.store');
Route::get('/appointments/{appointment}/prescription/create', [DoctorPrescriptionController::class, 'create'])
->name('appointments.prescription.create');

Route::post('/appointments/{appointment}/prescription', [DoctorPrescriptionController::class, 'store'])
->name('appointments.prescription.store');

Route::get('/patients', [DoctorPatientController::class, 'index'])
    ->name('patients.index');

    Route::get('/patients/{patient}', [DoctorPatientController::class, 'show'])
    ->name('patients.show');

    Route::get('/prescriptions', [DoctorPrescriptionController::class, 'index'])
    ->name('prescriptions.index');
        /*
        |--------------------------------------------------------------------------
        | Doctor Appointments
        |--------------------------------------------------------------------------
        */

        Route::get('/appointments', [DoctorAppointmentController::class, 'index'])
            ->name('appointments.index');

            Route::patch('/appointments/{appointment}/approve', [DoctorAppointmentController::class, 'approve'])
    ->name('appointments.approve');

    });

/*
|--------------------------------------------------------------------------
| Staff Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

Route::get('/health-centers', [StaffHealthCenterController::class, 'index'])
    ->name('health-centers.index');

Route::get('/health-centers/{healthCenter}', [StaffHealthCenterController::class, 'show'])
    ->name('health-centers.show');

Route::get('/dashboard', [StaffDashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/patients', [StaffPatientController::class, 'index'])
    ->name('patients.index');

Route::get('/patients/{patient}', [StaffPatientController::class, 'show'])
    ->name('patients.show');

Route::get('/appointments', [StaffAppointmentController::class, 'index'])
    ->name('appointments.index');

Route::get('/appointments/{appointment}', [StaffAppointmentController::class, 'show'])
    ->name('appointments.show');

Route::patch('/appointments/{appointment}/approve', [StaffAppointmentController::class, 'approve'])
    ->name('appointments.approve');

Route::patch('/appointments/{appointment}/cancel', [StaffAppointmentController::class, 'cancel'])
    ->name('appointments.cancel');
Route::get('/consultations', [StaffConsultationController::class, 'index'])
    ->name('consultations.index');

Route::get('/consultations/{consultation}', [StaffConsultationController::class, 'show'])
    ->name('consultations.show');

Route::get('/profile', [StaffProfileController::class, 'show'])
    ->name('profile');

    Route::get('/prescriptions', [StaffPrescriptionController::class, 'index'])
    ->name('prescriptions.index');

Route::get('/prescriptions/{prescription}', [StaffPrescriptionController::class, 'show'])
    ->name('prescriptions.show');

Route::patch('/prescriptions/{prescription}/release', [StaffPrescriptionController::class, 'release'])
    ->name('prescriptions.release');
    
    Route::get('/appointment-schedules', [StaffAppointmentScheduleController::class, 'index'])
    ->name('appointment-schedules.index');

Route::get('/appointment-schedules/create', [StaffAppointmentScheduleController::class, 'create'])
    ->name('appointment-schedules.create');

Route::post('/appointment-schedules', [StaffAppointmentScheduleController::class, 'store'])
    ->name('appointment-schedules.store');

Route::delete('/appointment-schedules/{appointmentSchedule}', [StaffAppointmentScheduleController::class, 'destroy'])
    ->name('appointment-schedules.destroy');
    });


/*
|--------------------------------------------------------------------------
| Patient Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:patient'])

    ->prefix('patient')
    ->name('patient.')
    ->group(function () {

Route::get('/profile', [PatientProfileController::class, 'show'])
    ->name('profile');

Route::patch('/profile', [PatientProfileController::class, 'update'])
    ->name('profile.update');

    Route::get('/appointments', [PatientAppointmentController::class, 'index'])
    ->name('appointments.index');

Route::patch('/appointments/{appointment}/cancel', [PatientAppointmentController::class, 'cancel'])
    ->name('appointments.cancel');

    Route::get('/appointments/create', [PatientAppointmentController::class, 'create'])
    ->name('appointments.create');

Route::post('/appointments', [PatientAppointmentController::class, 'store'])
    ->name('appointments.store');

        Route::get('/dashboard', [PatientDashboardController::class, 'index'])
            ->name('dashboard');

            Route::get('/medical-records', [PatientMedicalRecordController::class, 'index'])
    ->name('medical-records.index');
    Route::get('/prescriptions', [PatientPrescriptionController::class, 'index'])
    ->name('prescriptions.index');
    });