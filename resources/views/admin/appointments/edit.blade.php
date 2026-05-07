<x-admin-layout>
    <div class="px-4 pt-6 max-w-full bg-gray-50 min-h-screen pb-12">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900">
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="text-gray-400 mx-1">/</span>
                        <a href="{{ route('admin.appointments.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-gray-900 md:ml-2">Citas</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="text-gray-400 mx-1">/</span>
                        <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2">Editar</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Editar Cita #{{ $appointment->id }}</h1>

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 max-w-2xl">
            <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4 mb-6 border-b border-gray-100 pb-6">
                    <h2 class="text-lg font-bold text-gray-900">Información Actual (Solo Lectura)</h2>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500 block mb-1">Paciente:</span>
                            <span class="text-gray-900 font-medium">{{ $appointment->patient->user->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block mb-1">Doctor:</span>
                            <span class="text-gray-900 font-medium">{{ $appointment->doctor->user->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block mb-1">Fecha:</span>
                            <span class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block mb-1">Horario:</span>
                            <span class="text-gray-900 font-medium">
                                {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Estado de la Cita</label>
                    <select name="status" class="bg-white border border-gray-200 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="1" {{ $appointment->status == 1 ? 'selected' : '' }}>Programado</option>
                        <option value="2" {{ $appointment->status == 2 ? 'selected' : '' }}>Completado</option>
                        <option value="0" {{ $appointment->status == 0 ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Motivo de la cita</label>
                    <textarea name="reason" rows="4" class="bg-white border border-gray-200 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Escribe el motivo...">{{ old('reason', $appointment->reason) }}</textarea>
                </div>

                <div class="flex space-x-3">
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 text-center transition-colors">
                        Guardar Cambios
                    </button>
                    <a href="{{ route('admin.appointments.index') }}" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded text-sm px-5 py-2.5 text-center transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
