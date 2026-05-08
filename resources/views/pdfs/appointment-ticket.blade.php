<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Cita</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
        }
        .content {
            margin-bottom: 20px;
        }
        .info-group {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #4b5563;
        }
        .value {
            font-size: 16px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
            margin-top: 30px;
        }
        .ticket-box {
            border: 1px dashed #9ca3af;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Healthify Appointments</h1>
        <p>Comprobante Oficial de Cita Médica</p>
    </div>

    <div class="ticket-box">
        <div class="info-group">
            <span class="label">Folio de Cita:</span>
            <span class="value">#{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        
        <div class="info-group">
            <span class="label">Paciente:</span>
            <span class="value">{{ $appointment->patient->user->name ?? 'N/A' }}</span>
        </div>

        <div class="info-group">
            <span class="label">Doctor Asignado:</span>
            <span class="value">Dr(a). {{ $appointment->doctor->user->name ?? 'N/A' }}</span>
        </div>

        <div class="info-group">
            <span class="label">Especialidad:</span>
            <span class="value">{{ $appointment->doctor->specialty ?? 'N/A' }}</span>
        </div>

        <div class="info-group">
            <span class="label">Fecha Programada:</span>
            <span class="value">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</span>
        </div>

        <div class="info-group">
            <span class="label">Hora:</span>
            <span class="value">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</span>
        </div>

        @if($appointment->reason)
        <div class="info-group">
            <span class="label">Motivo de Consulta:</span>
            <span class="value">{{ $appointment->reason }}</span>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>Por favor presentar este comprobante (digital o impreso) el día de su cita.</p>
        <p>Se recomienda llegar 15 minutos antes de la hora programada.</p>
        <p>Generado automáticamente el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
