<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Mail\AppointmentCreatedMail;
use App\Services\UltraMsgService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessAppointmentNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Appointment $appointment
    ) {}

    /**
     * Execute the job.
     */
    public function handle(UltraMsgService $ultraMsgService): void
    {
        try {
            // Ensure relationships are loaded
            $this->appointment->loadMissing(['patient.user', 'doctor.user']);

            // 1. Generate and save PDF
            $pdf = Pdf::loadView('pdfs.appointment-ticket', ['appointment' => $this->appointment]);
            $pdfPath = 'tickets/ticket_' . $this->appointment->id . '_' . time() . '.pdf';
            
            // Store locally in public disk
            Storage::disk('public')->put($pdfPath, $pdf->output());
            $absolutePdfPath = Storage::disk('public')->path($pdfPath);

            // 2. Send Emails
            if ($this->appointment->patient && $this->appointment->patient->user && $this->appointment->patient->user->email) {
                try {
                    Mail::to($this->appointment->patient->user->email)
                        ->send(new AppointmentCreatedMail($this->appointment, $absolutePdfPath, 'patient'));
                } catch (\Exception $e) {
                    Log::warning('No se pudo enviar correo al paciente: ' . $e->getMessage());
                }
            }

            // Pausa de 3 segundos para la versión gratuita de Mailtrap
            sleep(3);

            if ($this->appointment->doctor && $this->appointment->doctor->user && $this->appointment->doctor->user->email) {
                try {
                    Mail::to($this->appointment->doctor->user->email)
                        ->send(new AppointmentCreatedMail($this->appointment, $absolutePdfPath, 'doctor'));
                } catch (\Exception $e) {
                    Log::warning('No se pudo enviar correo al doctor: ' . $e->getMessage());
                }
            }

            // 3. Send WhatsApp Notification
            if ($this->appointment->patient && $this->appointment->patient->user && $this->appointment->patient->user->phone) {
                $dateStr = \Carbon\Carbon::parse($this->appointment->date)->format('d/m/Y');
                $timeStr = \Carbon\Carbon::parse($this->appointment->start_time)->format('H:i');
                
                $patientName = $this->appointment->patient->user->name;
                $phone = $this->appointment->patient->user->phone;
                
                // Asegurar el código de país (si el número no empieza con +, asume que es de México +52)
                if (!str_starts_with($phone, '+')) {
                    $phone = '+52' . ltrim($phone, '0');
                }

                $message = "Hola {$patientName}, tu cita en Healthify para el *{$dateStr}* a las *{$timeStr}* ha sido confirmada con éxito. ¡Te esperamos!";
                
                $ultraMsgService->sendMessage($phone, $message);
            }

        } catch (\Exception $e) {
            Log::error('Error processing appointment notifications for appointment ' . $this->appointment->id . ': ' . $e->getMessage());
            throw $e;
        }
    }
}
