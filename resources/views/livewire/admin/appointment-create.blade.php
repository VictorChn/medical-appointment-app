<div>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Search & Doctors -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Buscar disponibilidad Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-1">Buscar disponibilidad</h2>
                    <p class="text-sm text-gray-500 mb-4">Encuentra el horario perfecto para tu cita.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label class="block mb-1 text-xs font-medium text-gray-500">Fecha</label>
                            <input type="date" wire:model="date" class="bg-white border border-gray-200 text-gray-900 text-sm rounded focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" required>
                            @error('date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block mb-1 text-xs font-medium text-gray-500">Hora</label>
                            <select wire:model="time_range" class="bg-white border border-gray-200 text-gray-900 text-sm rounded focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                                <option value="">Cualquier Hora</option>
                                <option value="08:00:00 - 09:00:00">08:00:00 - 09:00:00</option>
                                <option value="09:00:00 - 10:00:00">09:00:00 - 10:00:00</option>
                                <option value="10:00:00 - 11:00:00">10:00:00 - 11:00:00</option>
                                <option value="11:00:00 - 12:00:00">11:00:00 - 12:00:00</option>
                                <option value="12:00:00 - 13:00:00">12:00:00 - 13:00:00</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 text-xs font-medium text-gray-500">Especialidad (opcional)</label>
                            <select wire:model="specialty" class="bg-white border border-gray-200 text-gray-900 text-sm rounded focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                                <option value="">Cualquiera</option>
                                <option value="Endocrinología">Endocrinología</option>
                                <option value="Cardiología">Cardiología</option>
                                <option value="Medicina General">Medicina General</option>
                                <option value="Pediatría">Pediatría</option>
                            </select>
                        </div>
                        <div>
                            <button type="button" wire:click="searchAvailability" class="w-full text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:ring-indigo-300 font-medium rounded text-sm px-5 py-2.5">
                                <span wire:loading.remove wire:target="searchAvailability">Buscar disponibilidad</span>
                                <span wire:loading wire:target="searchAvailability">Buscando...</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Doctors List Stack -->
                <div class="space-y-4 relative">
                    <div wire:loading wire:target="searchAvailability" class="absolute inset-0 bg-white/50 z-10 rounded-lg flex items-center justify-center">
                        <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-indigo-500 border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
                            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
                        </div>
                    </div>
                    
                    @forelse($availableDoctors as $doctor)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 {{ $selectedDoctorId == $doctor->id ? 'ring-2 ring-indigo-500 border-indigo-500' : 'hover:bg-gray-50 transition-all' }}">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-14 h-14 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-500 font-medium text-xl">
                                {{ strtoupper(substr($doctor->user->name ?? 'D', 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="text-gray-900 font-bold text-lg">{{ $doctor->user->name ?? 'Doctor' }}</h3>
                                <p class="text-indigo-500 text-sm">{{ $doctor->specialty ?? 'General' }}</p>
                            </div>
                        </div>
                        
                        <hr class="border-gray-100 my-4">
                        
                        <p class="text-sm text-gray-600 mb-3">Horarios disponibles:</p>
                        <div class="flex flex-wrap gap-2">
                            @if(isset($doctorSchedules[$doctor->id]) && count($doctorSchedules[$doctor->id]) > 0)
                                @foreach($doctorSchedules[$doctor->id] as $schedule)
                                    @php 
                                        $formattedTime = \Carbon\Carbon::parse($schedule->time_slot)->format('H:i:s');
                                        $isSelected = ($selectedDoctorId == $doctor->id && $selectedTime == $formattedTime);
                                    @endphp
                                    <button type="button" 
                                            wire:click="selectDoctorTime({{ $doctor->id }}, '{{ $formattedTime }}')"
                                            class="px-4 py-2 text-sm font-medium rounded-md transition-colors {{ $isSelected ? 'text-white bg-indigo-700 ring-2 ring-offset-1 ring-indigo-700' : 'text-white bg-indigo-400 hover:bg-indigo-500' }}">
                                        {{ $schedule->time_slot }}
                                    </button>
                                @endforeach
                            @else
                                <span class="text-sm text-gray-400">No hay disponibilidad.</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 text-center text-gray-500">
                        @if($date)
                            No se encontraron doctores disponibles para estos criterios.
                        @else
                            Ingresa una fecha para buscar disponibilidad.
                        @endif
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Column: Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 sticky top-20">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Resumen de la cita</h2>
                    
                    <div class="space-y-4 text-sm mb-6 border-b border-gray-100 pb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Doctor:</span>
                            <span class="text-gray-900 font-medium text-right">
                                {{ $selectedDoctor ? ($selectedDoctor->user->name ?? '') : 'Seleccionado' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Fecha:</span>
                            <span class="text-gray-900 font-medium text-right">
                                {{ $selectedTime ? \Carbon\Carbon::parse($date)->format('Y-m-d') : 'Seleccionada' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Horario:</span>
                            <span class="text-gray-900 font-medium text-right">
                                @if($selectedTime)
                                    {{ $selectedTime }} - {{ \Carbon\Carbon::parse($selectedTime)->addMinutes(15)->format('H:i:s') }}
                                @else
                                    Seleccionado
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Duración:</span>
                            <span class="text-gray-900 font-medium text-right">15 minutos</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm text-gray-700">Paciente</label>
                        <select wire:model="patientId" class="bg-white border border-gray-200 text-gray-900 text-sm rounded focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" required>
                            <option value="">Selecciona un paciente</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">
                                    {{ $patient->user->name ?? 'Paciente #'.$patient->id }}
                                </option>
                            @endforeach
                        </select>
                        @error('patientId') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm text-gray-700">Motivo de la cita</label>
                        <textarea wire:model="reason" rows="3" class="bg-white border border-gray-200 text-gray-900 text-sm rounded focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" placeholder="Chequeo de medicamentos"></textarea>
                    </div>
                    
                    @error('selectedDoctorId') <div class="mb-4 text-xs text-red-500 font-medium">Por favor, selecciona un doctor y horario.</div> @enderror
                    @error('selectedTime') <div class="mb-4 text-xs text-red-500 font-medium">Por favor, selecciona un horario.</div> @enderror

                    <button type="submit" class="w-full text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:ring-indigo-300 font-medium rounded text-sm px-5 py-3 text-center transition-colors">
                        Confirmar cita
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
