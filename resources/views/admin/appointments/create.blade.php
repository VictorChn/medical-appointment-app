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
                        <span class="ml-1 text-sm font-medium text-gray-900 md:ml-2">Nuevo</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Nuevo</h1>

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <livewire:admin.appointment-create />
    </div>
</x-admin-layout>
