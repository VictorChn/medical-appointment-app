<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resumen de Citas</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3f4f6; padding: 20px; color: #374151; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #3b82f6; padding: 20px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; }
        .content h2 { color: #1f2937; font-size: 18px; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #f9fafb; font-weight: 600; color: #4b5563; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #6b7280; background-color: #f9fafb; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Healthify - Resumen Diario</h1>
        </div>
        
        <div class="content">
            <h2>Hola, {{ $recipientName }}</h2>
            <p>
                A continuación te presentamos el listado de citas programadas para el día de hoy, 
                <strong>{{ \Carbon\Carbon::today()->format('d/m/Y') }}</strong>.
            </p>

            @if($appointments->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Hora</th>
                            @if($role === 'admin')
                                <th>Doctor</th>
                            @endif
                            <th>Paciente</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
                            @if($role === 'admin')
                                <td>{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                            @endif
                            <td>{{ $appointment->patient->user->name ?? 'N/A' }}</td>
                            <td>{{ $appointment->reason ?? 'Consulta general' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="background-color: #f3f4f6; padding: 15px; text-align: center; border-radius: 6px; margin-top: 20px;">
                    No hay citas programadas para hoy.
                </div>
            @endif
        </div>

        <div class="footer">
            <p>Este es un correo generado automáticamente por el sistema Healthify.</p>
            <p>© {{ date('Y') }} Healthify. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
