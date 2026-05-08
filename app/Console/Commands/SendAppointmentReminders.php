<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Services\UltraMsgService;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-appointment-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios de WhatsApp para citas programadas al día siguiente';

    /**
     * Execute the console command.
     */
    public function handle(UltraMsgService $ultraMsgService)
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDate('date', $tomorrow)
            ->where('status', 1) // 1 = Scheduled
            ->get();

        $count = 0;
        foreach ($appointments as $appointment) {
            if ($appointment->patient && $appointment->patient->user && $appointment->patient->user->phone) {
                $timeStr = Carbon::parse($appointment->start_time)->format('H:i');
                $doctorName = $appointment->doctor->user->name ?? '';
                
                $patientName = $appointment->patient->user->name;
                $phone = $appointment->patient->user->phone;

                // Asegurar el código de país
                if (!str_starts_with($phone, '+')) {
                    $phone = '+52' . ltrim($phone, '0');
                }
                
                $message = "🚨 *RECORDATORIO DE CITA* 🚨\n\nHola {$patientName}, te recordamos que tienes una cita médica mañana *{$tomorrow}* a las *{$timeStr}* con el/la Dr(a). {$doctorName}.\n\n¡Te esperamos en Healthify!";
                
                $success = $ultraMsgService->sendMessage($phone, $message);
                if ($success) {
                    $count++;
                }
            }
        }

        $this->info("Recordatorios enviados: {$count}");
    }
}
