<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/appointments', [\App\Http\Controllers\Admin\AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [\App\Http\Controllers\Admin\AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [\App\Http\Controllers\Admin\AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [\App\Http\Controllers\Admin\AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [\App\Http\Controllers\Admin\AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [\App\Http\Controllers\Admin\AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/appointments/{appointment}/consultation', \App\Livewire\Admin\ConsultationManager::class)->name('appointments.consultation');

    Route::get('/doctors', \App\Livewire\Admin\DoctorList::class)->name('doctors.index');
    Route::get('/doctors/{doctor}/schedules', \App\Livewire\Admin\DoctorScheduleManager::class)->name('doctors.schedules');

    Route::get('/calendar', \App\Livewire\Admin\CalendarModule::class)->name('calendar');
});

// --- Rutas de Prueba para visualizar Correo y PDF ---
Route::get('/test-email', function () {
    $appointment = \App\Models\Appointment::with(['patient', 'doctor.user'])->latest()->first();
    if (!$appointment) {
        return "No hay citas registradas para generar la vista previa.";
    }
    return new \App\Mail\AppointmentCreatedMail($appointment, 'ruta/falsa.pdf', 'patient');
});

Route::get('/test-pdf', function () {
    $appointment = \App\Models\Appointment::with(['patient', 'doctor.user'])->latest()->first();
    if (!$appointment) {
        return "No hay citas registradas para generar la vista previa.";
    }
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdfs.appointment-ticket', ['appointment' => $appointment]);
    return $pdf->stream('ticket_test.pdf');
});
