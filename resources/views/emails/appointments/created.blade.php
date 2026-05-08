<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Cita Médica</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2 style="color: #2c3e50; text-align: center;">Confirmación de Cita Médica</h2>
        
        @if($recipientType === 'patient')
            <p>Hola <strong>{{ $appointment->patient->user->name ?? 'Paciente' }}</strong>,</p>
            <p>Tu cita médica ha sido confirmada con éxito. A continuación te presentamos los detalles:</p>
        @else
            <p>Hola Dr(a). <strong>{{ $appointment->doctor->user->name ?? 'Doctor' }}</strong>,</p>
            <p>Tienes una nueva cita programada en tu agenda:</p>
        @endif

        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</p>
            <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</p>
            <p><strong>Paciente:</strong> {{ $appointment->patient->user->name ?? 'N/A' }}</p>
            <p><strong>Doctor(a):</strong> {{ $appointment->doctor->user->name ?? 'N/A' }}</p>
            @if($appointment->reason)
                <p><strong>Motivo:</strong> {{ $appointment->reason }}</p>
            @endif
        </div>

        <p>Adjunto a este correo encontrarás el comprobante de la cita en formato PDF.</p>
        
        @if($recipientType === 'patient')
            <p>Por favor, asegúrate de asistir 15 minutos antes de la hora programada.</p>
        @endif

        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #777; text-align: center;">Este es un mensaje automático del sistema, por favor no respondas a este correo.</p>
    </div>
</body>
</html>
