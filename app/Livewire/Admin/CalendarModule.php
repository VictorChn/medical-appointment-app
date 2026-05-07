<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\Appointment;

class CalendarModule extends Component
{
    public function render()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])->get();
        
        $events = [];
        foreach ($appointments as $appointment) {
            $events[] = [
                'id' => $appointment->id,
                'title' => ($appointment->patient->user->name ?? 'Desconocido') . ' - Dr. ' . ($appointment->doctor->user->name ?? 'Desconocido'),
                'start' => $appointment->date . 'T' . $appointment->start_time,
                'end' => $appointment->date . 'T' . $appointment->end_time,
                'backgroundColor' => $appointment->status == 2 ? '#10b981' : '#3b82f6', // green if completed, blue if scheduled
                'borderColor' => $appointment->status == 2 ? '#10b981' : '#3b82f6',
            ];
        }

        return view('livewire.admin.calendar-module', [
            'events' => json_encode($events)
        ])->layout('layouts.admin');
    }
}
