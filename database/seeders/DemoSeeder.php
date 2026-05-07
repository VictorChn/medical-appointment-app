<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist
        Role::firstOrCreate(['name' => 'Administrador']);

        // Create Doctors
        $doc1User = User::firstOrCreate(['email' => 'sarah@healthify.com'], [
            'name' => 'Dra. Sarah Johnson',
            'password' => bcrypt('password'),
            'id_number' => 'DOC-001',
            'phone' => '1234567890',
            'address' => 'Test Address',
        ]);
        $doc1 = Doctor::firstOrCreate(['user_id' => $doc1User->id], [
            'specialty' => 'Cardiología'
        ]);

        $doc2User = User::firstOrCreate(['email' => 'michael@healthify.com'], [
            'name' => 'Dr. Michael Chen',
            'password' => bcrypt('password'),
            'id_number' => 'DOC-002',
            'phone' => '1234567891',
            'address' => 'Test Address',
        ]);
        $doc2 = Doctor::firstOrCreate(['user_id' => $doc2User->id], [
            'specialty' => 'Medicina General'
        ]);

        $doc3User = User::firstOrCreate(['email' => 'luis@healthify.com'], [
            'name' => 'Dr. Luis Torres',
            'password' => bcrypt('password'),
            'id_number' => 'DOC-003',
            'phone' => '1234567894',
            'address' => 'Test Address',
        ]);
        $doc3 = Doctor::firstOrCreate(['user_id' => $doc3User->id], [
            'specialty' => 'Endocrinología'
        ]);

        $doc4User = User::firstOrCreate(['email' => 'juan@healthify.com'], [
            'name' => 'Dr. Juan José Villagómez',
            'password' => bcrypt('password'),
            'id_number' => 'DOC-004',
            'phone' => '1234567895',
            'address' => 'Test Address',
        ]);
        $doc4 = Doctor::firstOrCreate(['user_id' => $doc4User->id], [
            'specialty' => 'Endocrinología'
        ]);

        $doc5User = User::firstOrCreate(['email' => 'elena@healthify.com'], [
            'name' => 'Dra. Elena Vargas',
            'password' => bcrypt('password'),
            'id_number' => 'DOC-005',
            'phone' => '1234567896',
            'address' => 'Test Address',
        ]);
        $doc5 = Doctor::firstOrCreate(['user_id' => $doc5User->id], [
            'specialty' => 'Pediatría'
        ]);

        // Add Schedules for Doctors
        DoctorSchedule::firstOrCreate(['doctor_id' => $doc1->id, 'day_of_week' => 1, 'time_slot' => '08:00:00']);
        DoctorSchedule::firstOrCreate(['doctor_id' => $doc1->id, 'day_of_week' => 1, 'time_slot' => '08:15:00']);
        DoctorSchedule::firstOrCreate(['doctor_id' => $doc2->id, 'day_of_week' => 2, 'time_slot' => '09:00:00']);
        DoctorSchedule::firstOrCreate(['doctor_id' => $doc3->id, 'day_of_week' => 3, 'time_slot' => '08:00:00']);
        DoctorSchedule::firstOrCreate(['doctor_id' => $doc4->id, 'day_of_week' => 3, 'time_slot' => '08:00:00']);
        DoctorSchedule::firstOrCreate(['doctor_id' => $doc5->id, 'day_of_week' => 4, 'time_slot' => '10:00:00']);
        DoctorSchedule::firstOrCreate(['doctor_id' => $doc5->id, 'day_of_week' => 4, 'time_slot' => '10:15:00']);
        DoctorSchedule::firstOrCreate(['doctor_id' => $doc5->id, 'day_of_week' => 4, 'time_slot' => '10:30:00']);

        // Create Patients
        $pat1User = User::firstOrCreate(['email' => 'isabel@test.com'], [
            'name' => 'Isabel Ruiz',
            'password' => bcrypt('password'),
            'id_number' => 'PAT-001',
            'phone' => '1234567892',
            'address' => 'Test Address',
        ]);
        $pat1 = Patient::firstOrCreate(['user_id' => $pat1User->id]);

        $pat2User = User::firstOrCreate(['email' => 'carlos@test.com'], [
            'name' => 'Carlos Mendoza',
            'password' => bcrypt('password'),
            'id_number' => 'PAT-002',
            'phone' => '1234567893',
            'address' => 'Test Address',
        ]);
        $pat2 = Patient::firstOrCreate(['user_id' => $pat2User->id]);

        $pat3User = User::firstOrCreate(['email' => 'berta@test.com'], [
            'name' => 'Berta Mota',
            'password' => bcrypt('password'),
            'id_number' => 'PAT-003',
            'phone' => '1234567897',
            'address' => 'Test Address',
        ]);
        $pat3 = Patient::firstOrCreate(['user_id' => $pat3User->id]);

        $pat4User = User::firstOrCreate(['email' => 'david@test.com'], [
            'name' => 'David Osorio',
            'password' => bcrypt('password'),
            'id_number' => 'PAT-004',
            'phone' => '1234567898',
            'address' => 'Test Address',
        ]);
        $pat4 = Patient::firstOrCreate(['user_id' => $pat4User->id]);

        $pat5User = User::firstOrCreate(['email' => 'sofia@test.com'], [
            'name' => 'Sofía Castillo',
            'password' => bcrypt('password'),
            'id_number' => 'PAT-005',
            'phone' => '1234567899',
            'address' => 'Test Address',
        ]);
        $pat5 = Patient::firstOrCreate(['user_id' => $pat5User->id]);

        // Create Appointments
        Appointment::firstOrCreate([
            'patient_id' => $pat1->id,
            'doctor_id' => $doc1->id,
            'date' => date('Y-m-d', strtotime('+1 day')),
            'start_time' => '08:00:00',
        ], [
            'end_time' => '08:15:00',
            'reason' => 'Chequeo general de presión',
            'status' => 1
        ]);

        Appointment::firstOrCreate([
            'patient_id' => $pat2->id,
            'doctor_id' => $doc2->id,
            'date' => date('Y-m-d', strtotime('+2 days')),
            'start_time' => '09:00:00',
        ], [
            'end_time' => '09:15:00',
            'reason' => 'Dolor de cabeza crónico',
            'status' => 1
        ]);
        
        // A completed one to see green on calendar
        $completedAppt = Appointment::firstOrCreate([
            'patient_id' => $pat1->id,
            'doctor_id' => $doc2->id,
            'date' => date('Y-m-d', strtotime('-1 day')),
            'start_time' => '10:00:00',
        ], [
            'end_time' => '10:15:00',
            'reason' => 'Fiebre',
            'status' => 2
        ]);

        \App\Models\Consultation::firstOrCreate([
            'appointment_id' => $completedAppt->id
        ], [
            'diagnosis' => 'Fiebre alta por infección viral',
            'treatment' => 'Paracetamol 500mg, reposo absoluto',
            'notes' => 'Paciente presenta temperatura de 39°C. Se recomienda hidratación.',
            'prescriptions' => [
                ['name' => 'Paracetamol', 'dosage' => '500mg', 'frequency' => '1 cada 8 horas', 'duration' => 'por 5 días']
            ]
        ]);

        // Extra Appointments
        Appointment::firstOrCreate([
            'patient_id' => $pat3->id,
            'doctor_id' => $doc3->id,
            'date' => date('Y-m-d', strtotime('+3 days')),
            'start_time' => '08:00:00',
        ], [
            'end_time' => '08:15:00',
            'reason' => 'Chequeo de niveles hormonales',
            'status' => 1
        ]);

        Appointment::firstOrCreate([
            'patient_id' => $pat4->id,
            'doctor_id' => $doc4->id,
            'date' => date('Y-m-d', strtotime('+4 days')),
            'start_time' => '08:00:00',
        ], [
            'end_time' => '08:15:00',
            'reason' => 'Consulta de tiroides',
            'status' => 1
        ]);

        Appointment::firstOrCreate([
            'patient_id' => $pat5->id,
            'doctor_id' => $doc5->id,
            'date' => date('Y-m-d', strtotime('+5 days')),
            'start_time' => '10:00:00',
        ], [
            'end_time' => '10:15:00',
            'reason' => 'Chequeo infantil',
            'status' => 1
        ]);
    }
}
