<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\Doctor;
use App\Models\DoctorSchedule;

class DoctorScheduleManager extends Component
{
    public Doctor $doctor;

    // Array bidimensional para manejar selecciones: $schedules['08:00:00'][1]['08:00:00']
    // $schedules[hour_block][day_of_week][time_slot] = true/false
    public $schedules = [];

    public $days = [
        1 => 'LUNES',
        2 => 'MARTES',
        3 => 'MIÉRCOLES',
        4 => 'JUEVES',
        5 => 'VIERNES',
        6 => 'SÁBADO'
    ];

    public $hours = [
        '08:00:00' => ['08:00:00', '08:15:00', '08:30:00', '08:45:00'],
        '09:00:00' => ['09:00:00', '09:15:00', '09:30:00', '09:45:00'],
        '10:00:00' => ['10:00:00', '10:15:00', '10:30:00', '10:45:00'],
        '11:00:00' => ['11:00:00', '11:15:00', '11:30:00', '11:45:00'],
        '12:00:00' => ['12:00:00', '12:15:00', '12:30:00', '12:45:00'],
        '13:00:00' => ['13:00:00', '13:15:00', '13:30:00', '13:45:00'],
        '14:00:00' => ['14:00:00', '14:15:00', '14:30:00', '14:45:00'],
        '15:00:00' => ['15:00:00', '15:15:00', '15:30:00', '15:45:00'],
        '16:00:00' => ['16:00:00', '16:15:00', '16:30:00', '16:45:00'],
        '17:00:00' => ['17:00:00', '17:15:00', '17:30:00', '17:45:00'],
    ];

    public function mount(Doctor $doctor)
    {
        $this->doctor = $doctor;
        $this->loadSchedules();
    }

    public function loadSchedules()
    {
        $existing = DoctorSchedule::where('doctor_id', $this->doctor->id)->get();
        foreach ($existing as $schedule) {
            $timeSlot = $schedule->time_slot;
            $hourBlock = substr($timeSlot, 0, 2) . ':00:00';
            $this->schedules[$hourBlock][$schedule->day_of_week][$timeSlot] = true;
        }
    }

    public function save()
    {
        // Limpiar horarios actuales
        DoctorSchedule::where('doctor_id', $this->doctor->id)->delete();

        $inserts = [];
        foreach ($this->schedules as $hourBlock => $days) {
            foreach ($days as $day => $slots) {
                foreach ($slots as $slot => $isSelected) {
                    if ($isSelected) {
                        $inserts[] = [
                            'doctor_id' => $this->doctor->id,
                            'day_of_week' => $day,
                            'time_slot' => $slot,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
        }

        if (count($inserts) > 0) {
            DoctorSchedule::insert($inserts);
        }

        session()->flash('success', 'Horarios guardados correctamente.');
        return redirect()->route('admin.doctors.index');
    }

    public function render()
    {
        return view('livewire.admin.doctor-schedule-manager')->layout('layouts.admin');
    }
}
