<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use App\Jobs\ProcessAppointmentNotifications;

class AppointmentCreate extends Component
{
    // Search fields
    public $date;
    public $time_range = '';
    public $specialty = '';

    // Selection fields
    public $selectedDoctorId = null;
    public $selectedTime = null; // e.g. "08:00:00"
    
    // Form fields
    public $patientId = '';
    public $reason = '';

    // Data lists
    public $patients = [];
    public $availableDoctors = [];
    public $doctorSchedules = [];

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->patients = Patient::with('user')->get();
        // Load all initially
        $this->searchAvailability();
    }

    public function searchAvailability()
    {
        // Reset selection when searching
        $this->selectedDoctorId = null;
        $this->selectedTime = null;

        $query = Doctor::with('user');
        if ($this->specialty) {
            $query->where('specialty', $this->specialty);
        }
        $this->availableDoctors = $query->get();

        // Load schedules for these doctors
        $dayOfWeek = Carbon::parse($this->date)->dayOfWeekIso; // 1 (Mon) - 7 (Sun)
        
        $this->doctorSchedules = [];
        foreach ($this->availableDoctors as $doctor) {
            $schedulesQuery = DoctorSchedule::where('doctor_id', $doctor->id)
                ->where('day_of_week', $dayOfWeek);

            if ($this->time_range) {
                // time_range is like '08:00:00 - 09:00:00'
                $parts = explode(' - ', $this->time_range);
                if (count($parts) == 2) {
                    $schedulesQuery->whereBetween('time_slot', [$parts[0], $parts[1]]);
                }
            }

            // Also we should filter out time slots that are already booked!
            $bookedTimes = Appointment::where('doctor_id', $doctor->id)
                ->where('date', $this->date)
                ->whereIn('status', [1, 2]) // 1: scheduled, 2: completed (not cancelled)
                ->pluck('start_time')
                ->toArray();

            $schedules = $schedulesQuery->orderBy('time_slot')->get();
            
            // Filter out booked ones
            $filteredSchedules = $schedules->filter(function($s) use ($bookedTimes) {
                // Ensure format matches
                $formattedTime = Carbon::parse($s->time_slot)->format('H:i:s');
                foreach ($bookedTimes as $bookedTime) {
                    if (Carbon::parse($bookedTime)->format('H:i:s') == $formattedTime) {
                        return false;
                    }
                }
                return true;
            });

            $this->doctorSchedules[$doctor->id] = $filteredSchedules;
        }
    }

    public function selectDoctorTime($doctorId, $time)
    {
        $this->selectedDoctorId = $doctorId;
        $this->selectedTime = $time;
    }

    public function save()
    {
        $this->validate([
            'patientId' => 'required|exists:patients,id',
            'selectedDoctorId' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'selectedTime' => 'required|date_format:H:i:s',
            'reason' => 'nullable|string'
        ]);

        $endTime = Carbon::parse($this->selectedTime)->addMinutes(15)->format('H:i:s');

        $appointment = Appointment::create([
            'patient_id' => $this->patientId,
            'doctor_id' => $this->selectedDoctorId,
            'date' => $this->date,
            'start_time' => $this->selectedTime,
            'end_time' => $endTime,
            'reason' => $this->reason,
            'status' => 1 // Scheduled
        ]);

        ProcessAppointmentNotifications::dispatch($appointment);

        session()->flash('success', 'Cita creada exitosamente.');
        session()->flash('swal', true);
        session()->flash('swal.title', '¡Cita Registrada!');
        session()->flash('swal.text', 'La nueva cita médica se ha guardado exitosamente en el sistema.');
        session()->flash('swal.icon', 'success');
        
        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        $selectedDoctor = null;
        if ($this->selectedDoctorId) {
            $selectedDoctor = Doctor::with('user')->find($this->selectedDoctorId);
        }

        return view('livewire.admin.appointment-create', compact('selectedDoctor'));
    }
}
