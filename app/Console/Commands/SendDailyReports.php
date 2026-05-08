<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class SendDailyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera y envía reportes diarios de citas para los doctores y administradores';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->format('Y-m-d');
        
        $appointments = Appointment::with(['doctor.user', 'patient.user'])
            ->whereDate('date', $today)
            ->where('status', 1) // Scheduled
            ->get();

        // 1. Send to Administrator
        // Obtenemos el correo del administrador (asumimos el primer usuario admin o uno de configuración)
        $adminEmail = env('MAIL_FROM_ADDRESS', 'admin@healthify.com');
        try {
            \Illuminate\Support\Facades\Mail::to($adminEmail)
                ->send(new \App\Mail\DailyReportMail('Administrador General', 'admin', $appointments));
            $this->info("Reporte general enviado al administrador.");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("No se pudo enviar el reporte diario al admin: " . $e->getMessage());
        }

        // 2. Send to Doctors
        $groupedByDoctor = $appointments->groupBy('doctor_id');
        $emailsSent = 0;

        foreach ($groupedByDoctor as $doctorId => $doctorAppointments) {
            $doctor = $doctorAppointments->first()->doctor;
            
            if ($doctor && $doctor->user && $doctor->user->email) {
                // Pequeña pausa para no saturar Mailtrap en la versión gratuita
                sleep(3);
                
                try {
                    \Illuminate\Support\Facades\Mail::to($doctor->user->email)
                        ->send(new \App\Mail\DailyReportMail($doctor->user->name, 'doctor', $doctorAppointments));
                    $emailsSent++;
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning("No se pudo enviar el reporte diario al doctor {$doctor->user->name}: " . $e->getMessage());
                }
            }
        }

        $this->info("Reportes diarios finalizados: {$emailsSent} doctores notificados sobre sus agendas de hoy.");
    }
}
