<x-admin-layout title="Roles" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
        'href' => route('admin.roles.index'),
    ],
    [
        'name' => 'Crear',
    ]

]">


    <x-wire-card>
        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf 
            @method('PUT')
            <x-wire-input label="Nombre" name="name" placeholder="Nombre del rol" value="{{ old('name', $role->name) }}" ></x-wire-input>
            <div class="flex justify-end mt-4">
                <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded">
                    Actualizar
                </button>
            </div>
        </form>
    </x-wire-card>
    
</x-admin-layout>