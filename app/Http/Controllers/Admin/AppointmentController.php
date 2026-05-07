<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = \App\Models\Appointment::with(['patient.user', 'doctor.user'])->latest();

        if ($search) {
            $query->whereHas('patient.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('doctor.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $appointments = $query->paginate(10)->appends(['search' => $search]);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('admin.appointments.create');
    }

    public function store(Request $request)
    {
        // Handled by Livewire component now, this can be removed or kept as fallback
    }

    public function edit(\App\Models\Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor.user']);
        return view('admin.appointments.edit', compact('appointment'));
    }

    public function update(Request $request, \App\Models\Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|integer|in:0,1,2',
            'reason' => 'nullable|string'
        ]);

        $appointment->update($validated);
        return redirect()->route('admin.appointments.index')->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy(\App\Models\Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index')->with('success', 'Cita eliminada correctamente.');
    }
}
