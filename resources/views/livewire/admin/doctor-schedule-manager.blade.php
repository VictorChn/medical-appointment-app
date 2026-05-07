<div class="px-4 pt-6 max-w-full">
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
                    <a href="{{ route('admin.doctors.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Doctores</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Horarios</span>
                </div>
            </li>
        </ol>
    </nav>
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Horarios</h1>

    <div class="bg-white relative shadow-md sm:rounded-lg">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Gestor de horarios</h3>
            <button wire:click="save" type="button" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Guardar horario
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">DÍA/HORA</th>
                        @foreach ($days as $dayId => $dayName)
                            <th scope="col" class="px-6 py-4 font-semibold">{{ $dayName }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hours as $hourBlock => $slots)
                        <tr class="border-b">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap align-top">
                                {{ substr($hourBlock, 0, 5) }}
                            </td>
                            @foreach ($days as $dayId => $dayName)
                                <td class="px-6 py-4 align-top">
                                    <div class="space-y-3">
                                        @foreach ($slots as $index => $slot)
                                            @php
                                                // calculate next slot for display e.g. 08:00 - 08:15
                                                $nextSlot = isset($slots[$index+1]) ? substr($slots[$index+1], 0, 5) : substr(date('H:i:s', strtotime($slot) + 900), 0, 5);
                                                $display = substr($slot, 0, 5) . ' - ' . $nextSlot;
                                            @endphp
                                            <div class="flex items-center">
                                                <input id="checkbox-{{$hourBlock}}-{{$dayId}}-{{$slot}}" type="checkbox" wire:model="schedules.{{$hourBlock}}.{{$dayId}}.{{$slot}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                                <label for="checkbox-{{$hourBlock}}-{{$dayId}}-{{$slot}}" class="ml-2 text-sm font-medium text-gray-900">{{ $display }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
