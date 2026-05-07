<div class="px-4 pt-6 max-w-full">
    <!-- Breadcrumb -->
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.appointments.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Citas</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Consulta</span>
                </div>
            </li>
        </ol>
    </nav>
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Consulta</h1>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">Éxito!</span> {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ $appointment->patient->user->name ?? 'Desconocido' }}</h2>
            <p class="text-sm text-gray-500">DNI: {{ $appointment->patient->user->id_number ?? 'N/A' }}</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-2">
            <button wire:click="$set('showPatientHistoryModal', true)" type="button" class="py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                <i class="fa-solid fa-file-medical text-gray-500 mr-2"></i> Ver Historia
            </button>
            <button wire:click="$set('showHistoryModal', true)" type="button" class="py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                <i class="fa-solid fa-clock-rotate-left text-gray-500 mr-2"></i> Consultas Anteriores
            </button>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
                <li class="mr-2">
                    <button wire:click="$set('activeTab', 'consulta')" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group {{ $activeTab === 'consulta' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        <i class="fa-solid fa-notes-medical mr-2 {{ $activeTab === 'consulta' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Consulta
                    </button>
                </li>
                <li class="mr-2">
                    <button wire:click="$set('activeTab', 'receta')" class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group {{ $activeTab === 'receta' ? 'text-blue-600 border-blue-600 active' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }}">
                        <i class="fa-solid fa-pills mr-2 {{ $activeTab === 'receta' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Receta
                    </button>
                </li>
            </ul>
        </div>
        <div class="p-4 md:p-6">
            @if($activeTab === 'consulta')
                <div class="space-y-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Diagnóstico</label>
                        <textarea wire:model="diagnosis" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-purple-500 focus:border-purple-500" placeholder="Describa el diagnóstico del paciente aquí..."></textarea>
                        @error('diagnosis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Tratamiento</label>
                        <textarea wire:model="treatment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-purple-500 focus:border-purple-500" placeholder="Describa el tratamiento recomendado aquí..."></textarea>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Notas</label>
                        <textarea wire:model="notes" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-purple-500 focus:border-purple-500" placeholder="Agregue notas adicionales sobre la consulta..."></textarea>
                    </div>
                </div>
            @endif

            @if($activeTab === 'receta')
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Medicamento</label>
                            <input type="text" wire:model="medicationName" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Amoxicilina 500mg">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Dosis</label>
                            <input type="text" wire:model="medicationDosage" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="1 cada 8 horas">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Frecuencia / Duración</label>
                            <div class="flex items-center space-x-2">
                                <input type="text" wire:model="medicationFrequency" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Ej: cada 8 horas por 7 dias">
                                <button type="button" class="text-red-600 bg-red-100 hover:bg-red-200 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button wire:click="addMedication" type="button" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <i class="fa-solid fa-plus mr-1"></i> Añadir Medicamento
                    </button>

                    @if(count($prescriptions) > 0)
                        <div class="mt-4">
                            @foreach($prescriptions as $index => $prescription)
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded-lg border border-gray-200 mb-2 items-center">
                                <div class="md:col-span-2">
                                    <p class="text-sm text-gray-900">{{ $prescription['name'] }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-900">{{ $prescription['dosage'] }}</p>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between space-x-2">
                                        <p class="text-sm text-gray-900">{{ $prescription['frequency'] }} {{ $prescription['duration'] }}</p>
                                        <button wire:click="removeMedication({{ $index }})" type="button" class="text-red-600 bg-red-100 hover:bg-red-200 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            <div class="mt-6 flex justify-end">
                <button wire:click="save" type="button" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                    <i class="fa-solid fa-lock mr-2"></i> Guardar Consulta
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Consultas Anteriores -->
    @if($showHistoryModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-50">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Consultas Anteriores
                    </h3>
                    <button wire:click="$set('showHistoryModal', false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4 max-h-[70vh] overflow-y-auto">
                    @forelse($this->pastConsultations as $pastConsultation)
                    <div class="p-4 bg-white border border-purple-200 rounded-lg shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-bold text-gray-900 flex items-center">
                                    <i class="fa-solid fa-calendar-days text-purple-600 mr-2"></i>
                                    {{ \Carbon\Carbon::parse($pastConsultation->appointment->date)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($pastConsultation->appointment->start_time)->format('H:i') }}
                                </h4>
                                <p class="text-sm text-gray-500 mt-1">Atendido por: Dr(a). {{ $pastConsultation->appointment->doctor->user->name ?? 'Desconocido' }}</p>
                            </div>
                            <button class="text-purple-600 border border-purple-600 hover:bg-purple-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center">
                                Consultar Detalle
                            </button>
                        </div>
                        <div class="mt-4 bg-gray-50 p-4 rounded border border-gray-100 space-y-2 text-sm text-gray-700">
                            <p><strong>Diagnóstico:</strong> {{ $pastConsultation->diagnosis }}</p>
                            <p><strong>Tratamiento:</strong> {{ $pastConsultation->treatment ?: 'No especificado' }}</p>
                            <p><strong>Notas:</strong> {{ $pastConsultation->notes ?: 'Sin notas' }}</p>
                        </div>
                    </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No hay consultas anteriores.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Historia del Paciente -->
    @if($showPatientHistoryModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-50">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t bg-white">
                    <h3 class="text-lg font-bold text-gray-900">
                        Historia médica del paciente
                    </h3>
                    <button wire:click="$set('showPatientHistoryModal', false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tipo de sangre:</p>
                            <p class="font-bold text-gray-900">{{ $appointment->patient->bloodType->name ?? 'A-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Alergias:</p>
                            <p class="font-bold text-gray-900">{{ $appointment->patient->allergies ?: 'No registradas' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Enfermedades crónicas:</p>
                            <p class="font-bold text-gray-900">{{ $appointment->patient->chronic_conditions ?: 'No registradas' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Antecedentes quirúrgicos:</p>
                            <p class="font-bold text-gray-900">{{ $appointment->patient->surgical_history ?: 'No registradas' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-4 pt-4 border-t border-gray-100">
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-semibold hover:underline">
                            Ver / Editar Historia Médica
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
