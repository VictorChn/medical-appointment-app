<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\Doctor;
use Livewire\WithPagination;

class DoctorList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    // Edit Modal properties
    public $isEditModalOpen = false;
    public $editingDoctorId = null;
    public $editName = '';
    public $editEmail = '';
    public $editPhone = '';
    public $editSpecialty = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function editDoctor($id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);
        $this->editingDoctorId = $doctor->id;
        $this->editName = $doctor->user->name;
        $this->editEmail = $doctor->user->email;
        $this->editPhone = $doctor->user->phone;
        $this->editSpecialty = $doctor->specialty;
        $this->isEditModalOpen = true;
    }

    public function updateDoctor()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editEmail' => 'required|email|max:255',
            'editPhone' => 'nullable|string|max:255',
            'editSpecialty' => 'nullable|string|max:255',
        ]);

        $doctor = Doctor::findOrFail($this->editingDoctorId);
        $doctor->user->update([
            'name' => $this->editName,
            'email' => $this->editEmail,
            'phone' => $this->editPhone,
        ]);
        
        $doctor->update([
            'specialty' => $this->editSpecialty,
        ]);

        $this->isEditModalOpen = false;
        session()->flash('success', 'Doctor actualizado correctamente.');
    }

    public function closeEditModal()
    {
        $this->isEditModalOpen = false;
    }

    public function deleteDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->user->delete(); // This will cascade to doctor and schedules
        session()->flash('success', 'Doctor eliminado correctamente.');
    }

    public function render()
    {
        $doctors = Doctor::with('user')
            ->whereHas('user', function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->orWhere('specialty', 'like', '%'.$this->search.'%')
            ->paginate($this->perPage);

        return view('livewire.admin.doctor-list', compact('doctors'))->layout('layouts.admin');
    }
}
