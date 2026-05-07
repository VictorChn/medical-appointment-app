<div class="px-4 pt-6 max-w-full relative">
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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Doctores</span>
                </div>
            </li>
        </ol>
    </nav>
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Doctores</h1>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">Éxito!</span> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="w-full md:w-1/2">
                <form class="flex items-center">
                    <label for="simple-search" class="sr-only">Buscar</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live="search" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2" placeholder="Buscar por nombre, especialidad..." required="">
                    </div>
                </form>
            </div>
            <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                <div class="flex items-center space-x-3 w-full md:w-auto">
                    <select wire:model.live="perPage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2">
                        <option value="10">10 por página</option>
                        <option value="25">25 por página</option>
                        <option value="50">50 por página</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-4 py-3 font-semibold">ID</th>
                        <th scope="col" class="px-4 py-3 font-semibold">NOMBRE</th>
                        <th scope="col" class="px-4 py-3 font-semibold">EMAIL</th>
                        <th scope="col" class="px-4 py-3 font-semibold">DNI</th>
                        <th scope="col" class="px-4 py-3 font-semibold">TELEFONO</th>
                        <th scope="col" class="px-4 py-3 font-semibold">ESPECIALIDAD</th>
                        <th scope="col" class="px-4 py-3 font-semibold text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($doctors as $doctor)
                        <tr class="border-b hover:bg-gray-50 text-gray-900">
                            <td class="px-4 py-3 font-medium">{{ $doctor->id }}</td>
                            <td class="px-4 py-3 font-medium">
                                @if($doctor->user->name) {{ $doctor->user->name }} @else - @endif
                            </td>
                            <td class="px-4 py-3">{{ $doctor->user->email }}</td>
                            <td class="px-4 py-3">{{ $doctor->user->id_number }}</td>
                            <td class="px-4 py-3">{{ $doctor->user->phone }}</td>
                            <td class="px-4 py-3">{{ $doctor->specialty }}</td>
                            <td class="px-4 py-3 flex items-center justify-center space-x-2">
                                <button type="button" wire:click="editDoctor({{ $doctor->id }})" class="inline-flex items-center p-1.5 text-sm font-medium text-center text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <a href="{{ route('admin.doctors.schedules', $doctor) }}" class="inline-flex items-center p-1.5 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300" title="Horarios">
                                    <i class="fa-regular fa-clock"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                No se encontraron doctores.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 flex items-center justify-between border-t border-gray-200">
            <div class="w-full">
                {{ $doctors->links() }}
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @if($isEditModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-50">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex justify-between items-center p-5 rounded-t border-b">
                    <h3 class="text-xl font-medium text-gray-900">
                        Editar Doctor
                    </h3>
                    <button type="button" wire:click="closeEditModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form wire:submit.prevent="updateDoctor">
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                                <input type="text" wire:model="editName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                @error('editName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                <input type="email" wire:model="editEmail" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                @error('editEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Teléfono</label>
                                <input type="text" wire:model="editPhone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('editPhone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Especialidad</label>
                                <input type="text" wire:model="editSpecialty" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('editSpecialty') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 pt-6 border-t border-gray-200 mt-6">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Guardar cambios</button>
                            <button type="button" wire:click="closeEditModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
