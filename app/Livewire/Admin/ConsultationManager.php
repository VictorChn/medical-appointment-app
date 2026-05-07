<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ConsultationManager extends Component
{
    public \App\Models\Appointment $appointment;
    public $activeTab = 'consulta';
    
    // Consulta
    public $diagnosis;
    public $treatment;
    public $notes;

    // Receta
    public $prescriptions = [];
    public $medicationName;
    public $medicationDosage;
    public $medicationFrequency;
    public $medicationDuration;

    public $showHistoryModal = false;
    public $showPatientHistoryModal = false;

    public function mount(\App\Models\Appointment $appointment)
    {
        $this->appointment = $appointment;
        $consultation = $appointment->consultation;
        if ($consultation) {
            $this->diagnosis = $consultation->diagnosis;
            $this->treatment = $consultation->treatment;
            $this->notes = $consultation->notes;
            $this->prescriptions = $consultation->prescriptions ?? [];
        }
    }

    public function addMedication()
    {
        $this->validate([
            'medicationName' => 'required',
            'medicationDosage' => 'required',
        ]);

        $this->prescriptions[] = [
            'name' => $this->medicationName,
            'dosage' => $this->medicationDosage,
            'frequency' => $this->medicationFrequency,
            'duration' => $this->medicationDuration,
        ];

        $this->reset(['medicationName', 'medicationDosage', 'medicationFrequency', 'medicationDuration']);
    }

    public function removeMedication($index)
    {
        unset($this->prescriptions[$index]);
        $this->prescriptions = array_values($this->prescriptions);
    }

    public function save()
    {
        $this->validate([
            'diagnosis' => 'required',
        ]);

        $this->appointment->consultation()->updateOrCreate(
            ['appointment_id' => $this->appointment->id],
            [
                'diagnosis' => $this->diagnosis,
                'treatment' => $this->treatment,
                'notes' => $this->notes,
                'prescriptions' => $this->prescriptions,
            ]
        );

        $this->appointment->update(['status' => 2]); // completed
        session()->flash('success', 'Consulta guardada correctamente.');
        return redirect()->route('admin.appointments.index');
    }

    public function getPastConsultationsProperty()
    {
        return \App\Models\Consultation::whereHas('appointment', function($q) {
            $q->where('patient_id', $this->appointment->patient_id)
              ->where('id', '!=', $this->appointment->id);
        })->with('appointment.doctor.user')->latest()->get();
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager')->layout('layouts.admin');
    }
}
