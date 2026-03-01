<x-admin-layout title="Roles" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
    ],

]">

    <x-slot name="action">
        <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded">
            <i class="fa-solid fa-plus mr-2"></i> Nuevo
        </a>
    </x-slot>

    @livewire('admin.datatables.role-table')

</x-admin-layout>