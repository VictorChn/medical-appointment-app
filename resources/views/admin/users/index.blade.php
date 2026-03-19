<x-admin-layout title="Usuarios" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
    ],

]">

    <x-slot name="action">
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded">
            <i class="fa-solid fa-plus mr-2"></i> Nuevo
        </a>
    </x-slot>

    @livewire('admin.datatables.user-table')

</x-admin-layout>