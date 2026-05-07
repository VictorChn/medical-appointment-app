<x-admin-layout>
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Citas</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Citas</h1>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                <span class="font-medium">Éxito!</span> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <form method="GET" action="{{ route('admin.appointments.index') }}" class="flex items-center">
                        <label for="simple-search" class="sr-only">Buscar</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2" placeholder="Buscar paciente o doctor...">
                        </div>
                    </form>
                </div>
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <a href="{{ route('admin.appointments.create') }}" class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                        <i class="fa-solid fa-plus mr-2"></i> Nuevo
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-4 py-3 font-semibold">ID</th>
                            <th scope="col" class="px-4 py-3 font-semibold">PACIENTE</th>
                            <th scope="col" class="px-4 py-3 font-semibold">DOCTOR</th>
                            <th scope="col" class="px-4 py-3 font-semibold">FECHA</th>
                            <th scope="col" class="px-4 py-3 font-semibold">HORA</th>
                            <th scope="col" class="px-4 py-3 font-semibold">HORA FIN</th>
                            <th scope="col" class="px-4 py-3 font-semibold">ESTADO</th>
                            <th scope="col" class="px-4 py-3 font-semibold text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr class="border-b hover:bg-gray-50 text-gray-900">
                                <td class="px-4 py-3 font-medium">{{ $appointment->id }}</td>
                                <td class="px-4 py-3">{{ $appointment->patient->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</td>
                                <td class="px-4 py-3">
                                    @if($appointment->status == 1)
                                        <span class="text-gray-900 font-medium">Programado</span>
                                    @elseif($appointment->status == 2)
                                        <span class="text-green-600 font-medium">Completado</span>
                                    @else
                                        <span class="text-red-600 font-medium">Cancelado</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="inline-flex items-center p-1.5 text-sm font-medium text-center text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="{{ route('admin.appointments.consultation', $appointment) }}" class="inline-flex items-center p-1.5 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300">
                                        <i class="fa-solid fa-file-medical"></i>
                                    </a>
                                    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center p-1.5 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-4 text-center text-gray-500">
                                    No hay citas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 flex items-center justify-between border-t border-gray-200">
                <div class="w-full">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
